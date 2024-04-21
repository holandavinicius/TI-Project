<?php


require_once("C:/UniServerZ/www/ti/api/device_data_interface.php");
require_once("C:/UniServerZ/www/ti/api/device_data_model.php");


class DeviceDataService implements DeviceDataInterface {
    
    CONST RelativePath = "../ti/api/files/";
    public function ProcessDataPost(DeviceDataModel $_deviceData){

        
        $path =  self::RelativePath.$_deviceData->getName();
        
        $path = strtolower($path);

        print_r($path);

        file_put_contents($path."/nome.txt",$_deviceData->getName(), FILE_TEXT);
        file_put_contents($path."/valor.txt",$_deviceData->getValue(), FILE_TEXT);
        file_put_contents($path."/hora.txt",$_deviceData->getTime(), FILE_TEXT);

        $log = "nome: ".$_deviceData->getName()." hora:".date("Y-m-d").date("h:i:sa")." valor:".$_deviceData->getValue();
        file_put_contents($path."/log.txt",   $log.PHP_EOL, FILE_APPEND);

        
    }
 
    public function ProcessDataGet($device) : DeviceDataModel{

        $path = self::RelativePath.$device;
        $path = strtolower($path);

       

        $name = file_get_contents($path."/nome.txt",false);
        $value = file_get_contents($path."/valor.txt", false);
        $time = file_get_contents($path."/hora.txt", false);
        $_deviceData = new DeviceDataModel($name, $time,$value);
        $_deviceData->setLog(file_get_contents($path."/log.txt", false));

        return $_deviceData;
    }

    


}

