<?php

header('Content-Type: text/html; charset=utf-8');

//##How to make a curl request in terminal
// $url = "http://localhost:8080/Ti-Project/api/api.php"; // URL to make a request
// // Data to send in the POST request
// $data = array(
//     'valor' => '42',
//     'nome' => 'temperatura'
// );

// $ch = curl_init($url); // Initialize cURL session
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
// curl_setopt($ch, CURLOPT_POST, true); // Set request to POST method
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Set POST data

// $response = curl_exec($ch); // Execute the request
// curl_close($ch); // Close cURL session

// echo $response; // Output the response
//##How to make a curl request in terminal



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