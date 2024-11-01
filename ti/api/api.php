<?php

header('Content-Type: text/html; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    
    $name = $_POST["nome"];
    $time = $_POST["hora"];
    $value = $_POST["valor"];
    
    $deviceService = new DeviceDataService();
    $deviceDataModel = new DeviceDataModel($name, $time, $value);
    $deviceService = new DeviceDataService();
    $deviceService->ProcessDataPost($deviceDataModel);


} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    
    $device = $_GET["nome"];
    $deviceService = new DeviceDataService();
    $deviceDataModel = $deviceService->ProcessDataGet($device);

    print_r($deviceDataModel->getValue());

} else {
    print_r("Invalid request");
}





class DeviceDataService {
    
    CONST RelativePath = __DIR__."/files/";


    /*
        Função ProcessDataPost: responsável por receber os dados da requisição POST, processa-los e envia-los (escrever)
        para os seus respetivos ficheiros em api/files 
    */
    public function ProcessDataPost(DeviceDataModel $_deviceData){

        $path = self::RelativePath;
        
        
        $path = $path.strtolower($_deviceData->getName());    

        file_put_contents($path."/nome.txt",$_deviceData->getName(), FILE_TEXT);
        file_put_contents($path."/valor.txt",$_deviceData->getValue(), FILE_TEXT);
        file_put_contents($path."/hora.txt",$_deviceData->getTime(), FILE_TEXT);
        //Log gerado a cada post ex: Porta | Data: 2024-04-21 08:51:38pm/Aberto,
        $log = $_deviceData->getName()."/".date("Y-m-d")."/".date("h:i:sa")."/".$_deviceData->getValue().",";
        
        file_put_contents($path."/log.txt",   $log.PHP_EOL, FILE_APPEND);

    }
 

    public function ProcessDataGet($device) : DeviceDataModel{

        $path = self::RelativePath.strtolower($device);

        $name = file_get_contents($path."/nome.txt",false);
        $value = file_get_contents($path."/valor.txt", false);
        $time = file_get_contents($path."/hora.txt", false);
        $_deviceData = new DeviceDataModel($name, $time,$value);
        $_deviceData->setLog(file_get_contents($path."/log.txt", false));

        return $_deviceData;
    }
 
}



class DeviceDataModel {

    private $time;
    private $log;
    private $name;
    private $value;

    private $type; //Sensor (1) or actuator (2)


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
        // if(is_numeric(($this->value))){
        //     $this->value = number_format($this->value,2,'.');
        //     return $this->value;
        // } else {
        // }
        return $this->value;
    }

    public function getTime(){
        return $this->time;
    }

}