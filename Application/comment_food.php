<?php
require '../Config/database.php';

class comment_food extends database {
 	
    function post_commentf($input) {
        $sql = $this->connect()->prepare('INSERT INTO comment_food (employee_num,rate,suggestion,comment,date,fk_idTurn_f, local) VALUES(:employee_num, :rate, :suggestion,:comment,NOW(), (select idTurn_f from turn_food WHERE local = :local order by idTurn_f DESC LIMIT 1), :local );');
        $sql->bindParam(':employee_num',$input['employee_num'],PDO::PARAM_STR);
        $sql->bindParam(':rate',$input['rate'],PDO::PARAM_INT);
        $sql->bindParam(':suggestion',$input['suggestion'],PDO::PARAM_STR);
        $sql->bindParam(':comment',$input['comment'],PDO::PARAM_STR);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        return $sql ->execute();
    }

     function get_commentf($dateStart,$dateFinal,$local) {
         $str= '';
         if(intval($local) == 0 || intval($local) ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :local';
        }
       $sql = $this->connect()->prepare('SELECT employee_num,rate,suggestion,comment FROM comment_food WHERE '.$str.' and date BETWEEN :dateStart AND :dateFinal ORDER BY date DESC;');
       $sql->bindParam(':dateStart',$dateStart,PDO::PARAM_STR);
       $sql->bindParam(':dateFinal',$dateFinal,PDO::PARAM_STR);
       
       if(intval($local) > 1){
            $sql->bindParam(':local',$local,PDO::PARAM_INT);
        }
       
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
       
    }
   
}