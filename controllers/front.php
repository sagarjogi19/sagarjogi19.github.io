<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Front extends CI_Controller {

    public function home() {
           
        //Load files
        $this->load->model('front_model');
        Query::$app_type='front';
        $list['displayFilter'] = true;
        $list['blogData'] = $this->front_model->getBlogData();
        $list['testimonial'] = $this->front_model->getTestimonialData();
        $list['featured'] = $this->front_model->getFeaturedData();
       
        $data = setTemplateData("front/home", "Home", $list);
        
        //Set Page Meta
        setMeta($data, "Home - Worthy Parts");
        //Show Error Message.
//        setMessage($result, $data);
        
        //Load Template
        loadTemplate($data);
    }

  
}
