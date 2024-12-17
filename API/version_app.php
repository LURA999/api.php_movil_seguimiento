<?php

require '../Config/config.php';
require '../Controllers/versionAppController.php';

$obj = new versionAppController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':               
            
                echo $obj ->getLastVersion();
            break;
        case 'POST':
            
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}