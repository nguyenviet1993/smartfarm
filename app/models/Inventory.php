<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20/06/2017
 * Time: 2:45 CH
 */
class Inventory
{
    protected $_collection = 'inventories';
    protected $_inventory = null;

    function __construct($data = array())
    {
        $this->_inventory = array(
            'inventory_id' => Pretty::getSequenceId('CL'),
            'cat_id' => $data['cat_id'],
            'catalog_name' => $data['catalog_name'],
            'price' => (double)$data['price'],
            'amount' => (int)$data['amount'],
            'unit_id' => $data['unit_id'],
            'unit' => $data['unit'],
            'date' => date('d-m-y', time()),
            'status' => 1,
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            //check exit
            $filter = array(
                'cat_id' => $this->_inventory['cat_id'],
                'date' => date('d-m-y', time())
            );
            if ($this->checkExits($filter) > 0) {
                $new_data = array(
                    'price' => (double)$this->_inventory['price'],
                    'amount' => (int)$this->_inventory['amount']
                );
                $this->update($filter, $new_data);

                //action log
                $re = $this->getRow($filter);

                $log_data =  array(
                    'content'=>'nhập giá '.number_format($re['price'],0)
                        .'=>'.number_format($this->_inventory['price'],0)
                        .'. số lượng '.number_format($re['amount'],0)
                        .'=>'.number_format($this->_inventory['amount'],0)
                        .'('.$re['catalog_name'].')',
                    'element_id'=>$re['cat_id']
                );
                ActionLog::insertDB(CategoryDefine::$log_input_inventory,$log_data);
            } else {
                LMongo::collection($this->_collection)->insert($this->_inventory);
            }

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_inventory;
    }

    function checkExits($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            $query->where('date', date('d-m-y', time()));
            if (!empty($filter['status'])) $query->where('status', (int)$filter['status']);
            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAllNotDate($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['status'])) $query->where('status', (int)$filter['status']);
            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            return $query->first();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            $query->where('date', date('d-m-y', time()));
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}