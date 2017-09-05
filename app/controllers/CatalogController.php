<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20/06/2017
 * Time: 8:30 SA
 */
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CatalogController extends AuthenManagerRole
{
    public function formCatalog()
    {
        $view = View::make('form_catalog');
        $category = new Category(null);
        $units = $category->getAll(array('code' => CategoryDefine::$comp_unit));

        //get
        $catalog = new Catalog(null);
        $re_catalog = $catalog->getAll();
        $view->catalogs = $re_catalog;
        $view->units = $units;
        unset($category, $units, $catalog, $re_catalog);
        return $view;
    }

    public function addCatalogAction()
    {
        $inputs = Input::all();
        $category = new Category(null);
        $unit = $category->getRow(array('category_id' => $inputs['unit_id']));
        $inputs['unit'] = $unit['category_name'];
        $catalog = new Catalog($inputs);

        if ($catalog->checkExits(@$inputs['cat_id']) > 0) {
            $filter = array(
                'cat_id'=>$inputs['cat_id']
            );
            $new_data = array(
                'catalog_name'=>$inputs['catalog_name'],
                'unit_id'=>$inputs['unit_id'],
                'unit'=>$inputs['unit']
            );
            $re = $catalog->update($filter, $new_data);

            //action log
            $log_data =  array(
                'content'=>'thêm mới danh mục vật tư "'.$inputs['catalog_name'].'"',
                'element_id'=>$re['unit_id']

            );
            ActionLog::insertDB(CategoryDefine::$log_add_catalog,$log_data);
            unset($inputs, $catalog, $filter, $unit, $new_data);
            Session::flash('success_catalog', 'Cập nhật thành công!');
        } else {
            $catalog->insert();
            unset($inputs, $catalog, $category, $unit, $filter);
            Session::flash('success_catalog', 'Thành công!');
        }
        return Redirect::to('/form-catalog');
    }

    public function inputInventory()
    {
        $view = View::make('input_inventory');
        $filter = array(
            'key'=>''
        );
        $inputs = Input::all();
        if (!empty($inputs['key'])){
            $filter = array(
                'key'=>$inputs['key']
            );
        }
        $catalog = new Catalog(null);
        $re_catalog = $catalog->getAlls($filter);
        //get all inventory
        $inventory = new Inventory(null);
        $re_inventories = $inventory->getAll();
        $inventories = array();
        $total = 0;
        foreach ($re_inventories as $key => $value) {
            foreach ($re_catalog as $cat) {
                if ($value['cat_id'] == $cat['cat_id']) {
                    $inventories[$value['cat_id']]['cat_id'] = $value['cat_id'];
                    $inventories[$value['cat_id']]['amount'] = $value['amount'];
                    $inventories[$value['cat_id']]['price'] = $value['price'];
                    $inventories[$value['cat_id']]['sum'] = $value['amount'] * $value['price'];
                    $total += $inventories[$value['cat_id']]['sum'];
                }
            }
        }
        $view->total = $total;
        $view->key = $filter['key'];
        $view->catalogs = $re_catalog;
        $view->inventories = $inventories;
        unset($filter, $inputs, $catalog, $re_catalog, $inventories, $inventory, $re_inventories, $value, $key, $cat);
        return $view;
    }

    public function inputInventoryAction()
    {
        $inputs = Input::all();
        //get catalog
        $catalog = new Catalog(null);
        $re_catalog = $catalog->getRow($inputs);
        $inputs['unit_id'] = $re_catalog['unit_id'];
        $inputs['unit'] = $re_catalog['unit'];
        $inputs['catalog_name'] = $re_catalog['catalog_name'];
        $inventory = new Inventory($inputs);
        $result = $inventory->insert();
        unset($inputs, $catalog, $re_catalog, $inventory);
        return $result;
    }

    public function delCatalog(){
        $inputs = Input::all();
        //check exits
        $catalog = new Catalog(null);
        $count = $catalog->checkExits($inputs['id']);
        $filter = array(
            'cat_id'=>$inputs['id']
        );
        if ($count > 0){
            $catalog->delete($filter);
            Session::flash('success_delete_catalog', 'Thành công!');
        }
        unset($inputs, $catalog, $count, $filter);
        return Redirect::to('/form-catalog');
    }
}