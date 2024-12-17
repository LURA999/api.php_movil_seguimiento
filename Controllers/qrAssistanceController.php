<?php
require '../Application/qr_assistance.php';
require_once '../message.php';

class qrAssistanceController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new qr_assistance();
    }

    function post_registerA($input){
        $this->obj = $this->obj->post_registerA($input);
        
        echo $this->obj;
    }
    
     function slc_report($input) {
        $this->obj = $this->obj->slc_report($input);
        $this->msg->select($this->obj,'turn assistance');
    }
    
    function get_namesSearch($in,$local) {
        $this->obj = $this->obj->get_namesSearch($in,$local);
        $this->msg->select($this->obj,'assistance');
    }
   
}
