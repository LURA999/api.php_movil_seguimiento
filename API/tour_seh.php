<?php

require '../Config/config.php';
require '../Controllers/tourSehController.php';

$obj = new tourSehController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            if(isset($_GET['form']) && isset($_GET['answer'])){
                echo $obj->getAnswer($_GET['form'],$_GET['local']);
            }
            
            if(isset($_GET['form']) && isset($_GET['question'])){
                echo $obj->getQuestion($_GET['form'],$_GET['local']);
            }
            
            if(isset($_GET['form']) && isset($_GET['title'])){
                echo $obj->getTitle($_GET['form'],$_GET['local']);
            }
            
            if(isset($_GET['form']) && isset($_GET['titleDescription'])){
                echo $obj->getTitleDescription($_GET['form'],$_GET['local']);
            }
            
            if(isset($_GET['form']) && isset($_GET['comments'])){
                echo $obj->getComments($_GET['form'],$_GET['local']);
            }
            
            if(isset($_GET['form']) && isset($_GET['descriptions'])){
                echo $obj->getDescriptions($_GET['form'],$_GET['local']);
            }
            break;
        case 'POST':
            if(isset($_GET['question'])){
                echo $obj->insertNewArea($input);
            }
            
            if(isset($_GET['area'])){
                echo $obj->insertNewQuestion($input);
            }
            
            break;
        case 'PATCH':
            if(isset($_GET['formAB'])){
                echo $obj->updateFormAB($input['data'],$_GET['formAB']);
            }
            
            if(isset($_GET['formComment'])){
                echo $obj->updateComments($input,$_GET['formComment']);
            }
            
            if(isset($_GET['formDescription'])){
                echo $obj->updateDescription($input,$_GET['formDescription']);
            }
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}