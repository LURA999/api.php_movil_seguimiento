<?php
require '../Config/database.php';

class turn_assistance extends database {

    
    function post_turna($input) {
        
        $connection = $this->connect();
        $sql = $connection->prepare('INSERT INTO `turn_assistance`(`course_name`, `schedule`, `date`, local) VALUES (:name, :schedule, NOW(), :local)');
        $sql->bindParam(':name',$input['course_name'],PDO::PARAM_STR);
        $sql->bindParam(':schedule',$input['schedule'],PDO::PARAM_STR);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);


        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }

    
    function post_turnca($input) {
        $sql = $this->connect()->prepare('UPDATE turn_assistance SET dateFinal = NOW() WHERE idTurn_a = :idTurn ;');
        $sql->bindParam(':idTurn',$input['idTurn'],PDO::PARAM_STR);
        return $sql ->execute();
    }

    
    function post_obva($input) {
        $sql = $this->connect()->prepare('UPDATE turn_assistance SET observation = :observation WHERE idTurn_a = :idTurn;');
        $sql->bindParam(':observation',$input['description'],PDO::PARAM_STR);
        $sql->bindParam(':idTurn',$input['idTurn'],PDO::PARAM_INT);
        return $sql ->execute();
    }

    
    function get_data() {
        $sql = $this->connect()->prepare('SELECT idTurn_a id, turn, sign, date, fk_idGuard FROM turn_assistance');
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_name_guard($name,$local) {
        $str ='';
        if($local == 0 || $local ==1){
            $str= 'AND (cveLocal = 0  or cveLocal = 1)';
        }else{
            $str = 'AND cveLocal = :local';
        }

        $like = '%'.$name.'%';
        $sql = $this->connect()->prepare("SELECT concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) name 
        FROM comunica_portalComunicacion.usuario where concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) 
        like :name and departamento = 'trafico' '.$str.'");
        $sql->bindParam(':name',$like,PDO::PARAM_STR);
        if($local > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_courses($name,$local) {
        $like = '%'.$name.'%';
        $str ='';
        if(intval($local) == 0 || intval($local) ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :local';
        }

        $sql = $this->connect()->prepare('SELECT /*concat(idFake," - ",course_name)*/ course_name FROM `turn_assistance` 
        WHERE '.$str.' AND course_name like :name GROUP BY course_name ORDER BY `idTurn_a` DESC LIMIT 30');
        $sql->bindParam(':name',$like,PDO::PARAM_STR);
        if(intval($local) > 1){
            $sql->bindParam(':local',$local,PDO::PARAM_INT);
        }
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
     function get_data_guard($id) {
        $sql = $this->connect()->prepare('SELECT sign,name FROM user_guard ug where ug.name = :name ');
        $sql->bindParam(':name',$id,PDO::PARAM_STR);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
      function get_observations($input){
        $sql4= '';
        
        $str ='';
        if($local == 0 || $local ==1){
            $str= 'AND (ttv.local = 0  or ttv.local = 1)';
        }else{
            $str = 'AND ttv.local = :local';
        }
        
        if($input['course_name'] != '' || $input['course_name'] != null){
            $sql3=' AND (course_name  = :curso ) ';
        }
        
        /*if(($input['dateStart'] != '' && $input['dateFinal'] != null) &&  ($input['dateStart'] != null && $input['dateFinal'] != '')  ){
            $sql4= ' AND  date BETWEEN :dateStart and :dateFinal ';
        }*/
        
        $sql = $this->connect()->prepare('SELECT distinct date,observation FROM turn_assistance ttv 
        INNER JOIN qr_assistance qtv ON qtv.fk_idTurn_a = ttv.idTurn_a 
        WHERE observation != ""
        '.$sql3.' '.$str.'
        ORDER BY idTurn_a DESC;');
        
        /*if(($input['dateStart'] != '' && $input['dateFinal'] != null) &&  ($input['dateStart'] != null && $input['dateFinal'] != '')  ){
            $sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
            $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);
        }*/
        
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        
        if($input['course_name'] != '' || $input['course_name'] != null){
            $sql->bindParam(':curso',$input['course_name'],PDO::PARAM_STR);
        }
        
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_ob_turn($idTurn){
        $sql = $this->connect()->prepare('SELECT observation FROM turn_assistance WHERE idTurn_a = :idTurn');
        $sql->bindParam(':idTurn',$idTurn,PDO::PARAM_STR);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
}