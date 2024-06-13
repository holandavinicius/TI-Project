<?php


require_once("device_data_model.php");


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
        $log = $_deviceData->getName()." | Data: ".date("Y-m-d")." ".date("h:i:sa")." Estado:".$_deviceData->getValue().",";
        
        file_put_contents($path."/log.txt",   $log.PHP_EOL, FILE_APPEND);

        
    }
 

    /*
        Função ProcessDataPost: responsável por obter os dados da requisição GET, processa-los e será devolvido
        um object DeviceDataModel que representa os dados de cada ficheiro.
    */


    public function ProcessDataGet($device) : DeviceDataModel{

        $path = self::RelativePath.strtolower($device);

        $name = file_get_contents($path."/nome.txt",false);
        $value = file_get_contents($path."/valor.txt", false);
        $time = file_get_contents($path."/hora.txt", false);
        $_deviceData = new DeviceDataModel($name, $time,$value);
        $_deviceData->setLog(file_get_contents($path."/log.txt", false));

        
        return $_deviceData;
    }

    
   /* public function ValidateDevice($deviceName) : bool {
        $isValid = false;

        $paths = [];
        $paths = $this->getFiles($path);
        

        foreach($paths as $fileinfo){
            if($fileinfo->isDir() && !$fileinfo->isDot()){
                 echo $fileinfo->getFile().PHP_EOL;
                 $isValid = true;
            }
        }

        return $isValid;
    } */

    public function ValidateDevice($deviceName) {
        
        $iterator = new DirectoryIterator(self::RelativePath);

        
        foreach ($iterator as $fileinfo) {
            
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                if(strcmp(strtolower($fileinfo->getFilename()),strtolower($deviceName)) === 0){
                    return true;
                }
            }
        }
        return false;
    }

}