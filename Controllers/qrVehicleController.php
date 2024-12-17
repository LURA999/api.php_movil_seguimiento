<?php
require '../Application/qr_vehicle.php';
require_once '../message.php';

class qrVehicleController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new qr_vehicle();
    }

    function post_qr($input){
        echo $this->obj->post_qr($input);
        /*
        if($this->obj){
            $this->msg->exitoso("qr");
        }else{
            $this->msg->noExitoso("qr",[]);
        }*/
    }
    
    function get_vehicle($plate,$c,$local){
        $this->obj = $this->obj->get_vehicle($plate,$c,$local);
        $this->msg->select($this->obj,'vehicle');
    }
    
    function platesSearch($plate,$local){
        $this->obj = $this->obj->platesSearch($plate,$local);
        $this->msg->select($this->obj,'vehicle');
    }
    
    
    function post_registerv($input){
            echo $this->obj->post_registerv($input);
    }
    
    function post_qr2($input){
        $this->obj = $this->obj->post_qr2($input);
        if($this->obj){
            $this->msg->exitoso("qr");
        }else{
            $this->msg->noExitoso("qr",[]);
        }
    }
    
    function slc_report($input){
        $this->obj = $this->obj->slc_report($input);
        $this->msg->select($this->obj,'vehicle');

    }


}
