<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 8/22/2017
 * Time: 9:53 PM
 */
class Settlement
{
    protected $_collection = 'settlement';
    protected $_settlement = null;

    function __construct($data = array())
    {
        $this->_settlement = array(
            'settlement_id' => Pretty::getSequenceId('STM'),
            'fees' => (double)$data['fees'],
            'inventories' => (double)$data['inventories'],
            'harvesting' => (double)$data['harvesting'],
            'reconciliation' => (double)$data['reconciliation'],//số dư kì trước
            'interest_rate' => (double)$data['interest_rate'],//tiền lãi
            'time' => $data['time'],
            'note' => $data['note'],
            'username' => $data['username'],
            'full_name' => !empty($data['full_name'])?$data['full_name']:$data['full_name'],
            'phone_number' => !empty($data['phone_number'])?$data['phone_number']:$data['phone_number'],
            'email' => !empty($data['email'])?$data['email']:$data['email'],
            'role' => !empty($data['role'])?$data['role']:$data['role'],
            'role_name' => !empty($data['role_name'])?$data['role_name']:$data['role_name'],
            'address' => !empty($data['address'])?$data['address']:$data['address'],
            'status' => 1,
            'date' => date('d-m-Y', time()),
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            LMongo::collection($this->_collection)->insert($this->_settlement);

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_settlement;
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query = $query->where('date', date('d-m-y', time()));
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['code'])) $query->where('code', $filter['code']);
            return $query->orderBy('order')->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['time'])) $query->where('time', (int)$filter['time']);
            return $query->first();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getMax($max_field)
    {
        try {
            $query = LMongo::collection($this->_collection);
            return $query->max($max_field);
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function checkExits($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query->where('date', date('d-m-y', time()));
            $query->where('date', date('d-m-y', time()));
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}