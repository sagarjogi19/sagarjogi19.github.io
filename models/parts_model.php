<?php

/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Parts_model extends CI_Model {

    public $tblName;
    public $tmpTblName;
    public $paymentTbl;
    public $pageCount = 10;
    public $module="parts";
    public $path;
    public $editorPath;
    public $isAdmin;
    public $userID;
    public $partsSession="parts_post";
    public $invoiceAbsPath;
    public function __construct() {
        $this->path = FCPATH . '/media/worthyparts/parts/';
        $this->editorPath = FCPATH ."/moxiemanager-php-pro/data/files/parts/";
        $this->tblName = Query::$parts;
        $this->paymentTbl = Query::$parts_payment;
        $this->tmpTblName=$this->tblName."_tmp";
        $this->isAdmin = isAdmin();
        $this->userID = getUserInfo("id");
        $this->invoiceAbsPath = FCPATH."/media/invoice/"; 
    }

    /**
     * Get Parts List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_list() {
        $data = array();
        $queryStr="";
        if($this->isAdmin == true){
            $queryStr=",approved,user_moderation";
        }
        //Model Sub Query
        $this->db->select('model'); 
        $this->db->where("id=m.model",'',false);
        $this->db->where("make_id=m.make",'',false);
         $modelQuery='('.$this->db->get_compiled_select(Query::$model ).') as model,';  
        $userQuery="";
        //User Sub Query
         $this->db->select('name'); 
         $this->db->where("id=m.created_by",'',false);
         $userQuery='('.$this->db->get_compiled_select(Query::$user_profile).')  as created_by,';
          if($this->isAdmin == false) {
            $this->db->where("user",$this->userID,false);
            $this->db->or_where("created_by",$this->userID,false);
            $this->db->or_where("updated_by",$this->userID,false);
          }
        $this->db->select('m.id,m.part_name,part_code,make,'.$modelQuery.'category,total_weight,quantity,suburb,status,ad_type,'.$userQuery.'p.payment_mode,p.id as payment_id,p.uid,user_moderation,p.payment_status,'.$queryStr); 
        $this->db->from($this->tblName . " as m ");
        $this->db->join($this->paymentTbl.' as p','m.id=p.parts_id','left' );
         $setTrash =  setTrash();
       
        if ($setTrash == "trash") {
             $this->db->where('m.is_trash','1'); 
        } else {
             $this->db->where('m.is_trash','0'); 
        }
         
        if($this->isAdmin == false) {
        $this->db->group_start();
        $this->db->where('m.created_by='.$this->userID);
        $this->db->or_where('m.updated_by='.$this->userID);
        $this->db->group_end();
        }
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        $make = ($this->input->post('make') != "") ? $this->input->post('make') : "";
        $model = ($this->input->post('model') != "") ? $this->input->post('model') : "";
        $category = ($this->input->post('category') != "") ? $this->input->post('category') : "";
        if ($make != "") {
          $this->db->where('make',$make);
        }
        if ($model != "") {
           $this->db->where('model',$model);
        }
        if ($category != "") {
           $this->db->where('category',$category); 
        }
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('part_name', $search);
            $this->db->or_like('part_code', $search); 
            $this->db->group_end();
        }
         $tempdb = clone $this->db; 
          $totalCount=$tempdb->count_all_results();
        //Set Sort order
        if ($this->input->get('sort') != "") {
            $sort = Query::setSortOrder($this->input->get('sort'));
            $this->db->order_by($sort['col'], $sort['value']);
        } else {
            $this->db->order_by("id","desc");
        }
        //Set Table Limit
        $limit = 0;
        $this->pageCount = Query::setPageCount($this->input->get('limit'), $this->pageCount);


        $currentPage = (int) $this->input->get('page');
        if ($currentPage != 0)
            $limit = Query::setLimit($currentPage, $this->pageCount);


        $this->db->limit($this->pageCount, $limit);

         $query = $this->db->get();  
      
         $data['showData'] = $setTrash;
        $data['show_page'] = $currentPage;
        $data['totalCount'] = Utility::getPageCount($totalCount,$this->pageCount);
        
         /**
         * Prepare row for search session data if exists in session
         * @author Kushan Antani <kushan.datatechmedia@gmail.com>
         */
        $searchDataSession = Utility::setSearchSession($this->module);
        if ($searchDataSession != "")
            $data['searchSession'] = $searchDataSession;
        
        if ($this->input->get('isAjax') != "") {
            // $query['totalCount'] = $this->db->count_all_results($this->tblName);
            echo json_encode(array("data" => $query->result(), "totalCount" => $data['totalCount']));
            exit;
        }
        return $data;
    }
    
    public function saveData(){
        $part_name=$this->input->post('part_name');
        $userID = getUserInfo("id");
        $randomCode = $this->input->post('random_code');
        $description = $this->input->post('description');
         $isEdit = $this->input->post('is_edit');
         $price_type=$this->input->post('price_type');
         $price =$this->input->post('price');
         if ($price == "") {
                $price = ($this->input->post('price_from') != "") ? $this->input->post('price_from') : $price;
            }
         $price_to = $this->input->post('price_to');
          if ($price_type == 'n' || $price_type == 'c') {
                $price = 0;
                $price_to = 0;
            } else if ($price_type == 'f') {
                $price_to = 0;
            }
         
          
         $cntImg = count($this->input->post('additional_image'));
          $additional_image = ""; 
            if ($cntImg != 0) {
                $aCnt = 0;
                $aImg = array();
                foreach ($this->input->post('additional_image') as $additionImg) {
                    if ($additionImg != "") {
                        $aImg[$aCnt] = $additionImg;
                        $aCnt++;
                    }
                }
                $additional_image = json_encode($aImg);
            }
            
         $arrFieled = array(
                'part_code' => ($this->input->post('part_code')!= "") ?$this->input->post('part_code') : 0,
                'part_name' => $part_name,
                'price_type' => $price_type,
                'price' => $price,
                'price_to' => $price_to,
                'is_gst' => (int)$this->input->post('is_gst'),
                'year' => $this->input->post('year'),
                'make' => $this->input->post('make'),
                'model' => $this->input->post('model'),
                'category' => $this->input->post('category'),
                'address' => $this->input->post('address'),
                'suburb' => $this->input->post('suburb'),
                'state' => $this->input->post('state'),
                'postcode' => $this->input->post('postcode'),
                'user' => $this->input->post('user_id'),
                'main_image' => $this->input->post('main_image'),
                'additional_image' => $additional_image,
                'description' => $description,
                'quantity' => $this->input->post('quantity'), 
                'width' => $this->input->post('width'),
                'length' => $this->input->post('length'),
                'total_weight' => $this->input->post('weight'),
                'height' => $this->input->post('height'),
                'ad_type' => $this->input->post('ad_type'),
                'conditions' => $this->input->post('condition'),
                'quantity' => $this->input->post('qty'),
                'user' => ($this->input->post('user_id')!=""?$this->input->post('user_id'):$userID),
                'status' => $this->input->post('status')
            );
     
        $id = "";
                //Approve / Disapprove
            if ($this->isAdmin == true) {
                $arrFieled['is_featured'] = ($this->input->post('is_featured')!=""?$this->input->post('is_featured'):"0");
                $arrFieled['approved'] = '1';
                $arrFieled['user_moderation'] = '0';
            }
     
            if ((int)$isEdit!=0) {
                //Update
                $slug = Utility::getSlug($part_name, (int) $isEdit, $this->tblName);
                $arrFieled['alias'] = $slug;
                $arrFieled['updated_date'] = date("Y-m-d H:i:s");
                $arrFieled['updated_by'] = $userID;
                if ($this->isAdmin==true) {
                    Query::updateData($this->tblName,$arrFieled,array('id' => (int) $isEdit));
                    unset($arrFieled['approved']);
                    unset($arrFieled['user_moderation']);
                    unset($arrFieled['is_featured'] );
                }
                 Query::updateData($this->tmpTblName,$arrFieled,array('id' => (int) $isEdit));
                if (!$this->isAdmin) {
                    Query::updateData($this->tblName,array("user_moderation" => '1'),array('id' =>(int) $isEdit)); 
                }
                if(!isAdmin()){
                      saveNotification($userID, $isEdit,'parts_updated_by_user', "id=" . $isEdit, 'admin');
                } else {
                     saveNotification($userID, $isEdit,'parts_updated_by_admin', "id=" . $isEdit, 'user');
                }
               /* if ($this->isAdminLoggedIn == false) {
                    //Mail to admin
                    $this->notifyAdmin($isEdit, $data);
                    saveNotification((int) $data['user'], 'mod_' . $this->module, $this->module . "_edit_user", $this->module . "_add?id=" . $isEdit, 'admin');
                    $tempstore->set('msg', "Machine approval request is sent successfully.");
                } else { 
                    saveNotification((int) $data['user'], 'mod_' . $this->module, $this->module . "_edit", $this->module . "_add?id=" . $isEdit, 'user');
                    $tempstore->set('msg', "Machine is updated successfully.");
                }
                $id = $isEdit;
                Query::updateData($this->tblName,$arrFieled,array('id' => $this->input->post('category_id')));*/
                $id = (int) $isEdit;
            } else {
                $slug = Utility::getSlug($part_name, 0, $this->tblName);
                $arrFieled['alias'] = $slug;
                $arrFieled['created_date'] = date("Y-m-d H:i:s");
                $arrFieled['created_by'] = $userID;
                
                $id=Query::insertData($this->tblName,$arrFieled);
                $arrFieled['id'] = $id; //Set Id for new tmp  and main record unique mapping.
                unset($arrFieled['approved']);
                unset($arrFieled['user_moderation']);
                unset($arrFieled['is_featured'] );
                Query::insertData($this->tmpTblName,$arrFieled);
               
                /*if ($this->isAdminLoggedIn == false) {
                    $id = $data['id']; // For tmp and main record image is store in one location
                } else {
                    $this->createInvoice($_POST,$id);
                   
                }*/
                rename($this->path . $randomCode, $this->path . $id);
                rename($this->editorPath . $randomCode, $this->editorPath . $id);
                $dataNew = array("description" => str_replace($randomCode, $id, $description));
                Query::updateData($this->tblName,$dataNew,array('id' => (int) $id));
                Query::updateData($this->tmpTblName,$dataNew,array('id' => (int) $id));
                if(!isAdmin()){
                      saveNotification($userID, $id,'parts_added_by_user', "id=" . $id, 'admin');
                } else {
                     saveNotification($userID, $id,'parts_added_by_admin', "id=" . $id, 'user');
                }
               /*
                
                if ($this->isAdminLoggedIn == false) {
                    saveNotification((int) $data['user'], 'mod_' . $this->module, $this->module . "_add_user", $this->module . "_add?id=" . $data['id'], 'admin');
                    $tempstore->set('msg', "Machine approval request is sent successfully.");
                } else {
                    saveNotification((int) $data['user'], 'mod_' . $this->module, $this->module . "_add", $this->module . "_add?id=" . $data['id'], 'user');
                    $tempstore->set('msg', "Machine is saved successfully.");
                }
                */
                 if ($this->isAdmin == false) {
                        $this->createInvoice($_POST,$id);
                        
                 } else if($this->input->post("user_id")!="" && $this->isAdmin){
                     $this->createInvoice($_POST,$id);
                 }
              
            }
            return $id;
    }

    /**
     * Fetches Single Record
     * @param type $id
     * @return type
     */
    public function getSingleData($id) {
        //Initalize variables  
        $parts = array();
        if ($this->input->get('page') != "") {
            $parts['page'] = $this->input->get('page');
        }
        
        $this->db->select('*');
        if($this->isAdmin){
            $this->db->from($this->tblName);
        } else {
            $this->db->from($this->tmpTblName);
        }
        $this->db->where('id',$id);
        $query = $this->db->get(); 
        return $query->row_array();
    }
 
        public function fetchCategoryTree($table,$parent = 0, $spacing = '', $user_tree_array = '', $withSub = '', $onlyActive = '') {

        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $this->db->select('id,category_name,image_name,image_name_hover,parent_id,alias,status');
        $this->db->from($this->tblName. " wr");  
        if ($withSub != '')
            $this->db->where('wr.parent_id',$parent); 
        else
             $this->db->where('wr.parent_id',0); 

        if ($onlyActive != '')
             $this->db->where('wr.status', '1');

        $this->db->order_by("category_name", 'ASC');

        $result = $this->db->get();
        
        $resultCategory = $result->result();
        if (count($resultCategory) > 0) {
            foreach ($resultCategory as $row) {
                $user_tree_array[] = array("id" => $row->id, "name" => $spacing . ucwords($row->category_name), "image_name" => $row->image_name, "image_name_hover" => $row->image_name_hover, 'alias' => $row->alias);
                if ($withSub != '')
                    $user_tree_array = $this->fetchCategoryTree($row->id, $spacing . '&nbsp;&nbsp;', $user_tree_array, $withSub, $onlyActive);
            }
        }
        return $user_tree_array;
    } 
    
    public function handleAjaxRequest(){
         if ($this->input->get('storeData') != "") {
            $this->session->set_userdata($this->partsSession, $this->input->post());
            echo "1";
            exit;
        }
        
        if( $this->input->post('makeValue')!="") {
             $this->load->model('make_model'); 
             $modelData=$this->make_model->loadModelFromMake($this->input->post('makeValue'));
             echo json_encode(array("models"=>$modelData)); 
             exit;
        }
       if($this->input->post("checkPartCode")!=""){
           $this->checkPartCode($this->input->post('partCode'));
           exit;
       }
        if ($this->input->post('payment_type') == 'PAYPAL_EXPRESS') {
            if ($this->input->post('part_name') != "") {
                $this->session->set_userdata($this->partsSession, $this->input->post());
                return $this->setExpressCheckout();
            }
        }
     
    }
    
    public function getSuburb(){
         $this->db->select("distinct(suburb) as suburb");
         $query=$this->db->get($this->tblName);
         return $query->result_array(); 
    }
     /**
     * Generate Random Code Number and folder for first time image save. After save parts auto incremented id of machine will be the folder name
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function generateRandomFolderName() {
        $random = rand(1, 100000) . "_" . date('dmY');
        $machineAbsPath = $this->path. $random;
        if (!file_exists($machineAbsPath)) {
            mkdir($machineAbsPath, 0755, true);
        } else {
            //$this->generateRandomFolderName();
        }
        $editorAbsPath = $this->editorPath. $random;
        if (!file_exists($editorAbsPath)) {
            mkdir($editorAbsPath, 0755, true);
        }
        return $random;
    }
     /**
      * Check unique part code
      * @author Kushan  Antani <kushan.datatechmedia@gmail.com>
      */
       public function checkPartCode($pc) {
        $this->db->select("part_code");
        $this->db->from($this->tblName);
        $this->db->where('part_code',$pc);
        if ($this->input->post('record_id') != "") {
            $this->db->where("id!=",$this->input->post('record_id')); 
        }
        $machineCode = $this->db->count_all_results(); 
        if ($machineCode  > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
        public function deleteRecord($tbl = "", $module = "") {
        if ($tbl != "") {
            $this->tblName = $tbl;
        }
        if ($module != "") {
            $this->module = $module;
        }
  
        $id = $this->input->get('id'); 
        $dataArr = array('is_trash' => '0');
        if ($this->input->get('restore')) {
            $dataArr = array('is_trash' => '0');
            $msg = 'Record is restored successfully.';
        } 
        
        else if (setTrash() == "trash") {
            $msg = $this->permanentDelete();
            echo $msg;
            exit;
        } else {
            $dataArr = array('is_trash' => '1', 'trash_by' => $this->userID, 'trash_date' => date("Y-m-d H:i:s"));
            $msg = '<div class="messages messages--status">Record is trashed successfully.</div>';
        }
        
        if ($id != "") {
             Query::updateData($this->tblName, $dataArr, array('id' => $id)); 
             Query::updateData($this->tmpTblName, $dataArr, array('id' => $id)); 
            return $msg;
        } else if (count($this->input->post('bulk')) != 0) { 
            foreach ($this->input->post('bulk') as $val) {
                  Query::updateData($this->tblName, $dataArr, array('id' => (int) $val['value'])); 
                  Query::updateData($this->tmpTblName, $dataArr, array('id' => (int) $val['value'])); 
 
            }
            return $msg;
        }
    }

    public function permanentDelete() {
        Query::deleteRecordFromList($this->tblName);
        Query::deleteRecordFromList($this->tmpTblName);
        $id = $this->input->get('id');
        if ($id != "") { 
            if (is_dir($this->path . $id)) {
                unlink($this->path . $id);
            }
         
        } else if (count($this->input->post('bulk')) != 0) { 

            foreach ($this->input->post('bulk') as $val) { 
                   if (is_dir($this->path . $val['value'])) {
                        unlink($this->path . $val['value']);
                   }
            }
        }
    }
    
        public function setExpressCheckout() {
 
        //Included Paypal class
        $this->load->library("paypal");
        $MyPayPalController = new Paypal;

        $returnUrl = setLink('user/parts/parts_add').'?confirmation=1';
        $cancelUrl = setLink('user/parts/parts_list'). '?cancel=true';

        $reqpa = $this->lists_session($this->partsSession);
        $padata = '&METHOD=SetExpressCheckout' . '&RETURNURL=' . urlencode($returnUrl) .
                '&CANCELURL=' . urlencode($cancelUrl . "&payment_cancel=1") .
                $this->paypalRequest() .
                '&LOCALECODE=GB' . //PayPal pages to match the language on your website.
                '&LOGOIMG=' . './theme/images/logo.png'; //site logo
        '&CARTBORDERCOLOR=FFFFFF' . //border color of cart
                '&ALLOWNOTE=1';

        extract(Utility::setPaypalDetails());

        $httpParsedResponseAr = $MyPayPalController->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);


        //Respond according to message we receive from Paypal
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

            //Redirect user to PayPal store with Token received.

            $paypalurl = 'https://www' . $PayPalMode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
            header('Location: ' . $paypalurl);
            die;
        } else {
            $this->lists_session("payment_type", 'PAYPAL_EXPRESS');
            $this->lists_session("payment_status", 'FAILED');
            $this->lists_session("payment_message", urldecode($httpParsedResponseAr['L_LONGMESSAGE0']));
            redirect(setLink('user/parts/parts_add')); 
        }
        exit;
    }

    public function doExpressCheckout() {

        extract(Utility::setPaypalDetails());
        $token = $_REQUEST["token"];
        $payer_id = $_REQUEST["PayerID"];
        $padata = '&TOKEN=' . urlencode($token) .
                '&PAYERID=' . urlencode($payer_id) . $this->paypalRequest();
        $this->load->library("paypal");
        $MyPayPalController = new Paypal;
        $httpParsedResponseAr = $MyPayPalController->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
            $this->lists_session("payment_type", 'PAYPAL_EXPRESS');
            $this->lists_session("payment_status", 'SUCCESS');
            $this->lists_session('payment_response', $httpParsedResponseAr);
            redirect(setLink('payment-thank-you'));  
        } else {
            $this->lists_session("payment_type", 'PAYPAL_EXPRESS');
            $this->lists_session("payment_status", 'FAILED');
            $this->lists_session("payment_message", urldecode($httpParsedResponseAr['L_LONGMESSAGE0'])); 
            redirect(setLink('user/parts/parts_add')); 
        }
        exit;
    }

    public function paypalRequest() {
        $reqpa = $this->lists_session($this->partsSession);
        $paypal_data = '';
        $p = 0;

        $paymentFor = 'Add Part - ' . $reqpa['part_name'];

        $paypal_data = '&L_PAYMENTREQUEST_0_NAME' . $p . '=' . urlencode($paymentFor);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT' . $p . '=' . urlencode($reqpa['totalPayment']);

        $padata = '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                $paypal_data .
                '&NOSHIPPING=1' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping
                '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($reqpa['totalPayment']) .
                '&PAYMENTREQUEST_0_TAXAMT=' . urlencode(0) .
                '&PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode(0) .
                '&PAYMENTREQUEST_0_HANDLINGAMT=' . urlencode(0) .
                '&PAYMENTREQUEST_0_SHIPDISCAMT=' . urlencode(0) .
                '&PAYMENTREQUEST_0_INSURANCEAMT=' . urlencode(0) .
                '&PAYMENTREQUEST_0_AMT=' . urlencode($reqpa['totalPayment']) .
                '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode('AUD');

        return $padata;
    }

    
    public function lists_session($key, $value = NULL) { 
        if (isset($key) && $value != NULL) {
            $this->session->unset_userdata($key);
            $this->session->set_userdata($key, $value);
        } else if (!empty($key)) {
            if (!empty($this->session->userdata($key))) {
                return $this->session->userdata($key);
            }
        } else if (!$key && $values == NULL) {
            $tempstore->remove($this->partsSession);
        }
    }
     /**
      * Function to save invoice data
      * @param type $postData
      * @param type $id
      * @return transcation id
      * @author Kushan Antani <kushan.datatechmedia@gmail.com>
      */
        public function createInvoice($postData, $id) {
 
        $payment = $this->session->userdata('payment_response');
        $userData = getUserInfo();
        extract(Utility::getPartsPrice());
        $arrFields = array();
        $makeQuery=$this->db->select('make')->from(Query::$make)->where('id=m.make','',FALSE)->get_compiled_select();
        $modelQuery=$this->db->select('model')->from(Query::$model)->where('id=m.model','',FALSE)->get_compiled_select();
        $categoryQuery=$this->db->select('category_name')->from(Query::$machine_category)->where('id=m.category','',FALSE)->get_compiled_select();
        $columns="(".$makeQuery.") as make,(".$modelQuery.") as model,(".$categoryQuery.") as category";
        $query=$this->db->select($columns)->from($this->tblName." as m ")->where("id",$id)->get(); 
        $partsDetails=$query->row_array();
 
        $arrField = array("uid" => $userData->id, "parts_id" => $id, "parts_name" => $postData['part_name'], "parts_category" => $partsDetails['category'], "parts_region" => $postData['suburb'], "parts_make" => $partsDetails['make'], "parts_model" => $partsDetails['model'], "name" => $userData->name . " " . $userData->surname, "email" => $userData->email, 'phone' => $userData->phone, 'payment_date' => date("Y-m-d H:i:s"), 'request_arr' => json_encode($postData), "subtotal" => $subtotal, "gst" => $gst, "total" => $total);
        if ($postData['payment_type'] == "PAYPAL_EXPRESS") {
            $arrField['payment_mode'] = $postData['payment_type'];
            $arrField['transcation_id'] = $payment['PAYMENTINFO_0_TRANSACTIONID'];
            $arrField['response_arr'] = json_encode($payment);
            if ($payment['PAYMENTINFO_0_ACK'] == "Success")
                $arrField['payment_status'] = 'COMPLETE';
            else
                $arrField['payment_status'] = 'CANCEL';
        } else if ($this->input->get('tx') != "") {
            $arrField['payment_status'] = 'COMPLETE';
            $arrField['response_arr'] = json_encode(array("CSCMATCH" => $this->input->get('CSCMATCH'), 'AVSCODE' => $this->input->get('AVSCODE')));
            $arrField['transcation_id'] = $this->input->get('tx');
            $arrField['payment_mode'] = 'PAYPAL_HOSTED_SOLUTIONS';
        } else {
            $arrField['payment_status'] = 'COMPLETE';
            $arrField['payment_mode'] = 'ADMIN_PAY';
        }
       $trid=Query::insertData(Query::$parts_payment,$arrField);
       if( $arrField['payment_mode'] !='ADMIN_PAY'){
            $worthyPartEmail = $this->config->item('site_email');
            $worthyPartName = $this->config->item('site_name');
            $this->sendAttachedMail($trid,$id); 
       }
        $this->session->unset_userdata('payment_response');
        $this->session->unset_userdata('payment_status');
        $this->session->unset_userdata('payment_message');
        return $trid;
         
    }
    
       /**
   * Send Attachement mail
   * @param type $transactionId
   * @param type $uid
   * @param type $name
   * @param type $email
   * @param type $fromName
   * @param type $fromEmail
   * @author Kushan Antani <kushan.datatechmedia@gmail.com>
   */
  public function sendAttachedMail($transactionId,$parts_id){
       $CI = setCodeigniterObj();
      $userData = getUserInfo();
      $from_name=$CI->config->item('site_name');
      $from_email=$CI->config->item('site_email');         
      $subject = "Parts Invoice From " . ucfirst($from_name); 
      $linkPDF=base_url().'/parts-invoice-pdf/'. $transactionId .'/'.$parts_id; 
      $this->generatePDF($transactionId,"","F");
      $attachment=$this->invoiceAbsPath."Parts_Invoice".$transactionId.".pdf"; 
      $contentInvoice='<tr><td style="padding:10px;"><b>Hi ' . $userData->name.',</b><br /><br />Here’s invoice '.$transactionId.' for $AUD '.number_format($CI->config->item('parts_price'),2,'.',',').'.<br /><br />View your bill online:<a href="'.$linkPDF.'" target="_blank">'.$linkPDF.'</a>. From your online bill you can print a PDF<br /><br />If  you have any questions, please let us know</td></tr>';
        $content = Utility::loadTemplate($subject, $contentInvoice); 
        Utility::sendMail($userData->email, $from_name, $from_email, $subject, $content,$attachment);
  }
  
   public function generatePDF($trid, $uid="", $saveFlag = "I" ) {
        $query=$this->db->select("id,parts_name,parts_category, parts_region, parts_make, parts_model,name,email,phone,subtotal,gst,total,payment_date,payment_mode,transcation_id")->from(Query::$parts_payment)->where("id",$trid)->get();
        $transcation = $query->row_array();  
        
        include_once ( $this->invoiceAbsPath . '/mpdf60/parts_invoice.php');
        if ($saveFlag == "I") {
            exit;
        }
    }
     
}
