<?php

/**
 * Query class used for write manual query if Query builder not work.
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Query {
    public static $user_profile = "user_profile";
    public static $machine_category = "machine_category";
     public static $parts_category = "machine_category";
    public static $machine_enquiry = "machine_enquiry";
    public static $machine = "machine";
    public static $make = "make";
    public static $model = "model";
     public static $parts = "parts";
     public static $topTable = "top_region_category";
     public static $parts_enquiry = "parts_enquiry";
     public static $testimonial = "testimonial";
     public static $parts_payment="parts_payment";
     public static $click_count="click_count";
     public static $parts_click_count="parts_click_count";
     public static $search_words="search_words";
     public static $search_data="search_data";
     public static $search_data_detail="search_data_detail";
     public static $parts_list="parts_list";
     public static $parts_tmp="parts_tmp";
     public static $blog_prefix="wpb_";
     public static $site_prefix="wp_";
     public static $app_type;
     public static $testimonial_dir='testimonial';
     public static $notification = "notification";
     
    /* public static function prepareQuery($select,$tableName,$where=array(),$compiledQuery=false,$orderBy=array(),$groupBy=array()){
      $this->db->select($select);
      $this->db->from($tableName);
      if(count($where) > 0 ) {
      $this->db->where($where);
      }
      if(count($orderBy) > 0){
      $this->db->order_by();
      }
      if(count($groupBy) > 0){
      $this->db->group_by();
      }
      if($compiledQuery==true){
      return $this->db->get_compiled_select();
      } else {
      $this->db->get();
      }
      } */

    public static function setPageCount($reqLimit, $pageCount) {
        if ((int) $reqLimit != 0) {
            $pageCnt = (int) $reqLimit;
        } else {
            $pageCnt = 0;
        }
        if ($pageCnt == 0) {
            $pageCnt = 10;
        }
        return $pageCnt;
    }

    public static function setLimit($page, $pageCount) {

        return ((int) $page * $pageCount);
    }

    public static function setSortOrder($sortOrderReq) {
        $sortKey = $sortOrderReq;
        $last = explode("_", $sortKey);
        $lastw = $last[count($last) - 1];
        $col = str_replace("_" . $lastw, " ", $sortKey);
        return(array("col" => $col, "value" => $lastw));
    }

    public static function updateStatusFromList($tblName,$field="status",$index="id",$message="") {
        $CI = setCodeigniterObj();
        $id = $CI->input->get('id');
        if ($id != "") {
            $data[$field] = $CI->input->get('status');
            Query::updateData($tblName, $data, array($index => $id));
        } else if (count($CI->input->post('bulk')) != 0) {
            $data[$field] = $CI->input->post('status');
            foreach ($CI->input->post('bulk') as $val) {
                Query::updateData($tblName, $data,array($index => $val['value']));
            }
        }
        if($tblName!=Query::$parts."_tmp") {
            echo '<div class="messages messages--status">';
            echo ($message!="")?$message:"Status is changed successfully.";
            echo '</div>';
        }
    }
    
   

    public static function updateData($tbl, $datanew, $index) { 
        $CI = setCodeigniterObj();
        $CI->db->update($tbl, $datanew, $index);
    }
    
    public static function deleteData($tbl,$index) {
          $CI = setCodeigniterObj();
          $CI->db->delete($tbl, $index); 
    }
    public static function deleteRecordFromList($tblName,$index="id",$message="") {
        $CI = setCodeigniterObj();
        $id = $CI->input->get('id');
        if ($id != "") { 
            Query::deleteData($tblName,array($index => $id));
        } else if (count($CI->input->post('bulk')) != 0) { 
            foreach ($CI->input->post('bulk') as $val) {
                Query::deleteData($tblName,array($index => $val['value']));
            }
        }
         if($tblName!=Query::$parts."_tmp") {
            echo '<div class="messages messages--status">';
            echo ($message!="")?$message:"Record is deleted successfully.";
            echo '</div>';
         }
    }
    
  public static function insertData($tbl,$dataArray){
      $CI = setCodeigniterObj();
      $CI->db->insert($tbl, $dataArray);
      return $CI->db->insert_id();
  }

}

?> 