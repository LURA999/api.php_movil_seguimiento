<?php
require '../Config/database.php';

class qr_vehicle extends database {

    
    function post_qr($input) {
        $ready = false;
        
        $conexion = $this -> connect();   
        
        $conexion -> beginTransaction();
        
        $str = '';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= '(cveLocal = 0  or cveLocal = 1)';
        }else{
            $str = 'cveLocal = :local';
        }
        
        $sql2 = $conexion->prepare('INSERT INTO qr_vehicle (fk_vehicle, time_entry, fk_idTurn_v, local) 
        VALUES( (SELECT usuario FROM comunica_portalComunicacion.usuario WHERE usuario = :numEmployee and '.$str.' ), NOW(), :fk_turn, :local)');
        $sql2->bindParam(':fk_turn',$input['fkTurn'],PDO::PARAM_INT);
        $sql2->bindParam(':numEmployee',$input['employee_num'],PDO::PARAM_STR);
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }

        
        //$passed = $sql2 -> execute();

        //if($passed){
            /*if($local == 0 || $local ==1){
                $str= '(local = 0  or local = 1)';
            }else{
                $str = 'local = :local';
            }
        
            $sql = $conexion->prepare('UPDATE vehicle SET type_vh = :typevh, color = :color WHERE employee_num = :numEmployee and '.$str.' ');
            $sql->bindParam(':typevh',$input['typevh'],PDO::PARAM_STR);
            $sql->bindParam(':color',$input['color'],PDO::PARAM_STR);
            $sql->bindParam(':numEmployee',$input['employee_num'],PDO::PARAM_STR);
            
            if($local > 1){
                $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
            }
            if($sql->execute()){*/
                $ready = true;
            /*}*/
        //}

        if($sql2 -> execute() /*$ready*/){
            
            $conexion -> commit();
            return json_encode(array("status" => "200", "container"=> [ ], "info" => "Proceso completado." ));
        }else{
            $conexion -> rollBack();
            return json_encode(array("status" => "404", "container"=> [  [ "error" => /*$sql2->errorInfo()[2]*/ 'El vehículo no se encuentra registrado' ]  ], "info" => "Error de la consulta" ) );
        }
        
        
        return $ready;
    }
    
    
    function post_qr2($input) { 
        $ready = false;
     
        $str = '';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= '(cveLocal = 0  or cveLocal = 1)';
        }else{
            $str = 'cveLocal = :local';
        }
        
        $conexion = $this->connect();   
        
        $conexion->beginTransaction();
        $sql2 = $conexion->prepare('INSERT INTO qr_vehicle (fk_vehicle, time_entry, fk_idTurn_v, local) 
        VALUES( (SELECT usuario FROM comunica_portalComunicacion.usuario WHERE CONCAT(nombres, " ",apellidoPaterno, " ",apellidoMaterno) = :employeeName ), NOW(), :fk_turn, :local)');
        $sql2->bindParam(':fk_turn',$input['fkTurn'],PDO::PARAM_INT);
        $sql2->bindParam(':employeeName',$input['employeeName'],PDO::PARAM_STR);
        $sql2->bindParam(':local',$input['local'],PDO::PARAM_STR);

        if($sql2 ->execute()){
            $sql = $conexion->prepare('UPDATE vehicle SET type_vh = :typevh, model_vh = :modelvh, color = :color WHERE employee_num = (SELECT usuario FROM comunica_portalComunicacion.usuario WHERE CONCAT(nombres, " ",apellidoPaterno, " ",apellidoMaterno) = :employeeName and '.$str.' ) and local = :local;');
            $sql->bindParam(':typevh',$input['typevh'],PDO::PARAM_STR);
            $sql->bindParam(':modelvh',$input['modelvh'],PDO::PARAM_STR);
            $sql->bindParam(':color',$input['color'],PDO::PARAM_STR);
            $sql->bindParam(':employeeName',$input['employeeName'],PDO::PARAM_STR);
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
            

            if($sql->execute()){
                $ready = true;
            }
        }
        
        if($ready){
            $conexion->commit();
            return true;
        }else{
            $conexion->rollBack();
            return false;
        }
        
        
        return $ready;
        
    }
    function get_vehicle($plate,$c,$local){
        $moreColumn = '';
        $innerjoinExtra = '';
        $orderBy = '';
        
        if($c == 1){
            $moreColumn = ',time_entry,time_exit';
            $innerjoinExtra = 'INNER JOIN qr_vehicle cu on fk_vehicle = idVehicle  ';
            $orderBy = 'time_entry';
        }else{
            $moreColumn = ',cd.departamento department';
            $orderBy = 'idVehicle';
        }
        
        $sql = $this->connect()->prepare('SELECT v.type_vh,v.color,v.plates, concat(nombres, " ",apellidoPaterno," ", apellidoMaterno ) employee_name, v.model_vh
        '.$moreColumn.' FROM vehicle v 
        INNER JOIN comunica_portalComunicacion.usuario cu on usuario = v.employee_num 
        INNER JOIN comunica_portalComunicacion.departamentos cd on cu.cveDepartamento = cd.idDepartamento 
        '.$innerjoinExtra.'
        WHERE v.plates = :plate AND 
        v.local = :local
        order by '.$orderBy.' desc limit 1;');
        
        /*
        SELECT v.type_vh,v.color,v.plates, concat(nombres, " ",apellidoPaterno," ", apellidoMaterno ) employee_name, cd.departamento FROM vehicle v 
        INNER JOIN comunica_portalComunicacion.usuario cu on usuario = v.employee_num 
        INNER JOIN comunica_portalComunicacion.departamentos cd on cu.cveDepartamento = cd.idDepartamento where v.plates = '12345' order by idVehicle desc limit 1;
        */
        
        $sql->bindParam(':plate',$plate,PDO::PARAM_STR);
        $sql->bindParam(':local',$local,PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    function post_registerv($input) {
        $sql = $this->connect()->prepare('INSERT INTO qr_vehicle (fk_vehicle, time_entry, fk_idTurn_v) VALUES(:fk_vehicle, NOW(), :fk_turn)');
        //$sql->bindParam(':typevh',$input['typevh'],PDO::PARAM_STR);
        //$sql->bindParam(':color',$input['color'],PDO::PARAM_STR);
        //$sql->bindParam(':plates',$input['platesSearch'],PDO::PARAM_STR);
        //$sql->bindParam(':employeeName',$input['employeeName'],PDO::PARAM_STR);
        //$sql->bindParam(':departament',$input['departament'],PDO::PARAM_STR);
        $sql->bindParam(':fk_turn',$input['fkTurn'],PDO::PARAM_INT);
        $sql->bindParam(':fk_vehicle',$input['employee_num'],PDO::PARAM_INT);
        /*$sql->bindParam(':name',$input['name'],PDO::PARAM_STR);
        $sql->bindParam(':turn',$input['turn'],PDO::PARAM_INT);*/
        
         if ($sql->execute()) {
            return json_encode(array("status" => "200", "container"=> [ ], "info" => "Proceso completado." ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" =>$sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ) );
        }
    }

    
    function slc_report($input) {
        $sqlp2 ='';
        $sqlp3 =' and turn = :turn ';
        
        if($input['guard'] != ''){
            $sqlp2= ' and usg.name = :guard ';
        }

        if($input['turn'] == 4 || $input['turn'] == '4'){
            $sqlp3=' ';
        }
        
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= ' (ttv.Local = 0  or ttv.Local = 1) AND';
        }else{
            $str = ' ttv.Local = :local AND';
        }
        
        $sql = $this->connect()->prepare('
        SELECT type_vh, model_vh, color, plates, concat(nombres, " ",apellidoPaterno," ", apellidoMaterno ) employee_name, cd.departamento department, time_entry
        FROM qr_vehicle qtv INNER JOIN vehicle v on idVehicle = fk_vehicle 
        INNER JOIN turn_vehicle ttv on ttv.idTurn_v = qtv.fk_idTurn_v 
        INNER JOIN user_guard usg on usg.idGuard = ttv.fk_idGuard
        INNER JOIN comunica_portalComunicacion.usuario cu on usuario = v.employee_num  /*AND cveLocal = v.local */
        INNER JOIN comunica_portalComunicacion.departamentos cd on cu.cveDepartamento = cd.idDepartamento
        WHERE '.$str.' time_entry BETWEEN :dateStart and :dateFinal '.$sqlp2. '  '.$sqlp3);
        
        $sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
        $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);
        
      
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
    
    
    function platesSearch($plate,$local){
        $plate = '%'.$plate.'%';
        $sql = $this->connect()->prepare('SELECT plates FROM `vehicle` where plates like :plate AND local = :local GROUP BY plates DESC;');
        $sql->bindParam(':plate',$plate,PDO::PARAM_STR);
        $sql->bindParam(':local',$local,PDO::PARAM_STR);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

}