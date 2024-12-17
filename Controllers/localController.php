<?php
require '../Application/local.php';
require_once '../message.php';

class localController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new local();
    }

    function comparar_pass($cve,$pass){
        $this->obj = $this->obj->comparar_pass($cve,$pass);
        $this->msg->select($this->obj,'local');

    }

    function insert_pass_local($cve,$pass){
        $this->obj = $this->obj->insert_pass_local($cve,$pass);
        if($this->obj){
            $this->msg->exitoso('local');
        }else{
            $this->msg->noexitoso('local',$e);
        }
    }
    
    function update_pass_local($cve,$pass){
        $this->obj = $this->obj->update_pass_local($cve,$pass);
        if($this->obj){
            $this->msg->exitoso('local');
        }else{
            $this->msg->noexitoso('local',$e);
        }
    }

}
