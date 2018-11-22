<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__; 
$CI = setCodeigniterObj();
$imgFolder ='testimonial';
$form = $imgFolder.'form';
$maxSize = $CI->config->item('max_upload_size_label');

if (isset($testimonialdata))
    extract($testimonialdata);

 
?>
<script type="text/javascript"> jQuery(document).ready(function () {
        fileUploader(jQuery("#image_name"), "<?php echo $imgFolder; ?>", jQuery("#imgPreview img"), 1, jQuery("#hndfileupload")); 
         var rules = {
               customer_name: {required:true},
               description: {required:true}
            };
           var messages = {
               customer_name: {required:'Please enter customer name'},
               description : { required:'Please enter description' }
           };
        validateForm(jQuery("#user-password-form"),rules,messages);
    });
</script>
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="categoryAdd notfiicationTabMain">
                <div class="container">
                    <div class="dTabCon">
                        <div class="">

                            <div class="formBox edit_frm">
                                <div class="editForm">
                                    <div  class="editTabBtn">
                                        <div class="tabsBtnGroup">
                                             
                                            <div class="pull-right button_append">
                                                <?php displayButton($form, 'user/testimonial_list'); ?> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php echo current_url(); ?>" method="post" name="<?php echo $form; ?>" id="<?php echo $form; ?>">
                                    <div class="formBoxInner"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <input type="hidden" name="edit" value="1">
                                                    <input type="hidden" name="testimonial_id" id="testimonial_id" value="<?php echo ( isset($id) && $id != "" ) ? $id : ""; ?>">

                                                    <div class="col-xs-12 note"><strong>Note:</strong> (<span class="redstar">*</span>) marked fields are mandatory</div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Customer Name</label>
                                                            <input type="text" name="customer_name" id="customer_name" title="Please enter customer name" class="inputFils required" value="<?php echo (isset($customer_name) && $customer_name != "") ? $customer_name : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Business Name</label>
                                                            <input type="text" name="business_name" id="business_name" title="Please enter business name" class="inputFils" value="<?php echo (isset($business_name) && $business_name != "") ? $business_name : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Designation</label>
                                                            <input type="text" name="designation" id="designation" title="Please enter designation" class="inputFils" value="<?php echo (isset($designation) && $designation != "") ? $designation : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Description</label>
                                                            <textarea style="max-height:75px" name="description" maxlength="200" id="description" title="Please enter description" class="inputFils required"><?php echo (isset($description) && $description != "") ? $description : ""; ?></textarea>
                                                        </div>   <div class="info">
                                                            <span class="infoNote">Allowed Maximum 200 Characters</span> </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <div class="addBannerSec">
                                                            <label class="captionLabel">Upload Image</label>
                                                            <p  class="bannerTitle">For best results, we recommend choosing proper icons.</p>
                                                            <div class="bannerUpload">
                                                                <div class="uploadBanner">
                                                                    <div class="uploadBox" data-colorclass = 'popTBlue'>
                                                                        <input id="image_name" type="file" class="input-text uploadImage uploadinput"  title="Please select image" name="files[0]" data-id="1" single>

                                                                        <div id="progress1" class="progress" style="display: none;">

                                                                            <div style="float:left" class="uploading"><img src="<?php echo $path; ?>/images/uploading_img.gif"></div>
                                                                            <div class="progress-bar progress-bar-success"  style="width:0%;display: none;"></div>
                                                                        </div>
                                                                        <div id="files1" class="files"></div>
                                                                        <input type="hidden" name="directory_id" id="directory_id" value="1" />
                                                                        <input type="hidden" name="image_name" id="hndfileupload" value="<?php echo (isset($image_name) && $image_name != "") ? $image_name : ""; ?>" />
                                                                        <img class="bannerImg" src="<?php echo $path; ?>/images/defalt-banner.jpg">
                                                                        <div id="imgPreview" <?php if (!isset($image_name) || (isset($image_name) && $image_name == "")) { ?>   style="display:none" <?php } ?>> 
                                                                            <?php
                                                                            $imgURL = "";
                                                                            if (isset($image_name)) {
                                                                                $imgURL = Utility::getResizeURL($image_name, "small", "1", "1", $imgFolder);
                                                                            }
                                                                            ?> 
                                                                            <img  src="<?php echo $imgURL; ?>"   />
                                                                            <?php if (isset($image_name) && $image_name != "") { ?>

                                                                                <a data-url="<?php echo $imgURL; ?>"  data-hidden="hndfileupload" data-preview="imgPreview" onclick='delImg(this)' title="Delete">Delete</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="info">
                                                                <span class="infoNote">You can upload icons images up to <?php echo $maxSize; ?>.<br><b>Allowed extensions:</b> jpg,png<br><b> Recommended size: width: 92px, height: 92px</b></span> 
                                                                <div id="fileError1" class="validation-advice" style="display: none;"></div>
                                                            </div>

                                                        </div>
                                                    </div> 

                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Sort Order</label>
                                                            <input type="text" name="sort_order" id="sort_order" title="Please enter sort order" class="inputFils sortOrder" value="<?php echo (isset($sort_order)) ? $sort_order : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-4"> 
                                                        <div class="inputBox chk_Box">
                                                            <label class="captionLabel">&nbsp;</label>
                                                            <label for="chkStatus">
                                                                <input id="chkStatus" type="checkbox" name="status" value="<?php if(isset($status)){ echo  $status; } else { ?>1<?php } ?>"   <?php if ((!isset($id))  || (isset($status) && $status == '1')) { ?>checked="checked"<?php } ?>  onclick="if (this.checked) {
                                                                this.value = '1';
                                                            } else {
                                                                this.value = '0';
                                                            }" title="Status" class="checkbox" /><span >Status</span></label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="saveBtn" id="saveBtn" value="1" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>  
                            <div  class="formBoxHead bottom_edit">
                                <div class="editForm">
                                    <?php displayButton($form, 'user/testimonial_list'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>