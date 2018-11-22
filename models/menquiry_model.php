<?php

/** Note: To wrtie manual query, create public static variable and access variable using scope resolution operator 
 *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Menquiry_model extends CI_Model {

    public $tblName;
    public $pageCount = 10;
    public $module = "machine_enquiry";
    public $currentUser; 
    
    public function __construct() {
        $this->tblName = Query::$machine_enquiry;
        $this->currentUser = getUserInfo("id"); 
    }

    /**
     * Get Enquiry List
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function get_list() {
        $data = array();
        //Create Sub-Query
        $this->db->select('slug');
        $this->db->from(Query::$machine);
        $this->db->where('id=e.machine_id', NULL, FALSE);
        $subQuery = $this->db->get_compiled_select();

        //Create Query with Sub Query 
        $this->db->select('id,machine_name,name, email,phone,suburb,enquiry_page,DATE_FORMAT(created_date, "%d/%m/%Y") AS created_date,status,(' . $subQuery . ') as slug ');
        $this->db->from($this->tblName . " e");
        //Set search 
        $search = ($this->input->post('search') != "") ? $this->input->post('search') : "";
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('machine_name', $search);
            $this->db->or_like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
            $this->db->group_end();
        }
        if(!isAdmin()){
            $this->db->group_start();
            $this->db->where('machine_created_by',$this->currentUser);
            $this->db->group_end();
        }
        $dateFrom = $dateTo = "";
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
        $colDate = "date(created_date)";
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
    /**
     * Get Enquiry Details
     * @param type $id
     * @return type
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public function getEnquiryData($id) {
        if ($id != "") {
            //Create Sub-Query
            $this->db->select('slug');
            $this->db->from(Query::$machine);
            $this->db->where('id=e.machine_id', NULL, FALSE);
            $subQuery = $this->db->get_compiled_select();
            $machine = array();
            $this->db->select('id,machine_id,machine_name,name,email,phone,suburb,message,enquiry_page,created_date,(' . $subQuery . ') as slug ');
            $this->db->from($this->tblName . " e");
            $this->db->where("id", $id);
            $query = $this->db->get();
            return $query->row_array();
        }
    }

}
