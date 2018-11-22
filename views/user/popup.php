<?php
$dirID="";
 if (isset($directory_id) !="") {
	 $dirID =$directory_id;
 }
$displayCropTab = true;
$showExistingImg = false;
 ?>
<div class="popupMain" id="crop">
    <input type="hidden" id="executeScript" value="<?php echo $displayCropTab; ?>" />
    <div class="overlayer"></div>
    <div class="popBody" >
        <div class="poptitle popTBlue"> 
            <h2 class="dircTitle">Image Gallery</h2>
            <a href="javascript:;" class="closeCrop closePopup"></a>
        </div>
        <?php if ($showExistingImg == true) { ?>
        <div class="tabCropSection">
              <ul class="imgTabing">
                  <li class="tabing current">
                      <a href="javascript:;" data-tab="#popDetails" class="cropTab" title="Upload Image">Upload Image</a>
                  </li>
				  <?php if($showExistingImg==true) { ?>
                  <li class="tabing">
                      <a href="javascript:;" data-tab="#selectFile"  class="cropTab" title="Use Existing Files">Use Existing Image</a>
                  </li>
				  <?php } ?>
              </ul>
        </div>
        <?php } ?>
        <div id="popDetails" class="popDetails cusClass">
            <form autocomplete="off" class="form-horizontal" id="frmCropImg" name="frmCropImg" method="post" enctype="multipart/form-data">
                   <div class="browse-box">
                                                    <span class="browse-btn2 trans">Choose file</span>
                                                    <span class="text">No file chosen</span>
                                                    <input id="uploadImage" class="up-Btn" type="file" name="myPhoto" onchange="PreviewImage(this);" />
                                                    <div class="pull-right cropSize"></div>
                                                </div>
                <div class="img-container imgCropCont">
                    <img src="<?php echo $path; ?>/images/blankImg.jpg"/>
                    <img id="imageCrop" src="" alt="Picture" style="display:none">
                   
                </div> 
                     <div id="zoomSection">   
                       <div id="zoomSlider"></div>
                       <div class="zoomLabel">
                         <div class="pull-left">Zoom Out</div>
                         <div class="pull-right">Zoom In</div>
                       </div>
                     </div>
                   <button class="btn saveBtnClass" type="button" id="cropImg" title="Crop" onclick="javascript:;"><span id="butNxtText">Crop</span></button>
                    <input type="hidden" id="thumbPreview" value="" />
                    <input type="hidden" id="thumbFolder" value="" />
                    <input type="hidden" id="thumbUser" value="" />
                    <input type="hidden" id="thumbHidden" value="" />
                    <input type="hidden" id="directory_id" value="<?php echo $dirID; ?>" />
                    <input type="hidden" id="sliderVal" value="100" />
					<input type="hidden" id="baseURL" value="<?php echo base_url(); ?>" />
            </form>
        </div>
        <?php if($showExistingImg==true) { ?>    
        <div id="selectFile" class="selectFile popDetails">
           <input type="hidden" id="frontURL" value="<?php echo base_url(); ?>" />
            <div class="popUpImgScroll"> 
                <ul class="imgList">
              
                </ul>
                <div class="loadSelectImg" style="display:none"><img src="<?php echo $path; ?>/images/loader.gif"></div>
            </div>
            
            <button class="btn saveBtnClass" type="button" id="insertImg" title="Crop Image" onclick="javascript:;"><span id="butNxtText">Crop Image</span></button>
            <button class="btn  skyBlueBtn" type="button" id="useImg" title="Insert Image" onclick="javascript:;"><span id="butNxtText">Insert Image</span></button>
        </div>
		<?php } ?>          
    </div>
</div>