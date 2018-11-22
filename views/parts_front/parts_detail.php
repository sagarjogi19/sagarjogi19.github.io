<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url   
//print_r($formData);exit;
$data=$formData;

$images = array();
$company=array('id'=>'company','business_name'=>$this->config->item('site_name'),'business_phone'=>$this->config->item('site_phone'),'suburb'=>$this->config->item('site_suburb'),'state'=>$this->config->item('site_state'),
    'postcode'=>$this->config->item('site_postcode'),'company_logo'=>$this->config->item('site_logo'),'address'=>$this->config->item('site_address'));
/* Main Enquiry */
$varName = (isset($_POST['constomerFName'])) ? $_POST['constomerFName'] : "";
$varEmail = (isset($_POST['constomerEmail'])) ? $_POST['constomerEmail'] : "";
$varPhone = (isset($_POST['constomerPhone'])) ? $_POST['constomerPhone'] : "";
$varMessage = (isset($_POST['constomerMessage'])) ? $_POST['constomerMessage'] : "";

/* Individual Enquiry */
$varFname1 = (isset($_POST['constomerFName1'])) ? $_POST['constomerFName1'] : "";
$varLname1 = (isset($_POST['constomerLName1'])) ? $_POST['constomerLName1'] : "";
$varEmail1 = (isset($_POST['constomerEmail1'])) ? $_POST['constomerEmail1'] : "";
$varPhone1 = (isset($_POST['constomerPhone1'])) ? $_POST['constomerPhone1'] : "";
$varMessage1 = (isset($_POST['constomerMessage1'])) ? $_POST['constomerMessage1'] : "";
$varSuburb1 = (isset($_POST['constomerSuburb1'])) ? $_POST['constomerSuburb1'] : "";

/* Compare*/
$highlightArray = array();
if(isset($_GET['a_R']) && !empty($_GET['a_R'])) {
    foreach($data['highlight'] as $k=>$v){
        if($data['main'][$k]!=$data['highlight'][$k]){
            array_push($highlightArray,$k);
        }
    }
}
if (isset($data['main_image']) && !empty($data['main_image'])) {
    array_push($images, $data['main_image']);
}
if (isset($data['additional_image']) && !empty($data['additional_image']) && $data['additional_image'] != '[]') {
    $img = json_decode($data['additional_image']);
    foreach ($img as $v)
        array_push($images, $v);
}
$seller=array();
if(isset($data['seller']) && !empty($data['seller'])){
    $seller=$data['seller'];
} else {
    $seller=$company;
}
$reseller=array();
if(isset($data['relSeller']) && !empty($data['relSeller'])){
    $reseller=$data['relSeller'];
} else {
    $reseller=$company;
}
/* Seller Info match */
$highSellerArray = array();
if(isset($_GET['a_R']) && !empty($_GET['a_R'])) {
    foreach($seller as $k=>$v){
        if($seller[$k]!=$reseller[$k]){
            array_push($highSellerArray,$k);
        }
    }
}
?>
<style type="text/css">
  .Deatial_box{background: #def6ff;padding:8px 10px;border: 1px solid #ebebeb;}
  .detailBox.first{margin-bottom: 0}
  .Deatial_box .title_text{font-size: 18px;color: #333333;line-height: 26px;font-weight: 600;}
  .Deatial_box .blue_text{color: #00bbfb;font-size: 16px;font-weight: 600;line-height: 26px;}
  .Deatial_box .address{font-size: 14px;line-height: 20px;color: #333333;position: relative;padding: 3px 35px 0;margin-bottom: 5px;}
  .Deatial_box .address:before{position: absolute;content: '';background: url('<?php echo $path; ?>/images/location1.png') no-repeat;left: 0px;top: 6px;width: 30px;height: 30px;}
  .Deatial_box .img_div{float: left;}
  .Deatial_box .links a{font-size: 14px;color: #333333;border-bottom: 1px solid; line-height: 20px;position: relative;margin-right: 10px;font-weight: 600;}
  .Deatial_box .links a:first-child:before{position: absolute;content: '';width: 1px;height: 100%;background: #333333;right: -7px;top: 2px;}
  .Deatial_box .side_part{margin-left: -15px;}
  
  .detailBox .dircBoxDetail .dircBoxInnerRight ul.new_list{padding:0px;}
  .detailBox .dircBoxDetail .dircBoxInnerRight ul.new_list li{display:block; width:100%;padding: 0; padding-left:15px;  line-height:26px;  border: 0;}
  .detailBox .dircBoxDetail .dircBoxInnerRight ul.new_list li:before{content:"•"; padding-right:10px; color:#53c7f1;}
  .detailBox .dircBoxDetail .dircBoxInnerRight ul.new_list li:nth-child(odd){background:#f5f5f5;}
  .quick_links li{width:33.33%}

  
  
</style>
<style type="text/css">
    .foldtr{display: none;}
    .foldtr.open{display: table-row;}
    .partsManualDetail #beforefilter{margin-top: 0;}
    .partsManualDetail .locationList .tblTitle{padding-top: 20px;}
    .partsManualDetail .locationList.teamListMain{border:0;}
    .locationList .custom-table{border-left:1px solid #dedede;border-right: 1px solid #dedede;}
    .custom-table tr td.viewbtnTD{text-align: right;    padding-right: 15px;}
    .viewTrBtn{display: inline-block;width: 20px;height: 20px;background: #333;border-radius: 50px;position: relative;cursor: pointer;box-shadow: 0 1px 1px 1px rgba(0,0,0,0.10);} 
    .viewTrBtn:after, .viewTrBtn:before {content: '';background-image: none;background-color: #fff;position: absolute;top: 0;bottom: 0;margin: auto;left: 0;right: 0;}
    .viewTrBtn:before {height: 2px;width: 12px;}
.viewTrBtn:after {height: 12px;width: 2px;-moz-transition: .7s;-ms-transition: .7s;-webkit-transition: .7s;transition: .7s;}
.viewTrBtn.minus:after {visibility: hidden;-moz-transition: .7s;-ms-transition: .7s;-webkit-transition: .7s;transition: .7s;transform: rotate(90deg);-webkit-transform: rotate(90deg);-moz-transform: rotate(90deg);-ms-transform: rotate(90deg);}
.custom-table tr.opensubrow{background: #f5f5f5;}
.custom-table tr.openTrColor{background:#41c8f3; }

.custom-table tr.openTrColor td{color:#fff; font-weight:700}
.desCon {max-height: 159px;}
.inputLabel:before {    font-size: 14px;    font-weight: 600; left:8px;}
.inputBox.inputLabel{    margin: 5px 2px 5px 0px;   width: auto;}
.inputFils{width: 51px; height: 34px; padding: 5px 10px;text-align:center;}
.inputBox{padding:0px 0px; }
.desMain.button_box .dircBtn{box-shadow: none!important; margin:5px 2px;  width: auto;   padding: 0px 15px}
.desMain.button_box{padding: 15px 15px 15px;}

    
</style>


<div class="container detailPage">
    <div class="breadcrumbs">
      <ul>
        <li><a href="<?php echo base_url(); ?>" title="Home" >Home</a></li>
        <li><a href="<?php echo setLink('parts/parts-list'); ?>" title="Parts" >Parts</a></li>
          <?php if (isset($data['part_name']) && !empty($data['part_name'])) { ?>
        <li class="active"><?php echo $data['part_name']; ?><?php echo ($data['part_code'])?' - '.$data['part_code']:''; ?></li>
         <?php } ?>
      </ul>
    </div>
    <div class="partTopListingBtn"><a href="#" class="dircBtn trans invertBtn" title="View Our Part Manual">View Our Part Manual</a></div>
    <!--<div class="Backbtn"><a href="#" class="trans">Back</a></div>-->
  </div>
  <div class="clearfix"></div>
   <section class="innerMainBottom">
    <div class="container">
      <div class="row">
        <div class="col-md-7 col-sm-7 col-xs-12">
          <div class="detailBox first">
            <div class="dircBoxTop">
              <div class="dircBoxInfoLeft">
                <div class="dircTitle <?php echo (in_array('part_name', $highlightArray) || in_array('part_code', $highlightArray))?'highlight':''; ?>"><?php echo $data['part_name']; ?><?php echo ($data['part_code'])?' - '.$data['part_code']:''; ?></div>
                <div class="dircPrPrice <?php echo (in_array('price_type', $highlightArray) || in_array('price', $highlightArray) || in_array('price_to', $highlightArray) || in_array('is_gst', $highlightArray))?'highlight':''; ?>"><?php echo Utility::displayPrice($data['price_type'], $data['price'], $data['price_to'], $data['is_gst'], "list"); ?></div>
              </div>
              <div class="dircBoxInfoRight">
                <!--<div class="dircTitle">ACN Admin</div>-->
                <div class="details_btn">
                  <div class="dircbtnBox">
                    <!-- <div class="inputBox inputLabel">
                      <input class="inputFils " placeholder="Qty">
                    </div> -->
                    <!-- <a href="#" class="dircBtn trans" title="Add To Quote" >Add To Quote</a> 
                    <a href="#" class="dircBtn trans greenBtn" title="Enquiry Now" >Enquiry Now</a>  -->
                  <!--  <a href="#" class="dircBtn trans freightQuote" title="Add To Shopping Truck" >Add To Shopping Truck</a> 
                    <a href="#" class="dircBtn trans freightQuote" title="Freight Quote" >Freight Quote</a> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="dircContBox">
              <div class="contactInfo">
                   <?php if ((isset($data['suburb']) && !empty($data['suburb'])) || (isset($data['state']) && !empty($data['state']))) { ?>
                <div class="location <?php echo (in_array('suburb', $highlightArray) || in_array('state', $highlightArray))?'highlight':''; ?>"><?php echo $data['suburb']; ?><?php echo ($data['suburb'] != '') ? ', ' . $data['state'] : $data['state']; ?></div>
                    <?php } ?>
                <div class="phshareBox">
                  <p class="time"><?php echo Utility::calculateDays($data['updated_date']); ?></p>
                  <?php if (isset($seller['business_phone']) && !empty($seller['business_phone'])) { ?>
                  <div class="phone m_call <?php echo (in_array('business_phone', $highSellerArray))?'highlight':''; ?>"><?php echo $seller['business_phone']; ?></div>
                     <?php } ?>
                  <div class="share"> <a href="javascript:;" title="Share" class="trans shareBtnClick">Share <span class="caret"></span></a>
                    <div class="shareListPop">
                      <ul class="shareList">
                        <li class="fb"><a onclick="socialClick(this)" data-slug="<?php echo setLink('parts/parts-detail/') . $data['alias']; ?>" data-website="fb" href="javascript:;"><i class="fa fa-facebook" aria-hidden="true"></i>Facebook</a></li>
                        <li class="twitter"><a onclick="socialClick(this)" data-slug="<?php echo setLink('parts/parts-detail/') . $data['alias']; ?>" data-website="twtr" href="javascript:;"><i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a></li>
                        <li class="linkdin "><a onclick="socialClick(this)" data-slug="<?php echo setLink('parts/parts-detail/') . $data['alias']; ?>" data-website="linked" href="javascript:;"><i class="fa fa-linkedin" aria-hidden="true"></i>Linkedin</a></li>
                        <li class="g_plus"><a onclick="socialClick(this)" data-slug="<?php echo setLink('parts/parts-detail/') . $data['alias']; ?>" data-website="gplus" href="javascript:;"><i class="fa fa-google-plus" aria-hidden="true"></i>Google plus</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 col-sm-5 col-xs-12">
          <div class="Deatial_box">
            <div class="row">
                
              <div class="col-md-4 col-sm-4 col-xs-4">
            <div class="img_div <?php echo (in_array('company_logo', $highSellerArray))?'highlight':''; ?>">
              <?php if (isset($seller['company_logo']) && !empty($seller['company_logo'])) { ?>
              <img src="<?php echo Utility::getResizeURL($seller['company_logo'], "small", "users", $seller['id'],  "logo" ); ?>" title="" alt="">
               <?php } else { ?>
               <img src="<?php echo $path; ?>/images/logo.png" title="" alt="">
               <?php } ?>
            </div>
          </div>
              
          <?php /*<div class="col-md-4 col-sm-4 col-xs-4">
            <div class="img_div">
              <img src="<?php echo $path; ?>/images/detail_image1.png" title="" alt="">
            </div>
          </div>*/ ?>
          <div class="col-md-8 col-sm-8 col-xs-8 <?php echo ($seller['company_logo']=='')?'noSellerImg':''; ?>">
            <div class="side_part">
              <p class="title_text">Seller Information</p>
                <?php if (isset($seller['business_name']) && !empty($seller['business_name'])) { ?>
              <p class="blue_text <?php echo (in_array('business_name', $highSellerArray))?'highlight':''; ?>"><?php echo $seller['business_name']; ?></p>
                <?php } ?>
               <?php if ($seller['address'] != '' && $seller['suburb'] != '' && $seller['state'] != '' && $seller['postcode'] != '') { ?>
              <p class="address <?php echo (in_array('address', $highSellerArray) || in_array('suburb', $highSellerArray) || in_array('state', $highSellerArray) || in_array('postcode', $highSellerArray))?'highlight':''; ?>"><?php echo Utility::formatMachineAddress($seller['address'], $seller['suburb'], $seller['state'], $seller['postcode']); ?></p>
               <?php } ?>
              <div class="links">
                <a href="#relatedParts" title="See other items">See other items</a>
                <a href="#enqFrm" title="Send Enquiry">Send Enquiry</a>
              </div>
            </div>
          </div>
          </div>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="detailBox">
            <div class="dircBoxDetail">
              <div class="dircBoxInnerLeft photoGallery <?php echo (in_array('main_image', $highlightArray) || in_array('additional_image', $highlightArray))?'highlight':''; ?>">
                <ul id="lightgallery" class="photoSlider list-unstyled row">
                       <?php if (isset($images) && !empty($images)) { ?>
                    <?php foreach ($images as $v) { ?>
                  <li class=" phBox ch-big" data-src="<?php echo Utility::getResizeURL($v,'detail','parts',$data['id'],'parts-image'); ?>" > <a href="" class="phoGlay_Img trans"> <img class="img-responsive" src="<?php echo Utility::getResizeURL($v,'detail','parts',$data['id'],'parts-image'); ?>" /> </a> </li>
                  <?php } ?>
                   <?php foreach ($images as $v) { ?>
                  <li class=" phBox" data-src="<?php echo Utility::getResizeURL($v,'detail','parts',$data['id'],'parts-image'); ?>" > <a href="" class="phoGlay_Img trans"> <img class="img-responsive" src="<?php echo Utility::getResizeURL($v,'detail_thumb','parts',$data['id'],'parts-image'); ?>" /> </a> </li>
                    <?php }
                       } else { ?>
                   <li class=" phBox ch-big"> <img class="img-responsive" src="<?php echo $path.'/images/no-image.jpg'; ?>" /> </li>
                       <?php } ?>
                </ul>
              </div>
              <div class="dircBoxInnerRight">
                <ul class="dirc_spanul">
                  <li <?php echo (in_array('year', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Year: </span><span><?php echo ($data['year'])?$data['year']:'Available on Request'; ?> </span></li>
                  <!--<li><span class="span_title">Quantity: </span><span>1</span></li>-->
                    <?php if (isset($data['make_name']) && !empty($data['make_name'])) { ?>
                  <li <?php echo (in_array('make_name', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Make: </span><span><?php echo $data['make_name']; ?></span></li>
                  <?php } if (isset($data['model_name']) && !empty($data['model_name'])) { ?>
                  <li <?php echo (in_array('model_name', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Model no: </span><span><?php echo $data['model_name']; ?></span></li>
                    <?php } if (isset($data['width']) && !empty($data['width'])) { ?>
                  <li <?php echo (in_array('width', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Width cm: </span><span><?php echo $data['width']; ?></span></li>
                    <?php } ?>
                  <!--<li><span class="span_title">Dangerous goods: </span><span>No</span></li>-->
                  <?php if (isset($data['height']) && !empty($data['height'])) { ?>
                  <li <?php echo (in_array('height', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Height cm: </span><span><?php echo $data['height']; ?></span></li>
                  <?php } if (isset($data['length']) && !empty($data['length'])) { ?>
                  <li <?php echo (in_array('length', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Length cm: </span><span><?php echo $data['length']; ?></span></li>
                  <?php } if (isset($data['conditions']) && !empty($data['conditions'])) { ?>
                  <li <?php echo (in_array('conditions', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Condition: </span><span><?php echo $data['conditions']; ?></span></li>
                     <?php } if (isset($data['total_weight']) && !empty($data['total_weight'])) { ?>
                  <li <?php echo (in_array('total_weight', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Total kg: </span><span><?php echo $data['total_weight']; ?></span></li>
                     <?php } if (isset($data['part_code']) && !empty($data['part_code'])) { ?>
                  <li <?php echo (in_array('part_code', $highlightArray))?'class="highlight"':''; ?>><span class="span_title">Part no: </span><span><?php echo $data['part_code']; ?></span></li>
                     <?php } ?>
                </ul>
                <div class="desMain button_box">  
                  <div class="inputBox inputLabel">
                      <input class="inputFils " placeholder="Qty">
                    </div>
                    <a href="AddtoCart.html" class="dircBtn trans" title="Add To Quote" >Add To Quote</a>
                    <a href="#" class="dircBtn trans greenBtn" title="Enquiry Now">Enquiry Now</a>
                    <a href="#" class="dircBtn trans invertBtn" title="Add To Shopping Truck" >Add To Shopping Truck</a> 
                    <a href="#" class="dircBtn trans invertBtn" title="Freight Quote" >Freight Quote</a>
                </div>
            <?php /*  <div class="desMain">
              	<div class="desTitle">Compatible with</div>
                <div class="desCon mCustomScrollbar">
                    <ul class="new_list">
                    	<li>Caterpillar - D20D</li>
                        <li>Caterpillar - D25C</li>
                        <li>Caterpillar - D25D</li>
                        <li>Caterpillar - D250B</li>
                        <li>Caterpillar - D250D</li>
                        <li>Caterpillar - D30C</li>
                        <li>Caterpillar - D30D</li>
                        <li>Caterpillar - D35C</li>
                        <li>Caterpillar - D35HP</li>
                        <li>Caterpillar - D40D</li>
                        <li>Caterpillar - D20D</li>
                        <li>Caterpillar - D25C</li>
                        <li>Caterpillar - D25D</li>
                        <li>Caterpillar - D250B</li>
                        <li>Caterpillar - D250D</li>
                        <li>Caterpillar - D30C</li>
                        <li>Caterpillar - D30D</li>
                        <li>Caterpillar - D35C</li>
                        <li>Caterpillar - D35HP</li>
                        <li>Caterpillar - D40D</li>
                    </ul>
                </div>
              </div>*/ ?>
              </div>
              
            </div>
          </div>
        </div>
          
           <?php if(isset($data['description']) && !empty($data['description'])) { ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="dircBoxDetail">
            <ul class="tabs">
              <!--<li class="active trans" data-tab="tab1"><span>Individual Parts</span></li>-->
              <li class="trans active " data-tab="tab2"><span>Description</span></li> 
            </ul>
            <div class="tab_container">
              <div class="innerTab">
               
                <!-- #tab1 -->
                 <h3 class="tab_drawer_heading" data-tab="tab2">Description</h3>
                <div id="tab2" class="tab_content">
                  <?php echo $data['description']; ?>
                </div> 
              </div>
            </div>
            
            <!-- .tab_container --> 
          </div>
        </div>
           <?php } ?>
          <div class="details_btn" id="enqFrm">
                                                <div class="dircbtnBox"> 
                                                    <?php if(isset($data['error_msg']) && !empty($data['error_msg'])) { echo $data['error_msg']; } ?>
                                                    <form class="form-horizontal" id="frmenquireNow" name="frmenquireNow" method="post">
                                                        <h3 class="tabTitle">Enquire Now</h3>
                                                        <input type="hidden" name="mid" id="sendEnquiryMid" value="<?php echo $data['id']; ?>"> 
                                                        <input type="hidden" name="mname" id="sendEnquiryMName" value="<?php echo $data['part_name']; ?>"> 
                                                        <input type="hidden" name="mstockid" id="sendStockId" value="<?php echo $data['part_code']; ?>"> 
                                                        <input type="hidden" name="mcondition" id="sendCondition" value="<?php echo ucfirst($data['conditions']); ?>"> 
                                                        <input type="hidden" name="mseller" id="sendSeller" value="<?php echo $seller['business_name']; ?>"> 
                                                        <input type="hidden" name="mprice" id="sendPrice" value="<?php echo Utility::displayPrice($data['price_type'], $data['price'], $data['price_to'], $data['is_gst'], "list"); ?>"> 
                                                        <input type="hidden" name="backUrl" class="backUrl" value="<?php echo setLink('parts/parts-detail/') . $data['alias']; ?>">
                                                        <input type="hidden" name="user" id="user" value="<?php echo $data['user']; ?>">
                                                        <input type="hidden" name="created_by" id="created_by" value="<?php echo $data['created_by']; ?>">
                                                        <input type="hidden" name="page" value="detail">
                                                        <div class="col-md-14 col-sm-7 col-xs-14 inputGap">
                                                            <div class="inputBox star">
                                                                <input type="text" placeholder="Name" class="inputFils star" id="constomerFName" value="<?php echo $varName; ?>" name="constomerFName" autocorrect="off" autocomplete="off" maxlength="256" title="First Name">
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-7 col-sm-7 col-xs-14 inputGap">
                                                            <div class="inputBox star"> 
                                                                <input placeholder="Email" type="text" class="inputFils star" id="constomerEmail" name="constomerEmail" autocorrect="off" autocomplete="off" title="Email" value="<?php echo $varEmail; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-sm-7 col-xs-14 inputGap">
                                                            <div class="inputBox"> 
                                                                <input placeholder="Phone" type="tel" class="numericOnly numbers inputFils" id="constomerPhone" name="constomerPhone" autocorrect="off" autocomplete="off" maxlength="10" title="Phone" value="<?php echo $varPhone; ?>">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-14 col-xs-14 inputGap">
                                                            <div class="inputBox star"> 
                                                                <textarea id="constomerMessage" class="inputFils inputTextarea" name="constomerMessage" rows="3" autocorrect="off" autocomplete="off" maxlength="2000" title="Enquiry" placeholder="Enquiry"><?php echo $varMessage; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-sm-7 col-xs-14 inputGap">
                                                            <div class="captchaBox  inputBox capnewBox">
                                                                <div id="captcha" class="bg" onclick="setCaptcha(jQuery(this))" title="I'm not robot">
                                                                     <?php
                                                $num = rand();
                                                $_SESSION['uniqueNum'] = $num;
                                                ?>
                                                                    <span style="display: none;" id="encriptNum"><?php echo Utility::encryptPass($num); ?></span>
                                                                    <span class="mandatory captchaText">I'm not a robot <em>*</em></span>
                                                                    <input type="hidden" value="" name="secureImg" id="secureImg">
                                                                    <label id="cptchaError" for="secureImg" generated="true" class="error" style="display: none;">Please select checkbox</label>
                                                                </div>                        
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-sm-7 col-xs-14 inputGap">
                                                            <div class="stepsBtn inputBox"><button class="btn skyBlueBtn" type="submit" title="Submit">Submit<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
        
              <?php if(isset($data['relatedParts']) && !empty($data['relatedParts'])) { ?>
                            <div class="col-md-9 col-sm-8 col-xs-12 machineData" id="relatedParts">
                                <div class="otherTitle">Other Items from this seller</div>
                                <div class="machineData machineDetList">
                                    <?php $parts=$data['relatedParts']; $abc=0; 
                                    
 include_once 'templates/part_list.php'; ?>
                                    
                                    
                                    <?php if(count($data['relatedParts'])>2) { ?>
                                    <a href="javascript:;" class="machBtn trans viewMore" title="View More">View More</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
      </div>
    </div>
  </section>
      <?php include_once 'js/parts_detail.php'; ?>