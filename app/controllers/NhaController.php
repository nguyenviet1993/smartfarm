<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/06/2017
 * Time: 2:32 CH
 */
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class NhaController extends AuthenNVCSController
{
    public function nhaProcess()
    {
        $view = View::make('nha_process');
        $user = new User(null);
        $filter = array(
            'username' => Session::get('user.username')
        );
        $re_user = $user->getRow($filter);
        $view->lakes = $re_user['lake_id'];
        $category = new Category(null);
        $re_cat = $category->getAll(array('code' => CategoryDefine::$comp_time));
        $re_drug = $category->getAll(array('code' => CategoryDefine::$comp_drug));
        $re_food_type = $category->getAll(array('code' => CategoryDefine::$comp_food_type));
        //get food
        $nha_daily = new NhaDaily(null);
        $filter = array(
            'date' => date('d-m-y', time())
        );
        $re_nha_daily = $nha_daily->getAll($filter);

        //số lần kiểm tra nhá trong ngày
        $new_nha = array();
        foreach ($re_user['lake_id'] as $item => $val) {
            $k = 0;
            foreach ($re_nha_daily as $key => $value) {
                if ($value['lake_id'] == $item) {
                    $new_nha[$item][$k]['nha_id'] = $value['nha_id'];
                    $new_nha[$item][$k]['lake_id'] = $item;
                    $new_nha[$item][$k]['time'] = (int)$value['time'];
                    $new_nha[$item][$k]['hour'] = $value['hour'];
                    $new_nha[$item][$k]['minute'] = $value['minute'];
                    $new_nha[$item][$k]['image_url'] = $value['image_url'];
                    $new_nha[$item][$k]['duration'] = $value['duration'];
                    $new_nha[$item][$k]['result'] = $value['result'];
                    $k++;
                }
            }
        }

        //get note
        $lake_note = new LakeNotes(null);
        $filter = array(
            'date' => date('d-m-y')
        );
        $re_notes = $lake_note->getAll($filter);
        $new_notes = array();
        foreach ($re_notes as $note) {
            $new_notes[$note['lake_id']] = $note['note'];
        }
        $view->notes = $new_notes;
        $view->drugs = $re_drug;
        $view->new_nha = $new_nha;
        $view->foods = array();
        $view->categories = $re_cat;
        $view->food_types = $re_food_type;
        unset($user, $re_user, $filter, $category, $re_cat, $re_drug, $re_food_type, $nha_daily, $re_nha_daily, $new_nha, $lake_note, $re_notes);
        return $view;
    }

    public function updateNhaProcess()
    {
        $inputs = Input::all();
        $nha = new NhaDaily(null);
        $filter = array(
            'lake_id' => $inputs['lake_id'],
            'time' => $inputs['time']
        );

        $new_data = array(
            'hour' => (int)$inputs['hour'],
            'minute' => (int)$inputs['minute'],
            'duration' => (double)$inputs['duration'],
            'result' => $inputs['result']
        );
        $file = Input::file('file');
        if ($file!=null) {
            $destination_path = public_path() . '/image-upload/';
            $file_name = str_random(12) . date('Y-d-m');
            $file->move($destination_path, $file_name . $file->getClientOriginalName());
            $new_data['image_url'] = '/image-upload/' . $file_name . $file->getClientOriginalName();
        }
        $result = $nha->update($filter, $new_data);
        unset($inputs, $nha, $filter, $new_data, $file, $destination_path, $file_name);
        return $result;
    }
}