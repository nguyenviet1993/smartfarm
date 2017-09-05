<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 22/06/2017
 * Time: 2:33 CH
 */
use LMongo\Facades\LMongo;

class Drug
{
    protected $_collection = 'drugs';
    protected $_drug = null;

    function __construct($data = array())
    {
        $this->_drug = array(
            'drug_id' => $data['drug_id'],
            'drug_name' => $data['drug_name'],
            'lake_id' => $data['lake_id'],
            'lake_name' => $data['lake_name'],
            'time' => (int)$data['time'],
            'hour' => (int)$data['hour'],
            'minute' => (int)$data['minute'],
            'amount' => (double)$data['amount'],
            'date' => date('d-m-y'),
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            $filter = array(
                'time' => $this->_drug['time'],
                'lake_id' => $this->_drug['lake_id']
            );

            $check = $this->checkExits($filter);
            if ($check > 0) {
                $new_data = array(
                    'drug_name'=>$this->_drug['drug_name']
                );
                $this->update($filter, $new_data);
            } else {
                LMongo::collection($this->_collection)->insert($this->_drug);
            }
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_drug;
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['time'])) $query->where('time', (int)$filter['time']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query->where('date', date('d-m-y'));
            $query->update($data);
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $data;
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['time'])) $query->where('time', $filter['time']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query = $query->where('date', date('d-m-y'));
            return $query->first();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            if (!empty($filter['from_date'])) $query = $query->whereGte('create_date', (int)$filter['from_date']);
            if (!empty($filter['to_date'])) $query = $query->whereLte('create_date', (int)$filter['to_date']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query->orderBy('hour', 'asc');
            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function checkExits($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['food_id'])) $query->where('food_id', $filter['food_id']);
            if (!empty($filter['time'])) $query->where('time', (int)$filter['time']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query = $query->where('date', date('d-m-y', time()));
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}