<?php


require_once("./device_data_interface");
require_once("./device_data_model");

class DevicePostData implements DeviceDataInterface {
    
    public function ProcessData(DeviceDataModel $_deviceData) : DeviceDataModel{

        
        $path = "./api/files/" . $_deviceData->getName();
        
        file_put_contents($path."/nome.txt", $_deviceData->getName() . PHP_EOL, FILE_APPEND);
        file_put_contents($path."/valor.txt", $_deviceData->getValue() . PHP_EOL, FILE_APPEND);
        file_put_contents($path."/hora.txt", $_deviceData->getTime() . PHP_EOL, FILE_APPEND);


        return $_deviceData;
    }

}

