<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 8/23/2017
 * Time: 9:35 PM
 */
use \Illuminate\Support\Facades\Session;
class ActionLog
{
    protected $_collection = 'actions_log';
    protected $_action_log = null;

    function __construct($data = array())
    {
        $this->_action_log = array(
            'log_id' => Pretty::getSequenceId('AL'),
            'username' => Session::get('user.username'),
            'full_name' => Session::get('user.full_name'),
            'role' => Session::get('user.role'),
            'role_name' => Session::get('user.role_name'),
            'content'=> $data['content'],
            'element_id'=> $data['element_id'],
            'date' => date('d-m-Y', time()),
            'status' => 1,
            'create_date' => time()
        );
    }


    public static function insertDB($code, $data = array()){
        $data = array(
            'log_id' => Pretty::getSequenceId('AL'),
            'content'=> $data['content'],
            'element_id'=> $data['element_id'],
            'username' => Session::get('user.username'),
            'full_name' => Session::get('user.full_name'),
            'role' => Session::get('user.role'),
            'role_name' => Session::get('user.role_name'),
            'date' => date('d-m-Y', time()),
            'status' => 1,
            'create_date' => time()
        );

        switch ($code){
            case CategoryDefine::$log_add_catalog:
                $data['code'] = $code;
                break;
        }

        LMongo::collection('actions_log')->insert($data);
    }

    function insert($code)
    {
        try {
            switch ($code){
                case CategoryDefine::$log_add_catalog:
                    $this->_action_log['code'] = $code;
                    break;
            }
            LMongo::collection($this->_collection)->insert($this->_action_log);
        } catch (MongoException $e) {
            $e->getMessage();
        }
        return $this->_action_log;
    }

}