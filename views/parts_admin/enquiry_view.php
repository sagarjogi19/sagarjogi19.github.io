<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__;
$currentPath = str_replace("parts_admin", "user", $currentPath);
$form = 'enquiryform';
?>
<style type="text/css">
    .checkForUpdatelink {
        border-bottom: 1px dotted #41c8f3;
        color: #41c8f3;
        font-weight:bold;
    }    
</style>
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php  include  $currentPath.'/tabs.php'; ?>
<div class="categoryAdd notfiicationTabMain">
    <div class="container">
        <div class="dTabCon">
            <div class="">

                <div class="formBox edit_frm">
                    <div class="editForm">
                        <div  class="editTabBtn">
                            <div class="tabsBtnGroup">
                                <?php include 'sub_tabs.php'; ?>
                                <div class="pull-right button_append">
                                    <?php displayButton($form,'user/parts/enquiry_list',false); ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo current_url(); ?>" method="post" name="<?php echo $form; ?>" id="<?php echo $form; ?>">
                        <div class="formBoxInner"> 
                            <div class="row">
                                           <div class="col-md-12">
                                    <div class="row">
                                        <?php if (isset($id)){ ?>
                                            <input type="hidden" name="edit" value="1">
                                            <input type="hidden" name="parts_id" id="machine_id" value="<?php echo $id; ?>">
                                        <?php } ?>

                                        <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Name</strong></label>
                                                <label class="captionLabel"><?php echo $name; ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Email</strong></label>
                                                <label class="captionLabel"><?php echo $email; ?></label>
                                            </div>
                                        </div>
                                        <?php if($phone!="") { ?> 
                                        <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Phone</strong></label>
                                                <label class="captionLabel"><?php echo $phone; ?></label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                         <?php if($suburb!="") { ?>     
                                            <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Suburb</strong></label>
                                                <label class="captionLabel"><?php echo $suburb; ?></label>
                                            </div>
                                        </div>
                                         <?php } ?>
                                            <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Machine Name</strong></label>
                                                <label class="captionLabel"><a class="checkForUpdatelink" href="<?php echo $slug; ?>" target="_blank" title="<?php echo $machine_name; ?>"><?php echo $machine_name; ?></a></label>
                                            </div>
                                        </div>
                                            <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Enquiry Page</strong></label>
                                                <label class="captionLabel"><?php echo ucfirst($enquiry_page); ?></label>
                                            </div>
                                        </div>
                                            <div class="col-md-4 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Enquiry Date</strong></label>
                                                <label class="captionLabel dateCalender"><?php echo date("d-m-Y h:i:s a",strtotime($created_date)); ?></label>
                                            </div>
                                        </div>
                                              <div class="col-md-8 col-xs-6">
                                            <div class="inputBox">
                                                <label class="captionLabel"><strong>Message</strong></label>
                                                <label class="captionLabel"><?php echo nl2br($message);?></label>
                                            </div>
                                        </div>
                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                            </div>
                        </div>
                    </form>
                </div>  
                <div  class="formBoxHead bottom_edit">
                    <div class="editForm">
                      <?php displayButton($form,'user/parts/enquiry_list',false); ?>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>