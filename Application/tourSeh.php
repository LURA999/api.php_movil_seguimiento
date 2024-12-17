<?php
require '../Config/database.php';

class tourSeh extends database {

    
    function getAnswer($form,$local) {
        $sql = $this->connect()->prepare('
            SELECT answer, fk_area_seh, fk_question, fk_period_seh, qds.local FROM `question_det_seh` qds 
            INNER JOIN question_seh ON fk_question = idQuestion 
            INNER JOIN forms_seh e ON idForm = fk_forms_seh 
            where fk_period_seh = :form AND qds.local = :local ORDER BY `fk_area_seh`, idQuestion ASC;
        ');
        
        $sql->bindParam(':form',$form,PDO::PARAM_INT);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_NUM);
    }
    
    function insertNewArea($in){
        $sql = $this->connect()->prepare('INSERT INTO area_seh (area) VALUES (:area)');
        $sql->bindParam(':area',$in['area'], PDO::PARAM_STR);
        return $sql->execute();
    }
    
    function insertNewQuestion($in){
        $sql = $this->connect()->prepare('INSER INTO question_seh (question) VALUES (:question);');
        $sql->bindParam(':question',$in['question'],PDO::PARAM_STR);
        return $sql->execute();
    }
    
    //preguntas
    function getQuestion($form,$local) { 
        if($local == 4 && $form == 13){
            $sql = $this->connect()->prepare('
                SELECT question
                FROM `question_det_seh` qds
                INNER JOIN question_seh ON fk_question = idQuestion 
                INNER JOIN forms_seh e ON idForm = fk_forms_seh 
                WHERE fk_period_seh = :form AND qds.local = :local GROUP BY idQuestion asc;
            ');
        } else {
            $sql = $this->connect()->prepare('
                SELECT question
                FROM `question_det_seh` qds
                INNER JOIN question_seh ON fk_question = idQuestion 
                INNER JOIN forms_seh e ON idForm = fk_forms_seh 
                WHERE fk_period_seh = :form AND qds.local = :local GROUP BY idQuestion asc;
            ');
       }
        
        $sql->bindParam(':form',$form,PDO::PARAM_INT);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }
    
    //description de titulos
    function getTitleDescription($form,$local) {
        $sql = $this->connect()->prepare('
            SELECT  titleDescription_form 
            FROM forms_seh e 
            INNER JOIN titleDescription_form ON titleDescription1 = idTitleDescription_form 
            WHERE fk_period_seh = :form AND local = :local 
            UNION ALL 
            SELECT  titleDescription_form 
            FROM forms_seh e 
            INNER JOIN titleDescription_form ON titleDescription2 = idTitleDescription_form 
            WHERE fk_period_seh = :form AND local = :local;
        ');
        $sql->bindParam(':form',$form,PDO::PARAM_INT);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }
    
    //titulos
    function getTitle($form, $local) {
        if ($local == 4 && $form == 13) {
        $sql = $this->connect()->prepare('
            SELECT a.area 
            FROM `question_det_seh` qds 
            INNER JOIN forms_seh e ON idForm = fk_forms_seh 
            INNER JOIN area_seh a ON a.idArea = fk_area_seh 
            WHERE fk_period_seh = :form AND qds.local = :local GROUP BY idArea ORDER BY qds.idQuestion_det asc;
        ');
        } else {
            $sql = $this->connect()->prepare('
            SELECT a.area 
            FROM `question_det_seh` qds 
            INNER JOIN forms_seh e ON idForm = fk_forms_seh 
            INNER JOIN area_seh a ON a.idArea = fk_area_seh 
            WHERE fk_period_seh = :form AND qds.local = :local GROUP BY idArea asc;
        ');
        }
        
        
        $sql->bindParam(':form',$form,PDO::PARAM_INT);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }
    
    function getComments($form, $local){
        
        $sql = $this->connect()->prepare('
            SELECT comment_text, fk_area_seh, fk_form_seh, c.local
            FROM `comment_area_seh` c INNER JOIN forms_seh e ON idForm = fk_form_seh 
            WHERE fk_period_seh = :form AND c.local = :local
        ');
        
        $sql->bindParam(':form',$form,PDO::PARAM_STR);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    function getDescriptions($form, $local){
        
        $sql = $this->connect()->prepare('
            SELECT description1, description2 
            FROM `forms_seh` where fk_period_seh = :form AND local = :local
        ');
        
        $sql->bindParam(':form',$form,PDO::PARAM_STR);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
     function updateDescription($input,$form){
         
        $sql = $this->connect()->prepare('
            UPDATE
            forms_seh
            SET description1 = :description1,
            description2 = :description2  WHERE fk_period_seh = :form AND local = :local; 
        ');
        
        $sql->bindParam(':description1',$input['description1'],PDO::PARAM_STR);
        $sql->bindParam(':description2',$input['description2'],PDO::PARAM_STR);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        $sql->bindParam(':form',$form,PDO::PARAM_INT);
        return  $sql ->execute();
        
    }
    
    function updateComments($input,$form){
        
        $sql = $this->connect()->prepare('
            UPDATE
            comment_area_seh
            SET
            comment_text = :comment
            WHERE 
            fk_area_seh = :area AND 
            fk_form_seh = :form AND
            local = :local; 
        ');
        
        $sql->bindParam(':comment',$input['comment_text'],PDO::PARAM_STR);
        $sql->bindParam(':area',$input['fk_area_seh'],PDO::PARAM_INT);
        $sql->bindParam(':form',$input['fk_form_seh'],PDO::PARAM_INT);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        return  $sql ->execute();
        
    }
    
    
    //Este es el que se usa (update FormAB) 
    
    function updateFormAB($input,$form){
        
        $sql = $this->connect()->prepare('
            UPDATE question_det_seh a 
            INNER JOIN forms_seh e ON idForm = fk_forms_seh SET answer = :answer 
            WHERE fk_area_seh = :area 
            AND fk_question = :question 
            AND fk_period_seh = :form 
            AND a.local = :local;
        ');
        
        $sql->bindParam(':local',$input[4],PDO::PARAM_INT);
        $sql->bindParam(':form',$input[3],PDO::PARAM_INT);
        $sql->bindParam(':area',$input[1],PDO::PARAM_INT);
        $sql->bindParam(':question',$input[2],PDO::PARAM_INT);
        $sql->bindParam(':answer',$input[0],PDO::PARAM_INT);
        return  $sql ->execute();
        
    }
    
   
   
    

}