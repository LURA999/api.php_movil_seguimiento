<?php
require '../Application/comment_food.php';
require_once '../message.php';

class commentFoodController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new comment_food();
    }

    
    function post_commentf($input){

        $bool = $this->obj->post_commentf($input);
 
        if($bool){
            $this->msg->exitoso('comment about the food');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    function get_commentf($dateStart,$dateFinal,$local){
        $this->obj = $this->obj->get_commentf($dateStart,$dateFinal,$local);
        $this->msg->select($this->obj,'turn');
    }
    


}
