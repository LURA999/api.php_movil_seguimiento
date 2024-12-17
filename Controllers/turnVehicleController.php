<?php
require '../Application/turn_vehicle.php';
require_once '../message.php';

class turnVehicleController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new turn_vehicle();
    }

    function post_turnv($input){
        $this->obj = $this->obj->post_turnv($input);
        echo $this->obj;
    }

    function post_turncv($input){
        try {
            $this->obj = $this->obj->post_turncv($input);
            $this->msg->exitoso('turn closed');
        } catch (Exception $e) {
            $this->msg->noexitoso('turn closed',$e);
        }

    }
    function post_obvv($input){
        try{
        $this->obj = $this->obj->post_obvv($input);
        $this->msg->exitoso('observacion');
        } catch(Exception $e){
            $this->msg->noexitoso('observacion',$e);
        }

    }

    function get_data($local){
        $this->obj = $this->obj->get_data($local);
        $this->msg->select($this->obj,'turns');
    }
    
    function get_name_guard($input, $local){
                        
        $this->obj = $this->obj->get_name_guard($input, $local);
        $this->msg->select($this->obj,'turns');
    }
    
    function get_observations($input){
        $this->obj = $this->obj->get_observations($input);
        $this->msg->select($this->obj,'turns');
    }
    
    function get_ob_turn($name, $local){
        $this->obj = $this->obj->get_ob_turn($name, $local);
        $this->msg->select($this->obj,'guard');
    }

    function get_names($local){
        $this->obj = $this->obj->get_names($local);
        $this->msg->select($this->obj,'guard');
    }
    
    function get_data_guard($name, $local){
        $this->obj = $this->obj->get_data_guard($name, $local);
        $this->msg->select($this->obj,'guard');
    }
}
