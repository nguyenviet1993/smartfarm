<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 22/06/2017
 * Time: 2:10 CH
 */
use \Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DrugController extends AuthenNVCSController
{
    public function drugProcess()
    {
        $view = View::make('drug_process');
        $user = new User(null);
        $filter = array(
            'username' => Session::get('user.username')
        );
        $re_user = $user->getRow($filter);
        $view->lakes = $re_user['lake_id'];
        $category = new Category(null);
        $re_cat = $category->getAll(array('code' => CategoryDefine::$comp_time));
        $re_drug_cat = $category->getAll(array('code' => CategoryDefine::$comp_drug));

        //get drug
        $drug = new Drug(null);
        $filter = array(
            'date' => date('d-m-y')
        );

        $re_drug = $drug->getAll($filter);

        ////get all lakes
        $lake = new Lake(null);
        $re_lakes = $lake->getAll();
        $new_lake = array();
        //số lần cho ăn trong ngày
        $new_drug = array();
        foreach ($re_user['lake_id'] as $item => $val) {
            $k = 0;
            foreach ($re_drug as $key => $value) {
                if ($value['lake_id'] == $item) {
                    $new_drug[$item][$k]['lake_id'] = $item;
                    $new_drug[$item][$k]['time'] = $value['time'];
                    $new_drug[$item][$k]['hour'] = $value['hour'];
                    $new_drug[$item][$k]['minute'] = $value['minute'];
                    $new_drug[$item][$k]['drug_id'] = $value['drug_id'];
                    $new_drug[$item][$k]['drug_name'] = $value['drug_name'];
                    $new_drug[$item][$k]['amount'] = $value['amount'];
                    $k++;
                }
            }
            foreach ($re_lakes as $item_lake){
                if ($item_lake['lake_id'] == $item){
                    $new_lake[$item]['drug_start_date'] = $item_lake['drug_start_date'];
                }
            }
        }

        //get note
        $lake_note = new LakeNotes(null);
        $re_notes = $lake_note->getAll($filter);
        $new_notes = array();
        foreach ($re_notes as $note) {
            $new_notes[$note['lake_id']] = $note['note'];
        }

        $view->new_lake = $new_lake;
        $view->notes = $new_notes;
        $view->drugs = $re_drug_cat;
        $view->new_drugs = $new_drug;
        $view->categories = $re_cat;
        unset($user, $filter, $re_user, $category, $re_cat, $re_drug, $food, $new_food, $item, $val, $value, $k, $key, $lake_note, $lake, $new_notes, $note);
        return $view;
    }

    public function addDrugToLake()
    {
        $inputs = Input::all();
        $category = new Category(null);
        $re_drug = $category->getRow(array('category_id' => $inputs['drug_id']));
        $inputs['drug_id'] = $re_drug['category_id'];
        $inputs['drug_name'] = $re_drug['category_name'];
        $lake = new Lake(null);
        $filter = array(
            'lake_id' => $inputs['lake_id']
        );
        $re_lake = $lake->getRow($filter);
        $inputs['lake_name'] = $re_lake['lake_name'];
        if ($re_drug['type'] == CategoryDefine::$drug_type_antibiotics && $re_lake['status'] != 4) {
            $new_data = array(
                'status' => 4,
                'lake_id'=>$inputs['lake_id'],
                'lake_name'=>$inputs['lake_name'],
                'drug_start_date'=>date('d-m-Y', time())
            );
        } else {
            $new_data = array(
                'lake_id'=>$inputs['lake_id'],
                'lake_name'=>$inputs['lake_name']
            );
            //dùng thuốc chữa bệnh và đang đánh thuốc
            if ($re_drug['type'] == CategoryDefine::$drug_type_antibiotics && $re_lake['status'] == 4){
                $new_data['status'] = 4;
            }else{
                $new_data['status'] = 5;
                $new_data['drug_start_date'] = '';
            }

        }

        $lake->update($filter, $new_data);
        $drug = new Drug($inputs);
        $result = $drug->insert();
        unset($inputs, $category, $re_lake, $drug, $re_drug, $new_data, $filter, $lake);
        return $result;
    }

    public function updateDrugToLake()
    {
        $inputs = Input::all();
        $filter = array(
            'time' => $inputs['time'],
            'lake_id' => $inputs['lake_id']
        );
        $drug = new Drug(null);
        $new_data = array(
            'hour' => (int)$inputs['hour'],
            'minute' => (int)$inputs['minute']
        );

        $category = new Category(null);
        $re_drug = $category->getRow(array('category_id' => $inputs['drug_id']));
        $new_data['drug_id'] = $re_drug['category_id'];
        $new_data['drug_name'] = $re_drug['category_name'];
        $new_data['amount'] = (double)$inputs['drug_val'];

        $result = $drug->update($filter, $new_data);
        unset($inputs, $filter, $food, $new_data, $drug, $re_drug, $category);
        return $result;
    }

    public function stopDrugProcess(){
        $inputs = Input::all();
        $lake = new Lake(null);
        $filter = array(
            'lake_id'=>$inputs['lake_id']
        );
        $new_data = array(
            'status'=>5,
            'drug_start_date'=>''
        );
        $lake->updateStatus($filter, $new_data);
        return Redirect::to('/drug-process');
    }
}