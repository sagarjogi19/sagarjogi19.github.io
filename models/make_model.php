<?php
/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Make_model extends CI_Model {

    public $tblName;
    public $tblModelName;
    public $pageCount = 10;
    public $module="make";
    public $modelSession ="model_id";
    public function __construct() {
        $this->tblName = Query::$make;
        $this->tblModelName = Query::$model;
    }

    /**
     * Get Make List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_list() {
        $data = array(); 
        $this->db->select('id,make,status');
        $this->db->from($this->tblName);
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('make', $search);
            $this->db->group_end();
        }
         $tempdb = clone $this->db; 
          $totalCount=$tempdb->count_all_results();
        //Set Sort order
        if ($this->input->get('sort') != "") {
            $sort = Query::setSortOrder($this->input->get('sort'));
            $this->db->order_by($sort['col'], $sort['value']);
        } else {
            $this->db->order_by('id','desc');
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
    
       public function saveData(){ 
           
         //Initalize variables
         $status='0';
        if($this->input->post('status')!=""){
            $status=$this->input->post('status');
        }
        $arrFieled = array(
                'make' => ($this->input->post('make')!= "") ?$this->input->post('make') : "", 
                'status' =>$status
            ); 
       
        $make = array(); 
        
        $userID = getUserInfo('id');
        $id= $this->input->post('id');
        //Check for request
        $name = $this->input->post('make');
    
            if ($this->input->post('is_edit') == '0' && $this->input->post('make') != '') {
               $arrFieled['created_date'] = date("Y-m-d H:i:s");
               $arrFieled['created_by'] = $userID; 
               $arrFieled['make_alias']=Utility::getSlug($this->input->post('make'), 0, $this->tblName,  "make_alias");
               $id=Query::insertData($this->tblName,$arrFieled);
            } else { 
                $arrFieled['updated_date'] = date("Y-m-d H:i:s");
                $arrFieled['updated_by'] = $userID;
                $id = $this->input->post('is_edit');
                $arrFieled['make_alias']=Utility::getSlug($this->input->post('make'), $id, $this->tblName,  "make_alias");
                Query::updateData($this->tblName,$arrFieled,array('id' => $id));
                
            }
            $this->saveModel($id,$userID);
            return $id;

    }
    
    public function saveModel($id,$userID){
       
        $modelRequest=$this->input->post('model');
        $cntModel=count($modelRequest);
        if($cntModel > 0){
            for($m=0;$m<$cntModel;$m++){
                if($modelRequest[$m]!=""){
                 $data=array();
                $data['model']=$modelRequest[$m];
                 $data['model_alias']=Utility::getSlug($modelRequest[$m], 0, $this->tblModelName,  "model_alias");
                $data['make_id']=$id;
                $data['created_date'] = date("Y-m-d H:i:s");
                $data['created_by'] = $userID;
                Query::insertData($this->tblModelName,$data);
                }
            }
        }
    }

    /**
     * Fetches Single Record
     * @param type $id
     * @return type
     */
    public function getSingleData($id) {
        //Initalize variables  
        $make = array();
        if ($this->input->get('page') != "") {
            $make['page'] = $this->input->get('page');
        }
        $this->db->select('id,make,status');
        $this->db->from($this->tblName);
        $this->db->where('id',$id);
        $query = $this->db->get();
   
        $make['makeData'] = $query->row_array();
          
        return $make;
    }
     
     /**
     * Check for unique make
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function checkUniqueMake(){
        $query="";
        if((int)$this->input->post('id')!=0){
           $this->db->where('id!=',$this->input->post('id'));
        }
        $make=$this->input->post('make');
          
        if($make!=""){  
        $this->db->like('make',$make);
        $this->db->from($this->tblName);
        $makeData=$this->db->count_all_results();
          if($makeData==0){
                echo "true";
                exit;
            }  
        }
         echo "false";
         exit;
    }
    
        /**
     * Check for unique model
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function checkUniqueModel($flag=false){
        $statusFlag="";
        if((int)$this->input->post('id')!=0){
           $model=strtolower($this->input->post('modelData'));
           if($model!=""){  
              $this->db->where('lower(model)',$model);
              $this->db->where('make_id',$this->input->post('id'));
              $this->db->from($this->tblModelName);  
             $modelData=$this->db->count_all_results(); 
       
             if($modelData==0){
                $statusFlag="true";
            } else {
                $statusFlag="false";
            }
        }
         
        } else {
            $statusFlag="true";
        }
        if($flag==false){ 
            echo $statusFlag;
            exit;
        } 
        return $statusFlag;
    }
      /**
     * Get All Data for Grid 
     * @global type $base_url
     * @return array
      * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function getModelList() {  
        $model = array();
        $this->db->select('id,model');
        $this->db->from($this->tblModelName); 
         
        $params = array();
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        $listingId=$this->input->get('id');
        $model_id=$this->session->userdata($this->modelSession);
        if(isset($_REQUEST['makeid']) && $_REQUEST['makeid']!=""){
           $listingId=$_REQUEST['makeid']; 
        }else if(isset($model_id) && $model_id!=""){
            $mData=json_decode($model_id,true);
            $listingId=$mData['makeid'];
        }
        
       $this->db->where('make_id',$listingId); 
        if ($search != "") { 
            $this->db->group_start();
            $this->db->like('model',$search);
            $this->db->group_end(); 
        }
        $tempdb = clone $this->db;
        
          $totalCount=$tempdb->count_all_results();
         //Set Sort order
        if ($this->input->get('sort') != "") {
            $sort = Query::setSortOrder($this->input->get('sort'));
            $this->db->order_by($sort['col'], $sort['value']);
        } else {
            $this->db->order_by('id','desc');
        }
        
        //Set Table Limit
        $limit = 0;
        $this->pageCount = Query::setPageCount($this->input->get('limit'), $this->pageCount);
        
        $currentPage = (int) $this->input->get('page');
        if ($currentPage != 0)
            $limit = Query::setLimit($currentPage, $this->pageCount);

      
        $this->db->limit($this->pageCount, $limit);
        
        $qry=$this->db->get();
 
        $row['data']=$qry->result(); 
        /** Set current page **/
        $model['show_page'] = $this->input->get('page');
         $row['totalCount']=Utility::getPageCount($totalCount,$this->pageCount);
           /**
         * Prepare row for search session data if exists in session
         * @author Kushan Antani <kushan.datatechmedia@gmail.com>
         */
        $searchDataSession = Utility::setSearchSession($this->modelSession);
        if ($searchDataSession != "")
            $row['searchSession'] = $searchDataSession;  
          
        /**
         * Check for request if there is ajax request if it is ajax request then pull data 
         */
        if ($this->input->get('isAjax') != "") { 
            echo json_encode($row);
            exit;
        } 
         
        return $row;
    }
    
      public function updateModel(){
        if($this->checkUniqueModel(true)=="true"){
         $userID = getUserInfo("id");   
         $data=array();
         $data['model']=$this->input->post('modelData');
         $data['model_alias']=Utility::getSlug($this->input->post('modelData'),(int) $this->input->post('modelid'), $this->tblModelName,  "model_alias");
         $data['updated_date'] = date("Y-m-d H:i:s");
         $data['updated_by'] = $userID;
         Query::updateData($this->tblModelName,$data,  array('id' => (int) $this->input->post('modelid')));
         echo "1";
        } else {
            echo "0";
        }
        exit;
    }
    
     /**
     * Delete record with single or multiple record
     */
    public function deleteModel($id){
       
        if($id!=""){ 
            Query::deleteData($this->tblModelName,array('id' => (int) $id)); 
        }  
    }
    public function handleRequest(){
               if($this->input->get('id')!=""){
             $delId=$this->input->get('id');
                if(strpos($delId,"@")!==false){
                    $this->deleteModel(substr($delId,0,strpos($delId,"@")));
                    exit;
                }
            }
         if (count($this->input->get('bulk')) != 0) {
              foreach($this->input->get('bulk') as $bK=>$bV){
                  $delId=$bV['value'];
                  if(strpos($delId,"@")!==false){
                       $this->deleteModel(substr($delId,0,strpos($delId,"@"))); 
                  } 
              } 
               exit;
         } 
         if ($this->input->post('action') != "") {
              $this->updateModel(); 
          }
         if ($this->input->post('checkMake') != "") {
              $this->checkUniqueMake(); 
          }
          if ($this->input->post('checkModel') != "") {
              $this->checkUniqueModel(); 
          }  
       
    }
    
    public function getAllMake(){
         $this->db->select('id,make');
         $this->db->from($this->tblName); 
         $this->db->order_by('make','asc');
         $query = $this->db->get();
         return $query->result_array();
    }
    
   public function loadModelFromMake($id="",$slug=""){
        $this->db->select('id,model');
         $this->db->from($this->tblModelName);
         if($id!="")
            $this->db->where('make_id',$id);
         else if($slug!="")
            $this->db->where('slug',$slug);
         
         $this->db->order_by('model','asc');
         
         $query = $this->db->get();
         return $query->result_array();
   }

}
