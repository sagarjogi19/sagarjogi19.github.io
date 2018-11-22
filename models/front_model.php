<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Front_model extends CI_Model {
    
    //Remeber Me Functionality cookie name
    public $remeberMeCookieName="remember_user";
    
    //User profile table
    public $userTable="user_profile";
    
     public function __construct() {

    }
      /*
     * Search Filter
     * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
     */
     public function fetchCategoryRegion() {
        
//       $orderBy = ' order by id desc ';
      $this->db->select('id, category_name, parent_id, category_alias as alias, parent_category_name, category as category_id, state, suburb'); 
      $this->db->from(Query::$parts_list);   
      $this->db->order_by('id', 'desc');
      $data=$this->db->get()->result_array();
      
//      $data = DB::query("SELECT id, category_name, parent_id, category_alias as alias, parent_category_name, category as category_id, state, suburb  FROM machine_list " . $orderBy);

      $category = array();
      $regions = array();
      
      foreach ($data as $k => $v) {
         
         //category
         if ($v['parent_id'] > 0) {
	 if (isset($subCategory[$v['parent_id']][$v['alias']])) {
	    $subCategory[$v['parent_id']][$v['alias']]['cat_cnt'] ++;
	 } else {
	    $subCategory[$v['parent_id']][$v['alias']] = array('cat_name' => $v['category_name'], 'sef_cat' => $v['alias'], 'parent_id' => $v['parent_id'], 'cat_cnt' => 1);
	    $category[$v['parent_id']] = array('cat_name' => $v['parent_category_name'], 'sef_cat' => '', 'parent_id' => '', 'cat_cnt' => 0);
	 }
         } else {
	 if (isset($category[$v['category_id']])) {
	    $category[$v['category_id']]['cat_cnt'] ++;
	 } else {
	    $category[$v['category_id']] = array('cat_name' => $v['category_name'], 'sef_cat' => $v['alias'], 'parent_id' => $v['parent_id'], 'cat_cnt' => 1);
	 }
         }

         //region
         if (isset($regions[$v['state']][str_replace('-', '_', Utility::getCleanSlugString($v['suburb']))])) {
	 $regions[$v['state']][str_replace('-', '_',Utility::getCleanSlugString($v['suburb']))]['region_cnt'] ++;
         } else {
	 $regions[$v['state']][str_replace('-', '_', Utility::getCleanSlugString($v['suburb']))] = array('sef_region' => str_replace('-', '_', Utility::getCleanSlugString($v['suburb'])), 'region_name' => $v['suburb'], 'region_cnt' => 1);
         }
      }
      $finalArr = array();
      
      $finalArr['categories'] = array('cat' => $category, 'subcat' => $subCategory);
      $finalArr['region'] = $regions;
      return $finalArr;
    } 
    /*
     * get blog data
     * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
     */
    public function getBlogData() {
        $this->db->set_dbprefix(Query::$blog_prefix);
         $this->db->select("p1.id,p1.post_title,p1.post_name,p1.post_content,DATE_FORMAT(p1.post_date,'%b %d, %Y') as post_date,p1.guid,wm2.meta_value"); 
         $this->db->from(Query::$blog_prefix . "posts as p1 ");
         $this->db->join(Query::$blog_prefix.'postmeta as wm1',"wm1.post_id = p1.id AND wm1.meta_value IS NOT NULL AND wm1.meta_key = '_thumbnail_id'",'left' );
         $this->db->join(Query::$blog_prefix.'postmeta as wm2',"wm1.meta_value = wm2.post_id AND wm2.meta_key = '_wp_attached_file' AND wm2.meta_value IS NOT NULL",'left' );
         $this->db->where(" p1.post_status='publish' AND p1.post_type='post'");
         $this->db->order_by('p1.post_date', 'desc');
         $this->db->limit(3);
         
         $data=$this->db->get()->result_array();
         $this->db->set_dbprefix(Query::$site_prefix);
         return $data;
    }
    /* get testimonial data
     * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
     */
    public function getTestimonialData() {
         $this->db->select("*"); 
         $this->db->from(Query::$testimonial);
         $this->db->where("status='1'");
         $this->db->order_by('sort_order', 'desc');
         $this->db->limit(6);
         $data=$this->db->get()->result_array();
         return $data;
    }
    /* get featured data
     * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
     */
    public function getFeaturedData() {
         $this->db->select("id,part_name,alias,main_image"); 
         $this->db->from(Query::$parts);
         $this->db->where("status='1' and is_trash='0' and approved='1' and is_featured='1'");
          $this->db->order_by('id', 'desc');
         $this->db->limit(15);
         $data=$this->db->get()->result_array();
         return $data;
    }
   /**
    * Send forgot password link to user if user email / user name matches or return error
    * @author Kushan Antani <kushan.datatechmedia@gmail.com>
    */
    public function sendForgotPwdLink(){
         //Set variable
         $result = array();
         if ($this->input->method() === 'post') {
             $uore = $this->input->post('email'); 
             if($uore!=""){
                 $this->db->select("id,email,status");
                 $this->db->from($this->userTable);
                 $this->db->where("email",$uore);
                 $this->db->or_where("username",$uore);
                 $query = $this->db->get();
                 $userData = $query->row();
                 if (count($userData) == 1) {
                     $CI =setCodeigniterObj();
                     $siteName = $CI->config->item('site_name');
                     $siteFromEmail = $CI->config->item('site_email');
                     $link = setLink('user/reset-password')."/".urldecode(base64_encode(serialize("@".$userData->id."/".date('Y-m-d H:i:s')))); 
                     $subject = " Password Reset Request For ".$siteName;
                     $content = "A request to reset the password for your account has been made at ".$siteName;
                     $content .= "<br><br>You may now reset password by clicking this link or copying and pasting it into your browser";
                     $content .= "<br><br><a href='".$link."'>".$link."</a>";
                    echo Utility::loadTemplate($subject,$content); exit;
                 } else {
                     $result['message'] = array("error" => $uore." not recognized as a username or an email address.");
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
        $dt=urldecode(unserialize(base64_decode($link))); 
        $date=substr($dt,strpos($dt,"/")+1,strlen($dt)); 
        $uid=substr($dt,1,strpos($dt,"/")-1);
        $linkDt=date('Y-m-d H:i:s', strtotime('+2 hours', strtotime($date)));
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
   public function updatePassword(){
       $pwd = Utility::encryptPass($this->input->post('password'));
       $uid = $this->input->post('uid'); 
       $this->db->where('id', $uid);
       $this->db->update($this->userTable,array('updated_date'=>date('Y-m-d H:i:s'),'password'=>$pwd,'updated_by' => $uid));
       $this->session->set_tempdata('message',array('success'=>'Password is changed successfully'), 60000); 
       redirect('user/login');
       exit;
   } 
   
   /**
    * Get all users for parts admin
    * @author Kushan Antani <kushan.datatechmedia@gmail.com>
    */
   public function getUsers(){
       $id=getUserInfo("id");
       $this->db->select("id,name,surname,email" );
       $this->db->from($this->userTable);
       $this->db->where('id!=',$id);
       $this->db->where('role_id!=',1);
        $query=$this->db->get(); 
       return $query->result_array();
   }

}
