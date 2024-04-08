<?php

//We can define here just REST method related to temperature sensor.

if( $_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST["nome"])){
        file_put_contents("./api/files/temperatura/nome.txt",$_POST['nome'].''.PHP_EOL,FILE_APPEND);
    }
     
    if(isset($_POST["valor"])){
        file_put_contents("./api/files/temperatura/valor.txt",$_POST['valor'].''.PHP_EOL,FILE_APPEND);
    }

    if(isset($_POST['hora'])){
        file_put_contents("./api/files/temperatura/hora.txt",$_POST['hora'].''.PHP_EOL,FILE_APPEND);

    }

    if(isset($_POST['valor']) && isset($_POST['hora'])){
        $log = $_POST['valor'].''.$_POST['hora'].''.PHP_EOL;
        file_put_contents("C:/api/files/temperatura/log.txt",$log,FILE_APPEND);

    }

} else if( $_SERVER["REQUEST_METHOD"] == "GET"){
    
    $nome = $_GET['nome'];

    if(isset($_GET['nome'])){
        
        echo file_get_contents('./api/files/temperatura/nome.txt', false,null,0,null);
    } else {
        echo "There is no parameters on GET method.";
    }
} else {
    echo "invalid method";
}
?>