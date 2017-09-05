<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15/06/2017
 * Time: 8:47 SA
 */
use Illuminate\Support\Facades\Input;

class UploadController extends AuthenNVCSController
{
    public function uploadImage()
    {
        $inputs = Input::all();
        $destination_path = public_path() . '/image-upload/';
        $file_name = str_random(12) . date('Y-d-m');
        $file = Input::file('file');
        $file->move($destination_path, $file_name . $file->getClientOriginalName());

        $inputs['image_url'] = '/image-upload/' . $file_name . $file->getClientOriginalName();
        $nha_daily = new NhaDaily($inputs);
        $nha_daily->insert();
        unset($destination_path, $file_name, $file, $nha_daily);
        return $inputs;
    }

    public function updateNhaImage(){
        $inputs = Input::all();
        $nha = new NhaDaily(null);
        $filter = array(
            'lake_id' => $inputs['lake_id'],
            'time' => $inputs['time']
        );

        $file = Input::file('file');
        $new_data = array();
        if ($file!=null) {
            $destination_path = public_path() . '/image-upload/';
            $file_name = str_random(12) . date('Y-d-m');
            $file->move($destination_path, $file_name . $file->getClientOriginalName());
            $new_data['image_url'] = '/image-upload/' . $file_name . $file->getClientOriginalName();
        }

        $result = $nha->update($filter, $new_data);
        unset($inputs, $nha, $filter, $file, $destination_path, $file_name, $new_data);
        return $result;
    }
}