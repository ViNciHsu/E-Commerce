<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

    // Facebook 登入
    public function facebookSignInProcess()
    {
        $redirect_url = env('FB_REDIRECT');
//dd($redirect_url);
        return Socialite::driver('facebook')
//            ->scopes(['user_friends'])
            ->redirectUrl($redirect_url)
            ->redirect();
    }

    // Facebook 登入重新導向授權資料處理
    public function facebookSignInCallbackProcess()
    {
        if(request()->error == 'access_denied')
        {
            throw new Exception('授權失敗,存取錯誤');
        }

        // 依照網域產生重新導向連結，驗證是否為發出時同 callback
        $redirect_url = env('FB_REDIRECT');

        // 取得第三方使用者資料
        $FacebookUser = Socialite::driver('facebook')
            ->fields([
                'name',
                'email',
                'gender',
                'verified',
                'link',
                'first_name',
                'last_name',
                'locale',
            ])
            ->redirectUrl($redirect_url)->user();

        $facebook_email = $FacebookUser->email;

        if(is_null($facebook_email))
        {
            throw new Exception('未授權取得使用者 Email');
        }

        // 取得 Facebook 資料
        $facebook_id = $FacebookUser->id;
        $facebook_name = $FacebookUser->name;

        // 取得使用者資料是否有此 Facebook_id 資料
        $user = User::where('facebook_id',$facebook_id)->first();

        if(is_null($user))
        {
            // 沒有綁定 Facebook_id 的帳號，透過 Email 尋找是否有此帳號
            $user = User::where('email',$facebook_email)->first();
            if(!is_null($user))
            {
                // 有此帳號，綁定 Facebook ID
                $user->facebook_id = $facebook_id;
                $user->save();
            }
        }

        if(is_null($user))
        {
            // 尚未註冊
            $input = [
                'facebook_id' => $facebook_id, // Facebook ID
                'email' => $facebook_email, // Email
                'password' => uniqid(), // 隨機產生密碼
            ];

            // 密碼加密
            $input['password'] = Hash::make($input['password']);
            // 新增會員資料
            $user = User::create($input);
            /*  此處新增至資料庫時,第一次facebook_id不會寫入
            *  第二次以facebook帳號登入,facebook_id才會寫入
            *  之後能直接以facebook登入
            *  不確定第一次不會寫入是否正常
            */

            session()->put('user',$user);
            return redirect()->intended('/');
        }
    }

    public function facebookLink(Request $request)
    {
        //紀錄一開始頁面的url,因為登入成功後要跳轉回來
        $redirect_url = env('FB_REDIRECT');
//        Session::flash('url',$request->server('HTTP_REFERER'));
//        return Socialite::driver('facebook')->redirect();
        return Socialite::driver('facebook')
//            ->scopes(['user_friends'])
            ->redirectUrl($redirect_url)
            ->redirect();
    }

    public function facebookCallback()
    {
        if(request()->error == 'access_denied')
        {
            throw new Exception('授權失敗,存取錯誤');
        }

        // 依照網域產生重新導向連結，驗證是否為發出時同 callback
        $redirect_url = env('FB_REDIRECT');

        // 取得第三方使用者資料
        $FacebookUser = Socialite::driver('facebook')
            ->fields([
                'name',
                'email',
                'gender',
                'verified',
                'link',
                'first_name',
                'last_name',
                'locale',
            ])
            ->redirectUrl($redirect_url)->user();

        $facebook_email = $FacebookUser->email;

        if(is_null($facebook_email))
        {
            throw new Exception('未授權取得使用者 Email');
        }

        // 取得 Facebook 資料
        $facebook_id = $FacebookUser->id;
        $facebook_name = $FacebookUser->name;

        // 取得使用者資料是否有此 Facebook_id 資料
        $user = User::where('facebook_id',$facebook_id)->first();

        if(is_null($user))
        {
            // 沒有綁定 Facebook_id 的帳號，透過 Email 尋找是否有此帳號
            $user = User::where('email',$facebook_email)->first();
            if(!is_null($user))
            {
                // 有此帳號，綁定 Facebook ID
                $user->facebook_id = $facebook_id;
                $user->save();
            }
        }

        if(is_null($user))
        {
            // 尚未註冊
            $input = [
                'facebook_id' => $facebook_id, // Facebook ID
                'email' => $facebook_email, // Email
                'password' => uniqid(), // 隨機產生密碼
            ];

            // 密碼加密
            $input['password'] = Hash::make($input['password']);
            // 新增會員資料
            $user = User::create($input);
            /*  此處新增至資料庫時,第一次facebook_id不會寫入
            *  第二次以facebook帳號登入,facebook_id才會寫入
            *  之後能直接以facebook登入
            *  不確定第一次不會寫入是否正常
            */

            session()->put('user',$user);
            return redirect()->intended('/');
        }
    }
}
