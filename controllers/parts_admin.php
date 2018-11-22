<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parts_Admin extends CI_Controller {

    public $partsView = "parts";
    
    function __construct() {
        parent::__construct();
       Utility::hasAccess();
    }
    public function category_list() {
        
        //Load files
        $this->load->model('mcategory_model');
        $list = $this->mcategory_model->get_list();
        $pageHeading = "Category List";
        $data = setTemplateData($this->partsView . "_admin/category_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("admin");
        loadTemplate($data);
    }

    public function category_add() {
        //Load files
        $dataArray = array();

        $this->load->model('mcategory_model');
        if ($this->input->post("category_name") != "") {
            $id = $this->mcategory_model->saveData();

            saveMessage(array('success' => 'Category is saved successfully'));
            $page = "";
            if ($this->input->post('page') != "")
                $page = "?page=" . $this->input->post('page');

            if ((int) $this->input->post('saveBtn') == 1) {
                redirect(setLink('user/' . $this->partsView . '/category_list') . $page);
            } else {
                redirect(setLink('user/' . $this->partsView . '/category_add') . "?id=" . $id);
            }
            exit;
        }
        if ($this->input->get("id") != "") {
            $dataArray = $this->mcategory_model->getSingleData($this->input->get("id"));
        }
        $dataArray['categorytree'] = $this->mcategory_model->fetchCategoryTree($this->mcategory_model->tblName, '', '', '', '', 'active');
        $dataArray = unsetMessage($dataArray);


        $pageHeading = "Category Add";
        $data = setTemplateData($this->partsView . "_admin/category_add", $pageHeading, $dataArray);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("jquery.ui.widget", "jquery.fileupload", "jquery.fileupload-process", "jquery.fileupload-validate", "admin");
        $data['addCSS'] = array("wh-form", "style");
        loadTemplate($data);
    }

    public function category_delete() {
        //Load files
        $this->load->model('mcategory_model');
        Query::deleteRecordFromList($this->mcategory_model->tblName);
        exit;
    }

    public function category_change_status() {
        //Load files
        $this->load->model('mcategory_model');
        Query::updateStatusFromList($this->mcategory_model->tblName);
        exit;
    }

    public function enquiry_list() {
        //Load files
        $this->load->model('menquiry_model');
        $list = $this->menquiry_model->get_list();
        $pageHeading = "Enquiry List";
        $data = setTemplateData($this->partsView . "_admin/enquiry_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("datepicker", "admin");
        $data['addCSS'] = array("jquery-ui", "mstyle01");
        loadTemplate($data);
    }

    public function enquiry_change_status() {
        //Load files
        $this->load->model('menquiry_model');
        Query::updateStatusFromList($this->menquiry_model->tblName);
        exit;
    }

    public function enquiry_view() {
        if ($this->input->get("id") == "")
            redirect(setLink('user/' . $this->partsView . '/enquiry_list'));
        //Load files
        $this->load->model('menquiry_model');
        $dataArray = $this->menquiry_model->getEnquiryData($this->input->get("id"));
        $pageHeading = "Enquiry View";
        $data = setTemplateData($this->partsView . "_admin/enquiry_view", $pageHeading, $dataArray);
        $data['meta_title'] = $pageHeading;
        loadTemplate($data);
    }

    public function parts_list() {
        Utility::checkLogin();
        //Load files
        $this->load->model('parts_model');
        $pageHeading = "Parts List";
        $list = array();
        $list = $this->parts_model->get_list();
        $this->load->model('make_model');
        $this->load->model('mcategory_model');
        $list['makeData'] = $this->make_model->getAllMake();
        $list['categoryData'] = $this->mcategory_model->getCategory();

        $data = setTemplateData($this->partsView . "_admin/parts_list", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("admin");
        loadTemplate($data);
    }

    public function parts_add() {
        //Load files
        $this->load->model('parts_model');
        //Handle Request
        $this->parts_model->handleAjaxRequest();
        if ($this->input->post('part_name') != "") {
            $id = $this->parts_model->saveData();
            saveMessage(array('success' => 'Parts is saved successfully'));
            $page = "";
            if ($this->input->post('page') != "")
                $page = "?page=" . $this->input->post('page');

            if ((int) $this->input->post('saveBtn') == 1) {
                redirect(setLink('user/' . $this->partsView . '/parts_list') . $page);
            } else {
                redirect(setLink('user/' . $this->partsView . '/parts_add') . "?id=" . $id);
            }
        }


        $this->load->model('make_model');
        $this->load->model('mcategory_model');

        $pageHeading = "Parts Add";
        $dataArray = array();

        $dataArray['makeData'] = $this->make_model->getAllMake();
        $dataArray['categoryData'] = $this->mcategory_model->getCategory();
        $dataArray['suburbData'] = $this->parts_model->getSuburb();

        if ($this->input->get('id') != "") {
            $dataArray['allowPay'] = false;
            $dataArray['partsdata'] = $this->parts_model->getSingleData($this->input->get('id'));
        }
        if ($this->input->get('id') == "") {
            $dataArray['use_folder'] = $this->parts_model->generateRandomFolderName();
        }
        if ($this->input->get('confirmation') != "") {
            $postedData = $this->session->userdata($this->parts_model->partsSession);

            $dataArray['use_folder'] = $postedData['random_code'];
         
            $postedData['additional_image'] = json_encode($postedData['additional_image']);
            $postedData['conditions'] = $postedData['condition'];
            $postedData['category_id'] = $postedData['category'];
            $postedData['total_weight'] = $postedData['weight'];
            $postedData['quantity'] = $postedData['qty'];
            $dataArray['partsdata'] = $postedData;
            if (isset($postedData['is_gst'])) {
                $dataArray['partsdata']['is_gst'] = $postedData['is_gst'];
            }
            $dataArray['partsdata']['price_from'] = $postedData['price_from'];
            unset($dataArray['partsdata']['id']);
        }
        //Set Express Checkout Payment Variables
        if ($this->input->get('token') != "") {
            $dataArray['payment_token'] = $this->input->get('token');
        }
        if ($this->input->get('PayerID') != "") {
            $dataArray['payment_PayerID'] = $this->input->get('PayerID');
        }

        if (isAdmin()) {

            $this->load->model('user_model');
            $dataArray['userData'] = $this->user_model->getUsers();
        }
        $data = setTemplateData($this->partsView . "_admin/parts_add", $pageHeading, $dataArray);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("select2", "jquery.ui.widget", "cropper", "canvas-toBlob", "admin", "formJs", "laodeditor", "jquery-ui", "jquery.ui.touch-punch.min");
        $data['addCSS'] = array("cropper", "wh-form", "jquery-ui", "select2");
        loadTemplate($data);
    }

    public function parts_change_status() {
        //Load files
        $this->load->model('parts_model');
        Query::updateStatusFromList($this->parts_model->tblName); 
        Query::updateStatusFromList($this->parts_model->tmpTblName);
        exit;
    }

    public function parts_delete() {
        $this->load->model('parts_model');
        $this->parts_model->deleteRecord();
        exit;
    }

    public function payment_thank_you() {
        $this->load->model('parts_model');
        $postedData = $this->session->userdata($this->parts_model->partsSession);
        $_POST = $postedData;
        $id = $this->parts_model->saveData();
        //$this->parts_model->createInvoice($postedData, $id);

        $this->session->unset_userdata($this->parts_model->partsSession);
        $pageHeading = "Thank You";
        $list['backURL'] = setLink('user/parts/parts_list');
        $data = setTemplateData("parts_admin/payment_thank_you", $pageHeading, $list);
        $data['meta_title'] = $pageHeading;
        $data['addJS'] = array("admin");
        loadTemplate($data);
    }

    public function payment_conformation() {

        $this->load->model('parts_model');
        if ($this->input->post('token') != "" && $this->input->post('PayerID') != "") {

            $_POST['payment_type'] = 'PAYPAL_EXPRESS';
            if (!isset($_POST['totalPayment'])) {
                $partsPrice = $this->config->item('parts_price');
                $_POST['totalPayment'] = $partsPrice['total'];
            }
            $this->session->set_userdata($this->parts_model->partsSession, $_POST);
            return $this->parts_model->doExpressCheckout();
        }
    }
    
    public function parts_invoice_pdf($trID,$userID) {
         $this->load->model('parts_model');
         $this->parts_model->generatePDF($trID,$userID);
    }

}
