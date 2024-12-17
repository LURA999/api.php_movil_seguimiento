<?php
require '../Application/tourSeh.php';
require_once '../message.php';

class tourSehController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new tourSeh();
    }

    function getAnswer($form,$local){
        $this->obj = $this->obj->getAnswer($form,$local);
        $this->msg->select($this->obj,'form');
    }
    
    function getQuestion($form,$local ){
        $this->obj = $this->obj->getQuestion($form,$local);
        $this->msg->select($this->obj,'form');
    }
        
    function getTitle($form, $local){
        $this->obj = $this->obj->getTitle($form, $local);
        $this->msg->select($this->obj,'form');
    }

    function getComments($form, $local){
        $this->obj = $this->obj->getComments($form, $local);
        $this->msg->select($this->obj,'form');
    }
    
    function getDescriptions($form, $local){
         $this->obj = $this->obj->getDescriptions($form, $local);
        $this->msg->select($this->obj,'form');
    }
    
    function getTitleDescription($form,$local){
        $this->obj = $this->obj->getTitleDescription($form,$local);
        $this->msg->select($this->obj,'form');
    }

    
    function updateFormAB($input,$form){
        $this->obj = $this->obj->updateFormAB($input,$form);
        if($this->obj){
            $this->msg->exitoso('formAB');
        }else{
            
            $this->msg->noExitoso('formAB',[]);
        }

    }
    
    function insertNewArea($area){
        $thi->obj = $this->obj->insertNewArea($area);
        if($this->obj){
            $this->msg->exitoso('insertArea');
        }else{
            $this->msg->noExitoso('insertArea',[]);
        }
    }
    
    function insertNewQuestion($question){
        $thi->obj = $this->obj->insertNewQuestion($question);
        if($this->obj){
            $this->msg->exitoso('insertQuestion');
        }else{
            $this->msg->noExitoso('insertQuestion',[]);
        }
    }
    
    function updateComments($input,$form){
        $boolean = $this->obj->updateComments($input,$form);
        
        if($boolean){
            $this->msg->exitoso('formAB');
        }else{
            
            $this->msg->noExitoso('formAB',[]);
        }

    }
    function updateDescription($input,$form){
        $this->obj = $this->obj->updateDescription($input,$form);
        
        if($this->obj){
            $this->msg->exitoso('formAB');
        }else{
            
            $this->msg->noExitoso('formAB',[]);
        }

    }
    
    


}
