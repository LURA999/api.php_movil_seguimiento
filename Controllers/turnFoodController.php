<?php
require '../Application/turn_food.php';
require_once '../message.php';

class turnFoodController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new turn_food();
    }

    function post_turnf($input){
        try {
        $this->obj = $this->obj->post_turnf($input);
        $this->msg->exitoso('turn food');
        } catch(Exception $e){
            $this->msg->noexitoso('turn food',$e);
        }

    }

    function post_turncf($input){
        try {
            $this->obj = $this->obj->post_turncf($input);
            $this->msg->exitoso('turn closed');
        } catch (Exception $e) {
            $this->msg->noexitoso('turn closed',$e);
        }

    }
    function post_obvf($input){
        try{
        $this->obj = $this->obj->post_obvf($input);
        $this->msg->exitoso('observacion');
        } catch(Exception $e){
            $this->msg->noexitoso('observacion',$e);
        }

    }
    
    function get_observations($plate){
        $this->obj = $this->obj->get_observations($plate);
        $this->msg->select($this->obj,'turn');
    }
    
    function get_menu($plate){
        $this->obj = $this->obj->get_menu($plate);
        $this->msg->select($this->obj,'turn');
    }
    
    function get_obvf($local){
        $this->obj = $this->obj->get_obvf($local);
        $this->msg->select($this->obj,'turn');
    }


}
