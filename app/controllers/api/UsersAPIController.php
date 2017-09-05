<?php

/**
 * Created by PhpStorm.
 * User: nguyen
 * Date: 7/2/2017
 * Time: 11:01 PM
 */
class UsersAPIController extends RestController
{
    public function login()
    {
        $inputs = RestController::$params;
        if (!empty($inputs['username']) && !empty($inputs['password'])) {
            //check login
            $user = new User(null);
            $filter = array(
                'username' => $inputs['username'],
                'password' => $inputs['password']
            );
            $count = $user->checkExits($filter);
            if ($count > 0) {
                $re_user = $user->getRow($filter);
                unset($re_user['_id'], $re_user['password']);
                return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_SUCCESS, $re_user);
            } else {
                return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, null);
            }
        } else {
            return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, null, ResponseMsg::SDK_INVALID_PARAMS);
        }
    }
}