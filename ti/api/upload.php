<?php 
    // echo "<img src='api/images/webcam.jpg?id=".time()."' style='width:100%'>"; 
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //Parameters validation
        // if (!isset($_POST["nome"])) {
        //     http_response_code(400);
        //     die("There is a unassined value on body post request.");
        // }
        
        //Array ( [name] => estg.jpg [full_path] => estg.jpg [type] => image/jpeg [tmp_name] => C:\UniServerZ\tmp\php11F5.tmp [error] => 0 [size] => 131508 )
            
        if(isset($_FILES['name'])){
            print_r($_FILES['imagem']);
            $from = strval($_FILES['imagem'][$tmp_name]);
            print_r($from);
            $to = "./api/files/images";
            move_uploaded_file($from, $to);
        } else {
            http_response_code(400);
            die("Error: There is no image file.");
        }
    
    
    
    } else {
        http_response_code(400);
        die("Error: There is no image file.");
    }
    

    
    


