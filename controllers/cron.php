<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function update_slug() {
        $query=$this->db->select("id,alias,make")->from(Query::$make)->get();
        $data = $query->result();

        foreach ($data as $user) { 
            $slug = Utility::getSlug($user->make, (int) $user->id, Query::$make, "alias");
             Query::updateData(Query::$make, array("alias"=>$slug), array('id' => (int) $user->id)); 
             
        }
    }

}
