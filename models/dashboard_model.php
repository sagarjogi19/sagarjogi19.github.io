<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    //Remeber Me Functionality cookie name
    public $remeberMeCookieName = "remember_user";
    //User profile table
    public $tblName;
    public $partTbl;
    public $pageCount = 10;
    public $module = "user";
    public $userID;
    public $graphAbsPath;

    public function __construct() {
        $this->graphAbsPath = FCPATH . '/media/worthyparts/graph/';
        $this->userID = getUserInfo("id");
        $this->tblName = Query::$parts_click_count;
        $this->partTbl = Query::$parts;
        parent::__construct();
    }

    /*
     * Prepare view count data
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    function getPartsViewCounts() {
        $uid = $this->userID;
        $dateMonthArr = $countArray = array();
        $this->db->select("sum(pc.is_view) as totalVistor,DATE(pc.created_date) as date");
        $this->db->from($this->tblName . " as pc", true);

        if ($this->input->get('date_range') != '') {
            $dateRange = explode('To', $this->input->get('date_range'));
            $this->db->where("date(pc.created_date) between '" . date("Y-m-d", strtotime($dateRange[0])) . "' and '" . date("Y-m-d", strtotime($dateRange[1])) . "'");
        }
        if (!isAdmin() || (trim($this->input->get('dahboard-user') != ''))) {
            if (trim($this->input->get('dahboard-user') != '')) {
                $this->userID = $this->input->get('dahboard-user');
            }
            $this->db->join($this->partTbl . " as p", "pc.parts_id=p.id", "left");
            $this->db->group_start();
            $this->db->where('p.created_by', $this->userID, false);
            $this->db->or_where('p.user', $this->userID, false);
            $this->db->group_end();
        }
        $this->db->group_by("DATE(pc.created_date)");
        $query = $this->db->get();
        $getPartView = $query->result();
        $totalView = 0;
        foreach ($getPartView as $key => $partView) {
            $dateMonthArr[] = date_format(date_create($partView->date), 'M d'); //date("F", strtotime('00-'.$profileView->date.'-01')); //
            $countArray[] = $partView->totalVistor;
            $totalView = $totalView + $partView->totalVistor;
        }

        $graphArr['labels'] = $dateMonthArr;
        $graphArr['counts'] = $countArray;
        $graphArr['totalView'] = $totalView;

        return $graphArr;
    }

    function getClickAndViewCounts() {
        $uid = $this->userID;
        $userWhere = $betweenQuery = "";
        if (trim($this->input->get('dahboard-user')) != '') {
            $uid = trim($this->input->get('dahboard-user'));
        }
        if (!isAdmin() || (trim($this->input->get('dahboard-user') != ''))) {
            $userWhere = "(p.created_by=" . $uid . " or p.user=" . $uid . ")";
        }

        if ($this->input->get('date_range') != '') {
            $dateRange = explode('To', $this->input->get('date_range'));
            $betweenQuery = "date(pc.created_date) between '" . date("Y-m-d", strtotime($dateRange[0])) . "' and '" . date("Y-m-d", strtotime($dateRange[1])) . "'";
        }
        //Total Number of views
        $this->db->select("sum(pc.is_view) as totalView,DATE(pc.created_date) as date");
        $this->db->from($this->tblName . " as pc", true);
        if ($userWhere != "") {
            $this->db->join($this->partTbl . " as p", "pc.parts_id=p.id", "left");
            $this->db->where($userWhere);
        }
        if ($betweenQuery != "") {
            $this->db->where($betweenQuery);
        }
        $this->db->group_by("DATE(pc.created_date)");
        $queryViews = $this->db->get();
        $getTotalView = $queryViews->result();

        //Total Number of clicks
        $this->db->select("sum(pc.is_click) as totalClick,DATE(pc.created_date) as date");
        $this->db->from($this->tblName . " as pc", true);
        if ($userWhere != "") {
            $this->db->join($this->partTbl . " as p", "pc.parts_id=p.id", "left");
            $this->db->where($userWhere);
        }
        if ($betweenQuery != "") {
            $this->db->where($betweenQuery);
        }
        $this->db->group_by("DATE(pc.created_date)");
        $queryClicks = $this->db->get();
        $getTotalClick = $queryClicks->result();

        $dateMonthArr = $totalViewArr = $totalClickArr = array();
        foreach ($getTotalView as $key => $partView) {
            $dateMonthArr[date_format(date_create($partView->date), 'd-m-Y')] = date_format(date_create($partView->date), 'd-m-Y');
            $totalViewArr[date_format(date_create($partView->date), 'd-m-Y')] = 0;
            $totalClickArr[date_format(date_create($partView->date), 'd-m-Y')] = 0;
        }
        foreach ($getTotalClick as $key => $partView) {
            $dateMonthArr[date_format(date_create($partView->date), 'd-m-Y')] = date_format(date_create($partView->date), 'd-m-Y');
            $countArray[date_format(date_create($partView->date), 'd-m-Y')] = 0;
        }

        $totalView = 0;

        foreach ($getTotalView as $key => $partView) {
            $totalViewArr[date_format(date_create($partView->date), 'd-m-Y')] = $partView->totalView;
            $totalView = $totalView + $partView->totalView;
        }

        $totalClick = 0;
        foreach ($getTotalClick as $key => $partView) {
            $totalClickArr[date_format(date_create($partView->date), 'd-m-Y')] = $partView->totalClick;
            $totalClick = $totalClick + $partView->totalClick;
        }



        $graphArr['labels'] = array_values($dateMonthArr);

        $graphArr['viewCounts'] = array_values($totalViewArr);
        $graphArr['totalView'] = $totalView;

        $graphArr['clickCounts'] = array_values($totalClickArr);
        $graphArr['totalClick'] = $totalClick;


        return $graphArr;
    }

    function getEnquiryCounts() {
        $uid = $this->userID;
        $userWhere = $betweenQuery = "";
        if (trim($this->input->get('dahboard-user')) != '') {
            $uid = trim($this->input->get('dahboard-user'));
        }

        if ($this->input->get('date_range') != '') {
            $dateRange = explode('To', $this->input->get('date_range'));
            $betweenQuery = "date(pc.created_date) between '" . date("Y-m-d", strtotime($dateRange[0])) . "' and '" . date("Y-m-d", strtotime($dateRange[1])) . "'";
        }
        $this->db->select("count(*) as totalVistor,DATE(pc.created_date) as date");
        $this->db->from(Query::$parts_enquiry . " as pc", true);
        if (!isAdmin() || (trim($this->input->get('dahboard-user') != ''))) {
            $this->db->group_start();
            $this->db->where("parts_created_by", $uid);
            $this->db->group_end();
        }

        if ($betweenQuery != "") {
            $this->db->where($betweenQuery);
        }
        $this->db->group_by("DATE(pc.created_date)");
        $queryEnq = $this->db->get();
        $getEnq = $queryEnq->result();
        $dateMonthArr = $countArray = array();
        foreach ($getEnq as $key => $enqView) {
            $dateMonthArr[date_format(date_create($enqView->date), 'd-m-Y')] = date_format(date_create($enqView->date), 'd-m-Y');
            $countArray[date_format(date_create($enqView->date), 'd-m-Y')] = 0;
        }
        $totalEnquiry = 0;
        foreach ($getEnq as $key => $enqView) {
            $countArray[date_format(date_create($enqView->date), 'd-m-Y')] = $enqView->totalVistor;
            $totalEnquiry = $totalEnquiry + $enqView->totalVistor;
        }


        $graphArr['labels'] = array_values($dateMonthArr);

        $graphArr['Enqcounts'] = array_values($countArray);
        $graphArr['totalEnquiry'] = $totalEnquiry;


//      print_R($graphArr);
//      exit;
        return $graphArr;
    }

    function getSummaryData() {
        $maxPad = 0;
        $returnArr = array();
        //Query for Regions
        $regionQuery = $this->db->select("region_id as region_name,count(region_id) as totalView")->from(Query::$topTable)->group_by("region_id", true)->order_by("totalView", 'DESC', true)->limit(10)->get();
        $returnArr['topRegions'] = $regionQuery->result();
        //Query for Category
        $categoryQuery = $this->db->select("p.id,p.category_name,count(pc.category_id) as totalView")->from(Query::$topTable . " as pc")->join(Query::$parts_category . " as p", "pc.category_id=p.id", "left")->group_by("pc.category_id")->order_by("totalView", "DESC", true)->limit(10)->get();
        $returnArr['topCategory'] = $categoryQuery->result();
        //Query for View
        $this->db->select("sum(pc.is_view) as parts_click, pc.parts_id,p.part_name ");
        $this->db->from($this->partTbl . " as p");
        $this->db->join($this->tblName . " as pc", "p.id=pc.parts_id", 'left');
        $this->db->where("parts_id > ", "0", true);
        $this->db->group_by("pc.parts_id")->order_by("parts_click", "DESC")->limit(10);
        $query = $this->db->get();
        $returnArr['topViewParts'] = $query->result();
        //Query for enquiry
        $this->db->select("count(parts_id) as total, parts_name");
        $this->db->from(Query::$parts_enquiry);
        $this->db->group_by("parts_id");
        $this->db->order_by("total", "DESC")->limit(10);
        $queryEnq = $this->db->get();
        $returnArr['topPartsEnqury'] = $queryEnq->result();
        if (count($returnArr['topRegions']) > $maxPad)
            $maxPad = count($returnArr['topRegions']);
        if (count($returnArr['topCategory']) > $maxPad)
            $maxPad = count($returnArr['topCategory']);
        if (count($returnArr['topViewParts']) > $maxPad)
            $maxPad = count($returnArr['topViewParts']);
        if (count($returnArr['topPartsEnqury']) > $maxPad)
            $maxPad = count($returnArr['topPartsEnqury']);

        $returnArr['topRegions'] = array_pad($returnArr['topRegions'], $maxPad, 0);
        $returnArr['topCategory'] = array_pad($returnArr['topCategory'], $maxPad, 0);
        $returnArr['topViewParts'] = array_pad($returnArr['topViewParts'], $maxPad, 0);
        $returnArr['topPartsEnqury'] = array_pad($returnArr['topPartsEnqury'], $maxPad, 0);

        return $returnArr;
    }

    function saveGraphImages() {
        $uid = getUserInfo("id");
        $uploadUrl = $this->graphAbsPath . $uid . "/";
        mkdir($uploadUrl, 0755, true);

        $img = $_REQUEST['myChart1'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $uploadUrl . 'myChart1.png';
        $success = file_put_contents($file, $data);

        $img = $_REQUEST['myChart2'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $uploadUrl . 'myChart2.png';
        $success = file_put_contents($file, $data);

        $img = $_REQUEST['myChart3'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $uploadUrl . 'myChart3.png';
        $success = file_put_contents($file, $data);
    }

    public function searchUser($searchString) {
        $searchString = trim($searchString);
        $query = $this->db->select("id,name as text")->from(Query::$user_profile)->like('name', $searchString)->or_like('surname', $searchString)->or_like('username', $searchString)->or_like('business_name', $searchString)->get();
        return json_encode(array("items" => $query->result()));
    }

    public function exportPDF($save=false) {
        $graphPath = $this->graphAbsPath;
        require_once (FCPATH . '/media/invoice/mpdf60/mpdf.php');
        $uid = getUserInfo("id");
        $uploadUrl = $graphPath . $uid . "/";
        if ($save == true) {
            $saveUrl = $uploadUrl . 'graph_pdf/';
            if (!is_dir($saveUrl)) {
                mkdir($saveUrl, 0755, true);
            }
        }
        $daterange = $this->session->userdata('date_range');
        if (isset($daterange) && $daterange != '') {
            $graphData = new stdClass();
            $graphData->PartsView = $this->getPartsViewCounts();
            $graphData->partsClickAndView = $this->getClickAndViewCounts();
            $graphData->enquiryGraph = $this->getEnquiryCounts();
            if (isAdmin()) {
                $graphData->summaryData = $this->getSummaryData();
            }
        }
        include_once(FCPATH . '/dashboard-graph.php');
    }

    public function sendDashboardEmail() {
        $subject = $this->input->post('subject');
        $mail_to = explode(",", $this->input->post('user_email'));
        $cc = !empty($this->input->post('cc_email')) ? explode(",", $this->input->post('cc_email')) : NULL;
        $mail_from = $this->config->item('site_email');
        $mail_from_name = $this->config->item('site_name');
        $arrContactData="";
        if($this->input->post('description')!=""){ 
        $arrContactData .= $this->input->post('description');
      
        }
        $content = Utility::loadTemplate($subject, $arrContactData);
        /*echo $mail_from."<br >";
        echo $mail_from_name."<br >";
        print_r($mail_to); echo "<br >";
        echo $subject."<br >";
        echo $content."<br >"; exit;
        $this->exportPdf(true); */
        $uid = getUserInfo("id");
        $attachment = array($this->graphAbsPath . $uid . '/graph_pdf/worthyparts-report.pdf');
        $status=Utility::sendMail($mail_to, $mail_from_name, $mail_from, $subject, $content, $attachment, $cc);
        if($status==false){
             saveMessage(array('error' => 'Error in sending mail'));
         } 
         redirect('dashboard');
    }
    
   public function export_enquiries_xls()
  { 
    $isAdmin = 0;
    if(isAdmin())
    {
        $isAdmin = 1;
    }
    
    $this->db->select("parts_name,name,email,phone,suburb,message,created_date")->from(Query::$parts_enquiry);
    if($this->input->get("uid")){
        $this->db->where('parts_created_by',$this->input->get("uid"));
    }
    $query = $this->db->get();
    $enquiryData = $query->result();
   
    require_once APPPATH.'/third_party/PHPExcel/PHPExcel.php'; 
    require_once APPPATH.'/third_party/PHPExcel/PHPExcel/IOFactory.php';  
    $objPHPExcel = new \PHPExcel();
    $objPHPIo = new \PHPExcel_IOFactory();

    // Create a first sheet, representing sales data
     $objPHPExcel->getActiveSheet()->setTitle('Parts Enquiry');
    $objPHPExcel->setActiveSheetIndex(0);
    
    foreach($enquiryData as $key=>$val)
    {
        if($key == 0)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Name');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Email');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Phone');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Suburb');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Enquiry');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Date');
            if($isAdmin == 1)
                $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Part');
        }
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2),$val->name);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), $val->email);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), $val->phone);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), $val->suburb);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), $val->message);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), date('d-m-Y h:i:s',strtotime($val->created_date)));
        if($isAdmin == 1)
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2), $val->parts_name);
        
    }
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Parts Enquiry.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = $objPHPIo->createWriter($objPHPExcel, 'Excel5');
     ob_end_clean();
    $objWriter->save('php://output');
    exit;
  }

}
