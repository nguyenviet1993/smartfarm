<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 8/24/2017
 * Time: 8:53 PM
 */
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthenManagerRole extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('@filterRequests');
    }

    public function filterRequests()
    {

        if ((Session::has('user.username') && Session::get('user.role') == CategoryDefine::$role_ql)
            || Session::get('user.role') == CategoryDefine::$role_super_admin) {
        }else{
            return Redirect::to('/login');
        }

    }
}