<?php


function readUsers() {
    $file = fopen("C:/Users/vinic/Desktop/TI/UniServerZ/www/TI-Project/users.txt", "r");
    $data = array();

    while(!feof($file)) {
        $line = fgets($file);
        $parts = explode(",", $line);
        $user = trim($parts[0]);
        $password = trim($parts[1]);   
        $data[$user] = password_hash($password,PASSWORD_DEFAULT);
    }

    fclose($file);
    return $data;
}

?>