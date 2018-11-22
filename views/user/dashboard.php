<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
$isAdmin = isAdmin();
if(isset($summary)){ 
    extract($summary);
}
?> 
<div class="deshMain dash_body">
    <div class="container">
        <div class="deshTabMain">
            <?php include 'tabs.php'; ?>
            <div class="dTabCon">
                     <?php if ($isAdmin == true) { ?>
                <section class="uDashboard   admindash ">
               
                    <div class="deshTabMain">
                        <ul class="dTabLi dTabU">
                            <?php
                            
                                $graphTitle = "Overview";
                                $clsFor = "";
                            
                            ?>
                            <p class="dashTitle mobTitle"><?php echo $graphTitle; ?></p>

                            <div class="avgindiv">
                                <button class="graph_sbtn trans" type="button" id="refineGraph" title="Search Graph"><i class="fa fa-search" aria-hidden="true"></i></button>
                                <div class="datebox">
                                    <input  type="text" placeholder="Date Range" name="date_range" id="date_range" class="txt inputField selectDate" maxlength="85" data-content="Select Date Range" data-placement="top" rel="popover" data-title="Select Date Range" data-trigger="focus" readonly title="To Date">
                                </div>



                            </div>

                        </ul>
                        <div class="dTabCon">
                            <div class="topButton">
                                 
                                    <div class="deshSelect" >
                                        <select id="filter_dashboard_user" name="filter_dashboard_user" class="   " title="Search By User">
                                            <option value="" selected="selected" >Select user</option>
                                        </select>
                                    </div>
                                  
                                
                                <div class="commonBtnul midd">  
                                    <a href="javascript:;" class="btn  <?php echo $clsFor; ?>skyBlueBtn popclick <?php echo $clsFor; ?>EmailBtn" title="Email" data-pop="sendEmail" data-colorclass="popTBlue"><?php if ($clsFor != "") { ?><img class="svgImg" src="<?php echo $path; ?>/images/emailIcon.svg" alt="Email"><span class="svgbtnTxt"><?php } ?>Email<?php if ($clsFor != "") { ?></span><?php } ?></a>
                                    <a class="btn <?php echo $clsFor; ?>skyBlueBtn <?php echo $clsFor; ?>ExportBtn" id="export_pdf" target="_blank" title="Export PDF" href="<?php echo setLink('user/export_pdf'); ?>" data-href="<?php echo setLink('user/export_pdf'); ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export</a>
                                </div>
                                <div class="secondSection"> 
                                    <p class="graphTitle">Directory view(s) graph from <span class="graphdate">01/01/2016 to 31/12/2016</span></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
 
                            <div class="graphdiv">   
                                <canvas id="myChart1" height="200" ></canvas>
                                <div class="showProcess loading"></div>
                            </div>
                            <?php include "dashboard/overview-graph.php"; ?>
                        </div>
                    </div>
                     <?php  include 'dashboard/admin-summary.php'; ?>
                </section>
                     <?php } else {  include 'dashboard/freebox.php';  } ?>
            </div>
        </div>
    </div>
</div>
<?php  include 'dashboard/email_popup.php'; ?>