<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Make extends CI_Controller { 
    
    public function make_list(){
         Utility::checkLogin();
            //Load files
            $this->load->model('make_model');
            $list=$this->make_model->get_list(); 
            $pageHeading="Make List";
            $data = setTemplateData("make_list",$pageHeading,$list);
            $data['meta_title']=$pageHeading;
            $data['addJS']=array("admin");
            loadTemplate($data);
    }
    
    public function make_add(){
        $this->load->model('make_model');
        $this->make_model->handleRequest();
          if ($this->input->post('make') != "") {
            $page = "";
            if ($this->input->post('page') != "")
                $page = "?page=" . $this->input->post('page');
            $id = $this->make_model->saveData();
                 if ((int) $this->input->post('saveBtn') == 1) {
                        redirect(setLink('user/make_list').$page);                       
                } else {
                        redirect(setLink('user/make_add')."?id=".$id);
                }
        }
        //Get Id
           $make = array(); 
           $pageCount=$this->make_model->pageCount;
        $id = $this->input->get('id');
        if($id!=0 || ($this->input->get('isAjax')==true)){
           
            $make['gridData']=$this->make_model->getModelList(); 
            $pageCount=$make['gridData']['totalCount'];
           
        }
       
        $make = $this->make_model->getSingleData($id);  
        $make['isFree']=1;
        $make['totalCount']=$pageCount;
      
        $pageHeading="Make Add";
            $data = setTemplateData("make_add",$pageHeading,$make);
            $data['meta_title']=$pageHeading;
            $data['addJS']=array("admin");
            $data['addCSS']=array("wh-form");
            loadTemplate($data);
    }
   
    public function make_delete(){
             //Load files
                $this->load->model('make_model');
                Query::deleteRecordFromList($this->make_model->tblName);
                exit;
    }
   public function make_change_status(){
                //Load files
                $this->load->model('make_model');
                Query::updateStatusFromList($this->make_model->tblName);
                exit;
   }

}
