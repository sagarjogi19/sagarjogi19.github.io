<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller {
 
	public function page_not_found()
	{   
	   $data['template']="404";
	   $data['title']="Page Not found";	   
	   $this->load->view('index',$data);		
	}
}
