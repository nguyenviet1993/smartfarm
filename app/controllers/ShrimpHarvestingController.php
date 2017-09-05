<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23/06/2017
 * Time: 2:34 CH
 */
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ShrimpHarvestingController extends AuthenManagerRole
{
    public function shrimpHarvesting()
    {
        $view = View::make('shrimp_harvesting');
        //get lakes
        $user = new User(null);
        $filter = array('email' => Session::get('user.username'));
        $re_user = $user->getRow($filter);
        $re_users = $user->getAll(array('role'=>CategoryDefine::$role_buyer));
        $view->users = $re_users;
        $view->lakes = $re_user['lake_id'];
        return $view;
    }

    public function addHarvestingAction()
    {
        $inputs = Input::all();
        //add buyer info
        $user = new User(null);
        $re_user = $user->getRow(array('user_id'=>$inputs['user_id']));
        $inputs['buyer'] = $re_user['full_name'];
        $inputs['address'] = $re_user['address'];
        $inputs['phone_number'] = $re_user['phone_number'];
        $inputs['email'] = $re_user['email'];
        $inputs['username'] = $re_user['username'];
        $lake = explode( '|', $inputs['lake']);
        $inputs['lake_id'] = $lake[0];
        $inputs['lake_name'] = $lake[1];
        $shrimp_harvesting = new ShrimpHarvesting($inputs);
        $re = $shrimp_harvesting->insert();

        //log action
        $data = array(
            'content'=>'bán '.$lake[1].' giá '.number_format($inputs['current_price'],0).'(vnđ/kg), khối lượng: '.number_format($inputs['weigh'],0).' Kg',
            'element_id'=> $re['harvesting_id']
        );
        ActionLog::insertDB(CategoryDefine::$log_sales_shrimp, $data);

        $filter = array(
            'lake_id' => $inputs['lake']
        );
        $lake = new Lake(null);
        $season = $lake->getRow($filter);
        Session::flash('success_add_harvesting', 'Thành công!');
        if ($inputs['weigh'] == 0 || $inputs['weigh'] == '') {

            $new_data = array(
                'status' => 2,
                'seed_source'=>'',
                'amount_brood'=>0,
                'acreage'=>0,
                'water_level'=>0,
                'start_date'=>'',
                'drug_start_date'=>'',
                'note'=>'',
                'amount_per_kg'=>0,
                'season'=>$season['season']+1
            );

            $lake->updateStatus($filter, $new_data);
        }else{
            $new_data = array(
                'status' => 1,
                'seed_source'=>'',
                'amount_brood'=>0,
                'acreage'=>0,
                'water_level'=>0,
                'start_date'=>'',
                'drug_start_date'=>'',
                'note'=>'',
                'amount_per_kg'=>0,
                'season'=>$season['season']+1
            );
            $lake->updateStatus($filter, $new_data);
        }
        return Redirect::to('/shrimp_harvesting');
    }
}