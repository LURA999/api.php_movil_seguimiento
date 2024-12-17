<?php
require '../Application/qr_food.php';
require_once '../message.php';

class qrFoodController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new qr_food();
    }

    function post_registerf($input){
        $this->obj = $this->obj->post_registerf($input);
        echo $this->obj;
    }
    
     function slc_report($input) {
        $this->obj = $this->obj->slc_report($input);
        $this->msg->select($this->obj,'turn food');
    }
}
