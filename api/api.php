<?php

header('Content-Type: text/html; charset=utf-8');


// $globalClass = new GlobalClass();
// require("C:/UniServerZ/www/TI-Project/controllers/ServiceController.php");

// $controller = new ServiceController;
// $controller->processRequest($_SERVER['REQUEST_METHOD'], $device);
// function readLastLine(string $path): void


$device = "";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
      
       $nome = $_POST["nome"];
       $valor = $_POST["nome"];
       $hora = $_POST["nome"];
         
        file_put_contents("./api/files/".$device."/nome.txt",$nome . '' . PHP_EOL, FILE_APPEND);
        file_put_contents("./api/files/".$device."/valor.txt", $valor . '' . PHP_EOL, FILE_APPEND);
        file_put_contents("./api/files/".$device."/hora.txt", $hora . '' . PHP_EOL, FILE_APPEND);
    } else if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $device = $_GET["nome"] ?? null;

        file_get_contents("./api/files/".$device."/nome.txt",$nome);
        file_get_contents("./api/files/".$device."/valor.txt", $valor);
        file_get_contents("./api/files/".$device."/hora.txt", $hora);
    } else {
        print("Invalid request");
    }


