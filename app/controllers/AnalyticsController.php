<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 8/8/2017
 * Time: 10:33 PM
 */
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class AnalyticsController extends AuthenManagerRole
{
    public function foodAnalytic()
    {
        $view = View::make('food_analytic');
        $inputs = Input::all();
        if (empty($inputs['from_date'])) {
            $from_date = date('d-m-y', strtotime('-1 month', time()));
        } else {
            if ($inputs['from_date'] == '') {
                $from_date = date('d-m-y', strtotime('-1 month', time()));
            } else {
                $from_date = date('d-m-y', strtotime($inputs['from_date']));

            }
        }
        $from_date_00 = strtotime(date('d-m-y 00:00:00', strtotime($from_date)));

        $filter = array(
            'from_date' => $from_date_00
        );

        if (empty($inputs['from_date'])) {
            $from_date2 = date('d-m-Y', strtotime('-1 month', time()));
        } else {
            if ($inputs['from_date'] == '') {
                $from_date2 = date('d-m-Y', strtotime('-1 month', time()));
            } else {
                $from_date2 = date('d-m-Y', strtotime($inputs['from_date']));

            }
        }
//////////////////////
        if (empty($inputs['to_date'])) {
            $to_date = date('d-m-y', time());
        } else {
            if ($inputs['to_date'] == '') {
                $to_date = date('d-m-y', time());
            } else {
                $to_date = date('d-m-y', strtotime($inputs['to_date']));

            }
        }
        $to_date_24 = strtotime(date('d-m-y 23:59:59', strtotime($to_date)));
        $filter['to_date'] = $to_date_24;


        if (empty($inputs['to_date'])) {
            $to_date2 = date('d-m-Y');
        } else {
            if ($inputs['to_date'] == '') {
                $to_date2 = date('d-m-Y');
            } else {
                $to_date2 = date('d-m-Y', strtotime($inputs['to_date']));

            }
        }

        if (!empty($inputs['lake_id']) && @$inputs['lake_id'] != 'default') {
            $filter['lake_id'] = $inputs['lake_id'];
        }


        $food = new Food(null);
        $re_food = $food->getAll($filter);
        $real_foods = array();
        $sum = 0.0;
        for ($i = 0; $i < 7; $i++) {
            $value = 0.0;
            foreach ($re_food as $food_item) {

                if ((string)$i == @$food_item['food_type_1'] && @$food_item['food_val_1'] != 0) {
                    $value += $food_item['food_val_1'];
                }
                if ((string)$i == @$food_item['food_type_2'] && @$food_item['food_val_2'] != 0) {
                    $value += $food_item['food_val_2'];
                }
            }
            $real_foods[$i] = $value;
            $sum += $value;

        }
        $view->sum = $sum;
        $view->foods = $real_foods;
        //get all lake
        $lake = new Lake(null);
        $lakes = $lake->getAll();

        $view->lake_id = @$inputs['lake_id'];
        $view->lakes = $lakes;
        $view->from_date = date('d-m-Y', strtotime($from_date2));
        $view->to_date = date('d-m-Y', strtotime($to_date2));
        return $view;
    }

    public function foodDetails(){
        $view = View::make('food_details');
        $inputs = Input::all();
        $food = new Food(null);
        $filter = array(
            'food_type_1'=>@$inputs['id'],
            'food_type_2'=>@$inputs['id'],
        );
        if (!empty($inputs['lake_id']) && @$inputs['lake_id'] != 'default'){
            $filter['lake_id'] = $inputs['lake_id'];
        }

        if (!empty($inputs['from_date']) && @$inputs['from_date'] != ""){
            $con_from_date = date('d-m-y', strtotime($inputs['from_date']));
            $from_date_00 = strtotime(date('d-m-y 00:00:00', strtotime($con_from_date)));
            $filter['from_date'] = $from_date_00;
        }

        if (!empty($inputs['to_date']) && @$inputs['to_date'] != ""){
            $con_to_date = date('d-m-y', strtotime($inputs['to_date']));
            $to_date_24 = strtotime(date('d-m-y 23:59:59', strtotime($con_to_date)));
            $filter['to_date'] = $to_date_24;
        }

        $re_food = $food->getAll($filter);
        $view->from_date = @$inputs['from_date'];
        $view->to_date = @$inputs['to_date'];
        $view->lake_id = @$inputs['lake_id'];
        $view->food_type = @$inputs['id'];
        $view->foods = $re_food;
        return $view;
    }


    public function drugAnalytic()
    {
        $view = View::make('drug_analytic');
        $inputs = Input::all();
        if (empty($inputs['from_date'])) {
            $from_date = date('d-m-y', strtotime('-1 month', time()));
        } else {
            if ($inputs['from_date'] == '') {
                $from_date = date('d-m-y', strtotime('-1 month', time()));
            } else {
                $from_date = date('d-m-y', strtotime($inputs['from_date']));

            }
        }

        $from_date_00 = strtotime(date('d-m-y 00:00:00', strtotime($from_date)));
        $filter = array(
            'from_date' => $from_date_00
        );

        if (empty($inputs['from_date'])) {
            $from_date2 = date('d-m-Y', strtotime('-1 month', time()));
        } else {
            if ($inputs['from_date'] == '') {
                $from_date2 = date('d-m-Y', strtotime('-1 month', time()));
            } else {
                $from_date2 = date('d-m-Y', strtotime($inputs['from_date']));

            }
        }
//////////////////////
        if (empty($inputs['to_date'])) {
            $to_date = date('d-m-y', time());
        } else {
            if ($inputs['to_date'] == '') {
                $to_date = date('d-m-y', time());
            } else {
                $to_date = date('d-m-y', strtotime($inputs['to_date']));

            }
        }
        $to_date_24 = strtotime(date('d-m-y 23:59:59', strtotime($to_date)));
        $filter['to_date'] = $to_date_24;

        if (empty($inputs['to_date'])) {
            $to_date2 = date('d-m-Y');
        } else {
            if ($inputs['to_date'] == '') {
                $to_date2 = date('d-m-Y');
            } else {
                $to_date2 = date('d-m-Y', strtotime($inputs['to_date']));

            }
        }

        if (!empty($inputs['lake_id']) && @$inputs['lake_id'] != 'default') {
            $filter['lake_id'] = $inputs['lake_id'];
        }

        $drug = new Drug(null);
        $re_drug = $drug->getAll($filter);
        $real_drugs = array();
        $sum = 0.0;
        //get all categories
        $cat = new Category(null);
        $drug_type = $cat->getAll(array('code'=>CategoryDefine::$comp_drug));

        foreach ($drug_type as $type_item){
            $value = 0.0;
            foreach ($re_drug as $drug_item) {

                if ($type_item['category_id'] == $drug_item['drug_id']) {
                    $value += $drug_item['amount'];
                }
            }
            $real_drugs[$type_item['category_id']]['amount'] = $value;
            $real_drugs[$type_item['category_id']]['drug_name'] = $type_item['category_name'];
            $real_drugs[$type_item['category_id']]['drug_id'] = $type_item['category_id'];
            $sum += $value;

        }

        $view->sum = $sum;
        $view->drugs = $real_drugs;
        //get all lake
        $lake = new Lake(null);
        $lakes = $lake->getAll();

        $view->lake_id = @$inputs['lake_id'];
        $view->lakes = $lakes;
        $view->from_date = date('d-m-Y', strtotime($from_date2));
        $view->to_date = date('d-m-Y', strtotime($to_date2));
        return $view;
    }

    public function drugDetails(){
        $view = View::make('drug_details');
        $inputs = Input::all();
        $drug = new Drug(null);
        $filter = array(
            'drug_id'=>@$inputs['id']
        );
        if (!empty($inputs['lake_id']) && @$inputs['lake_id'] != "default"){
            $filter['lake_id'] = $inputs['lake_id'];
        }

        if (!empty($inputs['from_date']) && @$inputs['from_date'] != ""){
            $con_from_date = date('d-m-y', strtotime($inputs['from_date']));
            $from_date_00 = strtotime(date('d-m-y 00:00:00', strtotime($con_from_date)));
            $filter['from_date'] = $from_date_00;
        }

        if (!empty($inputs['to_date']) && @$inputs['to_date'] != ""){
            $con_to_date = date('d-m-y', strtotime($inputs['to_date']));
            $to_date_24 = strtotime(date('d-m-y 23:59:59', strtotime($con_to_date)));
            $filter['to_date'] = $to_date_24;
        }

        $category = new Category(null);
        $filter_cat = array(
            'category_id'=>@$inputs['id']
        );

        $view->from_date = @$inputs['from_date'];
        $view->to_date = @$inputs['to_date'];
        $view->lake_id = @$inputs['lake_id'];
        $drug_name = $category->getRow($filter_cat);
        $re_drug = $drug->getAll($filter);
        $view->drug_name = $drug_name;
        $view->drugs = $re_drug;
        return $view;
    }


    public function feeAnalytic()
    {
        $view = View::make('fee_analytic');
        $inputs = Input::all();
        if (empty($inputs['from_date'])) {
            $from_date = date('d-m-y', strtotime('-1 month', time()));
        } else {
            if ($inputs['from_date'] == '') {
                $from_date = date('d-m-y', strtotime('-1 month', time()));
            } else {
                $from_date = date('d-m-y', strtotime($inputs['from_date']));

            }
        }

        $from_date_00 = strtotime(date('d-m-y 00:00:00', strtotime($from_date)));
        $filter = array(
            'from_date' => $from_date_00
        );

        if (empty($inputs['from_date'])) {
            $from_date2 = date('d-m-Y', strtotime('-1 month', time()));
        } else {
            if ($inputs['from_date'] == '') {
                $from_date2 = date('d-m-Y', strtotime('-1 month', time()));
            } else {
                $from_date2 = date('d-m-Y', strtotime($inputs['from_date']));

            }
        }
//////////////////////
        if (empty($inputs['to_date'])) {
            $to_date = date('d-m-y', time());
        } else {
            if ($inputs['to_date'] == '') {
                $to_date = date('d-m-y', time());
            } else {
                $to_date = date('d-m-y', strtotime($inputs['to_date']));

            }
        }
        $to_date_24 = strtotime(date('d-m-y 23:59:59', strtotime($to_date)));
        $filter['to_date'] = $to_date_24;

        if (empty($inputs['to_date'])) {
            $to_date2 = date('d-m-Y');
        } else {
            if ($inputs['to_date'] == '') {
                $to_date2 = date('d-m-Y');
            } else {
                $to_date2 = date('d-m-Y', strtotime($inputs['to_date']));

            }
        }
        $filter['status'] = 1;
        $fee = new Fee(null);
        $re_fees = $fee->getAllNotDate($filter);
        $real_fees = array();
        $sum = 0.0;
        //get all categories
        $fee_catalog = new FeeCatalog(null);
        $re_cat = $fee_catalog->getAll();

        foreach ($re_cat as $cat_item){
            $price = 0.0;
            $amount = 0.0;
            $sum_row = 0.0;
            foreach ($re_fees as $fee_item) {

                if ($cat_item['cat_id'] == $fee_item['cat_id']) {
                    $price += $fee_item['price'];
                    $amount += $fee_item['amount'];
                    $sum_row += $fee_item['price']*$fee_item['amount'];
                }
            }
            $real_fees[$cat_item['cat_id']]['price'] = $price;
            $real_fees[$cat_item['cat_id']]['catalog_name'] = $cat_item['catalog_name'];
            $real_fees[$cat_item['cat_id']]['amount'] = $amount;
            $real_fees[$cat_item['cat_id']]['sum_row'] = $sum_row;
            $real_fees[$cat_item['cat_id']]['unit'] = $cat_item['unit'];
            $real_fees[$cat_item['cat_id']]['cat_id'] = $cat_item['cat_id'];
            $real_fees[$cat_item['cat_id']]['cat_id'] = $cat_item['cat_id'];
            $sum += $sum_row;

        }

        $view->sum = $sum;
        $view->fees = $real_fees;
        $view->from_date = date('d-m-Y', strtotime($from_date2));
        $view->to_date = date('d-m-Y', strtotime($to_date2));
        return $view;
    }

    public function feeDetails(){
        $view = View::make('fee_details');
        $inputs = Input::all();
        $fee = new Fee(null);
        $filter = array(
            'cat_id'=>@$inputs['id'],
            'status'=>1
        );

        if (!empty($inputs['from_date']) && @$inputs['from_date'] != ""){
            $con_from_date = date('d-m-y', strtotime($inputs['from_date']));
            $from_date_00 = strtotime(date('d-m-y 00:00:00', strtotime($con_from_date)));
            $filter['from_date'] = $from_date_00;
        }

        if (!empty($inputs['to_date']) && @$inputs['to_date'] != ""){
            $con_to_date = date('d-m-y', strtotime($inputs['to_date']));
            $to_date_24 = strtotime(date('d-m-y 23:59:59', strtotime($con_to_date)));
            $filter['to_date'] = $to_date_24;
        }

        $view->from_date = @$inputs['from_date'];
        $view->to_date = @$inputs['to_date'];
        $re_fee = $fee->getAllNotDate($filter);
        $view->fees = $re_fee;
        return $view;
    }
}