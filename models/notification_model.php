<?php

/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

    public $tblName;
    public $pageCount = 10;
    public $module = "notification";
    public $currentUser; 
    
    public function __construct() {
        $this->tblName = Query::$notification;
        $this->currentUser = getUserInfo("id"); 
    }

    /**
     * Get Enquiry List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_admin_list() {
        $data = array(); 
        $this->db->select('n.id,name,surname,business_name,description,url_param,DATE_FORMAT(n.created_date, "%d/%m/%Y %h:%I:%s %p") AS created_date,n.status');
        $this->db->from($this->tblName . " as  n");
        $this->db->join(Query::$user_profile." as u","n.user_id=u.id","left");
        
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('name', $search); 
            $this->db->or_like('surname', $search);
            $this->db->or_like('business_name', $search);
            $this->db->group_end();
        }
      
        
        if($this->input->get("isAjax")==true) { 
            $_GET['show']=$this->session->userdata("show_notification");
        } else {
              $this->session->set_userdata("show_notification",$this->input->get('show'));
        }    
        
        if(!isAdmin()){
            $this->db->group_start();
            $this->db->where('user_id',$this->currentUser);
            $this->db->group_end();
        } else {
             $this->db->group_start();
            $this->db->where('for_user',"admin");
            $this->db->group_end();
        }
          if($this->input->get('show')!=""){
            $status=$this->input->get('show');
            $this->db->group_start();
            if($status=='approved'){
                $this->db->where('n.status',"1");
            }else {
                $this->db->where('n.status',"0"); 
            }
            $this->db->group_end();
        } else {
            $this->db->limit(10);
        }
        //echo $this->db->get_compiled_select(); exit;
        $tempdb = clone $this->db; 
          $totalCount=$tempdb->count_all_results();
        //Set Sort order
        if ($this->input->get('sort') != "") {
            $sort = Query::setSortOrder($this->input->get('sort'));
            $this->db->order_by($sort['col'], $sort['value']);
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
        $data['totalCount'] = Utility::getPageCount($totalCount, $this->pageCount);

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
  
    public function messageInfo($key=""){
       $messageData = array(
           "user_register" => "User is registered",
           "account_created" =>"Account is created",
           "profile_updated" =>"Profile is updated",
           "parts_added_by_admin" =>"New Part is created",
           "parts_updated_by_admin" =>"Part is updated",
           "parts_added_by_user" =>"New Part is created",
           "parts_updated_by_user" =>"Part is updated",
           
       ); 
       if($key!="") 
         return  $messageData[$key]; 
       
       return $messageData;
        
    }
    
    public function menu_list(){
        $data = array(); 
        $this->db->select('n.id,name,surname,business_name,description,url_param,DATE_FORMAT(n.created_date, "%d/%m/%Y %h:%I:%s %p") AS created_date,n.status');
        $this->db->from($this->tblName . " as  n");
        $this->db->join(Query::$user_profile." as u","n.user_id=u.id","left");
        $this->db->where('n.status','0');
        if(isAdmin()){
           $this->db->where('n.for_user','admin'); 
        } else {
            $this->db->where('n.user_id',$this->currentUser);
        }
        $this->db->order_by('n.id','DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        $notification = $query->result();
        return $notification;
    }
    public function clearAll(){
	 try{	
		$userRole = isAdmin();
		$data['status']='1';
		if ($userRole == true) {
			Query::updateData($this->tblName,$data,array('for_user'=>'admin')); 
		} else { 
                         Query::updateData($this->tblName,$data,array('user_id'=>$this->currentUser)); 
		}
		 echo "success";	
	 } catch(Exception $e){
		 echo "fail";
	 }
	}

}
