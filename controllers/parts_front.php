<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Parts_Front extends CI_Controller {

    public $partsView = "parts";
    public static $record = 2;
    public static $totalRecord = 0;
    public static $currentPage = 0;
     function __construct()
    {
     parent::__construct();
     $this->load->helper('cookie');
    }
    public function parts_list() {
//              Utility::checkLogin();
        //Load files
        $this->load->model('parts_front_model');
         Query::$app_type='front';
       
        $pageHeading = "Parts List";
        $list = array();
        if (isset($_GET['get_ajax']) && $_GET['get_ajax'] == 'yes' && isset($_GET['limitStart'])) {
            $this->parts_front_model->getSearchMachineListingAjax();
        } else {
            $list = $this->parts_front_model->getSearchMachineListing();
        }
         $list['displayFilter'] = true;
        /* $list=$this->parts_front_model->get_list();
          $this->load->model('make_model');
          $this->load->model('mcategory_model');
          $list['makeData']=$this->make_model->getAllMake();
          $list['categoryData']=$this->mcategory_model->getCategory(); */

        $data = setTemplateData($this->partsView . "_front/parts_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addCSS'] = array("jquery-ui","front-style","font-awesome.min","bootstrap.min","lightgallery");
        $data['addJS'] = array("jquery.placeholder","jquery-ui","jquery.lazy.min");
        loadTemplate($data);
    }
     public function parts_detail() {
//              Utility::checkLogin();
        //Load files
        $this->load->model('parts_front_model');
        Query::$app_type='front';
        $CI  = &get_instance();
        $pageHeading = "Parts Detail";
        $list = array();
      
       
        

      
      if (isset($_POST['constomerFName1']) && !empty($_POST['constomerFName1'])) {
         $emsg = $this->parts_front_model->sendEnquiryMail();
      }
      if (isset($_POST['constomerFName']) && !empty($_POST['constomerFName'])) {
         $esmsg = $this->parts_front_model->sendMainEnquiryMail();
      }
      
      if ($CI->uri->segment(3) &&  $this->parts_front_model->checkMachine($CI->uri->segment(3))) {         
         $list =  $this->parts_front_model->getMachineData($CI->uri->segment(3));
      } else {
         redirect(base_url());
      }
      /* Save As recent start*/
      /*$count=$this->parts_front_model->getRecentCount();
      if($count<8){
          if(!$machineObj->getRecent($data['id']))
                Machine::$machineDB->insert(CFG::$tblDPrefix . 'recent_machine', array('machine_id'=>$data['id']));
      } else {
          if(!$machineObj->getRecent($data['id'])) {
            Machine::$machineDB->query("DELETE FROM ".CFG::$tblDPrefix."recent_machine ORDER BY id LIMIT 1");
            Machine::$machineDB->insert(CFG::$tblDPrefix . 'recent_machine', array('machine_id'=>$data['id']));
          }
      }*/
      /* Save As recent end*/
      /* Save click count start*/
     $this->parts_front_model->saveClickCount($list['id']);
      /* Save click count end*/
      $list['error_enquiry_msg'] = $emsg;
      $list['error_msg'] = $esmsg;
       $list['displayFilter'] = true;
        $data = setTemplateData($this->partsView . "_front/parts_detail", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addCSS'] = array("jquery-ui","front-style","font-awesome.min","bootstrap.min","lightgallery");
        $data['addJS'] = array("jquery.placeholder","jquery-ui","jquery.lazy.min","jquery.mCustomScrollbar","lg-thumbnail","lg-video");
        loadTemplate($data);
    }
     public function header() {
         $this->load->view('includes/front-header-main');
        $this->load->view('includes/blog-header');
    } 
    public function footer() {
         $this->load->view('includes/front-footer');
    }
     public function parts_thank_you() {
           Query::$app_type='front';
           $list = array();
           $list['displayFilter'] = true;
           $data['meta_title'] = $pageHeading;
           $data = setTemplateData($this->partsView . "_front/parts_thank_you", $pageHeading, $list);
           loadTemplate($data);
    }
    

}
