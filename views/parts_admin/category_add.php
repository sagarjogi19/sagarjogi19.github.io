<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__;
$currentPath = str_replace("parts_admin", "user", $currentPath);
$CI = setCodeigniterObj();
$imgFolder ='parts_category_icon';
$form = 'categoryform';
$maxSize = $CI->config->item('max_upload_size_label');

if (isset($categorydata))
    extract($categorydata);
?>
<script type="text/javascript"> jQuery(document).ready(function () {
        fileUploader(jQuery("#image_name"), "machine_category_icon", jQuery("#imgPreview img"), 1, jQuery("#hndfileupload"));
        fileUploader(jQuery("#image_name_hover"), "machine_category_icon", jQuery("#imgPreview1 img"), 1, jQuery("#hndfileupload1"));
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
                                            <?php include 'sub_tabs.php'; ?>
                                            <div class="pull-right button_append">
                                                <?php displayButton($form, 'user/parts/category_list'); ?> 
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
                                                    <input type="hidden" name="category_id" id="category_id" value="<?php echo ( isset($id) && $id != "" ) ? $id : ""; ?>">

                                                    <div class="col-xs-12 note"><strong>Note:</strong> (<span class="redstar">*</span>) marked fields are mandatory</div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Category Name</label>
                                                            <input type="text" name="category_name" id="category_name" title="Please enter category name" class="inputFils required" value="<?php echo (isset($category_name) && $category_name != "") ? $category_name : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Category Alias</label>
                                                            <input type="text" name="alias" id="alias_name" title="Please enter category alias" class="inputFils" value="<?php echo (isset($alias) && $alias != "") ? $alias : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <div class="addBannerSec">
                                                            <label class="captionLabel">Upload Icon</label>
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
                                                                <span class="infoNote">You can upload icons images up to <?php echo $maxSize; ?>.<br><b>Allowed extensions:</b> jpg,png<br><b> Recommended size: width: 28px, height: 28px</b></span> 
                                                                <div id="fileError1" class="validation-advice" style="display: none;"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <div class="addBannerSec">
                                                            <label class="captionLabel">Upload Hover Icon</label>
                                                            <p  class="bannerTitle">For best results, we recommend choosing proper icons.</p>
                                                            <div class="bannerUpload">
                                                                <div class="uploadBanner">
                                                                    <div class="uploadBox" data-colorclass = 'popTBlue'>
                                                                        <input id="image_name_hover" type="file" class="input-text uploadImage uploadinput"  title="Please select image" name="files[1]" data-id="1" single>

                                                                        <div id="progress1" class="progress" style="display: none;">

                                                                            <div style="float:left" class="uploading"><img src="<?php echo $path; ?>/images/uploading_img.gif"></div>
                                                                            <div class="progress-bar progress-bar-success"  style="width:0%;display: none;"></div>
                                                                        </div>
                                                                        <div id="files1" class="files"></div>

                                                                        <input type="hidden" name="image_name_hover" id="hndfileupload1" value="<?php echo (isset($image_name_hover) && $image_name_hover != "") ? $image_name_hover : ""; ?>" />
                                                                        <img class="bannerImg" src="<?php echo $path; ?>/images/defalt-banner.jpg">
                                                                        <div id="imgPreview1" class="imgPreview1" <?php if (!isset($image_name_hover) || (isset($image_name_hover) && $image_name_hover == "")) { ?> style="display:none" <?php } ?>>
                                                                            <?php
                                                                            $imgHoverURL = "";
                                                                            if (isset($image_name_hover)) {

                                                                                $imgHoverURL = Utility::getResizeURL($image_name_hover, "small", "1", "1", $imgFolder);
                                                                            }
                                                                            ?>
                                                                            <img  src="<?php echo $imgHoverURL; ?>" />
                                                                            <?php if (isset($image_name_hover) && $image_name_hover != "") { ?>

                                                                                <a data-url="<?php echo$imgHoverURL; ?>"  data-hidden="hndfileupload1" data-preview="imgPreview1" onclick='delImg(this)' title="Delete">Delete</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="info">
                                                                <span class="infoNote">You can upload icons images up to <?php echo $maxSize; ?>.<br><b>Allowed extensions:</b> jpg,png<br><b> Recommended size: width: 28px, height: 28px</b></span> 
                                                                <div id="fileError1" class="validation-advice" style="display: none;"></div>
                                                            </div>

                                                        </div>
                                                    </div> 
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox customSelect">
                                                            <label class="captionLabel">Parent Category</label>
                                                            <span class="parent_id spanOut">Select Parent Category</span>
                                                            <select name="parent_id" id="parent_id" title="Select Parent category" class="" onchange="setSpanValue(jQuery(this));" onkeyup="setSpanValue(jQuery(this));">
                                                                <option value="">Select Parent Category</option> 
                                                                <?php
                                                                if (isset($categorytree) && count($categorytree) > 0) {
                                                                    foreach ($categorytree as $key => $categorys) { 
                                                                            ?>
                                                                            <option value="<?php echo $categorys['id']; ?>" <?php if (isset($id) && $id == $categorys['id']) { ?>selected="selected"<?php } ?>><?php echo $categorys['name']; ?></option>
                                                                            <?php
                                                                      
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div> 

                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Sort Order</label>
                                                            <input type="text" name="sort_order" id="sort_order" title="Please enter sort order" class="inputFils sortOrder" value="<?php echo (isset($sort_order) && $sort_order) ? $sort_order : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-4"> 
                                                        <div class="inputBox chk_Box">
                                                            <label class="captionLabel">&nbsp;</label>
                                                            <label for="chkStatus">
                                                                <input id="chkStatus" type="checkbox" name="status" value="<?php if(isset($status)){ echo (int)$status; } else { ?>1<?php } ?>"   <?php if ((!isset($id))  || (isset($status) && $status == '1')) { ?>checked="checked"<?php } ?>  onclick="if (this.checked) {
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
                                    <?php displayButton($form, 'user/parts/category_list'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>