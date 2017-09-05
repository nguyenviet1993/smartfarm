<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 25/05/2017
 * Time: 2:07 CH
 */
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoriesController extends AuthenManagerRole
{
    public function formDrugItem(){
        $view = View::make('form_drug_item');
        $category = new Category(null);
        $filter = array(
            'code'=>CategoryDefine::$comp_drug
        );
        $drugs = $category->getAll($filter);
        $order_max = $category->getMax($filter,'order');
        //get

        $catalog = new Catalog(null);
        $re_catalog = $catalog->getAll();
        $view->catalogs = $re_catalog;
        $view->drugs = $drugs;
        $view->order_max = $order_max+1;
        return $view;
    }

    public function addDrugItemAction(){
        $inputs = Input::all();
        $data = array(
            'category_name' => $inputs['category_name'],
            'code' => CategoryDefine::$comp_drug,
            'order' => (int)$inputs['order'],
            'type' => $inputs['type'],
            'value' => 0,
            'value1' => 0,
            'ftype' => '',
            'ftype1' => '',
        );
        $category = new Category($data);

        if ($category->checkExits($inputs['category_id']) > 0)
        {
            $filter = array(
                'category_id'=>$inputs['category_id']
            );
            $category->update($filter, $data);
        }else{
            $category->insert();
        }
        Session::flash('success_drug_item','Thành công!');
        return Redirect::to('/form-drug-item');
    }

    public function formEatTimeItem(){
        $view = View::make('form_eat_time_item');
        $category = new Category(null);
        $filter = array(
            'code'=>CategoryDefine::$comp_smart_hour
        );
        $smart_time = $category->getAll($filter);
        $order_max = $category->getMax($filter,'order');
        //get

        $catalog = new Catalog(null);
        $re_catalog = $catalog->getAll();
        $view->catalogs = $re_catalog;
        $view->smart_time = $smart_time;
        $view->order_max = $order_max+1;
        return $view;
    }

    public function addEatTimeItemAction(){
        $inputs = Input::all();

        $filter = array(
            'code'=>CategoryDefine::$comp_smart_hour
        );
        $cat = new Category(null);
        $time_max = $cat->getMax($filter,'type');
        $data = array(
            'category_name' => $inputs['value'].'h'.$inputs['value1'],
            'code' => CategoryDefine::$comp_smart_hour,
            'order' => (int)$inputs['order'],
            'value' => (int)$inputs['value'],
            'value1' => (int)$inputs['value1'],
            'type'=>$time_max+1,
            'ftype' => '',
            'ftype1' => '',
        );
        $category = new Category($data);
        if ($category->checkExits($inputs['category_id']) > 0)
        {
            $filter = array(
                'category_id'=>$inputs['category_id']
            );
            $category->update($filter, $data);
        }else{
            $category->insert();
        }
        Session::flash('success_eat_time_item','Thành công!');
        return Redirect::to('/form-eat-time-item');
    }

    public function formFoodTypeItem(){
        $view = View::make('form_food_type_item');
        $category = new Category(null);
        $filter = array(
            'code'=>CategoryDefine::$comp_food_type
        );
        $food_type = $category->getAll($filter);
        $order_max = $category->getMax($filter,'order');
        //get

        $catalog = new Catalog(null);
        $re_catalog = $catalog->getAll();
        $view->catalogs = $re_catalog;
        $view->food_types = $food_type;
        $view->order_max = $order_max+1;
        return $view;
    }

    public function addFoodTypeItemAction(){
        $inputs = Input::all();

        $value = explode('-', $inputs['ratio']);
        $inputs['value'] = $value[0];
        $inputs['value1'] = $value[1];
        $name = '';
        switch ($value[0]){
            case '0':
                $name = '0';
                break;
            case '1':
                $name = '1';
                break;
            case '0.3':
                $name = '1/3';
                break;
            case '0.5':
                $name = '1/2';
                break;
            case '0.7':
                $name = '2/3';
                break;
        }
        $name1 = '';
        switch ($value[1]){
            case '0':
                $name1 = '0';
                break;
            case '1':
                $name1 = '1';
                break;
            case '0.3':
                $name1 = '1/3';
                break;
            case '0.5':
                $name1 = '1/2';
                break;
            case '0.7':
                $name1 = '2/3';
                break;
        }

        if ($inputs['ftype'] == $inputs['ftype1']){
            $inputs['category_name'] = $inputs['ftype'];
            $inputs['value'] = 1;
            $inputs['value1'] = 0;
            $inputs['ftype1'] = '';
        }else{
            $inputs['category_name'] = $inputs['ftype'].'->'.$inputs['ftype1'].' ('.$name.'-'.$name1.')';
        }
        unset($inputs['ratio']);
        $data = array(
            'category_name' => $inputs['category_name'],
            'code' => CategoryDefine::$comp_food_type,
            'order' => (int)$inputs['order'],
            'type' => 1,
            'value' => $inputs['value'],
            'value1' => $inputs['value1'],
            'ftype' => $inputs['ftype'],
            'ftype1' => $inputs['ftype1'],
        );

        $category = new Category($data);

        if ($category->checkExits($inputs['category_id']) > 0)
        {
            $filter = array(
                'category_id'=>$inputs['category_id']
            );
            $category->update($filter, $data);
        }else{
            $category->insert();
        }
        Session::flash('success_food_type_item','Thành công!');
        return Redirect::to('/form-food-type-item');
    }

    public function getFoodType(){
        $inputs = Input::all();
        $category = new Category(null);
        $re_cat = $category->getRow(array('category_id'=>$inputs['category_id']));
        return $re_cat;

    }
}