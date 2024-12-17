<?php

require '../Config/config.php';
require '../Controllers/commentFoodController.php';

$obj = new commentFoodController();
try{
    $input = json_decode(file_get_contents('php://input'), true);
    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            
            break;
        case 'POST':
            if(isset($input['dateStart']) && isset($input['dateFinal'])){
                echo $obj ->get_commentf($input['dateStart'], $input['dateFinal'], $input['local']);
            }
            
            if(isset($input['comment']) && isset($input['rate'])){
                echo $obj ->post_commentf($input);

            }
            
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}