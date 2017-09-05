<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 26/05/2017
 * Time: 3:41 CH
 */
use LMongo\Facades\LMongo;

class Food
{
    protected $_collection = 'foods';
    protected $_food = null;

    function __construct($data = array())
    {
        $this->_food = array(
            'food_id' => Pretty::getSequenceId('F'),
            'time' => (int)$data['time'],
            'lake_id' => $data['lake_id'],
            'lake_name' => $data['lake_name'],
            'hour'=> (int)$data['hour'],
            'minute'=> (int)$data['minute'],
            'food_type_id'=>$data['food_type_id'],
            'food_type'=>$data['food_type'],
            'food_type_1'=>$data['food_type_1'],
            'food_type_2'=>$data['food_type_2'],
            'food_val_1' => (double)$data['food_val_1'],
            'food_val_2' => (double)$data['food_val_2'],
            'date' => (empty($data['date'])?date('d-m-y'):$data['date']),
            'create_date' => time()
        );
    }

    function insert()
    {
        try {
            $filter = array(
                'time' => $this->_food['time'],
                'lake_id' => $this->_food['lake_id']
            );

            $check = $this->checkExits($filter);
            if ($check > 0) {
                $new_data = array(
                    'food_type'=>$this->_food['food_type']
                );
                $this->update($filter, $new_data);
            } else {
                LMongo::collection($this->_collection)->insert($this->_food);
            }
			$lake = new Lake(null);
			$lake->updateStatus($filter, array('status'=>5));
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_food;
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['time'])) $query->where('time', (int)$filter['time']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            if (!empty($filter['date'])){
                $query->where('date', $filter['date']);
            }else{
                $query->where('date', date('d-m-y'));
            }

            $query->update($data);
			
			$lake = new Lake(null);
			$lake->updateStatus($filter, array('status'=>5));
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
            if (!empty($filter['from_date']) && !empty($filter['to_date']))
            {
                $query = $query->whereBetween('create_date', (int)$filter['from_date'], (int)$filter['to_date']);
            }

            $query = $query->Where(function($query)
            {
                if (!empty($filter['food_type_1'])) $query->orWhere('food_type_1', $filter['food_type_1']);
                if (!empty($filter['food_type_2'])) $query->orWhere('food_type_2', $filter['food_type_2']);

                return $query;
            });

//            if (!empty($filter['from_date'])) $query = $query->whereGte('create_date', (int)$filter['from_date']);
//            if (!empty($filter['to_date'])) $query = $query->whereLte('create_date', (int)$filter['to_date']);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);

            $query->orderBy('create_date', 'desc');
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