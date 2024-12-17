<?php

require '../Config/config.php';
require '../Controllers/turnAssistanceController.php';

$obj = new turnAssistanceController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':               

            /*if(isset($_GET['nameSign'])){
                echo $obj ->get_data_guard($_GET['nameSign']);
            }
            
            if(isset($_GET['name'])){
                echo $obj ->get_name_guard($_GET['name']);
            }
            */
            if(isset($_GET['courseSearch'])){
                echo $obj ->get_courses($_GET['courseSearch'],$_GET['local']);
            }
            
             if(isset($_GET['description'])){
                echo $obj->get_ob_turn($_GET['description']);
            }
            /*
            if(!isset($_GET['name']) && !isset($_GET['idGuard']) && !isset($_GET['nameTurn']) ){
                echo $obj ->get_data();    
            }*/
            
           
            
            break;
        case 'POST':
            if(isset($input['description']) && !isset($_GET['getObservations'])){
                if( $input['description'] != ""){
                  echo $obj ->post_obva($input);
                }
            }

            if(isset($input['course_name']) && !isset($_GET['getObservations'])){
                echo $obj ->post_turna($input);
            }

            if(isset($_GET['idTurn']) && !isset($_GET['getObservations'])){
                echo $obj ->post_turnca($input);
            }
            
            if(isset($input['dateStart']) && isset($input['dateFinal']) && isset($_GET['getObservations'])){
                    echo $obj ->get_observations($input);
                
            }
            
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}