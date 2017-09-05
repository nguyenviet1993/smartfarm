<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/06/2017
 * Time: 10:30 SA
 */
class Fee
{
    protected $_collection = 'fees';
    protected $_fee = null;

    function __construct($data = array())
    {
        $this->_fee = array(
            'fee_id' => Pretty::getSequenceId('F'),
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
                'cat_id' => $this->_fee['cat_id'],
                'date' => $this->_fee['date']
            );
            if ($this->checkExits($filter) > 0) {
                $new_data = array(
                    'price' => (double)$this->_fee['price'],
                    'amount' => (int)$this->_fee['amount']
                );
                $re = $this->getRow($filter);
                $this->update($filter, $new_data);

                //action log

                $log_data = array(
                    'content' => 'nhập giá ' . number_format($re['price'], 0)
                        . '=>' . number_format($this->_fee['price'], 0)
                        . '. số lượng ' . number_format($re['amount'], 0)
                        . '=>' . number_format($this->_fee['amount'], 0)
                        . '(' . $re['catalog_name'] . ')',
                    'element_id' => $re['cat_id']
                );
                ActionLog::insertDB(CategoryDefine::$log_input_fee, $log_data);
            } else {
                LMongo::collection($this->_collection)->insert($this->_fee);
            }

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_fee;
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
            if (!empty($filter['status'])) $query->where('status', (int)$filter['status']);
            if (!empty($filter['date'])) {
                $query->where('date', $filter['date']);
            } else {
                $query->where('date', date('d-m-y', time()));
            }


            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAllNotDate($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            if (!empty($filter['status'])) $query->where('status', (int)$filter['status']);

            if (!empty($filter['from_date']) && !empty($filter['to_date'])) {
                $query = $query->whereBetween('create_date', (int)$filter['from_date'], (int)$filter['to_date']);
            }

            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            if (!empty($filter['status'])) $query->where('status', (int)$filter['status']);
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

    function sum($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            $result = $query->where('status', 1);
            return $result->sum();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}