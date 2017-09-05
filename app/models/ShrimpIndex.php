<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/06/2017
 * Time: 9:41 SA
 */
class ShrimpIndex
{
    protected $_collection = 'shrimp_index';
    protected $_shrimp_index = null;

    function __construct($data = array())
    {
        $this->_shrimp_index = array(
            'index_id' => Pretty::getSequenceId('SI'),
            'amount_per_kg' => (int)@$data['amount_per_kg'],
            'lake_name' => $data['lake_name'],
            'lake_id' => $data['lake_id'],
            'season'=> (int)@$data['season'],
            'date' => date('d-m-y', time()),
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            $filter = array(
                'lake_id'=>$this->_shrimp_index['lake_id'],
                'date'=>date('d-m-y', time())
            );
            if ($this->checkExits($filter) > 0){
                $this->update($filter, $this->_shrimp_index);
            }else{
                LMongo::collection($this->_collection)->insert($this->_shrimp_index);
            }

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_shrimp_index;
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
            $query->where('date', date('d-m-y',time()));$query->where('date', date('d-m-y',time()));
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}