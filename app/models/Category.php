<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 25/05/2017
 * Time: 2:04 CH
 */
class Category
{
    protected $_collection = 'categories';
    protected $_category = null;

    function __construct($data = array())
    {
        $this->_category = array(
            'category_id' => Pretty::getSequenceId('CG'),
            'category_name' => $data['category_name'],
            'code' => $data['code'],
            'order' => (int)$data['order'],
            'value' => (double)$data['value'],
            'value1' => (double)$data['value1'],
            'type' => (int)$data['type'],
            'ftype' => $data['ftype'],
            'ftype1' => $data['ftype1'],
            'create_date' => time()
        );
    }

    function getMax($filter = array(),$max_field)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['code'])) $query->where('code', $filter['code']);
            return $query->max($max_field);
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function insert()
    {
        try {
            LMongo::collection($this->_collection)->insert($this->_category);
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_category;
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
            if (!empty($filter['code'])) $query->where('code', $filter['code']);
            if (!empty($filter['type'])) $query->where('type', (int)$filter['type']);
            return $query->first();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function checkExits($category_id)
    {
        try {
            return LMongo::collection($this->_collection)->where('category_id', $category_id)->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['category_id'])) $query->where('category_id', $filter['category_id']);
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }
}