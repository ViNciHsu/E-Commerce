<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Socialite;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function googleSignInProcess()
    {
//        $test = Socialite::driver('google')
//            ->scopes(['https://www.googleapis.com/auth/userinfo.profile',
//                'https://www.googleapis.com/auth/userinfo.email',
//                'https://www.googleapis.com/auth/plus.me'])
//            ->with(
//                ['client_id' => '453343820007-7ve95p6p0ivglhn4atav31kop17vnp6j.apps.googleusercontent.com'],
//                ['client_secret' => 'qpQKmqk828Q4qA8naaMUqfmS'],
//                ['redirect' => 'http://ecom-laravel8.herokuapp.com/google-sign-in-callback'])
////            ->redirectUrl($redirect_url)
//            ->redirect();
//        dd($test);
//        $redirect_url = env('GOOGLE_REDIRECT');
//        dd($redirect_url);
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/plus.me'])
            ->with(
                ['client_id' => '453343820007-7ve95p6p0ivglhn4atav31kop17vnp6j.apps.googleusercontent.com'],
                ['client_secret' => 'qpQKmqk828Q4qA8naaMUqfmS'],
                ['redirect' => 'https://accounts.google.com/o/oauth2/auth/oauthchooseaccount?client_id=453343820007-7ve95p6p0ivglhn4atav31kop17vnp6j.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fgoogle-sign-in-callback&scope=openid%20profile%20email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.me&response_type=code&state=QRuW0Lpph23IFlRmWgOttWDRLLwJ9Aj04noPUgL3&flowName=GeneralOAuthFlow'])
//            ->redirectUrl($redirect_url)
            ->redirect();

    }

    public function googleSignInCallbackProcess()
    {
//        $user = Socialite::driver('google')->stateless()->user();
//        dd($user);
//        $redirect_url = env('GOOGLE_REDIRECT');
        try {
            $user = Socialite::driver('google')
                ->scopes(['https://www.googleapis.com/auth/userinfo.profile',
                    'https://www.googleapis.com/auth/userinfo.email',
                    'https://www.googleapis.com/auth/plus.me'])
                ->with(
                    ['client_id' => '453343820007-7ve95p6p0ivglhn4atav31kop17vnp6j.apps.googleusercontent.com'],
                    ['client_secret' => 'qpQKmqk828Q4qA8naaMUqfmS'],
                    ['redirect' => 'https://accounts.google.com/o/oauth2/auth/oauthchooseaccount?client_id=453343820007-7ve95p6p0ivglhn4atav31kop17vnp6j.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fgoogle-sign-in-callback&scope=openid%20profile%20email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.me&response_type=code&state=QRuW0Lpph23IFlRmWgOttWDRLLwJ9Aj04noPUgL3&flowName=GeneralOAuthFlow'])
//            ->redirectUrl($redirect_url)
//                ->redirect()
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // only allow people with @company.com to login
//        if(explode("@", $user->email)[1] !== 'company.com'){
//            return redirect()->to('/');
//        }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
//        dd($existingUser);
        if($existingUser){
            // log them in
//            auth()->login($existingUser, true);
            session()->put('user',$existingUser);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->password        = Hash::make(uniqid());
            $newUser->save();
//            auth()->login($newUser, true);
            session()->put('user',$newUser);
        }
        return redirect('/');
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
//        $redirect_url = env('FB_REDIRECT');
        Session::flash('url',$request->server('HTTP_REFERER'));
        return Socialite::driver('facebook')->redirect();
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
