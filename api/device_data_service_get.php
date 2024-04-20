<?php


require_once("./device_data_interface");
require_once("./device_data_model");

class DevicePostData implements DeviceDataInterface {
    
    private $_deviceData; 
    public function ProcessData($_deviceData) : DeviceDataModel{

        
        $path = "./api/files/" . $_deviceData->getName();
        
        file_get_contents($path."/nome.txt", $_deviceData->getName());
        file_get_contents($path."/valor.txt", $_deviceData->getValue());
        file_get_contents($path."/hora.txt", $_deviceData->getTime());
        

        return $_deviceData;
    }

}

