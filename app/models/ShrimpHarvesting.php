<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 7/15/2017
 * Time: 7:52 AM
 */
class ShrimpHarvesting
{
    protected $_collection = 'shrimp_harvesting';
    protected $_shrimp_harvesting = null;

    function __construct($data = array())
    {
        $this->_shrimp_harvesting = array(
            'harvesting_id' => Pretty::getSequenceId('SH'),
            'weigh' => (double)$data['weigh'],
            'size' => (double)$data['size'],
            'current_price' => (double)$data['current_price'],
            'buyer' => $data['buyer'],
            'user_id'=>$data['user_id'],
            'username'=>$data['username'],
            'address'=>$data['address'],
            'phone_number'=>$data['phone_number'],
            'email'=>$data['email'],
            'type' => $data['type'],
            'day_of_sale' => $data['day_of_sale'],
            'lake_name' => $data['lake_name'],
            'lake_id' => $data['lake_id'],
            'note' => $data['note'],
            'date' => date('d-m-y', time()),
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            LMongo::collection($this->_collection)->insert($this->_shrimp_harvesting);

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_shrimp_harvesting;
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
            if (!empty($filter['category_id'])) $query->where('category_id', $filter['category_id']);
            return $query->first();
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