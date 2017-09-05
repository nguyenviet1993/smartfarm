<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/06/2017
 * Time: 9:30 SA
 */
class FeeCatalog
{
    protected $_collection = 'fee_catalogs';
    protected $_fee_catalog = null;

    function __construct($data = array())
    {
        $this->_fee_catalog = array(
            'cat_id' => Pretty::getSequenceId('FC'),
            'catalog_name' => $data['catalog_name'],
//            'price' => (double)$data['price'],
//            'code' => $data['code'],
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
            LMongo::collection($this->_collection)->insert($this->_fee_catalog);
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_fee_catalog;
    }

    function checkExits($cat_id)
    {
        try {
            return LMongo::collection($this->_collection)->where('cat_id', $cat_id)->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            return $query->orderBy('create_date', 'desc')->paginate(10);
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAlls($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['key'])) $query->whereLike('catalog_name', $filter['key']);
            return $query->orderBy('create_date', 'desc')->get()->toArray();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
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
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function delete($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['cat_id'])) $query->where('cat_id', $filter['cat_id']);
            $query->delete();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}