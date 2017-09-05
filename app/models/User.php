<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 24/05/2017
 * Time: 9:07 SA
 */

use LMongo\Facades\LMongo;

class User
{
    protected $_collection = 'users';
    protected $_user = null;

    function __construct($data = array())
    {
        $this->_user = array(
            'user_id' => Pretty::getSequenceId('USER'),
            'username' => $data['username'],
            'password' => md5('sunvn2017'),
            'full_name' => !empty($data['full_name']) ? $data['full_name'] : null,
            'address' => !empty($data['address']) ? $data['address'] : null,
            'phone_number' => !empty($data['phone_number']) ? $data['phone_number'] : null,
            'email' => !empty($data['email']) ? $data['email'] : null,
            'role' => $data['role'],
            'role_name' => $data['role_name'],
            'lake_id'=>!empty($data['lake_id']) ? $data['lake_id'] : null,
            'status' => 1,
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            $filter = array(
                'username'=>$this->_user['username']
            );
            if ($this->checkExits($filter) > 0) {
                return false;
            } else {
                LMongo::collection($this->_collection)->insert($this->_user);
                return true;
            }

        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_user;
    }

    function checkExits($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['username'])) $query->where('username', $filter['username']);
            if (!empty($filter['password'])) $query->where('password', $filter['password']);
            return $query->count();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getAll($filter = array())
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['role'])) $query->where('role', $filter['role']);
            return $query->get();
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

    function getRow($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['user_id'])) $query->where('user_id', $filter['user_id']);
            if (!empty($filter['username'])) $query->where('username', $filter['username']);
            if (!empty($filter['password'])) $query->where('password', $filter['password']);
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
            if (!empty($filter['username'])) $query->where('username', $filter['username']);
            if (!empty($filter['password'])) $query->where('password', $filter['password']);
            $query->update($data);
            return $data;
        } catch (MongoException $e) {
            $e->getMessage();
        }
    }

}