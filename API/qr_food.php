<?php

require '../Config/config.php';
require '../Controllers/qrFoodController.php';

$obj = new qrFoodController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            break;
        case 'POST':
            if(isset($input['dateStart']) && isset($input['dateFinal'])){
                echo $obj ->slc_report($input);
            }
            
            if(isset($input['contract'])){
                echo $obj ->post_registerf($input);
            }
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}