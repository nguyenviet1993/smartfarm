<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 8/13/2017
 * Time: 8:38 PM
 */
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class StatementController extends AuthenManagerRole
{
    public function statementForm()
    {
        $view = View::make('statement_form');
        $fee = new Fee(null);
        $fee_filter = array(
            'status' => 1
        );
        $re_fee = $fee->getAllNotDate($fee_filter);
        $fee_sum = 0.0;
        foreach ($re_fee as $fee_item) {
            $fee_sum += $fee_item['price'] * $fee_item['amount'];
        }
        //get inventories
        $inventory = new Inventory(null);
        $inventory_filter = array(
            'status' => 1
        );
        $re_inventory = $inventory->getAllNotDate($inventory_filter);
        $inventory_sum = 0.0;
        foreach ($re_inventory as $inventory_item) {
            $inventory_sum += $inventory_item['price'] * $inventory_item['amount'];
        }

        //get all harvesting
        $harvesting = new ShrimpHarvesting(null);
        $harvesting_filter = array(
            'status' => 1
        );
        $re_harvesting = $harvesting->getAll($harvesting_filter);
        $harvesting_sum = 0.0;
        foreach ($re_harvesting as $harvesting_item) {
            $harvesting_sum += $harvesting_item['current_price'] * $harvesting_item['weigh'];
        }

        //get last settlement
        $settlement = new Settlement(null);
        $max_time = $settlement->getMax('time');
        $setlm_filter = array(
            'time'=>$max_time
        );
        $re_settlement = $settlement->getRow($setlm_filter);
        //calculate
        $interest = $harvesting_sum - ($inventory_sum + $fee_sum)+$re_settlement['reconciliation'];

        $view->reconciliation = $re_settlement['reconciliation'];
        $view->harvesting_sum = $harvesting_sum;
        $view->inventory_sum = $inventory_sum;
        $view->fee_sum = $fee_sum;
        $view->interest = $interest;
        return $view;
    }

    public function settlementAction()
    {
        $inputs = Input::all();
        $settlement = new Settlement(null);
        $max_time = $settlement->getMax('time');
        $inputs['time'] = $max_time+1;
        //get user info
        $user = new User(null);
        $user_filter = array(
            'username' => Session::get('user.username')
        );
        $re_user = $user->getRow($user_filter);
        $inputs['username'] = $re_user['username'];
        $inputs['full_name'] = $re_user['full_name'];
        $inputs['phone_number'] = $re_user['phone_number'];
        $inputs['email'] = $re_user['email'];
        $inputs['role'] = $re_user['role'];
        $inputs['role_name'] = $re_user['role_name'];
        $inputs['address'] = $re_user['address'];

        $settlement = new Settlement($inputs);
        $re = $settlement->insert();
        //log action
        $data = array(
            'content'=> ' quyết toán ngày '.date('d-m-Y').', lãi: '.number_format($re['interest_rate'],0),
            'element_id'=> $re['settlement_id']
        );
        ActionLog::insertDB(CategoryDefine::$log_sales_shrimp, $data);

        Session::flash('success_statement', 'Thành công!');
        return Redirect::to('/statement');
    }
}