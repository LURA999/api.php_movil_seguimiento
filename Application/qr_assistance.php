<?php
require '../Config/database.php';

class qr_assistance extends database {

    
    function post_registerA($input) {
        
        if(intval($input['local']) == 0 ){
            $input['local'] = 1;
        }
        
        $sql = $this->connect()->prepare('INSERT INTO qr_assistance (employee_num, time, fk_idTurn_a, local) VALUES(:numEmployee, NOW(), :fk_idTurn_a, :local)');
        $sql->bindParam(':numEmployee',$input['employee_num'],PDO::PARAM_STR);
        $sql->bindParam(':fk_idTurn_a',$input['idTurn'],PDO::PARAM_INT);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        
        if ($sql->execute()) {
            return json_encode(array("status" => "200", "container"=> [ ], "info" => "Proceso completado." ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" =>$sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ) );
        }
    }
    
    function slc_report($input) {
        //$like = '%'.$input['course_name'].'%';
        $sql3 =' ';
        $sql4 = '';
        //$addAnd = ' AND ';
        //$count = 0;
        $sql5 = '';
        
        $str ='';
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= '(ta.local = 0  or ta.local = 1) ';
        }else{
            $str = 'ta.local = :local ';
        }
        
        if($input['course_name'] != null){
            
            $sql3=' AND (course_name  = :curso ) ';
            /*
            AND course_name = 
            (SELECT course_name 
            FROM `qr_assistance`
            INNER JOIN comunica_portalComunicacion.usuario on usuario = employee_num 
            INNER JOIN turn_assistance qr on idTurn_a = fk_idTurn_a 
            WHERE '.$str2.' AND idFake  = :curso)
            */
        }else{
            $sql3=' AND (course_name  = "" ) ';
        }
        
        if(($input['dateStart'] != '' && $input['dateFinal'] != null) &&  ($input['dateStart'] != null && $input['dateFinal'] != '')  ){
            $sql4= ' AND  qr.time BETWEEN :dateStart and :dateFinal ';
        }
        
        if( $input['personal'] == 2 ){
            $sql5 = ' AND (contrato = 3  OR contrato = 2) ';
        }else if( $input['personal'] == 1 ){
            $sql5 = ' AND contrato = :contrato ';
        }
        
        $sql = $this->connect()->prepare('
        SELECT employee_num, concat(nombres," ", apellidoPaterno," ", apellidoMaterno) complete_name, course_name, schedule, time date 
        FROM `qr_assistance` qr INNER JOIN comunica_portalComunicacion.usuario on usuario = employee_num AND qr.local = IF(cveLocal = 0, 1, cveLocal) 
        INNER JOIN turn_assistance ta on idTurn_a = fk_idTurn_a
        WHERE  '.$str.' '.$sql3.' '.$sql4.' '.$sql5.' order by date asc
        ') ;

        if(($input['dateStart'] != '' && $input['dateFinal'] != null) &&  ($input['dateStart'] != null && $input['dateFinal'] != '')  ){
            $sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
            $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);
        }
        
        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        
        if($input['course_name'] != null){
            $sql->bindParam(':curso',$input['course_name'],PDO::PARAM_STR);
        }
        
        if($input['personal'] == 1){
            $sql->bindParam(':contrato',$input['personal'],PDO::PARAM_STR);
        }

        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_namesSearch($in,$local){
        $str ='';
        if(intval($local) == 0 || intval($local) == 1){
            $str= ' (cveLocal = 0  or cveLocal = 1) AND ';
        }else{
            $str = ' cveLocal = :local AND ';
        }
        $like = '%'.$in.'%';
        
        $sql = $this->connect()->prepare("SELECT concat(u.nombres,' ',u.apellidoPaterno,' ',u.apellidoMaterno) complete_name, u.usuario, u.cveLocal, CASE
        WHEN l.nombre = 'General' THEN 'Mexicali'
        ELSE l.nombre
        END AS local
        FROM comunica_portalComunicacion.usuario u 
        INNER JOIN comunica_portalComunicacion.local l ON idLocal = cveLocal 
        WHERE $str  concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) like :name Limit 10;");
        /*echo "SELECT concat(u.nombres,' ',u.apellidoPaterno,' ',u.apellidoMaterno) complete_name, u.usuario, u.cveLocal, CASE
        WHEN l.nombre = 'General' THEN 'Mexicali'
        ELSE l.nombre
        END AS local
        FROM comunica_portalComunicacion.usuario u 
        INNER JOIN comunica_portalComunicacion.local l ON idLocal = cveLocal 
        WHERE $str  concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) like :name Limit 10;";*/
        $sql->bindParam(':name',$like,PDO::PARAM_STR);
        
         if(intval($local) > 1){
            $sql->bindParam(':local',$local,PDO::PARAM_INT);
        }
        

        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

}