<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
//        $user = User::where('id', '!=', $id)->get();
//        dd($user);

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
        $user->save();

        return redirect('admin/list')->with('status', 'Account updated successfully！');
    }
}
