<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function addAccountListPage ()
    {
        $users = User::OrderBy('updated_at', 'desc')
            ->where('email', '!=', 'admin@gmail.com')
            ->paginate(10);

//        dd($users);
        return view('admin',[
            'users' => $users
        ]);
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
        $user->save();
//        dd($user);
        $success = true;
        return redirect('admin/add')->with('status', 'Account added successfully！');

    }

    public function UserAccountList()
    {
        $users = User::OrderBy('updated_at', 'desc')
            ->where('email', '!=', 'admin@gmail.com')
            ->paginate(10);

        return view('adminList',[
            'users' => $users
        ]);
    }

    // admin edit list
    public function updateUserAccountPage($id)
    {
        $user = User::all()->find($id);

        return view('adminEdit',[
            'user' => $user
        ]);
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
        $user->save();

        return redirect('admin/list')->with('status', 'Account updated successfully！');
    }

    public function searchAccount()
    {
        $users = User::all();
        $temp = [];
        foreach($users as $k => $v){
            $temp[] = $v->user_level;
            $counts = array_count_values($temp);
        }
        $max_count_user_level = array_keys($counts, max($counts));
//        dd($max_count_user_level);
        // 使用jsonData()撈到的ajax資料,引數目前放user_level數出來最多的index
        $users_ajax = $this->jsonData($max_count_user_level[0]);
//        dd($users_ajax);
        return view('adminAccountSearch',[
            'users' => $users,
            'users_ajax' => $users_ajax
        ]);
    }

    public function searchAccountAjax(Request $request)
    {
        $tmp = $request->search_user_level;
        return '11111111111';
//        $query = $request->search_query;
//        $tmp = $request->ajax();
//        dd($query);
//        echo '請求成功了';exit;
        //取回data
//        $data = $request->input('search_user_level');

        //取得所有data
//        $allData = $request->all();
//        dd($allData);
//        $results = User::all()->get();
        //取得多個table data
//        $results = DB::table('users')
//            ->select('id', 'name', 'email', 'user_level')
//            ->where('user_level', "=", $query)->get();
//        dd($results); //text

        //傳回到前端
//        return $results; //json
//        return response()->json($results);
    }

    public function jsonData($select_id = null)
    {
        $users = DB::table('users')
            ->select('id', 'name', 'email', 'user_level')
            ->where('email', '!=', 'admin@gmail.com')
            ->where('user_level', "=", $select_id)
            ->get();
//        dd($users);
        return $users;
    }

}
