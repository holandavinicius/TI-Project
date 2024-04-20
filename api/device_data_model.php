<?php


class DeviceDataModel {

    private string $_time;
    private array $_log;
    private string $_name;
    private float $_value;


    public function __construct($_name,$_time,$_value) {
        
        $this->_time = $_time;
        $this->_log = array();
        $this->_name = $_name;
        $this->_value = $_value;
    }
   
    public function getTime() : string{
        return $this->_time;
    }

   
    public function getLog() : array{
        return $this->_log;
    }

    public function setLog($_log){
        $this->_log = $_log;
    }
    public function getName() : string{
        return $this->_name;
    }

    
    public function getValue() : string{
        return $this->_value;
    }



}