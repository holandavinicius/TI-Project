<?php


class DeviceDataModel {

    private $time;
    private $log;
    private $name;
    private $value;

    private $type; //Sensor (1) or actuator (2)


    public function __construct($name,$time,$value,$type) {
        
        $this->time = $time;
        $this->log = "";
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
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
        if(is_numeric(($this->value))){
            $this->value = number_format($this->value,2,'.');
            return $this->value;
        } else {
            return $this->value;
        }
    }

    public function getTime(){
        return $this->time;
    }

    public function getType(){
        return $this->type;
    }

}