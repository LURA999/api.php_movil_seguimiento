<?php
require '../Application/medical_exam.php';
require_once '../message.php';

class medicalExamController
{
    private $obj;
    private $msg;

    function __construct()
    {
        $this->msg = new message();
        $this->obj = new medical_exam();
    }

    
    function get_examAccidentDisease($input){
        $this->obj = $this->obj->get_examAccidentDisease($input);
        $this->msg->select($this->obj,'turn');
    }
    
    function get_examHistory($input){
        $this->obj = $this->obj->get_examHistory($input);
        $this->msg->select($this->obj,'turn');
    }
    
    function get_examOneInformationPart1($input){
        $this->obj = $this->obj->get_examOneInformationPart1($input);
        $this->msg->select($this->obj,'turn');
    }
    
    function get_examHeredityFam($input){
        $this->obj = $this->obj->get_examHeredityFam($input);
        $this->msg->select($this->obj,'turn');
    }
    
    
    function get_allExamList($input){
        $this->obj = $this->obj->get_allExamList($input);
        $this->msg->select($this->obj,'turn');
    }
    
    function get_allExamListSearch($word){
        $this->obj = $this->obj->get_allExamListSearch($word);
        $this->msg->select($this->obj,'turn');
    }
    
    
    function post_exam($dateStart,$dateFinal){
        $bool = $this->obj->post_exam($input);
        if($bool){
            $this->msg->exitoso('comment about the food');
        }else{
            $this->msg->noExitosoInsert();
        }
    
    }
    
    
    function patch_exam($dateStart,$dateFinal){
        $bool = $this->obj->patch_exam($input);
        if($bool){
            $this->msg->exitoso('comment about the food');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    
    //POST EXAM
    function post_examMain($input) {
        $bool = $this->obj->post_examMain($input);
        if($bool){
            $this->msg->exitoso('exam about pre-admission and income');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    function post_examDetail($input) {
        echo  $this->obj->post_examDetail($input);
    }
    
    function post_examAccident($input) {
        $bool = $this->obj->post_examAccident($input);
        if($bool){
            $this->msg->exitoso('exam about pre-admission and income');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    function post_examApparatusSys($input) {
        echo $this->obj->post_examApparatusSys($input);
    }
    
    function post_examGynecologistBack($input) {
        $bool = $this->obj->post_examGynecologistBack($input);
        if($bool){
            $this->msg->exitoso('exam about pre-admission and income');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    function post_examHeredityFam($input) {
        echo  $this->obj->post_examHeredityFam($input);
    }
    
    function post_examHeredityPers($input) {
        echo $this->obj->post_examHeredityPers($input);
    }
    
    function post_examHistory($input) {
        $bool = $this->obj->post_examHistory($input);
        if($bool){
            $this->msg->exitoso('exam about pre-admission and income');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    function post_examImagingStudy($input) {
        echo $this->obj->post_examImagingStudy($input);
    }
    
    function post_examLaboratoryTest($input) {
       echo $this->obj->post_examLaboratoryTest($input);
    }
    
    function post_examInitPre($input) {
        echo $this->obj->post_examInitPre($input);
    }
    
    function post_examPataPersBack($input) {
        echo $this->obj->post_examPataPersBack($input);
    }
    
    function post_examPersonalLife($input) {
        echo $this->obj->post_examPersonalLife($input);
    }
    
    function post_examPhyExploration($input) {
        echo $this->obj->post_examPhyExploration($input);
    }
    

    function get_paginator($input, $search) {
        $this->obj = $this->obj->get_paginator($input, $search);
        $this->msg->select($this->obj,'paginator');
    }
    
    function get_allPagesPaginator($input, $search) {
        $this->obj = $this->obj->get_allPagesPaginator($input, $search);
        $this->msg->select($this->obj,'paginator');
    }
    

    //este no
    function post_examPhyEyes($input) {
        $bool = $this->obj->post_examPhyEyes($input);
        if($bool){
            $this->msg->exitoso('exam about pre-admission and income');
        }else{
            $this->msg->noExitosoInsert();
        }
    }
    
    
    //PATCH
    
    
    function patch_examMain($input){
        $bool = $this->obj->patch_examMain($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
 
    }
    
    function patch_examDetail($input){
        $bool = $this->obj->patch_examDetail($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examAccident($input){
        $bool = $this->obj->patch_examAccident($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examApparatusSys($input){
        $bool = $this->obj->patch_examApparatusSys($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examGynecologistBack($input){
        $bool = $this->obj->patch_examGynecologistBack($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examHeredityFam($input){
        $bool = $this->obj->patch_examHeredityFam($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examHeredityPers($input){
        $bool = $this->obj->patch_examHeredityPers($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examHistory($input){
        $bool = $this->obj->patch_examHistory($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examImagingStudy($input){
        $bool = $this->obj->patch_examImagingStudy($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examLaboratoryTest($input){
        $bool = $this->obj->patch_examLaboratoryTest($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examInitPre($input){
        $bool = $this->obj->patch_examInitPre($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examPersonalLife($input){
        $bool = $this->obj->patch_examPersonalLife($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examPhyExploration($input){
        $bool = $this->obj->patch_examPhyExploration($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examPhyEyes($input){
        $bool = $this->obj->patch_examPhyEyes($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function patch_examPataPersBack($input){
        $bool = $this->obj->patch_examPataPersBack($input);
        if($bool){
            $this->msg->exitoso('patch exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    function delete_exam($id){
        $bool = $this->obj->delete_exam($id);
        if($bool){
            $this->msg->exitoso('delete exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    
    
    function update_dateTimeExam($id){
        $bool = $this->obj->update_dateTimeExam($id);
        if($bool){
            $this->msg->exitoso('delete exam');
        }else{
            $this->msg->noExistosoInser();
        }
    }
    


}
