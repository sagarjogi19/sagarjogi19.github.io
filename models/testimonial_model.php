<?php

/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {

    public $tblName;
    public $pageCount = 10;
    public $module="testimonial";
    public function __construct() {
        $this->tblName = Query::$testimonial;
    }

    /**
     * Get Cateogory List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_list() {
        $data = array(); 

        //Create Query  
        $this->db->select('id, customer_name, designation,sort_order,status');
        $this->db->from($this->tblName . " a");
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('customer_name', $search);
            $this->db->or_like('business_name', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('designation', $search);
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
                'customer_name' => $this->input->post('customer_name'),
             'business_name' => $this->input->post('business_name'),
                'designation' => $this->input->post('designation'),
                'image_name' => $this->input->post('image_name'),
              'description' => $this->input->post('description'),
             'sort_order' => $this->input->post('sort_order'),
                'status' =>  $this->input->post('status')
            );
         
             $id = ""; 
            if ($this->input->post('edit') == '1' && $this->input->post('testimonial_id') != '') { 
                $arrFieled['updated_date'] = date("Y-m-d H:i:s");  
                Query::updateData($this->tblName,$arrFieled,array('id' => $this->input->post('testimonial_id')));
                $id = $this->input->post('testimonial_id');
            } else {   
                $arrFieled['sort_order'] = $this->input->post(sort_order)!= '' ? $this->input->post('sort_order') : Utility::getMaxId($this->tblName); 
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
        $testimonial = array();
        if ($this->input->get('page') != "") {
            $category['page'] = $this->input->get('page');
        }
        $this->db->select('id,customer_name,business_name,designation,description,image_name,sort_order,status');
        $this->db->from($this->tblName);
        $this->db->where('id',$id);
        $query = $this->db->get();
   
        $testimonial['testimonialdata'] = $query->row_array(); 
        return $testimonial;
    }
 
 

}
