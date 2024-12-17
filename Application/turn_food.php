<?php
require '../Config/database.php';

class turn_food extends database {
 
    function post_turnf($input) {
        if(intval($input['local']) == 0){
            $input['local'] = 1;
        }
         
        $sql = $this->connect()->prepare('INSERT INTO turn_food (plate, garrison, dessert, received, date_hour,photo,menu_portal, local) 
        VALUES(:dish, :garrison, :dessert, :received, NOW(),:photo,:menu_portal,:local)');
        $sql->bindParam(':dish',$input['dish'],PDO::PARAM_STR);
        $sql->bindParam(':garrison',$input['garrison'],PDO::PARAM_STR);
        $sql->bindParam(':dessert',$input['dessert'],PDO::PARAM_STR);
        $sql->bindParam(':received',$input['received'],PDO::PARAM_INT);
        $sql->bindParam(':photo',$input['photo'],PDO::PARAM_STR);
        $sql->bindParam(':menu_portal',$input['menu_portal'],PDO::PARAM_STR);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        return $sql ->execute();
    }

    
    function post_turncf($input) {
        $sql = $this->connect()->prepare('UPDATE turn_food SET dateFinal = NOW() WHERE idTurn_f = ( SELECT * FROM ( SELECT idTurn_f FROM turn_food WHERE local = :local ORDER BY idTurn_f DESC Limit 1 ) AS subquery ) and local = :local');
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        return $sql ->execute();
    }

     function get_obvf($local) {
         $str ='';
        if($local == 0 || $local ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :local';
        }

       $sql = $this->connect()->prepare('SELECT description observation FROM turn_food WHERE '.$str.' ORDER BY idTurn_f  DESC LIMIT 1');
       if(intval($local) > 1){
            $sql->bindParam(':local',$local,PDO::PARAM_INT);
        }
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function post_obvf($input) {
        $str ='';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :local';
        }

        $sql = $this->connect()->prepare('UPDATE turn_food SET description = :description WHERE idTurn_f = ( SELECT * FROM (SELECT idTurn_f FROM turn_food WHERE '.$str.' ORDER BY idTurn_f DESC Limit 1) AS subquery );');
        $sql->bindParam(':description',$input['description'],PDO::PARAM_STR);
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        return $sql ->execute();
    }
    
    function get_observations($input){
        $str ='';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= '(ttf.local = 0  or ttf.local = 1) AND';
        }else{
            $str = 'ttf.local = :local AND';
        }

        $like = '%'.$input['dish'].'%';
        $sqlp3 =' (garrison like :dish or dessert like :dish or plate like :dish) AND';
        if($input['dish'] == '' || $input['dish'] == null){
            $sqlp3=' ';
        }
        
        $sql = $this->connect()->prepare('
        SELECT DISTINCT fk_turn_food,date_hour, CONCAT(description," - ", date_hour) description	
        FROM qr_food qtf INNER JOIN turn_food ttf on qtf.fk_turn_food = ttf.idTurn_f INNER JOIN contract ct on idContract = contract
        WHERE  '.$sqlp3.' '.$str.' /*qtf.date BETWEEN :dateStart and :dateFinal*/ description is not null order by fk_turn_food asc');
    
        /*$sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
        $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);*/
        
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        
        if($input['dish'] != '' || $input['dish'] != null){
            $sql->bindParam(':dish',$like,PDO::PARAM_STR);
        }
    
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_menu($input){
        $like = '%'.$input['dish'].'%';
        $sqlp3 =' (garrison like :dish or dessert like :dish or plate like :dish) AND';
        if($input['dish'] == '' || $input['dish'] == null){
            $sqlp3=' ';
        }
        
        $str ='';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= ' (ttf.local = 0  or ttf.local = 1) AND';
        }else{
            $str = ' ttf.local = :local AND';
        }
        $sql = $this->connect()->prepare('
        SELECT DISTINCT idTurn_f fk_turn_food, date_hour fecha ,menu_portal, CONCAT("Platillo: ",plate," Guarnicion:",garrison," Postre: ", dessert) menu_movil	
        FROM  turn_food ttf 
        WHERE  '.$sqlp3.' '.$str.' date_hour BETWEEN :dateStart and :dateFinal order by fk_turn_food asc');
        
        /*$sql = $this->connect()->prepare('
        SELECT DISTINCT fk_turn_food,qtf.date fecha ,menu_portal, CONCAT("Platillo: ",plate," Guarnicion:",garrison," Postre: ", dessert) menu_movil	
        FROM qr_food qtf INNER JOIN turn_food ttf on qtf.fk_turn_food = ttf.idTurn_f INNER JOIN contract ct on idContract = contract
        WHERE  '.$sqlp3.' '.$str.' qtf.date BETWEEN :dateStart and :dateFinal order by fk_turn_food asc');*/
        
        $sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
        $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);
         if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }

        if($input['dish'] != '' || $input['dish'] != null){
            $sql->bindParam(':dish',$like,PDO::PARAM_STR);
        }
    
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}