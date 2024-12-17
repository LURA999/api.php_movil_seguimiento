<?php

require '../Config/config.php';
require '../Controllers/qrVehicleController.php';

$obj = new qrVehicleController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            if (isset($_GET['plate']) && isset($_GET['condition'])) {
                echo $obj -> get_vehicle($_GET['plate'],$_GET['condition'],$_GET['local']);
            }
            
            if(isset($_GET['platesSearch'])){
                echo $obj -> platesSearch($_GET['platesSearch'],$_GET['local']);
            }
            
            break;
        case 'POST':

            if(isset($_GET['qr'])){
                echo $obj ->post_qr($input);
            }
            
            if(isset($_GET['qr2'])) {
                echo $obj ->post_qr2($input);
            }
        
            
            if(isset($input['dateStart']) && isset($input['dateFinal'])){
                echo $obj ->slc_report($input);
            }
            
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}