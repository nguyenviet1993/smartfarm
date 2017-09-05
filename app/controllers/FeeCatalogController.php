<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/06/2017
 * Time: 9:29 SA
 */
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class FeeCatalogController extends AuthenManagerRole
{
    public function formFeeCatalog()
    {
        $view = View::make('form_fee_catalog');
        $category = new Category(null);
        //get
        $fee_catalog = new FeeCatalog(null);
        $view->fee_catalogs = $fee_catalog->getAll();
        $view->units = $category->getAll(array('code' => CategoryDefine::$comp_fee_unit));
        unset($category, $fee_catalog);
        return $view;
    }

    public function addFeeCatalogAction()
    {
        $inputs = Input::all();
        $category = new Category(null);
        $unit = $category->getRow(array('category_id' => $inputs['unit_id']));
        $inputs['unit'] = $unit['category_name'];
        $fee_catalog = new FeeCatalog($inputs);

        if ($fee_catalog->checkExits(@$inputs['cat_id']) > 0) {
            $filter = array(
                'cat_id' => $inputs['cat_id']
            );
            $new_data = array(
                'catalog_name',
                'unit_id' => $inputs['unit_id'],
                'unit' => $inputs['unit']
            );
            $re = $fee_catalog->update($filter, $new_data);

            //action log
            $log_data =  array(
                'content'=>'thêm mới danh mục chi phí "'.$inputs['catalog_name'].'"',
                'element_id'=>$re['unit_id']

            );
            ActionLog::insertDB(CategoryDefine::$log_add_catalog,$log_data);
            Session::flash('success_fee_catalog', 'Cập nhật thành công!');
        } else {
            $fee_catalog->insert();
            Session::flash('success_fee_catalog', 'Thành công!');
        }
        unset($inputs, $category, $unit, $fee_catalog, $filter, $new_data);
        return Redirect::to('/form-fee-catalog');
    }

    public function inputFee()
    {
        $view = View::make('input_fee');
        $fee_catalog = new FeeCatalog(null);
        $filter = array();
        $inputs = Input::all();
        if (!empty($inputs['key'])) {
            $filter['key'] = $inputs['key'];
        }
        $re_fee_catalog = $fee_catalog->getAlls($filter);
        //get all inventory
        $fee = new Fee(null);
        $re_fees = $fee->getAll();
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
        $view->total = $total;
        $view->key = @$filter['key'];
        $view->fee_catalogs = $re_fee_catalog;
        $view->fees = $fees;
        unset($fee_catalog, $filter, $inputs, $re_fee_catalog, $fee, $re_fees, $key, $value, $cat, $fees);
        return $view;
    }

    public function inputFeeAction()
    {
        $inputs = Input::all();
        //get catalog
        $fee_catalog = new FeeCatalog(null);
        $re_fee_catalog = $fee_catalog->getRow($inputs);
        $inputs['unit_id'] = $re_fee_catalog['unit_id'];
        $inputs['unit'] = $re_fee_catalog['unit'];
        $inputs['catalog_name'] = $re_fee_catalog['catalog_name'];
        $fee = new Fee($inputs);
        $result = $fee->insert();
        unset($inputs, $fee_catalog, $re_fee_catalog, $fee);
        return $result;
    }
}