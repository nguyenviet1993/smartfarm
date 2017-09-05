<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 02/06/2017
 * Time: 11:00 SA
 */
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class EnvironmentController extends AuthenNVCSController
{
    public function environmentIndex(){
        $view = View::make('environment_index');
        $user = new User(null);
        $filter = array(
            'username' => Session::get('user.username')
        );
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
        $environments_index = new Environment(null);
        $re_environments_index = $environments_index->getAll();
        $index = array();
        foreach ($re_environments_index as $item){
            $id = $item['lake_id'].$item['type_id'].$item['time_id'];
            $index[$id]['hour'] = $item['hour'];
            $index[$id]['minute'] = $item['minute'];
            $index[$id]['val'] = $item['val'];
        }

        $view->index = $index;
        $view->environments = $environments;
        $view->times = $times;
        $view->lakes = $re_user['lake_id'];
        unset($user, $filter, $re_user, $category, $times, $environments_index, $environments, $re_environments_index, $index);
        return $view;
    }

    public function inputEnvironmentIndex(){
        $inputs = Input::all();
        //get times
        $category = new Category(null);
        $times = $category->getRow(array('category_id'=>$inputs['time_id']));
        $inputs['time'] = $times['category_name'];
        $lake = new Lake(null);
        //get lake
        $re_lake = $lake->getRow(array('lake_id'=>$inputs['lake_id']));
        $inputs['lake'] = $re_lake['lake_name'];

        //get type
        $type = $category->getRow(array('category_id'=>$inputs['type_id']));
        $inputs['type'] = $type['category_name'];
        $environment = new Environment($inputs);
        $result = $environment->insert();
        unset($category, $times, $inputs, $environment, $re_lake, $lake);
        return $result;
    }
}