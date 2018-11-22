<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(Query::$app_type == 'front'){
    $this->load->view('includes/front-header-main');
    $this->load->view('includes/front-header');
} else {
$this->load->view('includes/header-main');
$this->load->view('includes/header');
}
if(isset($template)){  
         if(isset($formData['message'])){
               showMessage($formData['message']); 
         } else {
               
               showMessage();
         }
         if(isset($formData)){ 
            $this->load->view($template,$formData);
         } else {
             $this->load->view($template);
         }
} else {
	$this->load->view("404");
}
if(Query::$app_type == 'front'){
    $this->load->view('includes/front-footer');
} else {
    $this->load->view('includes/front-footer');
}
?> 