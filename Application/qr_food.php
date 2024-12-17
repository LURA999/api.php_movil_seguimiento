<?php
require '../Config/database.php';

class qr_food extends database {

    
    function post_registerf($input) {
        $str = '';
        if(intval($input['localApp']) == 0 || intval($input['localApp']) ==1){
            $str= '(local = 0  or local = 1)';
        }else{
            $str = 'local = :localApp';
        }
        
        $sql = $this->connect()->prepare('INSERT INTO qr_food (numberEmployee, name, contract, date,fk_turn_food, local) 
        VALUES(:numEmployee, :name,:contract, NOW(), ( SELECT idTurn_f FROM turn_food WHERE '.$str.' ORDER BY idTurn_f DESC Limit 1 ), :local)');
        $sql->bindParam(':numEmployee',$input['numEmployee'],PDO::PARAM_INT);
        $sql->bindParam(':name',$input['name'],PDO::PARAM_STR);
        $sql->bindParam(':contract',$input['contract'],PDO::PARAM_INT);
        $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);

        if($input['localApp'] > 1){
            $sql->bindParam(':localApp',$input['localApp'],PDO::PARAM_INT);
        }
        
        
        if ($sql->execute()) {
            return json_encode(array("status" => "200", "container"=> [ ], "info" => "El empleado aun puede comer =)" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" =>$sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ) );
        }
        
    }
    
    function slc_report($input) {
        $like = '%'.$input['plate'].'%';
        $sqlp3 =' (garrison like :plate or dessert like :plate or plate like :plate) and ';
        
        if($input['plate'] == '' || $input['plate'] == null){
            $sqlp3=' ';
        }
        
        if(intval($input['local']) == 0 || intval($input['local']) ==1){
            $str= ' (ttf.Local = 0  or ttf.Local = 1) AND';
        }else{
            $str = ' ttf.Local = :local AND';
        }
        
        $sql = $this->connect()->prepare('
        SELECT numberEmployee, qtf.name, ct.name contract, date
        FROM qr_food qtf INNER JOIN turn_food ttf on qtf.fk_turn_food = ttf.idTurn_f INNER JOIN contract ct on idContract = contract
        WHERE  '.$sqlp3.' '.$str.' qtf.date BETWEEN :dateStart and :dateFinal order by date asc');
        
        
        $sql->bindParam(':dateStart',$input['dateStart'],PDO::PARAM_STR);
        $sql->bindParam(':dateFinal',$input['dateFinal'],PDO::PARAM_STR);

        if(intval($input['local']) > 1){
            $sql->bindParam(':local',$input['local'],PDO::PARAM_INT);
        }
        
        if($input['plate'] != '' || $input['plate'] != null){
            $sql->bindParam(':plate',$like,PDO::PARAM_STR);
        }
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

}