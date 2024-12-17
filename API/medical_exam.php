<?php

require '../Config/config.php';
require '../Controllers/medicalExamController.php';

$obj = new medicalExamController();
try{
    $input = json_decode(file_get_contents('php://input'), true);
    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            
            
            
            break;
        case 'POST':
            if(isset($_GET['search'])){
                echo $obj ->get_allExamListSearch($input);
            }
            
            //GET
            if(isset($_GET['ExamList'])){
                echo $obj ->get_allExamList($input);
            }
            
            
            if(isset($_GET['getOneExamPart1'])){
                echo $obj ->get_examOneInformationPart1($input);
            }
            
            if(isset($_GET['getExamAcciddentDisease'])){
                echo $obj ->get_examAccidentDisease($input);
            }
            
            if(isset($_GET['getExamHeredityFam'])){
                echo $obj ->get_examHeredityFam($input);
            }
            
            if(isset($_GET['getExamHistory'])){
                echo $obj ->get_examHistory($input);
            }
            
            //POST
            
            if(isset($_GET['post_examMa'])){
                echo $obj->post_examMain($input);
            }
            
            if(isset($_GET['post_examDe'])){
                echo $obj->post_examDetail($input);
            }
            
            if(isset($_GET['post_examAc'])){
                echo $obj->post_examAccident($input);
            }
            
            if(isset($_GET['post_examAp'])){
                echo $obj->post_examApparatusSys($input);
            }
            
            if(isset($_GET['post_examGy'])){
                echo $obj->post_examGynecologistBack($input);
            }
            
            if(isset($_GET['post_examHeF'])){
                echo $obj->post_examHeredityFam($input);
            }
            
            if(isset($_GET['post_examHeP'])){
                echo $obj->post_examHeredityPers($input);
            }
            
            if(isset($_GET['post_examHi'])){
                echo $obj->post_examHistory($input);
            }
            
            if(isset($_GET['post_examIm'])){
                echo $obj->post_examImagingStudy($input);
            }
            
            if(isset($_GET['post_examLa'])){
                echo $obj->post_examLaboratoryTest($input);
            }
            
            if(isset($_GET['post_examIn'])){
                echo $obj->post_examInitPre($input);
            }
            
            if(isset($_GET['post_examPa'])){
                echo $obj->post_examPataPersBack($input);
            }
            
            if(isset($_GET['post_examPe'])){
                echo $obj->post_examPersonalLife($input);
            }
            
            if(isset($_GET['post_examPhX'])){
                echo $obj->post_examPhyExploration($input);
            }
            
            if(isset($_GET['post_examPhY'])){
                echo $obj->post_examPhyEyes($input);
            }
            
            
            if(isset($_GET['get_paginator'])){
                echo $obj->get_paginator($input,$_GET['get_paginator']);
            }
            
            if(isset($_GET['allPagesPaginator'])){
                echo $obj->get_allPagesPaginator($input,$_GET['allPagesPaginator']);
            }
            
            
            break;
        case 'PATCH':
            if(isset($_GET['timeModification_exam'])){
                echo $obj->update_dateTimeExam($_GET['timeModification_exam']);
            }
            
            if(isset($_GET['patch_examMa'])){
                echo $obj->patch_examMain($input);
            }
            
            if(isset($_GET['patch_examDe'])){
                echo $obj->patch_examDetail($input);
            }
            
            if(isset($_GET['patch_examAc'])){
                echo $obj->patch_examAccident($input);
            }
            
            if(isset($_GET['patch_examAp'])){
                echo $obj->patch_examApparatusSys($input);
            }
            
            if(isset($_GET['patch_examGy'])){
                echo $obj->patch_examGynecologistBack($input);
            }
            
            if(isset($_GET['patch_examHeF'])){
                echo $obj->patch_examHeredityFam($input);
            }
            
            if(isset($_GET['patch_examHeP'])){
                echo $obj->patch_examHeredityPers($input);
            }
            
            if(isset($_GET['patch_examHi'])){
                echo $obj->patch_examHistory($input);
            }
            
            if(isset($_GET['patch_examIm'])){
                echo $obj->patch_examImagingStudy($input);
            }
            
            if(isset($_GET['patch_examLa'])){
                echo $obj->patch_examLaboratoryTest($input);
            }
            
            if(isset($_GET['patch_examIn'])){
                echo $obj->patch_examInitPre($input);
            }
            
            if(isset($_GET['patch_examPa'])){
                echo $obj->patch_examPataPersBack($input);
            }
            
            if(isset($_GET['patch_examPe'])){
                echo $obj->patch_examPersonalLife($input);
            }
            
            if(isset($_GET['patch_examPhX'])){
                echo $obj->patch_examPhyExploration($input);
            }
            
            if(isset($_GET['patch_examPhY'])){
                echo $obj->patch_examPhyEyes($input);
            }
            
           // echo $obj ->patch_exam($input);
            break;
            
        case 'DELETE':
            $obj->delete_exam($_GET['id']);
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}