<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class HomeController extends AuthenBaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
	    $view = View::make('index');
        $username = Session::get('user.username');
        $user = new User(null);
        $filter = array(
           'username' => $username
        );
        $lakes = $user->getRow($filter);

        //get food today
        $food = new Food(null);
        $re_foods = $food->getAll();
        $arr_lakes = array();
        foreach ($lakes['lake_id'] as $key=>$value){
            $k =0;
            foreach ($re_foods as $food_value){
                if ($key==$food_value['lake_id']){
                    $arr_lakes[$value][$k]['lake_id'] = $food_value['lake_id'];
                    $arr_lakes[$value][$k]['lake_name'] = $food_value['lake_name'];
                    $arr_lakes[$value][$k]['food_type'] = $food_value['food_type']=='default'?'Số':$food_value['food_type'];
                    $arr_lakes[$value][$k]['food_val'] = $food_value['food_val'];
                    $arr_lakes[$value][$k]['drug_1'] = $food_value['drug_1'];
                    $arr_lakes[$value][$k]['drug_val_1'] = $food_value['drug_val_1'];
                    $arr_lakes[$value][$k]['drug_2'] = $food_value['drug_2'];
                    $arr_lakes[$value][$k]['drug_val_2'] = $food_value['drug_val_2'];
                    $arr_lakes[$value][$k]['drug_3'] = $food_value['drug_3'];
                    $arr_lakes[$value][$k]['drug_val_3'] = $food_value['drug_val_3'];
                    $k++;
                }

            }
        }

        $view->lakes = $arr_lakes;
        unset($user, $username, $food, $re_foods, $arr_lakes, $lakes, $value, $key, $k, $filter, $food_value);
		return $view;
	}

}
