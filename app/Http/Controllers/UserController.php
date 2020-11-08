<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Socialite;

class UserController extends Controller
{
    //
    function login(Request $request)
    {
        $error_message = [
            'msg' => [
                'Incorrect E-mail or password,
                 please reconfirm your E-mail and password！',
            ],
        ];
        $user = User::where(['email'=>$request->email])->first();
//        dd($user);
        if(!$user || !Hash::check($request->password,$user->password))
        {
            return redirect('/login')
                ->withErrors($error_message)
                ->withInput();
        }
        else
        {
            $request->session()->put('user',$user);
            return redirect('/');
        }
    }

    function register(Request $request)
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
//        dd($user);
        if($validator->fails())
        {
            //資料驗證錯誤
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }
        $userEmail = User::where(['email'=>$request->email])->first();
//        dd($userAccount);
        if($userEmail)
        {
            return redirect('register')
                ->withErrors($error_message)
                ->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('login');
    }
}
