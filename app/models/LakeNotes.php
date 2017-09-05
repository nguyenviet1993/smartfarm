<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/06/2017
 * Time: 4:38 CH
 */
class LakeNotes
{
    protected $_collection = 'lake_notes';
    protected $_lake_notes = null;

    function __construct($data = array())
    {
        $this->_lake_notes = array(
            'note_id' => Pretty::getSequenceId('LN'),
            'lake_id'=>$data['lake_id'],
            'lake_name'=>$data['lake_name'],
            'note' => $data['note'],
            'status' => 1,
            'date' => (empty($data['date'])?date('d-m-y'):$data['date']),
            'create_date' => time()
        );
    }

    function update($filter, $data)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
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
                'lake_id'=>$this->_lake_notes['lake_id'],
                'date'=>date('d-m-y', time())
            );
            if ($this->checkExits($filter) > 0){
                $new_data = array(
                    'note'=>$this->_lake_notes['note']
                );
                $this->update($filter, $new_data);
            }else{
                LMongo::collection($this->_collection)->insert($this->_lake_notes);
            }


        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_lake_notes;
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

    function checkExits($filter)
    {
        try {
            $query = LMongo::collection($this->_collection);
            if (!empty($filter['lake_id'])) $query->where('lake_id', $filter['lake_id']);
            if (!empty($filter['date'])) $query->where('date', $filter['date']);
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