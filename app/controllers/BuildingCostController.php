<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 03/06/2017
 * Time: 3:15 CH
 */
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class BuildingCostController extends AuthenBaseController
{
    public function basicBuilding(){
        $view = View::make('basic_building');

        return $view;
    }
}