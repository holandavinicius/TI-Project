<?php


require_once("../TI-Project/api/device_data_interface.php");
require_once("../TI-Project/api/device_data_model.php");


class DeviceDataService implements DeviceDataInterface {
    

    
    public function ProcessDataPost(DeviceDataModel $_deviceData){

        
        $path = "./api/files/" . $_deviceData->getName();
        
        file_put_contents($path."/nome.txt", $_deviceData->getName() . PHP_EOL, FILE_TEXT);
        file_put_contents($path."/valor.txt", $_deviceData->getValue() . PHP_EOL, FILE_APPEND);
        file_put_contents($path."/hora.txt", $_deviceData->getTime() . PHP_EOL, FILE_APPEND);

        $log = "nome: ".$_deviceData->getName()." hora:".$_deviceData->getTime()." valor:".$_deviceData->getValue()." ".PHP_EOL;
        file_put_contents($path."/log.txt",   $log.PHP_EOL, FILE_APPEND);

        
    }
 
    public function ProcessDataGet($device) : DeviceDataModel{

        $path = "./api/files/" . $device;
        
        $name = file_get_contents($path."/nome.txt",false);
        $value = file_get_contents($path."/valor.txt", false);
        $time = file_get_contents($path."/hora.txt", false);
        $_deviceData = new DeviceDataModel($name, $time,$value);
        $_deviceData->setLog(file_get_contents($path."/log.txt", false));

        return $_deviceData;
    }

    


}
