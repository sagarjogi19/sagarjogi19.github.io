<?php

/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Parts_front_model extends CI_Model {

    public $tblName;
    public $tmpTblName;
    public $paymentTbl;
    public $pageCount = 10;
    public $totalRecord;
    public $module="parts";
    public $path;
    public $editorPath;
    public $isAdmin;
    public $userID;
    public $record;
    public $partsSession="parts_post";
    public function __construct() {
        $this->path = FCPATH . '/media/worthyparts/parts/';
        $this->editorPath = FCPATH ."/moxiemanager-php-pro/data/files/parts/";
        $this->tblName = Query::$parts_list;
        $this->paymentTbl = Query::$parts_payment;
        $this->tmpTblName=$this->tblName."_tmp";
        $this->isAdmin = isAdmin();
        $this->userID = getUserInfo("id");
        
        
    }

    /**
     * Get Parts List
     * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
     */
    public function getSearchMachineListing() {
      $this->getSetCount();
//        Parts_Front::$totalRecord; 
      $whereConditions = $this->getWhereParam();
//      print_r($whereConditions);exit;
      $orderBy = $this->getOrderBy();
      $order=explode(' ',$orderBy);
//      print_r($orderBy);exit;
      $this->db->select('*'); 
      $this->db->from($this->tblName . " as m ");
      if($whereConditions['where']!=''){
           $this->db->where($whereConditions['where']);
      }
      $this->db->order_by($order[0], $order[1]);
      $data=$this->db->get()->result_array();
//      print_r($data);exit;
      /*$data = $this->db->query("SELECT * FROM " . CFG::$tblDPrefix . "machine_list " . ($whereConditions['where'] != '' ? ' where ' . $whereConditions['where'] : '') . $orderBy, $whereConditions['whereParam']);*/
      Parts_Front::$totalRecord = count($data);
//      echo $this->$totalRecord;exit;
//      exit;
      $make = array();
      $model = array();

      $negotiable = false;
      $range = false;
      $poa = false;
      $fix = false;
      $minprice = 0;
      $maxprice = 0;

      $minyear = date('Y');
      $maxyear = 0;

      $category = array();
      $subCategory = array();

      $regions = array();

      $conditions = array();

      $machine = array();

      foreach ($data as $k => $v) {
         //make
         $sefMake = $v['make_alias'];
         if (isset($make[$sefMake])) {
	 $make[$sefMake]['make_cnt'] ++;
         } else {
	 $make[$sefMake] = array(
	     'sef_make' => $sefMake,
	     'make' => $v['make_name'],
	     'make_cnt' => 1
	 );
         }

         //model
         $sefModel = $v['model_alias'];
         if (isset($model[$sefModel])) {
	 $model[$sefModel]['model_cnt'] ++;
         } else {
	 $model[$sefModel] = array(
	     'sef_model' => $sefModel,
	     'model' => $v['model_name'],
	     'model_cnt' => 1
	 );
         }

         //minprice
         if ($v['price_type'] == 'r') {
	 $range = true;
         } else if ($v['price_type'] == 'f') {
	 $fix = true;
         } else if ($v['price_type'] == 'n') {
	 $negotiable = true;
         } else {
	 $poa = true;
         }
         if ($v['price'] >= $maxprice) {
	 $maxprice = $v['price'];
         }
         if ($v['price_to'] >= $maxprice) {
	 $maxprice = $v['price_to'];
         }
         if ($v['price'] <= $minprice) {
	 $minprice = $v['price'];
         }
         if ($v['price_to'] <= $minprice) {
	 $minprice = $v['price_to'];
         }

         //year
         if ($v['year'] <= $minyear && !empty($v['year']) && $v['year'] > 0) {
	 $minyear = $v['year'];
         }
         if ($v['year'] >= $maxyear) {
	 $maxyear = $v['year'];
         }

         //category
         if ($v['parent_id'] > 0) {
	 if (isset($subCategory[$v['parent_id']][$v['category_alias']])) {
	    $subCategory[$v['parent_id']][$v['category_alias']]['cat_cnt'] ++;
	 } else {
	    $subCategory[$v['parent_id']][$v['category_alias']] = array('cat_name' => $v['category_name'], 'sef_cat' => $v['category_alias'], 'parent_id' => $v['parent_id'], 'cat_cnt' => 1);
	    $category[$v['parent_id']] = array('cat_name' => $v['parent_category_name'], 'sef_cat' => '', 'parent_id' => '', 'cat_cnt' => 0);
	 }
         } else {
	 if (isset($category[$v['category']])) {
	    $category[$v['category']]['cat_cnt'] ++;
	 } else {
	    $category[$v['category']] = array('cat_name' => $v['category_name'], 'sef_cat' => $v['category_alias'], 'parent_id' => $v['parent_id'], 'cat_cnt' => 1);
	 }
         }

         //region
         if (isset($regions[$v['state']][str_replace('-', '_', Utility::getCleanSlugString($v['suburb']))])) {
	 $regions[$v['state']][str_replace('-', '_', Utility::getCleanSlugString($v['suburb']))]['region_cnt'] ++;
         } else {
	 $regions[$v['state']][str_replace('-', '_', Utility::getCleanSlugString($v['suburb']))] = array('sef_region' => str_replace('-', '_', Utility::getCleanSlugString($v['suburb'])), 'region_name' => $v['suburb'], 'region_cnt' => 1);
         }

         //Conditions
         if (isset($conditions[str_replace('-', '_', Utility::getCleanSlugString($v['conditions']))])) {
	 $conditions[str_replace('-', '_', Utility::getCleanSlugString($v['conditions']))]['conditions_cnt'] ++;
         } else {
	 $conditions[str_replace('-', '_', Utility::getCleanSlugString($v['conditions']))] = array('sef_conditions' => str_replace('-', '_', Utility::getCleanSlugString($v['conditions'])), 'conditions_name' => ucwords($v['conditions']), 'conditions_cnt' => 1);
         }

         if ($k < Parts_Front::$record) {
	 $machine[] = $v;
         }
      }
       $priceType = array('fix' => $fix, 'range' => $range, 'negotiable' => $negotiable, 'poa' => $poa);
      $finalArr = array();
      $finalArr['priceType'] = $priceType;
      $finalArr['minprice'] = ($minprice <= 500 ? 500 : round($minprice, -2));
      $finalArr['maxprice'] = ($maxprice <= 500 ? 500 : $this->roundSigDigs($maxprice, (strlen($maxprice) - 2)));
      $finalArr['minyear'] = $minyear;
      $finalArr['maxyear'] = $maxyear;
      $finalArr['make'] = $make;
      $finalArr['model'] = $model;
      $finalArr['categories'] = array('cat' => $category, 'subcat' => $subCategory);
      $finalArr['region'] = $regions;
      $finalArr['conditions'] = $conditions;
      $finalArr['machine'] = $machine;
//      print_r($finalArr);exit;
      return $finalArr;
    }
    function getSetCount() {
       
         /*$token = rand(100000000, 9999999999);
         $userIP = $this->getClientIP();*/
         
      if (!$this->input->cookie('partsToken') && !$this->input->cookie('partsIP')) {
         $token = rand(100000000, 9999999999);
         $userIP = $this->getClientIP();
         $arrFields = array(
	  'uid' => 0,
	  'directory_id' => 0,
	  'client_ip' => $userIP,
	  'visitor_id' => $token,
	  'created_date' => date("Y-m-d H:i:s"),
	  'is_monthly' => '0',
	  'is_click' => '0',
         );
         
          $this->db->insert(Query::$click_count,$arrFields);
      } else {
         $token =  $this->input->cookie('partsToken');
         $userIP = $this->input->cookie('partsIP');
         $arrFields = array(
	  'is_monthly' => '1',
	  'is_click' => '1',
         );
         $where=array(
             'client_ip' => $userIP,
             'visitor_id' => $token
         );
         $this->db->where($where);
         $this->db->update(Query::$click_count, $arrFields); 
      }
       
      $this->load->helper('cookie');
      $cookie=array(
        'name' => 'partsToken',  
        'value' => $token,
        'expire' => time() + (30 * 24 * 60 * 60)
      );
      $this->input->set_cookie($cookie);
      $cookieIP=array(
        'name' => 'partsIP',  
        'value' => $userIP,
        'expire' => time() + (30 * 24 * 60 * 60)
      );
      $this->input->set_cookie($cookieIP);
      
      /*$cookie=array(
        'name' => 'partsToken',  
        'value' => $token,
        'expire' => time() + (30 * 24 * 60 * 60),
      );
      set_cookie($cookie);
       $cookie=array(
        'name' => 'partsIP',  
        'value' => $userIP,
        'expire' => time() + (30 * 24 * 60 * 60),
      );
       set_cookie($cookie);*/
//       print_r($_COOKIE);exit;
      /*setcookie('partsToken', $token, time() + (30 * 24 * 60 * 60));
      setcookie('partsIP', $userIP, time() + (30 * 24 * 60 * 60));*/
       /* echo "IP Cookie<br />";
        print_r($this->input->cookie('partsIP' ));
         echo "Token Cookie<br />";
        print_r(  $this->input->cookie('partsToken' )); exit;*/
     
      if ((isset($_GET['searchKeyword']) && $_GET['searchKeyword'] != '')) {
         $this->storeSearchKeyword($_GET['searchKeyword']);
         $this->storeSearchData($token, 'keyword', $_GET['searchKeyword']);
      }
      if ((isset($_GET['searchCategory']) && $_GET['searchCategory'] != '')) {
         $this->storeSearchData($token, 'category', $_GET['searchCategory']);
      }
      if ((isset($_GET['searchRegion']) && $_GET['searchRegion'] != '')) {
         $this->storeSearchData($token, 'region', $_GET['searchRegion']);
      }
   }

   function getClientIP() {
      $ipaddress = '';
      if (isset($_SERVER['HTTP_CLIENT_IP']))
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if (isset($_SERVER['HTTP_X_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      else if (isset($_SERVER['HTTP_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
      else if (isset($_SERVER['REMOTE_ADDR']))
         $ipaddress = $_SERVER['REMOTE_ADDR'];
      else
         $ipaddress = 'UNKNOWN';
      return $ipaddress;
   }
  
   function getWhereParam() {
      $where = array();
      $whereParam = array();
       $CI  = &get_instance();
//       echo $total = count($this->uri->segment_array());exit;
//       echo $CI->uri->segment(3);exit;
      $where[] = " status = '1' ";
//      $whereParam['status'] = '1';
      $where[] = " is_trash = '0' ";
//      $whereParam['trash'] = '0';
      $where[] = " approved = '1' ";
//      $whereParam['approved'] = '1';

      switch (count($this->uri->segment_array())) {
         case 3://only make
	 $_GET['make'] = $make = str_replace('make-', '', $CI->uri->segment(3));
	 $where[] = " make_alias = '$make' ";
//	 $whereParam['make'] = $make;
	 break;
         case 4://make and model
	 $_GET['make'] = $make = str_replace('make-', '', $CI->uri->segment(3));
	 $_GET['model'] = $model = str_replace('model-', '', $CI->uri->segment(4));
	 $where[] = " make_alias = '$make' ";
	 $where[] = " model_alias = '$model' ";
//	 $whereParam['make'] = $make;
//	 $whereParam['model'] = $model;
	 break;
      }

      if (isset($_GET['minprice']) && ($_GET['minprice'] == 'c' || $_GET['minprice'] == 'n')) {
          $price=$_GET['minprice'];
         $where[] = " (price_type = $price) ";
//         $whereParam['minprice'] = $_GET['minprice'];
      } else if (isset($_GET['minprice']) && $_GET['minprice'] > 0) {
          $price=$_GET['minprice'];
         $where[] = " IF(price_type = 'f', price >= $price, price >= $price or price_to >= $price) ";
//         $whereParam['minprice'] = $_GET['minprice'];
      }

      if (isset($_GET['maxprice']) && $_GET['maxprice'] > 0) {
           $price=$_GET['maxprice'];
         $where[] = " IF(price_type = 'f', price <= $price, price <= $price or price_to <= $price) ";
//         $whereParam['maxprice'] = $_GET['maxprice'];
      }

      if (isset($_GET['minyear']) && $_GET['minyear'] > 0) {
          $year=$_GET['minyear'];
         $where[] = " year >= $year ";
//         $whereParam['minyear'] = $_GET['minyear'];
      }

      if (isset($_GET['maxyear']) && $_GET['maxyear'] > 0) {
           $year=$_GET['maxyear'];
         $where[] = " year <= $year ";
//         $whereParam['maxyear'] = $_GET['maxyear'];
      }

      if (isset($_GET['searchCategory']) && $_GET['searchCategory'] != '') {
         $_GET['cat'] = $_GET['searchCategory'];
      }

      if (isset($_GET['cat']) && $_GET['cat'] != '') {
          $cat= $_GET['cat'];
         $where[] = " category_alias = '$cat' ";
//         $whereParam['alias'] = $_GET['cat'];
      }

      if (isset($_GET['searchRegion']) && $_GET['searchRegion'] != '') {
         $_GET['region'] = $_GET['searchRegion'];
      }

      if (isset($_GET['region']) && $_GET['region'] != '') {
          $suburb=$_GET['region'];
         $where[] = " suburb = '$suburb' ";
//         $whereParam['region'] = $_GET['region'];
      }

      if (isset($_GET['conditions']) && $_GET['conditions'] != '') {
          $conditions=$_GET['conditions'];
         $where[] = " conditions = '$conditions' ";
//         $whereParam['conditions'] = $_GET['conditions'];
      }

      if ((isset($_GET['keywords']) && $_GET['keywords'] != '') || (isset($_GET['searchKeyword']) && $_GET['searchKeyword'] != '')) {
         if ((isset($_GET['searchKeyword']) && $_GET['searchKeyword'] != '')) {
	 $keyword = explode(' ', $_GET['searchKeyword']);
         } else {
	 $keyword = explode(' ', $_GET['keywords']);
         }
         $whereK = array();
         foreach ($keyword as $k => $v) {
	 $whereK[] = " (make_name LIKE '%$v%' OR model_name LIKE '%$v%' OR category_name LIKE '%$v%' OR suburb LIKE '%$v%' OR part_name LIKE '%$v%' OR conditions LIKE '%$v%') ";
//	 $whereParam['keywords' . $k] = $v;
         }
         if (count($whereK) > 0) {
	 $where[] = implode(' and ', $whereK);
         }
      }

      if (count($where) > 0) {
         $where = implode(' and ', $where);
      } else {
         $where = '';
      }
      return array('where' => $where);
   }
    public function getOrderBy() {
      $orderBy = 'id desc ';
      if (isset($_GET['sorting']) && $_GET['sorting'] != '') {
         switch ($_GET['sorting']) {
	 case 'price_desc':
	    $orderBy = 'price desc ';
	    break;
	 case 'price_asc':
	    $orderBy = 'price asc ';
	    break;
	 case 'year_desc':
	    $orderBy = 'year desc ';
	    break;
	 case 'year_asc':
	    $orderBy = 'year asc ';
	    break;
	 case 'updated_date_desc':
	    $orderBy = 'updated_date desc ';
	    break;
         }
      }
      return $orderBy;
   }
    public function roundSigDigs($number, $sigdigs) {
      $multiplier = 1;
      while ($number < 0.1) {
         $number *= 10;
         $multiplier /= 10;
      }
      while ($number >= 1) {
         $number /= 10;
         $multiplier *= 10;
      }
      return round($number, $sigdigs) * $multiplier;
   }
   function getSearchMachineListingAjax() {
      $whereConditions = $this->getWhereParam();
      $orderBy = $this->getOrderBy();
     $order=explode(' ',$orderBy);
      $this->db->select('*'); 
      $this->db->from($this->tblName . " as m ");
      if($whereConditions['where']!=''){
           $this->db->where($whereConditions['where']);
      }
      $this->db->order_by($order[0], $order[1]);
      $this->db->limit(Parts_Front::$record,$_GET['limitStart']);
      $data=$this->db->get()->result_array();
      
      /*$data = $this->db->query("SELECT * FROM " . CFG::$tblDPrefix . "machine_list " . ($whereConditions['where'] != '' ? ' where ' . $whereConditions['where'] : '') . $orderBy, $whereConditions['whereParam']);*/
     /* Parts_Front::$totalRecord = count($data);
      $data = Machine::$machineDB->query("SELECT * FROM " . CFG::$tblDPrefix . "machine_list " . ($whereConditions['where'] != '' ? ' where ' . $whereConditions['where'] : '') . $orderBy . ' limit ' . $_GET['limitStart'] . ', ' . Machine::$record, $whereConditions['whereParam']);*/
      ob_start();
      $parts = $data;
      include APPPATH.'views/parts_front/templates/part_list.php';
      $list = ob_get_contents();
      ob_clean();
      ob_end_clean();
      echo json_encode(array("list" => $list));
      exit;
   }
   function storeSearchKeyword($keyword) {
      $this->db->select('id, count'); 
      $this->db->from(Query::$search_words);
      $this->db->where('word',$keyword);
      $data=$this->db->get()->result_array();
//      print_r($data);exit;
      if (!isset($data[0]['id'])) {
         $arrFields = array(
	  'word' => $keyword,
	  'count' => 1,
	  'location' => 'search',
	  'word_type' => '',
	  'updated_date' => date("Y-m-d H:i:s"),
         );
          $this->db->insert(Query::$search_words,$arrFields);
      } else {
         $arrFields = array(
	  'count' => $data[0]['count'] + 1,
	  'updated_date' => date("Y-m-d H:i:s"),
         );
         $this->db->where('id',$data[0]['id']);
         $this->db->update(Query::$search_words, $arrFields); 
      }
   }

   function storeSearchData($token, $key, $value) {
         $this->db->select('id, count'); 
      $this->db->from(Query::$search_data);
      $where=array(
          'token' => $token,
          'value' => $value,
      );
      $this->db->where($where);
      $data=$this->db->get()->result_array();
      if (!isset($data[0]['id'])) {
         $arrFields = array(
	  'token' => $token,
	  'key' => $key,
	  'value' => $value,
	  'count' => 1,
	  'search_type' => 'machine',
	  'date' => date("Y-m-d H:i:s"),
         );
          $this->db->insert(Query::$search_data,$arrFields);
         $search_id = $this->db->insert_id();
      } else {
         $arrFields = array(
	  'count' => $data[0]['count'] + 1,
	  'date' => date("Y-m-d H:i:s"),
         );
         $this->db->where('id',$data[0]['id']);
         $this->db->update(Query::$search_data, $arrFields); 
         $search_id = $data[0]['id'];
      }
      $temp = array();
      foreach (getallheaders() as $name => $value) {
         $temp[$name] = $value;
      }
//      print_r($temp);exit;
      $arrFields = array(
          'search_id' => $search_id,
          'token' => $token,
          'ip_address' => $this->input->cookie('partsIP'),
          'http_header' => json_encode(array('Authorization' => $temp)),
          'http_referer' => $temp['Referer'],
          'user_agent' => $temp['User-Agent'],
          'date' => date("Y-m-d H:i:s"),
      );
       $this->db->insert(Query::$search_data_detail,$arrFields);
   }
   function sendEnquiryMail() {
      $message = "";
//        print_r($_POST);exit;
//include sender.php
      Load::loadLibrary("sender.php", "phpmailer");

      $valid = MachineModel::check($_SESSION['uniqueNum1'], $_POST['secureImg_enq']);

      if (!$valid) {
         $message = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Session Expired</span>";
      } else {
//Set Mail Data
         $varFname1 = (isset($_POST['constomerFName1'])) ? $_POST['constomerFName1'] : "";
         $varLname1 = (isset($_POST['constomerLName1'])) ? $_POST['constomerLName1'] : "";
         $varEmail1 = (isset($_POST['constomerEmail1'])) ? $_POST['constomerEmail1'] : "";
         $varPhone1 = (isset($_POST['constomerPhone1'])) ? $_POST['constomerPhone1'] : "";
         $varMessage1 = (isset($_POST['constomerMessage1'])) ? $_POST['constomerMessage1'] : "";
         $varSuburb1 = (isset($_POST['constomerSuburb1'])) ? $_POST['constomerSuburb1'] : "";

         if (!empty($varFname1)) {
	 $arrContactData['Name'] = trim($varFname1) . ' ' . trim($varLname1);
	 $saveArr['name'] = trim($varFname1) . ' ' . trim($varLname1);
         }

         if (!empty($varEmail1)) {
	 $arrContactData['Email'] = trim($varEmail1);
	 $saveArr['email'] = trim($varEmail1);
         }
         if (!empty($varPhone1)) {
	 $arrContactData['Phone'] = trim($varPhone1);
	 $saveArr['phone'] = trim($varPhone1);
         }
         if (!empty($varSuburb1)) {
	 $arrContactData['Suburb'] = trim($varSuburb1);
	 $saveArr['suburb'] = trim($varSuburb1);
         }
         $arrContactData['Machine Name'] = '<a href="' . $_POST['backUrlU'] . '" title="' . $_POST['uname'] . '">' . $_POST['uname'] . '</a>';
         if (!empty($varMessage1)) {
	 $arrContactData['Message'] = trim($varMessage1);
	 $saveArr['message'] = trim($varMessage1);
         }
         $arrContactData['Machine Name'] = trim($_POST['uname']);
         $arrContactData['Machine URL'] = trim($_POST['backUrlU']);
         $arrContactData['Stock ID'] = trim($_POST['ustockid']);
         $arrContactData['Conditions'] = trim($_POST['ucondition']);
         $arrContactData['Seller'] = trim($_POST['useller']);
         $arrContactData['Price'] = str_replace('#', "'", trim($_POST['uprice']));
         $saveArr['created_date'] = date("Y-m-d H:i:s");
         $saveArr['machine_id'] = $_POST['uid'];
         $saveArr['machine_name'] = $_POST['uname'];
         $saveArr['enquiry_page'] = $_POST['page'];
         $saveArr['status'] = '1';
//Load Mail Template 
         /* $subject = "Landing Page Enquiry for " . ucfirst(CFG::$siteConfig['site_name']); */


         $subject = "Machine enquiry for " . ucfirst(CFG::$siteConfig['site_name']);


         $content = Core::loadMailTempleate($subject, $arrContactData);

//            $this->saveEnquiry($saveArr, CFG::$tblPrefix . 'contact_enquiry');
         Machine::$machineDB->insert(CFG::$tblDPrefix . 'machine_enquiry', $saveArr);
         //Store enquiry in db
         // Send mail to client
         $mail_from = $varEmail1;
         $mail_from_name = trim($varFname1) . ' ' . trim($varLname1);
         $mail_to = explode(",", CFG::$siteConfig['enquiry_emails']);

//            echo $mail_from;
//            echo $mail_from_name;
//            print_r($mail_to);
//            echo $subject;
//               echo $content;
//              exit;
         if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1)) {
	 $message = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
         }
         //Send copy mail to customer
         $subject = "Copy of Machine enquiry to " . CFG::$siteConfig['site_name'];

         //$mail_from = CFG::$siteConfig['site_email'];
         $mail_from = CFG::$siteConfig['site_email'];
         $mail_from_name = CFG::$siteConfig['site_name'];
         $mail_to = array($varEmail1);
         $content = Core::loadCustomerMailTempleate($subject, $arrContactData);
//        echo $mail_from;
//        echo $mail_from_name;
//        print_r($mail_to);
//        echo $subject;
//        echo $content;
//        exit;
         if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1)) {
	 $message = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
         } else {
	 $_SESSION['contact'] = $_SERVER['HTTP_REFERER'];
	 UTIL::redirect(URI::getURL("mod_page", "machine_thankyou"));
	 exit;
         }
      }
      return $message;
   }

   function sendMainEnquiryMail() {
      $message = "";
//        print_r($_POST);exit;
//include sender.php
      

      $valid = $this->check($_SESSION['uniqueNum'], $_POST['secureImg']);

      if (!$valid) {
         $message = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Session Expired</span>";
      } else {
//Set Mail Data
          
         $varName = (isset($_POST['constomerFName'])) ? $_POST['constomerFName'] : "";
         $varEmail = (isset($_POST['constomerEmail'])) ? $_POST['constomerEmail'] : "";
         $varPhone = (isset($_POST['constomerPhone'])) ? $_POST['constomerPhone'] : "";
         $varMessage = (isset($_POST['constomerMessage'])) ? $_POST['constomerMessage'] : "";
         $varUser = (isset($_POST['user'])) ? $_POST['user'] : "";
         $varCreatedBy = (isset($_POST['created_by'])) ? $_POST['created_by'] : "";

         if (!empty($varName)) {
	 $arrContactData['Name'] = trim($varName);
	 $saveArr['name'] = trim($varName);
         }

         if (!empty($varEmail)) {
	 $arrContactData['Email'] = trim($varEmail);
	 $saveArr['email'] = trim($varEmail);
         }
         if (!empty($varPhone)) {
	 $arrContactData['Phone'] = trim($varPhone);
	 $saveArr['phone'] = trim($varPhone);
         }
         $arrContactData['Part Name'] = '<a href="' . $_POST['backUrl'] . '" title="' . $_POST['mname'] . '">' . $_POST['mname'] . '</a>';
         if (!empty($varMessage)) {
	 $arrContactData['Message'] = trim($varMessage);
	 $saveArr['message'] = trim($varMessage);
         }
         if(!empty($varUser) && $varUser!=0){
             $varUser=$varUser;
         } else {
             $varUser=$varCreatedBy;
         }
         
         $arrContactData['Part Code'] = trim($_POST['mstockid']);
         $arrContactData['Conditions'] = trim($_POST['mcondition']);
         $arrContactData['Seller'] = trim($_POST['mseller']);
         $arrContactData['Price'] = trim($_POST['mprice']);
         $saveArr['created_date'] = date("Y-m-d H:i:s");
         $saveArr['parts_id'] = $_POST['mid'];
         $saveArr['parts_name'] = $_POST['mname'];
         $saveArr['parts_created_by'] = $varUser;
         $saveArr['status'] = '1';
//Load Mail Template 
         /* $subject = "Landing Page Enquiry for " . ucfirst(CFG::$siteConfig['site_name']); */


         $subject = "Parts enquiry for " . $this->config->item('site_name');


         $content = Utility::loadTemplate($subject, $arrContactData);
//         echo $content;exit;
//            $this->saveEnquiry($saveArr, CFG::$tblPrefix . 'contact_enquiry');
         $this->db->insert(Query::$parts_enquiry, $saveArr);
         
         //Store enquiry in db
         // Send mail to client
         $mail_from = $varEmail;
         $mail_from_name = trim($varName);
         $mail_to = explode(",", $this->config->item('enquiry_emails'));

//            echo $mail_from;
//            echo $mail_from_name;
//            print_r($mail_to);
//            echo $subject;
//               echo $content;
//              exit;
          
         if (!$send = Utility::sendMail($mail_from,$mail_from_name, $mail_to, $subject, $content)) {
	 $message = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
         }
         
         $arrContactData['Part Name'] = trim($_POST['mname']);
         $arrContactData['Part URL'] = trim($_POST['backUrl']);
         
         //Send copy mail to customer
         $subject = "Copy of Parts enquiry to " .$this->config->item('site_name');
 
         //$mail_from = CFG::$siteConfig['site_email'];
         $mail_from = $this->config->item('site_email');
         $mail_from_name = $this->config->item('site_name');
         $mail_to = array($varEmail);
         $content = Utility::loadCustomerMailTempleate($subject, $arrContactData);
//        echo $mail_from;
//        echo $mail_from_name;
//        print_r($mail_to);
//        echo $subject;
//        echo $content;
//        exit;
         if (!$send = Utility::sendMail($mail_from,$mail_from_name, $mail_to, $subject, $content)) {
	 $message = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
         
         } else {
	 $_SESSION['contact'] = $_SERVER['HTTP_REFERER'];
	 redirect('/parts/parts_thank_you');
	 exit;
         }
      }
      return $message;
   }
   
   function getMachineData($slug) {
       /* Main array */
       $this->db->select('m.*,mk.make as make_name,mo.model as model_name');
       $this->db->from(Query::$parts .' as m ');
       $this->db->join(Query::$make.' as mk','m.make=mk.id','left' );
       $this->db->join(Query::$model.' as mo','m.model=mo.id','left' );
       $where=array(
         'm.alias' => $slug,
         'm.is_trash' => '0',
         'm.status' => '1'
       );
      $this->db->where($where);
      $query = $this->db->get();
      $data = (array)$query->row(); 
      $data['main'] = $data;
      /* Seller array */
      $this->db->select('id,business_name,phone as business_phone,suburb,state,postcode,business_logo as company_logo,address');
      $this->db->from(Query::$user_profile);
      $this->db->where('id',$data['user']);
      $query = $this->db->get();
      $seller = (array)$query->row(); 
      if (isset($seller) && !empty($seller)) {
         $data['seller'] = $seller;
      }
      /* Related Parts */
       $this->db->select('m.*,mk.make as make_name,mo.model as model_name,u.name as user_name');
       $this->db->from(Query::$parts .' as m ');
       $this->db->join(Query::$make.' as mk','m.make=mk.id','left' );
       $this->db->join(Query::$model.' as mo','m.model=mo.id','left' );
        $this->db->join(Query::$user_profile.' as u','m.user=u.id','left' );
       $where=array(
         'm.user' => $data['user'],
         'm.is_trash' => '0',
         'm.status' => '1',
         'm.approved' => '1'
       );
      $this->db->where($where);
      $this->db->limit('10');
      $query = $this->db->get()->result_array();
      $data['relatedParts'] = $query; 
      
      if (!isset($data['relatedParts']) && empty($data['relatedParts'])) {
       $this->db->select('m.*,mk.make as make_name,mo.model as model_name,u.name as user_name');
       $this->db->from(Query::$parts .' as m ');
       $this->db->join(Query::$make.' as mk','m.make=mk.id','left' );
       $this->db->join(Query::$model.' as mo','m.model=mo.id','left' );
        $this->db->join(Query::$user_profile.' as u','m.user=u.id','left' );
       $where=array(
         'm.category' => $data['category'],
         'm.is_trash' => '0',
         'm.status' => '1',
         'm.approved' => '1'
       );
      $this->db->where($where);
      $this->db->limit('10');
      $query = $this->db->get()->result_array();
      $data['relatedParts'] = $query; 
      }
      /* Highlight */
      if (isset($_GET['a_R']) && !empty($_GET['a_R'])) {
       $this->db->select('m.*,mk.make as make_name,mo.model as model_name,u.suburb,u.state,u.business_logo as company_logo');
       $this->db->from(Query::$parts_tmp .' as m ');
       $this->db->join(Query::$make.' as mk','m.make=mk.id','left' );
       $this->db->join(Query::$model.' as mo','m.model=mo.id','left' );
       $this->db->join(Query::$user_profile.' as u','m.user=u.id','left' );
       $where=array(
         'm.id' =>  base64_decode($_GET['a_R']),
         'm.is_trash' => '0',
         'm.status' => '1'
       );
      $this->db->where($where);
      $query = $this->db->get();
      $data['highlight'] = (array)$query->row(); 
      $this->db->select('id,business_name,phone as business_phone,suburb,state,postcode,business_logo as company_logo,address');
      $this->db->from(Query::$user_profile);
      $this->db->where('id',$data['highlight']['user']);
      $query = $this->db->get();
      $seller = (array)$query->row(); 
      if (isset($seller) && !empty($seller)) {
         $data['relSeller'] = $seller;
      }
      }
//       print_r($data);exit;
      return $data;
   }
   public function checkMachine($slug) {
       $this->db->select('id');
       $where=array(
         'alias' => $slug,
         'is_trash' => '0',
         'status' => '1'
       );
       $this->db->select('id');
       $this->db->where($where);
       $this->db->from(Query::$parts);
       $query = $this->db->get();
        $ret = $query->row();
      if (isset($ret->id) && !empty($ret->id))
         return true;
      else
         return false;
   }
   function saveClickCount($mid){
       
        if($this->input->cookie('partsToken')){
            $getClick=$this->checkClickInserted($this->input->cookie('partsToken'), $mid);
            if(isset($getClick) && !empty($getClick) && $getClick!=0){
                 $arrFields = array(
                 'is_click' => 'is_click + 1'
                );
                $where=array(
                    'parts_id' => $mid,
                    'visitor_id' => $this->input->cookie('partsToken')
                );
                $this->db->where($where);
                $this->db->update(Query::$parts_click_count, $arrFields); 
                 
            } else {
                 $arrFields = array(
                 'parts_id' => $mid,
                 'client_ip' => $this->input->cookie('partsIP'),
                 'visitor_id' => $this->input->cookie('partsToken'),
                 'created_date' => date("Y-m-d H:i:s"),
                 'is_click' => '1',
                );
                 $this->db->insert(Query::$parts_click_count, $arrFields); 
            }
      } else {
         $token = rand(100000000, 9999999999);
         $userIP =$this->getClientIP();  
         $this->load->helper('cookie');
        $cookie=array(
          'name' => 'partsToken',  
          'value' => $token,
          'expire' => time() + (30 * 24 * 60 * 60)
        );
      $this->input->set_cookie($cookie);
       $cookieIP=array(
        'name' => 'partsIP',  
        'value' => $userIP,
        'expire' => time() + (30 * 24 * 60 * 60)
      );
          $this->input->set_cookie($cookieIP);
         $arr=array('parts_id'=>$mid, 'client_ip' => $userIP,'visitor_id' => $token,'created_date' => date("Y-m-d H:i:s"),'is_click' => '1');
         $this->db->insert(Query::$parts_click_count, $arr); 
      }
   }
    function checkClickInserted($visitorID,$machineID) {
       $this->db->select('count(*)as cnt');
       $where=array(
         'visitor_id' => $visitorID,
         'parts_id' => $machineID
       );
       $this->db->where($where);
       $this->db->from(Query::$parts_click_count);
       $query = $this->db->get();
       $ret = (array)$query->row();
       return $ret['cnt'];
   }
   
   function check($sessionNum, $num) {

      if ($sessionNum == Utility::decryptPass($num)) {
         return TRUE;
      } else {
         return FALSE;
      }
   }
     
}
