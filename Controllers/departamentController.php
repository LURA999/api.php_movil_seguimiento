<?php
require '../Application/departament.php';
require_once '../message.php';

class departamentController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new departament();
    }

    function departament_id($departament,$pass){
        $this->obj = $this->obj->departament_id($departament,$pass);
        $this->msg->select($this->obj,'departament');

    }

    function insert_departament($departament,$pass){
        try {
            $this->obj = $this->obj->insert_departament($departament,$pass);
            $this->msg->exitoso('departament');
        } catch (Exception $e) {
            $this->msg->noexitoso('departament',$e);
        }

    }
    function update_departament($departament,$pass){
        $this->obj = $this->obj->update_departament($departament,$pass);
        $this->msg->exitoso('departament');

    }
    
    
    function update_pass_global($pass){
        $this->obj = $this->obj->update_pass_global($pass);
        $this->msg->exitoso('departament');

    }
    
    

}
