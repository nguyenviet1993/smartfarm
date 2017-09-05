<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 22/06/2017
 * Time: 8:38 SA
 */
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class HistoriesController extends AuthenManagerRole
{

    public function showFees(){
        $view = View::make('fees_histories');
        $fee_catalog = new FeeCatalog(null);
        $filter = array();
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

        if (!empty($inputs['key'])) {
            $filter['key'] = $inputs['key'];
        }
        $re_fee_catalog = $fee_catalog->getAlls($filter);
        //get all inventory
        $fee = new Fee(null);

        $filter['date'] = $date;
        $re_fees = $fee->getAll($filter);
        $fees = array();
        $total = 0;
        foreach ($re_fees as $key => $value) {
            foreach ($re_fee_catalog as $cat) {
                if ($value['cat_id'] == $cat['cat_id']) {
                    $fees[$value['cat_id']]['cat_id'] = $value['cat_id'];
                    $fees[$value['cat_id']]['amount'] = $value['amount'];
                    $fees[$value['cat_id']]['price'] = $value['price'];
                    $fees[$value['cat_id']]['sum'] = $value['amount'] * $value['price'];
                    $total += $fees[$value['cat_id']]['sum'];
                }
            }
        }

        if (empty($inputs['date'])) {
            $date2 = date('d-m-Y', strtotime('-1 day',time()));
        } else {
            if ($inputs['date'] == '') {
                $date2 = date('d-m-Y', strtotime('-1 day',time()));
            } else {
                $date2 = date('d-m-Y', strtotime($inputs['date']));

            }
        }
        $view->select_date = date('d-m-Y', strtotime($date2));

        $view->total = $total;
        $view->key = @$filter['key'];
        $view->fee_catalogs = $re_fee_catalog;
        $view->fees = $fees;
        return $view;
    }

    public function showEnvironmentIndex(){
        $view = View::make('environment_index_histories');
        $user = new User(null);
        $filter = array(
            'username' => Session::get('user.username')
        );

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

        $re_user = $user->getRow($filter);
        $category = new Category(null);
        $filter = array(
            'code'=>CategoryDefine::$comp_time
        );
        $times = $category->getAll($filter);
        $filter = array(
            'code'=>CategoryDefine::$comp_environment_index
        );
        $environments = $category->getAll($filter);
        $filter['date'] = $date;
        $environments_index = new Environment(null);
        $re_environments_index = $environments_index->getAlls($filter);
        $index = array();
        foreach ($re_environments_index as $item){
            $id = $item['lake_id'].$item['type_id'].$item['time_id'];
            $index[$id]['hour'] = $item['hour'];
            $index[$id]['minute'] = $item['minute'];
            $index[$id]['val'] = $item['val'];
        }

        if (empty($inputs['date'])) {
            $date2 = date('d-m-Y', strtotime('-1 day',time()));
        } else {
            if ($inputs['date'] == '') {
                $date2 = date('d-m-Y', strtotime('-1 day',time()));
            } else {
                $date2 = date('d-m-Y', strtotime($inputs['date']));

            }
        }
        $view->select_date = date('d-m-Y', strtotime($date2));

        $view->index = $index;
        $view->environments = $environments;
        $view->times = $times;
        $view->lakes = $re_user['lake_id'];
        unset($user, $filter, $re_user, $category, $times, $environments_index, $environments, $re_environments_index, $index);
        return $view;
    }

    public function showNurturingProcess()
    {
        $view = View::make('nurturing_process_histories');
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
            $date = date('d-m-y', strtotime('-1 day',time()));
        } else {
            if ($inputs['date'] == '') {
                $date = date('d-m-y', strtotime('-1 day',time()));
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
                    $new_food[$item][$k]['food_type'] = $value['food_type'];
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
            $date2 = date('d-m-Y', strtotime('-1 day',time()));
        } else {
            if ($inputs['date'] == '') {
                $date2 = date('d-m-Y', strtotime('-1 day',time()));
            } else {
                $date2 = date('d-m-Y', strtotime($inputs['date']));

            }
        }
        $view->select_date = date('d-m-Y', strtotime($date2));
        $view->notes = $new_notes;
        $view->drugs = $re_drug;
        $view->new_foods = $new_food;
        $view->foods = array();
        $view->categories = $re_cat;
        $view->food_types = $re_food_type;
        return $view;
    }

    public function showDrugProcess()
    {
        $view = View::make('drug_process_histories');
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
        $inputs = Input::all();
        if (empty($inputs['date'])) {
            $date = date('d-m-y', strtotime('-1 day', time()));
        } else {
            if ($inputs['date'] == '') {
                $date = date('d-m-y', strtotime('-1 day',time()));
            } else {
                $date = date('d-m-y', strtotime($inputs['date']));

            }
        }
        $filter = array(
            'date' => $date
        );

        $re_drug = $drug->getAll($filter);
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
            $date2 = date('d-m-Y', strtotime('-1 day',time()));
        } else {
            if ($inputs['date'] == '') {
                $date2 = date('d-m-Y', time());
            } else {
                $date2 = date('d-m-Y', strtotime($inputs['date']));

            }
        }

        $view->select_date = date('d-m-Y', strtotime($date2));

        $view->notes = $new_notes;
        $view->drugs = $re_drug_cat;
        $view->new_drugs = $new_drug;
        $view->categories = $re_cat;
        unset($user, $filter, $re_user, $category, $re_cat, $re_drug, $food, $new_food, $item, $val, $value, $k, $key);
        return $view;
    }

    public function showNhaProcess()
    {
        $view = View::make('nha_process_histories');
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
        $inputs = Input::all();
        if (empty($inputs['date'])) {
            $date = date('d-m-y', strtotime('-1 day', time()));
        } else {
            if ($inputs['date'] == '') {
                $date = date('d-m-y', strtotime('-1 day',time()));
            } else {
                $date = date('d-m-y', strtotime($inputs['date']));

            }
        }
        $filter = array(
            'date' => $date
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

        if (empty($inputs['date'])) {
            $date2 = date('d-m-Y', strtotime('-1 day',time()));
        } else {
            if ($inputs['date'] == '') {
                $date2 = date('d-m-Y', strtotime('-1 day',time()));
            } else {
                $date2 = date('d-m-Y', strtotime($inputs['date']));

            }
        }
        $view->select_date = date('d-m-Y', strtotime($date2));

        $view->notes = $new_notes;
        $view->drugs = $re_drug;
        $view->new_nha = $new_nha;
        $view->categories = $re_cat;
        $view->food_types = $re_food_type;
        return $view;
    }
}