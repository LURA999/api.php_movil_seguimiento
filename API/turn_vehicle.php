<?php

require '../Config/config.php';
require '../Controllers/turnVehicleController.php';

$obj = new turnVehicleController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':               

            if(isset($_GET['nameSign'])){
                echo $obj ->get_data_guard($_GET['nameSign'], $_GET['local']);
            }
            
            if(isset($_GET['name'])){
                echo $obj ->get_name_guard($_GET['name'], $_GET['local']);
            }
            
            if(isset($_GET['names'])){
                echo $obj ->get_names( $_GET['local']);
            }
            
             if(isset($_GET['nameTurn'])){
                echo $obj->get_ob_turn($_GET['nameTurn'], $_GET['local']);
            }
            
            if(!isset($_GET['name']) && !isset($_GET['idGuard']) && !isset($_GET['nameTurn']) ){
                echo $obj ->get_data($_GET['local']);    
            }
            
           
            
            break;
        case 'POST':
            if(isset($input['description'])){
                echo $obj ->post_obvv($input);
            }

            if(isset($input['turn']) && isset($input['sign']) && isset($input['guard'])){
                echo $obj ->post_turnv($input);
            }

            if(isset($_GET['idTurn'])){
                echo $obj ->post_turncv($input);
            }
            
            if(isset($input['dateStart']) && isset($input['dateFinal'])){
                echo $obj ->get_observations($input);
            }
            
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}