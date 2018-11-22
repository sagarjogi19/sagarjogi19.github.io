<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public $accessMessage = array("error" => "Access Denied");

    public function login() {
        if (isUserLoggedIn() == true) {
            redirect('user/dashboard');
        }
        //Load files
        $this->load->model('user_model');

        //Check posted data
        $result = $this->user_model->doLogin();

        //Setting post value to the template
        $setPostData = array();
        //Get Remember cookie data
        $getCookie = get_cookie($this->user_model->remeberMeCookieName);
        //Check post is set or not
        if ($getCookie != "") {
            $setPostData = Utility::decryptCookie($getCookie);
        }
        $data = setTemplateData("user/login", "Login", array_merge($result, $setPostData));

        //Set Page Meta
        setMeta($data, "Customer Login");
        //Show Error Message.
        setMessage($result, $data);

        //Load Template
        loadTemplate($data);
    }

    public function dashboard() {
        if (isUserLoggedIn() == false) {
            saveMessage($this->accessMessage);
            redirect('user/login');
        }
       
          $data = setTemplateData("user/dashboard");  
        $data['current_url'] = setLink($this->uri->uri_string());
        if(isAdmin()){
          $this->load->model('dashboard_model'); 
          if( trim($this->input->get('user_name')) != '' && trim($this->input->get('action')) == 'searchUserForDashboard')
         {  
             echo $this->dashboard_model->searchUser($this->input->get('user_name'));
             exit;
        }
          if($this->input->post('save_graph_image')!="" && $this->input->post('myChart1') != '')
            {
                echo $this->dashboard_model->saveGraphImages();
                exit;
           }
       
          if($this->input->get('isAjax')!=""){ 
            $graphData = new stdClass();
             $graphData->PartsView =$this->dashboard_model->getPartsViewCounts();
             $graphData->partsClickAndView = $this->dashboard_model->getClickAndViewCounts();
             $graphData->enquiryGraph = $this->dashboard_model->getEnquiryCounts();
               $this->session->set_userdata('date_range',$this->input->get('date_range'));
             echo json_encode($graphData); 
            exit;
          }
            $data['summary']=$this->dashboard_model->getSummaryData();
            $data['addJS'] = array("jquery.lazy.min", "chartjs/Chart.bundle.min", "datepicker-master/moment", "datepicker-master/daterangepicker","select2","formJs", "laodeditor", "dashboard", "jquery-ui", "jquery.ui.touch-punch.min");
            $data['addCSS'] = array("datepicker-master/daterangepicker", "select2", "jquery-ui");
        } 
        $this->load->view('index', $data);
    }

    public function export_pdf()
	{   
         $this->load->model('dashboard_model');    
         $this->dashboard_model->exportPDF();
       }
       
    public function forgotpwd() {
        if (isUserLoggedIn() == true) {
            redirect('user/dashboard');
        }
        //Load files
        $this->load->model('user_model');
        //Check email and then send reset link to user
        $result = $this->user_model->sendForgotPwdLink();
        $data = setTemplateData("user/forgotpwd", "Forgot Password");
        //Set Page Meta
        setMeta($data, "Forgot Password");
        //Show Error Message.
        setMessage($result, $data);
        //Load Template
        loadTemplate($data);
    }

    public function reset_password() {
        if (isUserLoggedIn() == true) {
            redirect('user/dashboard');
        }
        //Load files
        $result = array();
        $this->load->model('user_model');
        //Check Request is it post then do update operation
        if ($this->input->method() === 'post' && $this->input->post('action') != "") {
            $this->user_model->updatePassword();
        }
        //Checkes link is validate or not if not then throw error 
        $uid = $this->user_model->isValidLink();
        if ($uid == 0) {
            $result['message']['error'] = "Link is expired. Please Try Again. Back to <a href='" . setLink('user/forgotpwd') . "' class='reg_a trans'>Forgot Password Page</a>";
        }
        $data = setTemplateData("user/reset_password", "Password Reset");

        $data['formData'] = array("uid" => $uid);

        //Set Page Meta
        setMeta($data, "Password Reset");
        //Show Error Message.
        setMessage($result, $data);
        //Load Template
        loadTemplate($data);
    }

    public function logout() {
        if (isUserLoggedIn() == false) {
            saveMessage($this->accessMessage);
            redirect('user/login');
        }
        logout();
        redirect('user/login');
        exit;
    }

    public function uploadFile($folder, $user, $record_id) {
        $this->load->library('fileuploader');
        $this->fileuploader->uploadFile($folder, $user, $record_id);
        exit;
    }

    public function register() {
        if (isUserLoggedIn() == true) {
            saveMessage($this->accessMessage);
            redirect('user/dashboard');
        }
        //Load files
        $this->load->model('user_model');
        //Check email and then send reset link to user 
        if ($this->input->post("name") != "" && Utility::checkCaptcha('uniqueNumReg', $this->input->post('secureImg')) == true) {
            $this->user_model->saveUser();
            redirect("user/register-thankyou");
        }

        $data = setTemplateData("user/register", "Register");
        //Set Page Meta
        setMeta($data, "Register");
        //Load Template
        loadTemplate($data);
    }

    /**
     * Checks duplicate user email or username
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function checkusername() {
        //Load files
        $this->load->model('user_model');
        if ($this->input->post('checkUsername') && $this->input->post('username') != "") {
            $this->user_model->checkUniqueUsername($this->input->post('username'), $this->input->post('uid'));
        }
        if ($this->input->post('checkEmail') && $this->input->post('email') != "") {
            $this->user_model->checkUniqueEmail($this->input->post('email'), $this->input->post('userid'));
        }
        exit;
    }

    /**
     * Register Thank You Page
     * @auhtor Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function register_thankyou() {
        $pageHeading = "Thank You";
        $list['backURL'] = setLink('user/login');
        $data = setTemplateData("user/register_thankyou", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        loadTemplate($data);
    }

    /**
     * Edit Personal Details Page
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function edit_profile($uid = "") {
        if (isUserLoggedIn() == false) {
            saveMessage($this->accessMessage);
            redirect('user/login');
        } else if ($uid != "" && getUserInfo("role_id") != 1) {
            saveMessage(array("error" => "Access Denied"));
            redirect("user/edit_profile");
        }

        $this->load->model('user_model');
        if ($this->input->post("name") != "") {
            if ($_REQUEST['uid'] == "") {
                $_REQUEST['uid'] = getUserInfo("id");
            }
            $this->user_model->saveUser();
            saveMessage(array("success"=>"Profile is update successfully"));
            redirect("user/".__FUNCTION__);
        }
        $userData = $this->user_model->getSingleData($uid);
        $data = setTemplateData("user/edit_profile", "Edit Profile", $userData);
        $data['meta_title'] = "Edit Profile";
        $data['addJS'] = array("jquery.ui.widget", "cropper", "canvas-toBlob", "admin", "jquery-ui", "jquery.ui.touch-punch.min");
        $data['addCSS'] = array("cropper", "wh-form", "jquery-ui");
        loadTemplate($data);
    }

    /**
     * User List Page
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function user_list() {
  
         if (Utility::hasAccess( __FUNCTION__ ,1 ) == false) {
            saveMessage(array("error" => "Access Denied"));
            redirect("user/dashboard");
        }
        //Load files
        $this->load->model('user_model');
        $list = $this->user_model->get_list();
        $pageHeading = "User List";
        $data = setTemplateData("user/user_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("admin");
        loadTemplate($data);
    }
    /**
     * User Delete
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function user_delete() {
        //Load files
        $this->load->model('user_model');
        Query::deleteRecordFromList($this->user_model->userTable);
        exit;
    }
    /**
     * User Change Status
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function user_change_status() {
        //Load files
        $this->load->model('user_model');
        Query::updateStatusFromList($this->user_model->userTable);
        exit;
    }
    /**
     * User Add / Edit
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function user_add() {
          if (Utility::hasAccess( __FUNCTION__ ,1 ) == false) {
            saveMessage(array("error" => "Access Denied"));
            redirect("user/dashboard");
        }
        //Load files
        $dataArray = array();

        $this->load->model('user_model');
        if ($this->input->post("name") != "") {
            $id = $this->user_model->saveUser();

            saveMessage(array('success' => 'User is saved successfully'));
            $page = "";
            if ($this->input->post('page') != "")
                $page = "?page=" . $this->input->post('page');

            if ((int) $this->input->post('saveBtn') == 1) {
                redirect(setLink('user/user_list') . $page);
            } else {
                redirect(setLink('user/user_add') . "?id=" . $id);
            }
            exit;
        }
        if ($this->input->get("id") != "") {
            $dataArray = $this->user_model->getSingleData($this->input->get("id"));
        }
        
        $dataArray = unsetMessage($dataArray);


        $pageHeading = "User Add";
        $data = setTemplateData("user/user_add", $pageHeading, $dataArray);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("jquery.ui.widget", "cropper", "canvas-toBlob", "admin", "jquery-ui", "jquery.ui.touch-punch.min");
        $data['addCSS'] = array("cropper", "wh-form", "jquery-ui");
        loadTemplate($data);
    }
    /**
     * Testimonal Manager Section
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
        public function testimonial_list() {
        
        //Load files
        $this->load->model('testimonial_model');
        $list = $this->testimonial_model->get_list();
        $pageHeading = "Testimonals List";
        $data = setTemplateData("user/testimonial_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("admin");
        loadTemplate($data);
    }

    public function testimonial_add() {
        //Load files
        $dataArray = array();

        $this->load->model('testimonial_model');
        if ($this->input->post("customer_name") != "") {
            $id = $this->testimonial_model->saveData();

            saveMessage(array('success' => 'Testimoninal is saved successfully'));
            $page = "";
            if ($this->input->post('page') != "")
                $page = "?page=" . $this->input->post('page');

            if ((int) $this->input->post('saveBtn') == 1) {
                redirect(setLink('user/testimonial_list') . $page);
            } else {
                redirect(setLink('user/testimonial_add') . "?id=" . $id);
            }
            exit;
        }
        if ($this->input->get("id") != "") {
            $dataArray = $this->testimonial_model->getSingleData($this->input->get("id"));
        }
       
        $dataArray = unsetMessage($dataArray);


        $pageHeading = "Testimonial Add";
        $data = setTemplateData("user/testimonial_add", $pageHeading, $dataArray);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("jquery.ui.widget", "jquery.fileupload", "jquery.fileupload-process", "jquery.fileupload-validate", "admin");
        $data['addCSS'] = array("wh-form", "style");
        loadTemplate($data);
    }

    public function testimonial_delete() {
        //Load files
        $this->load->model('testimonial_model');
        Query::deleteRecordFromList($this->testimonial_model->tblName);
        exit;
    }

    public function testimonial_change_status() {
        //Load files
        $this->load->model('testimonial_model');
        Query::updateStatusFromList($this->testimonial_model->tblName);
        exit;
    }
    
    public function send_dashboad_email(){
         $this->load->model('dashboard_model');
         $this->dashboard_model->sendDashboardEmail();
    }
    
    public function export_enquiries(){
        $this->load->model('dashboard_model');
        $this->dashboard_model->export_enquiries_xls();
    }
    
     /**
     * Notification List Page
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function notification_list() { 
        //Load files
        $this->load->model('notification_model');
        if($this->input->get("isAjaxIcon")!=""){
            $notification['notifications']=$this->notification_model->menu_list();
            $notification['messageData']=$this->notification_model->messageInfo();
            echo $this->load->view("user/ajaxListHTML",$notification,TRUE);
            exit;
        }
         if($this->input->post("clearAll")!=""){
           $this->notification_model->clearAll();
           exit;
         }
        $list = $this->notification_model->get_admin_list(); 
        $pageHeading = "Notification List";
        $data = setTemplateData("user/notification_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("admin");
        loadTemplate($data);
    }
      /**
     * Notification Delete
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
        public function notification_delete() {
        //Load files
        $this->load->model('notification_model');
        Query::deleteRecordFromList($this->notification_model->tblName);
        exit;
    }
   /**
     * Notification Status Change
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function notification_change_status() {
        //Load files
        $this->load->model('notification_model');
        Query::updateStatusFromList($this->notification_model->tblName);
        exit;
    }
       /**
     * Trasaction Page
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
     public function transaction_list() { 
        //Load files
        $this->load->model('user_model');
        $list = $this->user_model->get_transaction_list();
        $pageHeading = "Transactions";
        $data = setTemplateData("user/transaction_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("datepicker","admin"); 
        $data['addCSS'] = array("jquery-ui", "mstyle01");
        loadTemplate($data);
    }
    
  
}
