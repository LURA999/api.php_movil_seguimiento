<?php

require '../Config/config.php';
require '../Controllers/departamentController.php';

$obj = new departamentController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            echo $obj ->departament_id($_GET["departament"],$_GET["pass"]);
            break;
        case 'POST':
            echo $obj ->insert_departament($_GET["departament"],$_GET["pass"]);
            break;
        case 'PATCH':
            if(isset($_GET["departament"])){
                echo $obj ->update_departament($_GET["departament"],$_GET["pass"]);
            } else {
                echo $obj ->update_pass_global($input["passGlobal"]);
            }
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}