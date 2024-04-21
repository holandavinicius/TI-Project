<?php

header('Content-Type: text/html; charset=utf-8');

require_once($_SERVER["DOCUMENT_ROOT"]."/ti/api/device_data_interface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ti/api/device_data_model.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ti/api/device_data_service.php");




if ($_SERVER['REQUEST_METHOD'] == "POST") {

    
    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $hora = $_POST["hora"]; 

  
    $deviceDataModel = new DeviceDataModel($nome,$hora,$valor);

    $deviceService = new DeviceDataService();
    $deviceService->ProcessDataPost($deviceDataModel);


} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $device = $_GET["nome"];

    $deviceService = new DeviceDataService();
    $deviceDataModel = $deviceService->ProcessDataGet($device);
    
    print_r(json_encode((array)$deviceDataModel));
} else {
    print ("Invalid request");
}


