<?php

header('Content-Type: text/html; charset=utf-8');

require_once("device_data_model.php");
require_once("device_data_service.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $deviceService = new DeviceDataService();
    
    
    //Parameters validation
    if (!isset($_POST["nome"]) || !isset($_POST["valor"]) || !isset($_POST["hora"])) {
        http_response_code(400);
        die("There is a unassined value on body post request.");
    }



    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $hora = $_POST["hora"];

    $deviceDataModel = new DeviceDataModel($nome, $hora, $valor);

    $deviceService = new DeviceDataService();
    $deviceService->ProcessDataPost($deviceDataModel);


} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    
    $deviceService = new DeviceDataService();
    
    
    //Parameters validation
    if(!isset($_GET["nome"])){
        http_response_code(400);
        die("There is a unassined value to nome property.");
    }

    

    if(!$deviceService->ValidateDevice($_GET["nome"])){
        http_response_code(400);
        die($_GET["nome"]." is not a valid device.");
    }
    //verify if nome=value exists.
    

    $device = $_GET["nome"];
    $deviceService = new DeviceDataService();
    $deviceDataModel = $deviceService->ProcessDataGet($device);


    print_r($deviceDataModel->getValue());

} else {
    print ("Invalid request");
}


