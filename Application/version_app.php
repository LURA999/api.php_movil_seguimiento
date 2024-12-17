<?php
require '../Config/database.php';

class version_app extends database {

    
    function getLastVersion() {

        $sql = $this->connect()->prepare('SELECT version,description FROM `version_app` order by idVersion desc LIMIT 1;');
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        
    }

    
    
}