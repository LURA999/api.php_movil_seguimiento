<?php

require '../Config/config.php';
require '../Controllers/localController.php';

$obj = new localController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            echo $obj ->comparar_pass($_GET["cve"],$_GET["pass"]);
            break;
        case 'POST':
            echo $obj ->insert_pass_local($input["cve"],$input["pass"]);
            break;
        case 'PATCH':
            echo $obj ->update_pass_local($input["cve"],$input["pass"]);
            break;
    }
    
    
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}