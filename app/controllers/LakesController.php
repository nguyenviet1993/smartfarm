<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 25/05/2017
 * Time: 8:11 SA
 */
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class LakesController extends AuthenNVCSController
{
    public function formAddLake()
    {
        $view = View::make('form_add_lake');

        return $view;
    }

    public function addLakeAction()
    {
        $inputs = Input::all();
        $lake = new Lake($inputs);
        $lake->insert();
        unset($lake, $inputs);
        Session::flash('success_add_lake', 'Thành công!');
        return Redirect::to('/form-add-lake');
    }

    public function lakes()
    {
        $view = View::make('lakes');
        $lake = new Lake(null);
        $lakes = $lake->getAll();
        $lake_note = new LakeNotes(null);
        $filter = array(
            'date' => date('d-m-y', time())
        );
        $re_note = $lake_note->getAll($filter);
        $new_note = array();
        foreach ($lakes as $lake) {
            foreach ($re_note as $note) {
                if ($note['lake_id'] == $lake['lake_id']) {
                    $new_note[$lake['lake_id']]['note'] = $note['note'];
                }
            }
        }
        $view->notes = $new_note;
        $view->lakes = $lakes;
        return $view;
    }

    public function editLake()
    {
        $inputs = Input::all();
        $view = View::make('edit_lake');
        $lake = new Lake(null);
        $filter = array(
            'lake_id' => $inputs['id']
        );
        if ($lake->checkExits($inputs['id']) > 0) {
            $re_lake = $lake->getRow($filter);
            $view->lake = $re_lake;
            unset($inputs, $lake, $filter, $re_lake);
            return $view;
        } else {
            return Redirect::to('/lakes');
        }

    }

    public function editLakeAction()
    {
        $inputs = Input::all();

        $lake = new Lake(null);

        $new_data = array(
            'lake_id' => $inputs['lake_id'],
            'lake_name' => $inputs['lake_name'],
            'amount_brood' => (int)$inputs['amount_brood'],
            'acreage' => (double)$inputs['acreage'],
            'water_level' => (int)$inputs['water_level'],
            'start_date' => $inputs['start_date'],
            'seed_source' => $inputs['seed_source'],
            'amount_per_kg' => (int)$inputs['amount_per_kg'],
            'note' => $inputs['note'],
            'season' => (int)$inputs['season'],
        );
        $filter = array(
            'lake_id' => $inputs['lake_id']
        );
        if ($lake->checkExits($inputs['lake_id']) > 0) {
            $lake->update($filter, $new_data);
            unset($lake, $new_data, $filter);
            if ($inputs['btnSave'] == 'save') {
                Session::flash('success_edit_lake', 'Thành công!');
                return Redirect::to('/edit-lake?id=' . $inputs['lake_id']);
            } else {
                return Redirect::to('/lakes');
            }
        } else {
            return Redirect::to('/lakes');
        }
    }

    public function addNote()
    {
        $inputs = Input::all();
        $lake = new Lake(null);
        $filter = array(
            'lake_id' => $inputs['lake_id']
        );
        $re_lake = $lake->getRow($filter);
        $inputs['lake_name'] = $re_lake['lake_name'];
        $inputs['date'] = date('d-m-y', strtotime($inputs['date']));
        $lake_note = new LakeNotes($inputs);
        $result = $lake_note->insert();
        unset($inputs, $lake_note);
        return $result;
    }

    public function nurturingProcess()
    {
        $view = View::make('nurturing_process');
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
        $food = new Food(null);
        $inputs = Input::all();
        if (empty($inputs['date'])) {
            $date = date('d-m-y', time());
        } else {
            if ($inputs['date'] == '') {
                $date = date('d-m-y', time());
            } else {
                $date = date('d-m-y', strtotime($inputs['date']));

            }
        }

        $filter = array(
            'date' => $date
        );

        $re_food = $food->getAll($filter);
        //số lần cho ăn trong ngày
        $new_food = array();
        foreach ($re_user['lake_id'] as $item => $val) {
            $k = 0;
            foreach ($re_food as $key => $value) {
                if ($value['lake_id'] == $item) {
                    $new_food[$item][$k]['food_id'] = $value['food_id'];
                    $new_food[$item][$k]['lake_id'] = $item;
                    $new_food[$item][$k]['time'] = $value['time'];
                    $new_food[$item][$k]['hour'] = $value['hour'];
                    $new_food[$item][$k]['minute'] = $value['minute'];
                    $new_food[$item][$k]['food_type_id'] = $value['food_type_id'];
                    $new_food[$item][$k]['food_val_1'] = $value['food_val_1'];
                    $new_food[$item][$k]['food_val_2'] = $value['food_val_2'];
                    $k++;
                }
            }
        }


        //get note
        $lake_note = new LakeNotes(null);
        $filter = array(
            'date' => $date
        );
        $re_notes = $lake_note->getAll($filter);
        $new_notes = array();
        foreach ($re_notes as $note) {
            $new_notes[$note['lake_id']] = $note['note'];
        }

        $smart_time = array();
        $cat_filter = array(
            'code' => CategoryDefine::$comp_smart_hour,
        );
        $re_smart_time = $category->getAll($cat_filter);

        foreach ($re_smart_time as $item) {
            $smart_time['type'][$item['type']] = array(
                'hour_value'=>$item['value'],
                'minute_value'=>$item['value1']
            );
        }
        $view->smart_time = $smart_time;
        $view->select_date = @$inputs['date'];
        $view->notes = $new_notes;
        $view->drugs = $re_drug;
        $view->new_foods = $new_food;
        $view->foods = array();
        $view->categories = $re_cat;
        $view->food_types = $re_food_type;
        unset($user, $filter, $re_user, $category, $re_cat, $re_drug, $food, $re_food, $new_food, $item, $val, $value, $k, $key);
        return $view;
    }

    public function addEatToLake()
    {
        $inputs = Input::all();
        $category = new Category(null);

        $re_food = $category->getRow(array('category_id' => $inputs['food_type_id']));
        $inputs['food_type'] = $re_food['category_name'];
        $str = explode("->", explode(" ", $re_food['category_name'])[0]);
        $type1 = $str[0];
        $type2 = !empty($str[1]) ? $str[1] : null;
        $val1 = $inputs['food_val'] * $re_food['value'];
        $val2 = $inputs['food_val'] * $re_food['value1'];
        $inputs['food_type_1'] = $type1;
        $inputs['food_type_2'] = $type2;
        $inputs['food_val_1'] = $val1;
        $inputs['food_val_2'] = $val2;
        $lake = new Lake(null);
        $re_lake = $lake->getRow(array('lake_id' => $inputs['lake_id']));
        $inputs['lake_name'] = $re_lake['lake_name'];
        if (!empty($inputs['date'])) {
            $inputs['date'] = date('d-m-y', strtotime($inputs['date']));
        } else {
            $inputs['date'] = date('d-m-y', time());
        }


        $food = new Food($inputs);
        $result = $food->insert();

        unset($inputs, $category, $re_lake, $re_drug_3, $re_drug_1, $re_drug_2, $food);
        return $result;
    }

    public function updateEatToLake()
    {
        $inputs = Input::all();
        if (!empty($inputs['date'])) {
            $inputs['date'] = date('d-m-y', strtotime($inputs['date']));
        } else {
            $inputs['date'] = date('d-m-y', time());
        }

        $filter = array(
            'time' => $inputs['time'],
            'lake_id' => $inputs['lake_id'],
            'date' => $inputs['date']

        );
        $food = new Food(null);

        $new_data = array(
            'food_type_id' => $inputs['food_type_id'],
            'food_val' => (double)$inputs['food_val'],
            'hour' => (int)$inputs['hour'],
            'minute' => (int)$inputs['minute'],
            'date' => $inputs['date']
        );

        $category = new Category(null);

        $re_food = $category->getRow(array('category_id' => $inputs['food_type_id']));
        $new_data['food_type'] = $re_food['category_name'];
        $str = explode("->", explode(" ", $re_food['category_name'])[0]);
        $type1 = $str[0];
        $type2 = !empty($str[1]) ? $str[1] : null;
        $val1 = $inputs['food_val'] * $re_food['value'];
        $val2 = $inputs['food_val'] * $re_food['value1'];

        $new_data['food_type_1'] = $type1;
        $new_data['food_type_2'] = $type2;
        $new_data['food_val_1'] = $val1;
        $new_data['food_val_2'] = $val2;
//        var_dump($new_data);die;
        $result = $food->update($filter, $new_data);
        unset($inputs, $filter, $food, $new_data);
        return $result;
    }

    public function nurturingProcessAdmin()
    {
        $view = View::make('nurturing_process_admin');
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
        $food = new Food(null);
        $inputs = Input::all();
        if (empty($inputs['date'])) {
            $date = date('d-m-y', time());
        } else {
            if ($inputs['date'] == '') {
                $date = date('d-m-y', time());
            } else {
                $date = date('d-m-y', strtotime($inputs['date']));

            }
        }

        $filter = array(
            'date' => $date
        );

        $re_food = $food->getAll($filter);
        //số lần cho ăn trong ngày
        $new_food = array();
        foreach ($re_user['lake_id'] as $item => $val) {
            $k = 0;
            foreach ($re_food as $key => $value) {
                if ($value['lake_id'] == $item) {
                    $new_food[$item][$k]['food_id'] = $value['food_id'];
                    $new_food[$item][$k]['lake_id'] = $item;
                    $new_food[$item][$k]['time'] = $value['time'];
                    $new_food[$item][$k]['hour'] = $value['hour'];
                    $new_food[$item][$k]['minute'] = $value['minute'];
                    $new_food[$item][$k]['food_type_id'] = $value['food_type_id'];
                    $new_food[$item][$k]['food_val_1'] = $value['food_val_1'];
                    $new_food[$item][$k]['food_val_2'] = $value['food_val_2'];
                    $k++;
                }
            }
        }

        //get note
        $lake_note = new LakeNotes(null);
        $filter = array(
            'date' => $date
        );
        $re_notes = $lake_note->getAll($filter);
        $new_notes = array();
        foreach ($re_notes as $note) {
            $new_notes[$note['lake_id']] = $note['note'];
        }
        if (empty($inputs['date'])) {
            $date2 = date('d-m-Y', time());
        } else {
            if ($inputs['date'] == '') {
                $date2 = date('d-m-Y', time());
            } else {
                $date2 = date('d-m-Y', strtotime($inputs['date']));

            }
        }

        $smart_time = array();
        $cat_filter = array(
            'code' => CategoryDefine::$comp_smart_hour,
        );
        $re_smart_time = $category->getAll($cat_filter);

        foreach ($re_smart_time as $item) {
            $smart_time['type'][$item['type']] = array(
                'hour_value'=>$item['value'],
                'minute_value'=>$item['value1']
            );
        }
        $view->smart_time = $smart_time;
        $view->select_date = $date2;
        $view->notes = $new_notes;
        $view->drugs = $re_drug;
        $view->new_foods = $new_food;
        $view->foods = array();
        $view->categories = $re_cat;
        $view->food_types = $re_food_type;
        unset($user, $filter, $re_user, $category, $re_cat, $re_drug, $food, $re_food, $new_food, $item, $val, $value, $k, $key);
        return $view;
    }
}