<?php
require '../Config/database.php';

class turn_vehicle extends database {

    
    function post_turnv($input) {
        $sql = $this->connect()->prepare('Select count(*),idGuard from user_guard where name = :name');
        $sql->bindParam(':name',$input['guard'],PDO::PARAM_STR);
        $sql ->execute();
        $res = $sql->fetch(PDO::FETCH_NUM);
        
        if($res[0] == 1 || $res[0] > 1){
            $connection1 = $this->connect();
            $sql1 = $connection1->prepare('INSERT INTO turn_vehicle (turn, date, fk_idGuard, dateFinal, local) VALUES(:turn, NOW(), :name, :finish, :local)');
            $sql1->bindParam(':turn',$input['turn'],PDO::PARAM_STR);
            $sql1->bindParam(':name',$res[1],PDO::PARAM_INT);
            $sql1->bindParam(':finish',$input['finish'],PDO::PARAM_STR);
            $sql1->bindParam(':local',$input['local'],PDO::PARAM_INT);

            $connection2 = $this->connect();
            $sql2 =$connection2->prepare('update user_guard set sign = :sign where idGuard = :id');
            $sql2->bindParam(':id',$res[1],PDO::PARAM_INT);
            $sql2->bindParam(':sign',$input['sign'],PDO::PARAM_STR);
            $sql2 ->execute();
            
            if ($sql1->execute()) {
                $lastInsertedId = $connection1->lastInsertId();
                return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
            } else {
                return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
            }
        }else{
            $connection1 = $this->connect();
            $sql1 = $connection1->prepare('INSERT INTO user_guard (sign, name) VALUES(:sign, :name)');
            $sql1->bindParam(':sign',$input['sign'],PDO::PARAM_STR);
            $sql1->bindParam(':name',$input['guard'],PDO::PARAM_STR);
            $sql1->execute();
            $lastInsertedId1 = $connection1->lastInsertId();
            
            $connection2 = $this->connect();
            $sql2 = $connection2->prepare('INSERT INTO turn_vehicle (turn, date, fk_idGuard, dateFinal, local) VALUES( :turn, NOW(), :idTurn, :finish, :local)');
            $sql2->bindParam(':turn',$input['turn'],PDO::PARAM_STR);
            $sql2->bindParam(':finish',$input['finish'],PDO::PARAM_STR);
            $sql2->bindParam(':idTurn',$lastInsertedId1,PDO::PARAM_INT);
            $sql2->bindParam(':local',$input['local'],PDO::PARAM_INT);

            if ($sql2->execute()) {
                $lastInsertedId = $connection2->lastInsertId();
                return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
            } else {
                return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql2->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
            }

        }
       
    }

    
    function post_turncv($input) {
        $sql = $this->connect()->prepare('UPDATE turn_vehicle SET dateFinal = NOW() WHERE idTurn_v = :idTurn;');
        $sql->bindParam(':idTurn',$input['idTurn'],PDO::PARAM_STR);
       // $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        return $sql ->execute();
    }

    
    function post_obvv($input) {
        $sql = $this->connect()->prepare('UPDATE turn_vehicle SET observation = :observation WHERE idTurn_v = :idTurn;');
        $sql->bindParam(':observation',$input['description'],PDO::PARAM_STR);
        $sql->bindParam(':idTurn',$input['idTurn'],PDO::PARAM_STR);
       // $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        return $sql ->execute();
    }

    
    function get_data($local) {
        $str ='';
        if($local == 0 || $local ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :local';
        }

        $sql = $this->connect()->prepare('SELECT idTurn_v id, turn, sign, date, fk_idGuard FROM turn_vehicle WHERE '.$str.'');
        if($local > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_name_guard($name, $local) {
        $str ='';
        if($local == 0 || $local ==1){
            $str= 'AND (cveLocal = 0  or cveLocal = 1)';
        }else{
            $str = 'AND cveLocal = :local';
        }

        $like = '%'.$name.'%';
        
        $sql = $this->connect()->prepare("SELECT concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) name 
        FROM comunica_portalComunicacion.usuario where concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) like :name and (cveDepartamento = 40 OR cveDepartamento = 38) $str");
        if($local > 1){
          $sql->bindParam(':local',$local,PDO::PARAM_INT);
        }
        $sql->bindParam(':name',$like,PDO::PARAM_STR);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_names($local) {
        $str ='';
        if($local == 0 || $local ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :local';
        }

        $sql = $this->connect()->prepare("SELECT idGuard id, name FROM user_guard WHERE  $str");
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
     function get_data_guard($id, $local) {
         $str ='';
        if($local == 0 || $local ==1){
            $str= 'AND (local = 0  or local = 1)';
        }else{
            $str = 'AND local = :local';
        }

        $sql = $this->connect()->prepare('SELECT sign,name FROM user_guard ug WHERE ug.name = :name '.$str.' ');
        if($local > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        $sql->bindParam(':name',$id,PDO::PARAM_STR);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
      function get_observations($input){
        $sqlp2 ='';
        $sqlp3 =' turn = :turn and ';

        $str ='';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= 'AND (ttv.local = 0  or ttv.local = 1)';
        }else{
            $str = 'AND ttv.local = :local';
        }


        if($input['guard'] != ''){
            $sqlp2= ' usg.name = :guard and ';
        }  
        
        if($input['turn'] == 4 || $input['turn'] == '4'){
            $sqlp3=' ';
        }
        
        $sql = $this->connect()->prepare('SELECT distinct date,observation FROM turn_vehicle ttv 
        INNER JOIN qr_vehicle qtv ON qtv.fk_idTurn_v = ttv.idTurn_v 
        INNER JOIN user_guard usg ON ttv.fk_idGuard = idGuard
        WHERE '.$sqlp2.' '.$sqlp3.' observation != ""
         /*AND qtv.time_entry BETWEEN :dateStart and :dateFinal*/ '.$str.'
        ORDER BY idTurn_v DESC;');
        
        /*$sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
        $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);*/
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        
        
        if($input['guard'] != '' ){
            $sql->bindParam(':guard',$input['guard'],PDO::PARAM_STR);
        }
        
        if($input['turn'] != 4 || $input['turn'] != '4'){
            $sql->bindParam(':turn',$input['turn'],PDO::PARAM_INT);
        }
        
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_ob_turn($n, $local){
        $str ='';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= 'AND (tv.local = 0  or tv.local = 1)';
        }else{
            $str = 'AND tv.local = :local';
        }
       $sql = $this->connect()->prepare('SELECT observation FROM turn_vehicle tv inner join user_guard ug on idGuard = fk_idGuard 
       WHERE ug.name = :name '.$str.'
       ORDER BY idTurn_v DESC LIMIT 1');
       
       
        $sql->bindParam(':name',$n,PDO::PARAM_STR);
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
         $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
}