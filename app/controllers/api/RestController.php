<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 07/06/2016
 * Time: 4:49 CH
 */
use \Illuminate\Support\Facades\Input;

class RestController extends BaseController
{
    public static $params;

    public function __construct()
    {
        self::$params = Input::all();
        $this->beforeFilter('@filterRequests');
    }

    public function filterRequests()
    {
        $auth = $this->auth();
        if ($auth != 1) {
            $res = '';
            if ($auth == 406) $res = ResponseMsg::SDK_INCORRECT_SIGNATURE;
            print_r(ResponseMsg::makeResp(self::$params, $res));
            exit();
        }
    }

    static public function auth()
    {
//        $request_signature = self::$params['signature'];
//        unset(self::$params['signature']);
        ksort(self::$params);
        $signature = implode('', self::$params);
//        if ($request_signature != md5($signature)) {
//            return ResponseMsg::SDK_INCORRECT_SIGNATURE;
//        } else {
            return ResponseMsg::SDK_SUCCESS;
//        }
    }
}