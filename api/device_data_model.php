<?php


class DeviceDataModel {

    private $time;
    private $log;
    private $name;
    private $value;


    public function __construct($name,$time,$value) {
        
        $this->time = $time;
        $this->log = "";
        $this->name = $name;
        $this->value = $value;
    }
   

  

    public function setLog($log){
        $this->log = $log;
    }


    public function getLog(){
        return $this->log;
    }

    public function getName(){
        return $this->name;
    }

    
    public function getValue(){
        return $this->value;
    }

    public function getTime(){
        return $this->time;
    }

}