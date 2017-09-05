<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/06/2017
 * Time: 8:58 SA
 */
class LakeLog
{
    protected $_collection = 'lake_logs';
    protected $_lake_log = null;

    function __construct($data = array())
    {
        $this->_lake_log = array(
            'log_id' => Pretty::getSequenceId('LL'),
            'lake_name' => $data['lake_name'],
            'lake_id' => $data['lake_id'],
            'amount_brood' => (int)@$data['amount_brood'],
            'acreage' => (double)@$data['acreage'],
            'season' => (int)@$data['season'],
            'water_level' => (int)@$data['water_level'],
            'start_date' => @$data['start_date'],
            'note' => @$data['note'],
            'seed_source' => @$data['seed_source'],
            'date'=>date('d-m-y'),
            'create_date' => time()
        );
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function insert()
    {
        try {
            LMongo::collection($this->_collection)->insert($this->_lake_log);

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_lake_log;
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
            return $query->first();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function checkExits($lake_id)
    {
        try {
            return LMongo::collection($this->_collection)->where('lake_id', $lake_id)->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            return $query->get();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}