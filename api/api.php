<?php

header('Content-Type: text/html; charset=utf-8');
// header('Location: http://www.example.com/');



if( $_SERVER['REQUEST_METHOD'] == "POST"){
    echo "we get POST";

} else if( $_SERVER["REQUEST_METHOD"] == "GET"){
    echo "we get GET";
} else {
    echo "invalid method";
}


?>