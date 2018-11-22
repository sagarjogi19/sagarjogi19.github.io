<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Defines user session key
 * @auhtor Kushan Antani <kushan.datatechmedia@gmail.com>
 */
define('user_session', 'user_login');

/**
 * Return CodeigniterObj used to access config variables or call view from helper
 * @return type Object
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function setCodeigniterObj() {
    $CI = & get_instance();
    return $CI;
}

/**
 * Returns Theme path
 * @return type
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function getTemplateLivePath() {
    return base_url() . "theme";
}

function loadTemplate($data) {
    $CI = setCodeigniterObj();
    $CI->load->view('index', $data);
}

/**
 * Set internal link
 * Pass controller/method in argument. example: user/login
 * @author Kushan <kushan.datatechmedia@gmail.com>
 * */
function setLink($url) {
    if ($url != "")
        return base_url() . $url;
    else
        return "";
}

/**
 * Set page title and heading
 * @author Kushan <kushan.datatechmedia@gmail.com>
 * */
function setTitle($title) {
    if (!isset($title)) {
        $title = "Worthy Parts";
    }
    return $title;
}

/**
 * Footer Category Icons
 * Right now machine category icons are shown in future it will be update
 * @author Kushan <kushan.datatechmedia@gmail.com> 
 * */
function footerIcons() {
     $CI = setCodeigniterObj();
     $CI->load->model('mcategory_model');
     return $CI->mcategory_model->fetchCategoryTree($CI->mcategory_model->tblName, '', '', '', '', 'active');
}

/**
 * Common function for setting template data
 * @param type $template
 * @param type $pageTitle
 * @param type $modelData
 * @return type
 */
function setTemplateData($template, $pageTitle = "", $modelData = array()) {
    $data = array("template" => $template, "title" => $pageTitle, "formData" => $modelData);

    return $data;
}

/**
 * Common Message Block for all site
 * @param type $message
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function showMessage($message="") {
          $status="";
          $CI = setCodeigniterObj();
       if(isset($message) && is_array($message)) {
       $status=key($message); 
       } else if($CI->session->has_userdata('message')) {
           $message=$CI->session->userdata('message');
           $status=key($message); 
           $CI->session->unset_userdata('message');
       }
       $class="error";
       if($status=="success"){
           $class="status";
        }
    ?>
    <div class="container">
        <div class="row">
            <div class="message">
                   <?php if(isset($message) && is_array($message)) { ?>
                    <div  class="messages messages--<?php echo $class; ?>">
                        <?php  echo $message[$status];  ?>
                    </div>
                   <?php } ?>
                </div>
            </div> 
        </div>
<?php
}

/**
 * Common function to load logo in entire site
 * @params $options provide option to view different logo for email / invoice
 * @author Kuahan Antani <kushan.datatechmedia@gmail.com>
 */
function getLogo($option = array()) {
    return getTemplateLivePath() . '/images/logo.png';
}

/**
 * Overwrite data variable to Show message if $result error / success 
 * @param type $result
 * @param type $data overwrite data variable
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function setMessage($result, &$data) {
    $CI = setCodeigniterObj();
    if (count($result) != 0) {
        $data[key($result)] = $result[key($result)];
    }
    $getSessionData = $CI->session->userdata('message');
    $CI->session->unset_userdata('message');
    if ($getSessionData) {
        $data['message'][key($getSessionData)] = $getSessionData[key($getSessionData)];
    }
}

/**
 * Over data variable to set meta title, keyword and description if provided also function set no index, no follow if no index is set to 1
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function setMeta(&$data, $title = "", $description = "", $keyword = "", $noindex = 0) {
    $CI = setCodeigniterObj();
    $siteName = $CI->config->item('site_name');
    if ($title != "") {
        $data['meta_title'] = $title;
    } else {
        $data['meta_title'] = $siteName;
    }
    if ($description != "") {
        $data['meta_description'] = $description;
    } else {
        $data['meta_description'] = $siteName;
    }
    if ($keyword != "") {
        $data['meta_keywords'] = $keyword;
    } else {
        $data['meta_keywords'] = $siteName;
    }
    if ($noindex == 1) {
        $data['no_index'] = true;
    }
}

/**
 * Set user session
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function setUserInfo($userData) {
    $CI = setCodeigniterObj();
    $CI->session->set_userdata(user_session, $userData);
}

/**
 * Get user session data
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function getUserInfo($info="") {
    $currentUser = array();
    if (isUserLoggedIn() == true) {
        $CI = setCodeigniterObj();
        $userData = $CI->session->userdata(user_session);
        $currentUser = $userData[key($userData)];
        if($info!=""){
           return $currentUser->$info; 
           //return $currentUser[$info];
        }
    }
    return $currentUser;
}

/**
 * Checks User Logged In or not
 * @return bool
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function isUserLoggedIn() {
    $CI = setCodeigniterObj();
    $flg = $CI->session->has_userdata(user_session);
    if ($flg == true) {
        $arr = $CI->session->userdata(user_session);

        if (count($arr) == 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return $flg;
    }
}

/**
 * Checks Logged In User is admin or not
 * @return boolean
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function isAdmin() {
    $currentUser = getUserInfo();
    if(empty($currentUser)){
        return false;
    }
    if ($currentUser->role_id == 1) {
        return true;
    }
    return false;
}

/**
 * Checks Logged In User is Free User or not
 * @return boolean
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function isFreeUser() {
    $currentUser = getUserInfo();
    if ($currentUser->role_id == 2) {
        return true;
    }
    return false;
}

/**
 * Logout single or multiple user
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function logout($all = 0) {
    $CI = setCodeigniterObj();
    if ($all == 1) {
        //Logout All Users
        unset_userdata(user_session);
    } else {
        //Logout Single User 
        $userData = $CI->session->get_userdata(user_session);
        unset($_SESSION[user_session][key($userData[user_session])]);
    }
}

/**
 * Set current class
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function setCurrentClass($link, $currentClass = "") {
    $CI = setCodeigniterObj();
    $currentURL = $CI->uri->uri_string();
    if (is_array($link) && in_array($currentURL, $link)) {
        echo $currentClass;
    } else if ($currentURL == $link) {
        echo $currentClass;
    }
}

function saveMessage($message){
     $CI = setCodeigniterObj();
     $CI->session->set_userdata('message',$message);  
}

function unsetMessage($data){
     $CI = setCodeigniterObj();
     if($CI->session->has_userdata('message')){
        $data['message']=$CI->session->userdata('message');  
        $CI->session->unset_userdata('message');
        return $data;
     }
     return $data;
}
/**
 * Show Top and Bottom Buttons
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function displayButton($form,$backLink,$showSave=true){
       $CI = setCodeigniterObj();
       $CI->load->view('user/buttons',array('form'=>$form,'backLink'=>$backLink,'showSave'=>$showSave));
}

/**
 * State Array
 */
function getState() {
    return array('New South Wales','Victoria','Western Australia','Queensland','South Australia','Tasmania','Northern Territory','Australian Capital Territory');
}

/**
 * Enable Trash or not
 * @author  Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function setTrash(){
     $CI = setCodeigniterObj();
     if($CI->input->get('show')=="trash"){
            return "trash";
        }  
        return "list";
}

/**
 * Display Formatted Phone Number
 * @param type $val
 * @param type $type
 * @return type
 * @author  Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function formatPhone($val,$type="phone"){
        $finalData="";
        $val = trim(str_replace(' ','',$val));
        if(substr($val,0,2)=="08" || substr($val,0,2)=="02"){
            $finalData=substr($val,0,2)." ".substr($val,2,4)." ".substr($val,6,4);
        } else {
            $finalData=substr($val,0,4)." ".substr($val,4,3)." ".substr($val,7,3);
        }
        return trim($finalData);
  }
  
  /**
 * Filter Data
 * Get Category and region
 * @author Sagar Jogi <sagarjogi.datatech@gmail.com> 
 * */
function filterData() {
     $CI = setCodeigniterObj();
     $CI->load->model('front_model');
     return $CI->front_model->fetchCategoryRegion();
}

/***
 * Saves Notification (Action)
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function saveNotification($uid,$parts_id,$description,$param="",$foruser='admin',$overwriteAction="")
{ 
  $CI = setCodeigniterObj();  
  $param =($param!="")?"?".$param:"";
  $data = array();
  $data['user_id'] = $uid;
  $data['parts_id'] = $parts_id;
  $data['description'] = $description; 
  if($overwriteAction!="")
      $data['url_param']=$overwriteAction;
  else
      $data['url_param'] = $CI->uri->uri_string().$param;
  $data['created_date'] = date("Y-m-d H:i:s");
  $data['status'] = '0';
  $data['for_user'] = $foruser; 
  Query::insertData(Query::$notification,$data);
}
/**
 * Get Payment Method Label
 * @author Kushan Antanti <kushan.datatechemdia@gmail.com>
 */
function paymentMethod($key=""){
    $methods=array("ADMIN_PAY" =>"Paid By Admin","PAYPAL_HOSTED_SOLUTIONS" =>"Paypal Hosted Solutions","PAYPAL_EXPRESS" =>"Paypal Express Checkout");
    if($key=="") {
        return $methods;
    }      
    return $methods[$key];
}