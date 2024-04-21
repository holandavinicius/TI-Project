<?php

header('Content-Type: text/html; charset=utf-8');~

require_once("../TI-Project/api/device_data_interface.php");
require_once("../TI-Project/api/device_data_model.php");
require_once("../TI-Project/api/device_data_service.php");


$deviceDataModel;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $hora = $_POST["hora"];

    $$deviceDataModel = new DeviceDataModel($nome,$time,$valor);
    $deviceService = new DeviceDataService();
    $deviceService->ProcessDataPost($$deviceDataModel);


} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $device = $_GET["nome"] ?? null;

    $deviceService = new DeviceDataService();
    $deviceDataModel = $deviceService->ProcessDataGet($device);

} else {
    print ("Invalid request");
}


