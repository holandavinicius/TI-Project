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

    //Parameters validation
    if(!isset($_POST["nome"])){
        http_response_code(400);
        die("There is a unassined value to nome property.");
    }

    if(!$deviceService->ValidateDevice($_POST["nome"])){
        http_response_code(400);
        die($_GET["nome"]." is not a valid device.");
    }



    $name = $_POST["nome"];
    $time = $_POST["hora"];
    $value = $_POST["valor"];
    $type = $_POST["tipo"];


    $deviceDataModel = new DeviceDataModel($name, $time, $value, $type);

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

    $device = $_GET["nome"];
    $deviceService = new DeviceDataService();
    $deviceDataModel = $deviceService->ProcessDataGet($device);


    print_r($deviceDataModel->getValue());

} else {
    print ("Invalid request");
}


