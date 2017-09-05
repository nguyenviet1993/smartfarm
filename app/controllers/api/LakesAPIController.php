<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 7/22/2017
 * Time: 9:59 PM
 */
class LakesAPIController extends RestController
{
    public function getLakes()
    {
        $inputs = RestController::$params;
        //get all lakes
        $lake = new Lake(null);
        $re_lake = $lake->getAllToArray();
        if (count($re_lake) > 0) {
            $i = 0;
            $lakes = array();
            foreach ($re_lake as $item) {
                $lakes[$i]['lake_id'] = $item['lake_id'];
                $lakes[$i]['lake_name'] = $item['lake_name'];
                $lakes[$i]['amount_brood'] = $item['amount_brood'];
                $lakes[$i]['acreage'] = $item['acreage'];
                $lakes[$i]['water_level'] = $item['water_level'];
                $lakes[$i]['start_date'] = $item['start_date'];
                $lakes[$i]['seed_source'] = $item['seed_source'];
                $lakes[$i]['status'] = $item['status'];
                $lakes[$i]['create_date'] = $item['create_date'];
                $lakes[$i]['drug_start_date'] = $item['drug_start_date'];
                $lakes[$i]['amount_per_kg'] = $item['amount_per_kg'];
                $lakes[$i]['note'] = $item['note'];
                $i++;
            }
            return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_SUCCESS, $lakes);
        } else {
            return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, null);
        }
    }

    public function getFoodType()
    {
        $inputs = RestController::$params;
        $cat = new Category(null);
        $cat_filter = array(
            'code' => CategoryDefine::$comp_food_type
        );
        $result = $cat->getAll($cat_filter);
        if (count($result) > 0) {
            $food_types = array();
            $i = 0;
            foreach ($result as $item) {
                $food_types[$i]['type_id'] = $item['category_id'];
                $food_types[$i]['type_name'] = $item['category_name'];
                $food_types[$i]['order'] = $item['order'];
                $food_types[$i]['value1'] = $item['value'];
                $food_types[$i]['value2'] = $item['value1'];
                $i++;
            }
            return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_SUCCESS, $food_types);
        } else {
            return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, EMPTY_DATA);
        }
    }

    public function setFoodToLake()
    {
        $inputs = RestController::$params;
        if (!empty($inputs['lake_id']) && !empty($inputs['time'])
            && !empty($inputs['food_type_id']) && !empty($inputs['hour'])
            && !empty($inputs['minute']) && !empty($inputs['food_val'])
        ) {

            $category = new Category(null);

            $re_food = $category->getRow(array('category_id' => $inputs['food_type_id']));
            if (count($re_food) > 0) {
                $inputs['food_type'] = $re_food['category_name'];

                $val1 = $inputs['food_val'] * $re_food['value'];
                $val2 = $inputs['food_val'] * $re_food['value1'];
                $inputs['food_type_1'] = $re_food['ftype'];
                $inputs['food_type_2'] = $re_food['ftype1'];
                $inputs['food_val_1'] = $val1;
                $inputs['food_val_2'] = $val2;

                $lake = new Lake(null);
                $ck_lake = $lake->checkExits($inputs['lake_id']);
                if ($ck_lake > 0) {
                    $re_lake = $lake->getRow(array('lake_id' => $inputs['lake_id']));
                    $inputs['lake_name'] = $re_lake['lake_name'];

                    $food = new Food($inputs);
                    $result = $food->insert();
                    return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_SUCCESS, $result);
                } else {
                    return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, INVALID_LAKE);
                }
            } else {
                return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, INVALID_LAKE);
            }
        } else {
            return ResponseMsg::makeResp($inputs, ResponseMsg::SDK_FAIL, INVALID_PARAMS);
        }
    }
}