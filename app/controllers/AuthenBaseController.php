<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/01/2016
 * Time: 2:32 CH
 */
use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Redirect;

class AuthenBaseController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('@filterRequests');
    }

    public function filterRequests()
    {
        switch (Session::get('user.role')){
            case CategoryDefine::$role_nvcs:
                return Redirect::to('/');
                break;
            case CategoryDefine::$role_ql:
                return Redirect::to('/statement');
                break;
            default:

                break;
        }
    }
}