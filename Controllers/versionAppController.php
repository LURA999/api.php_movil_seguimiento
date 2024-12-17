<?php
require '../Application/version_app.php';
require_once '../message.php';

class versionAppController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new version_app();
    }

    function getLastVersion(){
        $this->obj = $this->obj->getLastVersion();
        $this->msg->select($this->obj,'turns');
    }
    
}
