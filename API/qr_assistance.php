<?php
require '../Config/config.php';
require '../Controllers/qrAssistanceController.php';

$obj = new qrAssistanceController();
try{
    $input = json_decode(file_get_contents('php://input'), true);
    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
        
            if(isset($_GET['nameSearch'])){
                echo $obj ->get_namesSearch($_GET['nameSearch'], $_GET['local']);
            }
            break;
        case 'POST':
            
            if(isset($input['employee_num'])){
                echo $obj ->post_registerA($input);
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