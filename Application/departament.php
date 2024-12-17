<?php
require '../Config/database.php';

class departament extends database {

    
    function departament_id($id,$pass) {

        $sql = $this->connect()->prepare('SELECT pass FROM departament WHERE idDepartament = :id ');
        $sql -> bindParam(':id',$id,PDO::PARAM_INT);
        $sql -> execute();
        
        $sql2 = $this->connect()->prepare('SELECT passGlobal FROM departament WHERE idDepartament = :id ');
        $sql2 -> bindParam(':id',$id,PDO::PARAM_INT);
        $sql2 -> execute();
        
        $sql = $sql->fetch(PDO::FETCH_NUM);
        $sql2 = $sql2->fetch(PDO::FETCH_NUM);
        
        if ( password_verify($pass, $sql[0])) {
            return array('session' => 'You can enter successfully');
        } else if ( password_verify($pass, $sql2[0])){
            return array('session' => 'You can enter successfully');
        }else{
            return [];
        }

    }

    
    function insert_departament($departament, $pass) {
        $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);
        $sql = $this->connect()->prepare('INSERT INTO departament (departament, pass) VALUES(:departament, :pass)');
        $sql->bindParam(':departament',$departament,PDO::PARAM_INT);
        $sql->bindParam(':pass',$pass_hasheada,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function update_departament($departament, $pass) {
        $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);
        $sql = $this->connect()->prepare('UPDATE departament SET pass = :pass WHERE idDepartament = :departament');
        $sql->bindParam(':departament',$departament,PDO::PARAM_INT);
        $sql->bindParam(':pass',$pass_hasheada,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function update_pass_global($pass) {
        $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);
        $sql = $this->connect()->prepare('UPDATE departament SET passGlobal = :pass;');
        $sql->bindParam(':pass',$pass_hasheada,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
}