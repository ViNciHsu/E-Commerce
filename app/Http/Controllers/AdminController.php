<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function addAccountListPage()
    {
        $users = User::OrderBy('updated_at', 'desc')
            ->where('email', '!=', 'admin@gmail.com');

        $address_countys = Address::select('county')->groupBy('county')->orderBy('county')->get();

        $address_citys = Address::select('city')->groupBy('city')->orderBy('city')->get();
//        dd($users);

        if(session()->has('user_id')) {
            return view('admin',[
                'users' => $users,
                'address_countys' => $address_countys,
                'address_citys' => $address_citys,
            ]);
        }else{
            return redirect('/login');
        }
    }

    public function addAccount(Request $request)
    {

        $input = $request->input();
//dd($input);
        // 驗證規則
        $rules = [
            //name
            'name' => [
                'required',
                'min:1',
            ],
            //email
            'email' => [
                'required',
                'max:150',
                'email',
            ],
            //密碼
            'password' => [
                'required',
                'min:5',
            ],
        ];
        $error_message = [
            'msg' => [
                'This E-mail has already been registered,
                 please try a new one！',
            ],
        ];

        //驗證資料
        $validator = Validator::make($input, $rules);
//        dd($validator);
        if($validator->fails())
        {
            //資料驗證錯誤
            return redirect('admin/add')
                ->withErrors($validator)
                ->withInput();
        }

        $userEmail = User::where(['email'=>$request->email])->first();

        if($userEmail)
        {
            return redirect('admin/add')
                ->withErrors($error_message)
                ->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address_zip = $request->address_zip;
        $user->address_county = $request->address_county;
        $user->address_city = $request->address_city;
        $user->address_street = $request->address_street;
        $user->save();
//        dd($user);
        $success = true;
        return redirect('admin/add')->with('status', 'Account added successfully！');

    }

    public function userAccountList()
    {
        $users = User::OrderBy('updated_at', 'desc')
            ->where('email', '!=', 'admin@gmail.com')
            ->paginate(100);

        $address_countys = Address::select('county')->groupBy('county')->orderBy('county')->get();
        $address_citys = Address::select('city')->groupBy('city')->orderBy('city')->get();

//        dd(session()->has('user_id'));
        if(session()->has('user_id')) {
            return view('adminList', [
                'users' => $users,
                'address_countys' => $address_countys,
                'address_citys' => $address_citys,
            ]);
        }else{
            return redirect('/login');
        }

    }

    // admin edit list
    public function updateUserAccountPage($id)
    {
        $user = User::all()->find($id);

        $address_countys = Address::select('county')->groupBy('county')->orderBy('county')->get();

        foreach ($address_countys as $v){
            $allAddresses[] = $v->county;
        }

        foreach ($allAddresses as $key2 => $v2_county){
            $tmp_address_citys[] = Address::select('city', 'county', 'address_zip')
                ->where('county','=',$v2_county)
                ->groupBy('city', 'county')
                ->orderBy('county')->orderBy('city')->get();
        }

        foreach ($tmp_address_citys as $key3 => $v3_data){
            foreach ($v3_data as $v4_data_details) {
//                $address_citys[] = $v4_data_details->city;
//                $address_zips[] = $v4_data_details->address_zip;
                $address_all[] = $v4_data_details;
            }
        }
        $address_citys = Address::select('county','city')
            ->where('county','=',$user->address_county)
            ->groupBy('county','city')
            ->orderBy('county')
            ->orderBy('city')
            ->get();
//        echo '<pre>';
//        var_dump($address_citys);
//        echo '</pre>';
//        dd($address_citys);
//        dd($address_all);

        if(session()->has('user_id')) {
            return view('adminEdit',[
                'user' => $user,
//            'allAddresses' => $allAddresses,
                'address_countys' => $address_countys,
                'address_citys' => $address_citys,
//            'address_zips' => $address_zips,
                'address_all' => $address_all,
            ]);
        }else{
            return redirect('/login');
        }
    }

    // admin 修改帳號
    public function updateUserAccount(Request $request, $id)
    {
//        echo 'updateUserAccount~';exit;
        $user = User::find($id);
        $input = $request->input();
//        $input = request()->name;
//        dd($input);

        // 驗證規則
        $rules = [
            //name
            'update_name' => [
                'required',
                'min:1',
            ],
            //email
            'update_email' => [
                'required',
                'max:150',
                'email',
            ],
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            // 資料驗證錯誤
            return redirect('admin/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        $user->name = $request->update_name;
        $user->email = $request->update_email;
        $user->user_level = $request->update_user_level;
        $user->address_county = $request->update_address_county;
        $user->address_city = $request->update_address_city;
        $user->address_zip = $request->update_address_zip;

//        $user->user_id = $request->user_id;
        $user->add = $request->authority_add_id ? 1 : 0;
        $user->edit = $request->authority_edit_id ? 1 : 0;
        $user->delete = $request->authority_delete_id ? 1 : 0;
//        dd($user);
        $user->save();

        return redirect('admin/list')->with('status', 'Account updated successfully！');
    }

    // admin 刪除帳號
    public function deleteUserAccount($id){
        $user = User::all()->find($id);
//        dd($user);
        $user->delete();
        return redirect('admin/list')->with('status', 'Account deleted successfully！');
    }

    // admin 原頁修改帳號
    public function updateUserAccountOriginPage(Request $request, $id)
    {
//        echo 'updateUserAccount~';exit;
        $user = User::find($id);
        $input = $request->input();
//        dd($input);

        // 驗證規則
        $rules = [
            //name
            'origin_update_name' => [
                'required',
                'min:1',
            ],
            //email
            'origin_update_email' => [
                'required',
                'max:150',
                'email',
            ],
        ];

        $validator = Validator::make($input, $rules);
//        dd($validator);
        if($validator->fails())
        {
            // 資料驗證錯誤
            return redirect('admin/list')
                ->with('error', 'Account updated failed！');
//                ->withErrors($validator)
//                ->withInput();
        }
        $user->name = $request->origin_update_name;
        $user->email = $request->origin_update_email;
        $user->user_level = $request->origin_update_user_level;
        $user->add = $request->authority_add_id ? 1 : 0;
        $user->edit = $request->authority_edit_id ? 1 : 0;
        $user->delete = $request->authority_delete_id ? 1 : 0;
        $user->address_county = $request->update_address_county;
        $user->address_city = $request->update_address_city;
        $user->address_zip = $request->update_address_zip;
        $user->save();

        return redirect('admin/list')->with('status', 'Account updated successfully！');
    }

    public function searchAccount()
    {
        $users = User::all();
//        dd($users);
        $temp = [];
        foreach($users as $k => $v){
            $temp[] = $v->user_level;
            $user = $v;
            $counts = array_count_values($temp);
        }
        $max_count_user_level = array_keys($counts, max($counts));
//        dd($max_count_user_level);
        // 使用jsonData()撈到的ajax資料,引數目前放user_level數出來最多的index
        $users_ajax = $this->jsonData($max_count_user_level[0]);

        $address_countys = Address::select('county')->groupBy('county')->orderBy('county')->get();

        $address_citys = Address::select('city')->groupBy('city')->orderBy('city')->get();
//        dd($user);

        if(session()->has('user_id')) {
            return view('adminAccountSearch',[
                'users' => $users,
                'users_ajax' => $users_ajax,
                'address_countys' => $address_countys,
                'address_citys' => $address_citys,

            ]);
        }else{
            return redirect('/login');
        }
    }

    public function jsonData($select_id = null)
    {
        $users = DB::table('users')
            ->select('id', 'name', 'email', 'user_level', 'address_county', 'address_city', 'address_zip', 'address_street')
            ->where('email', '!=', 'admin@gmail.com')
            ->where('user_level', "=", $select_id)
            ->get();
//        dd($select_id);
        if($select_id != 99) {
            return $users;
        }else{
            return 'noData';
        }
    }

    public function jsonDataSecond($user_name)
    {
        $userData = DB::table('users')
            ->select('id', 'name', 'email', 'user_level', 'address_county', 'address_city', 'address_zip', 'address_street')
            ->where('email', '!=', 'admin@gmail.com')
            ->where('name', "=", $user_name)
            ->get();
//        dd($users);
        return $userData;
    }

    function addMutilpleAccountPage()
    {
//        dd(session()->has('user_id'));
        if(session()->has('user_id')) {
            return view('adminMutilAdd',[
//                'users' => $users,
//                'address_countys' => $address_countys,
//                'address_citys' => $address_citys,
            ]);
        }else{
            return redirect('/login');
        }
    }

    function addMutilpleAccount(Request $request)
    {
//        dd(session()->has('user_id'));
        $input = $request->input();
        $name_row = $request->input('name_row');
        $email_row = $request->input('email_row');

        for($i = 0; $i < count($name_row); $i++) {
            $user = new User;
            $user->name = $name_row[$i];
            $user->email = $email_row[$i];
            $user->save();
        }

        return redirect('/admin/add_mutil_account');
        // 驗證規則
//        $rules = [
//            //name
//            'name' => [
//                'required',
//                'min:1',
//            ],
//            //email
//            'email' => [
//                'required',
//                'max:150',
//                'email',
//            ],
//            //密碼
//            'password' => [
//                'required',
//                'min:5',
//            ],
//        ];
//        $error_message = [
//            'msg' => [
//                'This E-mail has already been registered,
//                 please try a new one！',
//            ],
//        ];
//
//        //驗證資料
//        $validator = Validator::make($input, $rules);
////        dd($validator);
//        if($validator->fails())
//        {
//            //資料驗證錯誤
//            return redirect('admin/account_search')
//                ->withErrors($validator)
//                ->withInput();
//        }
//
//        $userEmail = User::where(['email'=>$request->email])->first();
//
//        if($userEmail)
//        {
//            return redirect('admin/account_search')
//                ->withErrors($error_message)
//                ->withInput();
//        }
    }

}
