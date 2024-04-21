<?php


class DeviceDataModel {

    private $_time;
    private $_log;
    private $_name;
    private $_value;


    public function __construct($_name,$_time,$_value) {
        
        $this->_time = $_time;
        $this->_log = "";
        $this->_name = $_name;
        $this->_value = $_value;
    }
   

    public function getTime(){
        return $this->_time;
    }

    public function setLog($log){

        $this->_log = $log;
    }


    public function getLog(){
        return $this->_log;
    }

    public function getName(){
        return $this->_name;
    }

    
    public function getValue(){
        return $this->_value;
    }



}