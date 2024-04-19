<?php

class ServiceController{
    public function processRequest(string $method, ?string $device): void {
        if($device){
            $this->processResourceRequest($method, $device);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $device): void {
        switch($method){
            case "GET":
                break;
            case "POST":
                //switch($device){}
                if ($device == "temperatura") {
                    file_put_contents("C:/UniServerZ/www/TI-Project/api/files/temperatura/nome.txt", $_POST['nome'] . '' . PHP_EOL, FILE_APPEND);
                    file_put_contents("C:/UniServerZ/www/TI-Project/api/files/temperatura/valor.txt", $_POST['valor'] . '' . PHP_EOL, FILE_APPEND);
                    file_put_contents("C:/UniServerZ/www/TI-Project/api/files/temperatura/valor.txt", $_POST['hora'] . '' . PHP_EOL, FILE_APPEND);
                }
                    
                else if ($device == "valor") {
                    file_put_contents("C:/UniServerZ/www/TI-Project/api/files/temperatura/valor.txt", $_POST['valor'] . '' . PHP_EOL, FILE_APPEND);
                }
                    
                else if ($device == "hora") {
                    file_put_contents("C:/UniServerZ/www/TI-Project/api/files/temperatura/valor.txt", $_POST['hora'] . '' . PHP_EOL, FILE_APPEND);
                }
                break;
            default:
                echo "Invalid method.";
        }
    }

    private function processCollectionRequest(string $method): void{
        switch($method){
            case "GET":
                break;
            case "POST":
                break;
        }
    }
}