<?php
require '../Application/turn_assistance.php';
require_once '../message.php';

class turnAssistanceController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new turn_assistance();
    }

    function post_turna($input){
        $this->obj = $this->obj->post_turna($input);
        echo $this->obj;
    }

    function post_turnca($input){

        $this->obj = $this->obj->post_turnca($input);
         if($this->obj){
            $this->msg->exitoso('close session');
        }else{
            $this->msg->noexitoso('close session',$e);
        }
        
       

    }
    function post_obva($input){
        
        $this->obj = $this->obj->post_obva($input);
        if($this->obj){
            $this->msg->exitoso('observation successfully upload');
        }else{
            $this->msg->noexitoso('The observation was not accepted',$e);
        }
       
    }

    function get_data(){
        $this->obj = $this->obj->get_data();
        $this->msg->select($this->obj,'turns');
    }
    
    function get_name_guard($input,$local){
                        
        $this->obj = $this->obj->get_name_guard($input,$local);
        $this->msg->select($this->obj,'turns');
    }
    
    function get_observations($input){
        $this->obj = $this->obj->get_observations($input);
        $this->msg->select($this->obj,'turns');
    }
    
    function get_ob_turn($idTurn){
        $this->obj = $this->obj->get_ob_turn($idTurn);
        $this->msg->select($this->obj,'guard');
    }

    function get_courses($name,$local){
        $this->obj = $this->obj->get_courses($name,$local);
        $this->msg->select($this->obj,'courses');
    }
    
    function get_data_guard($name){
        $this->obj = $this->obj->get_data_guard($name);
        $this->msg->select($this->obj,'guard');
    }
}
