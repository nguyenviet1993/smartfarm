<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 03/06/2017
 * Time: 10:48 SA
 */
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class ShrimpIndexController extends AuthenNVCSController
{
    public function shrimpIndex(){
        $view = View::make('shrimp_index');
        $shrimp = new ShrimpIndex(null);
        $shrimps = $shrimp->getAll();
        $lake = new Lake(null);
        $lakes = $lake->getAll();
        $shrimp_indexs = array();
        foreach ($lakes as $key=>$value){

            foreach ($shrimps as $item){
                if ($item['lake_id'] == $value['lake_id']){
                    $shrimp_indexs[$item['lake_id']]['amount_per_kg'] = $item['amount_per_kg'];
                    $shrimp_indexs[$item['lake_id']]['date'] = $item['date'];
                }
            }
        }

        $view->shrimp_indexs = $shrimp_indexs;
        $view->lakes = $lakes;
        unset($shrimp, $shrimps, $shrimp_indexs, $lake, $lakes);
        return $view;
    }

    public function updateShrimpIndex(){
        $view = View::make('update_shrimp_index');

        return $view;
    }
}