<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url    
$data=$formData;
$currentPath = __DIR__;
$currentPath = str_replace("parts_front", "parts", $currentPath);
$isTrash=1;
$CI  = &get_instance();
error_reporting(0);
//print_r($data);exit;
/*if ($showData=="list") { 
    $isTrash=0;
}*/
?>
<div class="container detailPage">
    <div class="breadcrumbs">
    	<ul>
        	<li><a href="<?php echo base_url(); ?>" title="Home" >Home</a></li>
            <li class="active">Parts</li>
        </ul>
    </div>
    <div class="partTopListingBtn"><a href="parts-manual-Flow_2-step1.html" class="dircBtn trans invertBtn" title="View Our Part Manual">View Our Part Manual</a></div>
    </div>
    
    <div class="clearfix"></div>
    <section class="innerMainBottom">
    <div class="container">
        <div class="mobfilter">
            <div class="mPanelClick filterIcon">Filter By</div>
        </div>
    <div class="row">
    <!-- sidebar start -->
    <div class="col-md-3 col-sm-4 col-xs-12 filterleft">
    	<div class="filterSidebar">
        	<div class="visible-xs closePenal"><i class="fa fa-arrow-right" aria-hidden="true"></i> Back</div>
                <input type="hidden" value="<?php echo Parts_Front::$totalRecord; ?>" id="totalRecord" />
            <div class="filterBox">
            <div class="filterTitle sidebarTitle">Filter By</div>   
            <?php if((isset($_GET) && !empty($_GET)) || !empty($CI->uri->segment(3)) || $CI->uri->segment(4)) { ?>
            <a href="javascript:;" title="Clear Search Result" class="clearSea saveCleBtn trans">
				    <i class="fa fa-refresh" aria-hidden="true"></i> Clear Search
				</a>
             <?php } ?>
            </div>
           
            <div class="filterBox">
            <div class="filterTitle">Part Number</div>            
            <div class="filterCon">
            	<div class="inputBox filtSearch">
                	<input class="inputFils" type="text" name="keywords" id="keywords" placeholder="Search" value="<?php echo isset($_GET['keywords']) && $_GET['keywords'] != '' ? $_GET['keywords'] : $_GET['searchKeyword']; ?>">
                    <button class="searchBtn searchBtnkey" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
            </div>
            
            <div class="filterBox">
                <div class="filterTitle catTogleClick">Make</div>
                <div class="filterCon togleBody">
                    <a class="close" title="Remove" id="makeRemove" style="display:<?php echo (isset($_GET['make']) && $_GET['make'] != '' ? 'block' : 'none'); ?>;"/>×</a>
                    <ul class="catLists clearfix">
                            <?php 
				    if (count($data['make']) > 0) {
				       foreach ($data['make'] as $k => $v) {
				          echo "<li><a href='javascript:;' class='makeLi " . ($_GET['make'] == $v['sef_make'] ? 'active' : '') . "' data-make='" . $v['sef_make'] . "' >" . $v['make'] . "<span class='catCount'>(" . $v['make_cnt'] . ")</span></a></li>";
				       }
				    } else {
				       echo "<li>No Records Found </li>";
				    }
				    ?>
                    </ul>
                </div>
            </div>
                
              <?php if (isset($_GET['make']) && $_GET['make'] != '') { ?>   
            <div class="filterBox">
                <div class="filterTitle catTogleClick">Model</div>
                <a class="close" title="Remove" id="modelRemove" style="display:<?php echo (isset($_GET['model']) && $_GET['model'] != '' ? 'block' : 'none'); ?>;"/>×</a>
                <div class="filterCon togleBody">
                    <ul class="catLists clearfix">
                        <?php
				       if (count($data['model']) > 0) {
				          foreach ($data['model'] as $k => $v) {
					  echo "<li><a href='javascript:;' class='modelsLi " . ($_GET['model'] == $v['sef_model'] ? 'active' : '') . "' data-model='" . $v['sef_model'] . "' >" . $v['model'] . "<span class='catCount'>(" . $v['model_cnt'] . ")</span></a></li>";
				          }
				       } else {
				          echo "<li>No Records Found </li>";
				       }
				       ?>
                    </ul>
                </div>
            </div>
                 <?php } ?>
             <div class="filterBox">
            <div class="filterTitle catTogleClick">Regions</div>
            <div class="filterCon togleBody">
                <a class="close" title="Remove" id="regionRemove" style="display:<?php echo (isset($_GET['region']) && $_GET['region'] != '' ? 'block' : 'none'); ?>;"/>×</a>
            	<ul class="catLists clearfix" id="models">
                    <?php  
				    if (count($data['region']) > 0) {
				       echo '<ul class="catLists clearfix">';
				       foreach ($data['region'] as $k => $v) {
				          echo "<li>";
				          echo '<span class="catAccor trans"><i class="fa fa-plus-square" aria-hidden="true"></i></span>';
				          echo "<a href='javascript:;' >" . $k . "</a>";
				          echo '<ul class="subCat">';
				          foreach ($v as $kr => $vr) {
					  echo "<li>";
					  echo "<a href='javascript:;' class='regionLi " . ($_GET['region'] == $vr['sef_region'] ? 'active' : '') . "' data-region='" . $vr['sef_region'] . "' >" . $vr['region_name'] . "<span class='catCount'>(" . $vr['region_cnt'] . ")</span></a>";
					  echo '</li>';
				          }
				          echo '</ul>';
				          echo '</li>';
				       }
				       echo '</ul>';
				    } else {
				       echo "<li>No Records Found </li>";
				    }
				    ?>                
                </ul>
            </div>
            </div>   
                
            <div class="filterBox">
                <div class="filterTitle catTogleClick">Categories</div>
                <div class="filterCon togleBody">
                    <a class="close" title="Remove" id="categoriesRemove" style="display:<?php echo (isset($_GET['cat']) && $_GET['cat'] != '' ? 'block' : 'none'); ?>;"/>×</a>
                    <ul class="catLists clearfix" id="models">
                        <?php
				    $cate = $data['categories'];
//                                    print_r($cate);exit;
				    if (count($cate['cat']) > 0) {
				       //echo '<ul class="catLists clearfix">';
				       foreach ($cate['cat'] as $k => $v) {
				          echo "<li>";
				          if (count($cate['subcat'][$k]) > 0) {
					  echo '<span class="catAccor trans"><i class="fa fa-plus-square" aria-hidden="true"></i></span>';
				          }
				          if ($v['cat_cnt'] == 0) {
					  echo "<a href='javascript:;' >" . $v['cat_name'] . "</a>";
				          } else {
					  echo "<a href='javascript:;' class='catLi " . ($_GET['cat'] == $v['sef_cat'] ? 'active' : '') . "' data-cat='" . $v['sef_cat'] . "' >" . $v['cat_name'] . "<span class='catCount'>(" . $v['cat_cnt'] . ")</span></a>";
				          }
				          if (count($cate['subcat'][$k]) > 0) {
					  echo '<ul class="subCat">';
					  foreach ($cate['subcat'][$k] as $ks => $vs) {
					     echo "<li>";
					     echo "<a href='javascript:;' class='catLi " . ($_GET['cat'] == $vs['sef_cat'] ? 'active' : '') . "' data-cat='" . $vs['sef_cat'] . "' >" . $vs['cat_name'] . "<span class='catCount'>(" . $vs['cat_cnt'] . ")</span></a>";
					     echo '</li>';
					  }
					  //echo '</ul>';
				          }
				          echo '</li>';
				       }
				       echo '</ul>';
				    } else {
				       echo "<li>No Records Found </li>";
				    }
				    ?>
                    </ul>
                </div>
            </div>
                
            <div class="filterBox">
                <div class="filterTitle catTogleClick">Condition</div>
                <div class="filterCon togleBody">
                    <a class="close" title="Remove" id="conditionsRemove" style="display:<?php echo (isset($_GET['conditions']) && $_GET['conditions'] != '' ? 'block' : 'none'); ?>;"/>×</a>
                    <ul class="catLists clearfix">
                        <?php
				    if (count($data['conditions']) > 0) {
				       //echo '<ul class="catLists clearfix">';
				       foreach ($data['conditions'] as $k => $v) {
				          echo "<li>";
				          echo "<a href='javascript:;' class='conditionsLi " . ($_GET['conditions'] == $v['sef_conditions'] ? 'active' : '') . "' data-conditions='" . $v['sef_conditions'] . "' >" . $v['conditions_name'] . "<span class='catCount'>(" . $v['conditions_cnt'] . ")</span></a>";
				          echo '</li>';
				       }
				       //echo '</ul>';
				    } else {
				       echo "<li>No Records Found </li>";
				    }
				    ?>
                    </ul>
                </div>
            </div>
            
            
        </div>
    </div>
    <!-- sidebar end -->
    <style>
    	.directoryBox{margin: 0 0 10px 0;}	
		.dircBoxInnerLeft p{display:inline-block; padding-right:20px;}
		.dirLT{border:0px; margin:5px 0 0px; padding:5px 0px;	border-top:1px solid #dedede;}
    	.dircbtnBox{margin:0px; border:0px; padding-top:0px;}
		.viewParts{padding-left:20px;}
		.dircBoxRight{padding-bottom:0px;}
		.company_info{float:left; width:100%; text-align:center; border-top:1px solid #dedede; padding-top:10px;}
		.company_info  .compnay_logo{width:100%; float:left; text-align:center;}
		.company_info  .compnay_logo img{max-height:67px;}
		.company_info   .company_name{color: #00bbfb;  font-size: 16px;   font-weight: 600;    line-height: 26px; margin-top:5px; width:100%; float:left}
        .company_name a{color:#00bbfb;}
        .company_name a:hover{color:#4d981b;}
    </style>
    <!-- Directory list start -->
    <div class="col-md-9 col-sm-8 col-xs-12 machineData" id="">
    	<?php      $parts = $data['machine'];
        if(isset($parts) && !empty($parts)) {
        include_once 'templates/part_list.php'; 
        }  else { ?>
             <div class="" id="noRecordFound">
			   <div class="norecord">No records found</div>
		          </div>
        <?php } ?>
       
        
         
        
    </div>
    <div class="clearfix"></div>
    
     <div class="viewBtn loadMoreBtn loadMore" style="display:<?php echo (Parts_Front::$totalRecord > Parts_Front::$record ? 'block' : 'none'); ?>;">
                              <center>  
                                <div id="loader" style="display:none;">
                                    <img class="svgImg" src="<?php echo $path; ?>/images/loader.gif" alt="loader" title="Loader">
                                </div>
                                <a href="javascript:;" title="View More" class="treadMore dircBtn trans viewMore">View More</a>
                              </center>
		          </div>
    <!-- Directory list end -->    
 
    </div>
    </div>
    </section>
    <?php     
        include_once 'js/parts_list.php'; ?>

