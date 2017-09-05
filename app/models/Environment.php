<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 02/06/2017
 * Time: 2:04 CH
 */
use LMongo\Facades\LMongo;

class Environment
{
    protected $_collection = 'environments';
    protected $_environment = null;

    function __construct($data = array())
    {
        $this->_environment = array(
            'environment_id' => Pretty::getSequenceId('E'),
            'time_id' => $data['time_id'],
            'time' => $data['time'],
            'type_id' => $data['type_id'],
            'type' => $data['type'],
            'hour'=> (int)$data['hour'],
            'minute'=> (int)$data['minute'],
            'val'=> (double)$data['val'],
            'lake_id' => $data['lake_id'],
            'lake' => $data['lake'],
            'date' => date('d-m-y'),
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            $filter = array(
                'time_id' => $this->_environment['time_id'],
                'lake_id' => $this->_environment['lake_id'],
                'type_id' => $this->_environment['type_id']
            );

            $check = $this->checkExits($filter);
            if ($check > 0) {
                $new_data = array(
                    'val'=>$this->_environment['val'],
                    'hour'=>$this->_environment['hour'],
                    'minute'=>$this->_environment['minute']
                );
                $this->update($filter, $new_data);
            } else {
                LMongo::collection($this->_collection)->insert($this->_environment);
            }
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_environment;
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['time_id'])) $query->where('time_id', $filter['time_id']);
            if (!empty($filter['type_id'])) $query->where('type_id', $filter['type_id']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            if (!empty($filter['date'])) $query->where('date', date('d-m-y'));
            $query->update($data);
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            $query = $query->where('date', date('d-m-y'));
            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAlls($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            return $query->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function checkExits($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['time_id'])) $query->where('time_id', $filter['time_id']);
            if (!empty($filter['type_id'])) $query->where('type_id', $filter['type_id']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query = $query->where('date', date('d-m-y', time()));
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}