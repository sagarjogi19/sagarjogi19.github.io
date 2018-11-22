<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    //Remeber Me Functionality cookie name
    public $remeberMeCookieName = "remember_user";
    //User profile table
    public $userTable = "user_profile";
    public $pageCount = 10;
    public $module="user";
    public $isAdmin; 
    
    /*
     * Check user name and password
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    public function doLogin() {
        //Set variable
        $result = array();
        //Checking post
        if ($this->input->method() === 'post') {

            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember_me');
            if ($remember != "") {
                $cookieData = Utility::encryptCookie(array("username" => $username, "password" => $password, "remember_me" => $remember));
                set_cookie($this->remeberMeCookieName, $cookieData, time() + 31556926);
            } else {
                delete_cookie($this->remeberMeCookieName);
            }
            if (trim($username) != "" && trim($password) != "") {
                $this->db->select('id,name,surname,business_name,username,email,phone,address,suburb,postcode,state,website,abn,business_logo,role_id,status');
                $this->db->from($this->userTable);
                $this->db->where(array('username' => $username, 'password' => Utility::encryptPass($password),'status' => '1'));
                $query = $this->db->get();
                $userData = $query->row();
                if (count($userData) == 1) {
                    setUserInfo(array($userData->id => $userData));
                    redirect('dashboard');
                    exit;
                } else {
                    $result['message'] = array("error" => "Incorrect Login Details. Please try again");
                }
            } else if (trim($username) == "") {
                $result['message'] = array("error" => "Please enter username");
            } else if (trim($password) == "") {
                $result['message'] = array("error" => "Please enter password");
            }
            return $result;
        }
        return $result;
    }

    /**
     * Send forgot password link to user if user email / user name matches or return error
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function sendForgotPwdLink() {
        //Set variable
        $result = array();
        if ($this->input->method() === 'post') {
            $uore = $this->input->post('email');
            if ($uore != "") {
                $this->db->select("id,email,status");
                $this->db->from($this->userTable);
                $this->db->where("email", $uore);
                $this->db->or_where("username", $uore);
                $query = $this->db->get();
                $userData = $query->row();
                if (count($userData) == 1) {
                    $CI = setCodeigniterObj();
                    $siteName = $CI->config->item('site_name');
                    $siteFromEmail = $CI->config->item('site_email');
                    $link = setLink('user/reset-password') . "/" . urldecode(base64_encode(serialize("@" . $userData->id . "/" . date('Y-m-d H:i:s'))));
                    $subject = " Password Reset Request For " . $siteName;
                    $content = "A request to reset the password for your account has been made at " . $siteName;
                    $content .= "<br><br>You may now reset password by clicking this link or copying and pasting it into your browser";
                    $content .= "<br><br><a href='" . $link . "'>" . $link . "</a>";
                    echo Utility::loadTemplate($subject, $content);
                    exit;
                } else {
                    $result['message'] = array("error" => $uore . " not recognized as a username or an email address.");
                }
            } else if (trim($uore) == "") {
                $result['message'] = array("error" => "Please enter username or email");
            }
        }
        return $result;
    }

    /**
     * This function validates link. If link is false then it will return false
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function isValidLink() {
        $link = $this->uri->segment('3');
        $dt = urldecode(unserialize(base64_decode($link)));
        $date = substr($dt, strpos($dt, "/") + 1, strlen($dt));
        $uid = substr($dt, 1, strpos($dt, "/") - 1);
        $linkDt = date('Y-m-d H:i:s', strtotime('+2 hours', strtotime($date)));
        $currentDt = date('Y-m-d H:i:s');
        //$currentDt = date('2018-10-05 00:00:00'); 
        if (strtotime($linkDt) >= strtotime($currentDt)) {
            return $uid;
        } else {
            return 0;
        }
    }

    /**
     * Function updates the password
     * @author Kushan Antani <kushan.datatechmedia@tgmail.com>
     */
    public function updatePassword() {
        $pwd = Utility::encryptPass($this->input->post('password'));
        $uid = $this->input->post('uid');
        $this->db->where('id', $uid);
        $this->db->update($this->userTable, array('updated_date' => date('Y-m-d H:i:s'), 'password' => $pwd, 'updated_by' => $uid));
        $this->session->set_tempdata('message', array('success' => 'Password is changed successfully'), 60000);
        redirect('user/login');
        exit;
    }

    /**
     * Get all users for parts admin
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function getUsers() {
        $id = getUserInfo("id");
        $this->db->select("id,name,surname,email");
        $this->db->from($this->userTable);
        $this->db->where('id!=', $id);
        $this->db->where('role_id!=', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Saves user data
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function saveUser() {
        $this->isAdmin = isAdmin();
        /* Enable it for server side validation
        if($this->checkUniqueUsername($this->input->post('username'),$this->input->post('uid'))==false) {
            saveMessage(array('error' => 'Public username already in use, Please enter another username'));
            return false;
        } else if($this->checkUniqueEmail($this->input->post('email'),$this->input->post('userid'))==false) {
            saveMessage(array('error' => 'Email already in use. Please enter other email'));
            return false;
        } else {*/ 
                $isUserLoggedIn=isUserLoggedIn();
                $arrField=array();
                $arrField['name']=$this->input->post('name');
                $arrField['surname']=$this->input->post('surname');
                $arrField['business_name']=$this->input->post('business_name');
                if($isUserLoggedIn==false ){
                    $arrField['username']=$this->input->post('username');
                } else if( $this->isAdmin==true && $this->input->post('uid')==""){
                     $arrField['username']=$this->input->post('username');
                }
                $arrField['password']=Utility::encryptPass($this->input->post('password'));
                $arrField['email']=$this->input->post('email');
                $arrField['phone']=$this->input->post('phone');
                $arrField['address']=$this->input->post('address');
                $arrField['suburb']=$this->input->post('suburb');
                $arrField['postcode']=$this->input->post('postcode');
                $arrField['state']=$this->input->post('state');
                $arrField['website']=$this->input->post('website');
                $arrField['abn']=$this->input->post('abn');
                $arrField['business_logo']=$this->input->post('main_image');
                $arrField['role_id']=2;
              
                //Update Data
                if($this->input->post('uid')!="") { 
                    $arrField['updated_date'] = date("Y-m-d H:i:s");  
                    if($isUserLoggedIn==true){
                        $arrField['updated_by'] = getUserInfo("id");  
                    }
                    Query::updateData($this->userTable,$arrField,array('id' => (int) $this->input->post('uid')));  
                     if($this->isAdmin==true)
                           saveNotification($arrField['updated_by'],0,"profile_updated","id=".$this->input->post('uid'),'user');
                     
                    return (int) $this->input->post('uid');
                } else { 
                    $arrField['created_date'] = date("Y-m-d H:i:s");
                    if($isUserLoggedIn==true){
                        $arrField['created_by'] = getUserInfo("id");  
                    }
                    $id=Query::insertData($this->userTable,$arrField);   
                    $subject="Account Created For ".$this->config->item("site_name"); 
                    $content="<strong>Hello ".$arrField['name']." ".$arrField['surname'].",</strong><br /><br />";
                    $content.="Thank you for registering at ".$this->config->item("site_name").".<br /><br />Your account is created and activated.<br /><br />You can login to your account by clicking on the following link or copy-paste it in your browser:<br /><br />".setLink('user/login')."<br /><br />You may login using the following username and password:<br /><br /><strong>Username:</strong> ".$arrField['username']."<br /><strong>Password:</strong> Your choosen Password";
                    $contentData=Utility::loadTemplate($subject, $content);
            
                    Utility::sendMail($arrField['email'],$this->config->item("site_name"), $this->config->item("site_email"), $subject, $contentData);
                    if($this->isAdmin==true)
                        saveNotification($id,0,"account_created","",'user');
                    else 
                        saveNotification($id,0,"user_register");
                    return $id; 
                } 
            
    }
    /**
     * Function check unique user name
     * @param type $username
     * @param type $uid
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function checkUniqueUsername($username, $uid = '') {
      $this->db->select("name")->from($this->userTable)->where('username',$username);  
        if (isset($uid) && $uid != '') {
            $this->db->where('id!=',$uid);
        }
        $query =$this->db->get();
        $checkUser = $query->row_array();
        if (!empty($checkUser['name'])) {
            echo "false";
        } else {
            echo "true";
        }
    }
    /**
     * Checks unique email
     * @param type $email
     * @param type $uid
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function checkUniqueEmail($email, $uid = '') {
         $this->db->select("email")->from($this->userTable)->where('email',$email); 
          if (isset($uid) && $uid != '') {
            $this->db->where('id!=',$uid);
        } 
         $query =$this->db->get();
        $checkUser = $query->row_array();
        if (!empty($checkUser['email'])) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    public function getSingleData($id=""){
        if($id==""){
            $id=getUserInfo("id");
        } 
        $query=$this->db->select("id,name,surname,business_name,username,password,email,phone,address,suburb,postcode,state,website,abn,business_logo")->from($this->userTable)->where("id",$id)->get();
        $userData=$query->row_array();
        $userData['password']=Utility::decryptPass($userData['password']);
        return $userData;
                
    }
    /**
     * Get User List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_list(){
          $data = array();
        //Create Query
        $this->db->select('id,name,surname,email,phone,business_name,username,status');
        $this->db->from($this->userTable);
        $this->db->where('role_id!=',1);
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('surname', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
            $this->db->or_like('username', $search);
            $this->db->or_like('business_name', $search);
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
    
    public function get_transaction_list() {
        $data = array();
        //Create Query
        $this->db->select('id,uid,parts_name,name,email,phone,payment_mode,transcation_id,DATE_FORMAT(payment_date, "%d/%m/%Y %h:%I:%s %p") as payment_date,payment_status,total');
        $this->db->from(Query::$parts_payment);
        
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            if(isAdmin()){
                $this->db->like('name', $search); 
                $this->db->or_like('email', $search);
                $this->db->or_like('phone', $search);  
            } 
            $this->db->or_like('parts_name', $search);  
            $this->db->group_end();
        }
        if(!isAdmin()){
            $this->db->where("uid",getUserInfo("id"));
        }
          $dateFrom = $dateTo = "";
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
        $colDate = "date(payment_date)";
        if ($dateTo != "" && $dateFrom != "") {
            if ($dateTo == $dateFrom) {
                $this->db->group_start();
                $this->db->where($colDate . "=", date('Y-m-d', strtotime($dateFrom)));
                $this->db->group_end();
            } else {
                $this->db->group_start();
                $this->db->where($colDate . ">=", date('Y-m-d', strtotime($dateFrom)));
                $this->db->where($colDate . "<=", date('Y-m-d', strtotime($dateTo)));
                $this->db->group_end();
            }
        } else if ($dateFrom != "" && $dateTo == "") {
            $this->db->group_start();
            $this->db->where($colDate . ">=", date('Y-m-d', strtotime($dateFrom)));
            $this->db->group_end();
        } else if ($dateTo != "" && $dateFrom == "") {
            $this->db->group_start();
            $this->db->where($colDate . "<=", date('Y-m-d', strtotime($dateTo)));
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
         
        $data['show_page'] = $currentPage;
        $data['totalCount'] = Utility::getPageCount($totalCount,$this->pageCount);
        
         /**
         * Prepare row for search session data if exists in session
         * @author Kushan Antani <kushan.datatechmedia@gmail.com>
         */
        $searchDataSession = Utility::setSearchSession("transaction");
        if ($searchDataSession != "")
            $data['searchSession'] = $searchDataSession;
        
        if ($this->input->get('isAjax') != "") {
            // $query['totalCount'] = $this->db->count_all_results($this->tblName);
            echo json_encode(array("data" => $query->result(), "totalCount" => $data['totalCount']));
            exit;
        }
        return $data;
    }
    
      /**
     * Get Free User's Dashboard Payment and Enquiry Data 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
     public function getFreeUserData($obj) { 
         $dashboardObj = new stdClass();
         $userID = getUserInfo("id");
         $queryData=$this->db->select("id,uid,parts_name,payment_mode,payment_date,transcation_id,total")->from(Query::$parts_payment)->where("uid",$userID)->order_by("id","DESC")->limit(5)->get();
         $dashboardObj->transactionData = $queryData->result();
         $queryEnqData=$this->db->select("parts_name,name,email,phone")->from(Query::$parts_enquiry)->where("parts_created_by",$userID)->order_by("id","DESC")->limit(5)->get();
         $dashboardObj->enquiryData = $queryEnqData->result();
         return $dashboardObj;
     }


}
