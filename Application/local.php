<?php
require '../Config/database.php';

class local extends database {

    
    function comparar_pass($cve,$pass) {
        $sql = $this->connect()->prepare('
            SELECT pass FROM pass_local WHERE cveLocal = :id 
        ');
        
        $sql->bindParam(':id',$cve,PDO::PARAM_INT);
        $sql ->execute();
        
        $sql = $sql->fetch(PDO::FETCH_NUM);
        
        if (password_verify($pass,$sql[0])) {
            return 
            array(
                'status' => true,
                'session' => 'You can enter successfully'
            );
        }else{
            return [];
        }
    }
    
    function insert_pass_local($cve, $pass) {
        $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);
        $sql = $this->connect()->prepare('INSERT INTO pass_local (`cveLocal`, `pass`) VALUES(:cve, :pass)');
        $sql->bindParam(':cve',$cve,PDO::PARAM_INT);
        $sql->bindParam(':pass',$pass_hasheada,PDO::PARAM_STR);
        return $sql ->execute();
    }

    
    function update_pass_local($cve, $pass) {
        $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);
        $sql = $this->connect()->prepare('UPDATE pass_local SET `pass`= :pass WHERE cveLocal = :cve');
        $sql->bindParam(':cve',$cve,PDO::PARAM_INT);
        $sql->bindParam(':pass',$pass_hasheada,PDO::PARAM_STR);
        return $sql ->execute();
    }
}





