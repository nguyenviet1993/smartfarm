<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16/06/2017
 * Time: 10:15 SA
 */
class NhaDaily
{
    protected $_collection = 'nha_daily';
    protected $_nha_daily = null;

    function __construct($data = array())
    {
        $this->_nha_daily = array(
            'nha_id' => Pretty::getSequenceId('ND'),
            'lake_id' => $data['lake_id'],
            'time' => (int)$data['time'],
            'hour' => (int)$data['hour'],
            'minute' => (int)$data['minute'],
            'image_url' => $data['image_url'],
            'duration' => (double)$data['duration'],
            'result' => $data['result'],
            'date'=>date('d-m-y'),
            'status'=>1,
            'create_date' => time()
        );
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            if (!empty($filter['time'])) $query->where('time', (int)$filter['time']);
            $query = $query->where('date', date('d-m-y', time()));
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function insert()
    {
        try {
            $filter = array(
                'lake_id'=>$this->_nha_daily['lake_id'],
                'time'=>$this->_nha_daily['time']
            );

            if ($this->checkExits($filter) > 0){
                $new_data = array(
                    'image_url'=>$this->_nha_daily['image_url'],
                );
                $this->update($filter, $new_data);
            }else{
                LMongo::collection($this->_collection)->insert($this->_nha_daily);
            }
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_nha_daily;
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
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
            if (!empty($filter['time'])) $query->where('time', (int)$filter['time']);
            $query = $query->where('date', date('d-m-y', time()));
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            return $query->get();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}