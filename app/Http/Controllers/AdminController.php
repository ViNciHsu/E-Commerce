<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function productsManageListPage()
    {
        return view('admin');
    }

    public function addAccount(Request $request)
    {

        $input = $request->input();

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
            return redirect('admin')
                ->withErrors($validator)
                ->withInput();
        }

        $userEmail = User::where(['email'=>$request->email])->first();

        if($userEmail)
        {
            return redirect('admin')
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
        return redirect('admin')->with('status', 'Account added successfully！');

    }
}
