<?php

/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcategory_model extends CI_Model {

    public $tblName;
    public $pageCount = 10;
    public $module="category";
    public function __construct() {
        $this->tblName = Query::$machine_category;
    }

    /**
     * Get Cateogory List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_list() {
        $data = array();
        //Create Sub-Query
        $this->db->select('category_name');
        $this->db->from($this->tblName);
        $this->db->where('id=a.parent_id', NULL, FALSE);
        $subQuery = $this->db->get_compiled_select();

        //Create Query with Sub Query 
        $this->db->select('id,(' . $subQuery . ') as parent_category,category_name, parent_id,sort_order,status');
        $this->db->from($this->tblName . " a");
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('category_name', $search);
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
    
    public function saveData(){
         $arrFieled = array(
                'parent_id' => ($this->input->post('parent_id')!= "") ?$this->input->post('parent_id') : 0,
                'category_name' => $this->input->post('category_name'),
                'image_name' => $this->input->post('image_name'),
                'image_name_hover' => $this->input->post('image_name_hover'),
                'status' => $this->input->post('status')
            );
       
        $id = "";
     
            if ($this->input->post('edit') == '1' && $this->input->post('category_id') != '') {
                $arrFieled['alias'] =  Utility::getSlug($this->input->post('category_name'), $this->input->post('category_id'), $this->tblName );
                $arrFieled['sort_order'] = $this->input->post('sort_order') != '' ? $this->input->post('sort_order') : Utility::getMaxId($this->tblName);
                $arrFieled['updated_by'] = 1;
                $arrFieled['updated_date'] = date("Y-m-d H:i:s");  
                Query::updateData($this->tblName,$arrFieled,array('id' => $this->input->post('category_id')));
                $id = $this->input->post('category_id');
            } else {
                $alias=$this->input->post('category_name');
                if($this->input->post('alias')!=""){
                    $alias = $this->input->post('alias');
                }
                $arrFieled['alias'] = Utility::getSlug($alias, 0, $this->tblName);
                $arrFieled['sort_order'] = $this->input->post(sort_order)!= '' ? $this->input->post('sort_order') : Utility::getMaxId($this->tblName);
                $arrFieled['created_by'] = 1;
                $arrFieled['created_date'] = date("Y-m-d H:i:s");
               $id=Query::insertData($this->tblName,$arrFieled);
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
        $category = array();
        if ($this->input->get('page') != "") {
            $category['page'] = $this->input->get('page');
        }
        $this->db->select('*');
        $this->db->from($this->tblName);
        $this->db->where('id',$id);
        $query = $this->db->get();
   
        $category['categorydata'] = $query->row_array(); 
        return $category;
    }
 
        public function fetchCategoryTree($table,$parent = 0, $spacing = '', $user_tree_array = '', $withSub = '', $onlyActive = '') {
         if($table=="")
              $table=$this->tblName;
        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $this->db->select('id,category_name,image_name,image_name_hover,parent_id,alias,status');
        $this->db->from($table. " wr");  
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
                $user_tree_array[] = array("id" => $row->id, "name" => ($spacing . ucwords($row->category_name)), "image_name" => $row->image_name, "image_name_hover" => $row->image_name_hover, 'alias' => $row->alias);
                if ($withSub != '')
                    $user_tree_array = $this->fetchCategoryTree($table,$row->id, $spacing, $user_tree_array, $withSub, $onlyActive);
            }
        }
        
        return $user_tree_array;
    } 
   public function getCategory(){
        $this->db->select("p.id as parent_id,p.category_name as parent_name,p.alias as  parent_alias,c.id as child_id,c.category_name as child_name,c.alias as child_alias" );
        $this->db->from($this->tblName." as p" );
        $this->db->join($this->tblName." as c", 'c.parent_id=p.id','left' );
        $this->db->where('p.parent_id',0 );
        $this->db->where('p.status','1' );
        $this->db->order_by('p.category_name','asc' );
         $query = $this->db->get(); 
        return $query->result_array();
   }

}
