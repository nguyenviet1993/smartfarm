<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 25/01/2016
 * Time: 10:28 SA
 */
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Redirect;
use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Cookie;

class UserAuthController extends BaseController
{
    public function loginAction()
    {
        $inputs = Input::all();
        //check email and password
        $user = new User(null);
        $filter = array(
            'username' => $inputs['username'],
            'password' =>  md5($inputs['password']),
            'status' => 1
        );

        $re_user = $user->getRow($filter);

        unset($filter, $user, $inputs);
        if (Cookie::has('username')){
            switch (Cookie::get('user.role')){
                case CategoryDefine::$role_ql:
                    return Redirect::to('/statement');
                    break;
                case CategoryDefine::$role_nvcs:
                    return Redirect::to('/');
                    break;
            }
        }
        if ($re_user != "" && $re_user != null) {
            if(Input::get('cb_remember') == 'on'){
                Session::put('user.username', $re_user['username']);
                Session::put('user.full_name', $re_user['full_name']);
                Session::put('user.role', $re_user['role']);
                Session::put('user.role_name', $re_user['role_name']);
                $username = Cookie::make('username', $re_user['username']);
                $fullname = Cookie::make('full_name', $re_user['full_name']);
                $role = Cookie::make('role', $re_user['role']);
                switch (Session::get('user.role')){
                    case CategoryDefine::$role_ql:
                        return Redirect::to('/statement');
                        break;
                    case CategoryDefine::$role_nvcs:
                        return Redirect::to('/');
                        break;
                }
                return Redirect::to('/')->withCookie($username)->withCookie($fullname)->withCookie($role);
            }else{
                Session::put('user.username', $re_user['username']);
                Session::put('user.full_name', $re_user['full_name']);
                Session::put('user.role', $re_user['role']);
                Session::put('user.role_name', $re_user['role_name']);
                switch (Session::get('user.role')){
                    case CategoryDefine::$role_ql:
                        return Redirect::to('/statement');
                        break;
                    case CategoryDefine::$role_nvcs:
                        return Redirect::to('/');
                        break;
                }

            }

        } else {
            return Redirect::to('/login');
        }


    }

    public function logout()
    {
        //handler logout
        $username = Cookie::forget('username');
        $password = Cookie::forget('password');

        Session::remove('user.username');
        Session::remove('user.full_name');
        Session::remove('user.role');
        Session::remove('user.role_name');

        return Redirect::to('/login')->withCookie($username)->withCookie($password);
    }
}