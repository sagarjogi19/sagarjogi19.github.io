<script type="text/javascript">
    jQuery(document).ready(function () {
        <?php if(isset($id)) { 
         $CI = setCodeigniterObj();
         $imgFolder = 'logo';
         $maxSize = $CI->config->item('max_upload_size_label');
         ?>
          jQuery("#directory_id").val('<?php echo $id; ?>');
          fileUploader(jQuery("#upload_image"), "<?php echo $imgFolder; ?>", jQuery("#imgPreview0 img"), "users", jQuery("#hndfileupload0"), true);        
        <?php } ?>
        var rules = {
            name: {required: true},
            surname: {required: true},
            email: {required: true, email: true, remote: {url: '<?php echo setLink('user/checkusername'); ?>', type: "post", data: {'checkEmail': 'true', 'userid': jQuery("#uid_value").val()}, beforeSend: function () {
                        jQuery('.loaderAjax').show();
                        jQuery('.toPaymentStep').attr('disabled', 'disabled');
                    },
                    complete: function () {
                        jQuery('.loaderAjax').hide();
                        jQuery('.toPaymentStep').removeAttr('disabled');
                    }}},
            username: {required: true, remote: {url: '<?php echo setLink('user/checkusername'); ?>', type: "post", data: {'checkUsername': 'true'}, beforeSend: function () {
                        jQuery('.loaderAjax').show();
                    },
                    complete: function () {
                        jQuery('.loaderAjax').hide();
                    }}, minlength: 6, usernameValue: true, whitespaceValue: true},
            phone: {required: true, minlength: 10, checkZero: true},
            password: {minlength: 6, passwordValue: true, whitespaceValue: true, required: function () {
                    return typeof jQuery("#uid_value").val() == 'undefined'
                }},
            conf_password: {required: function () {
                    return typeof jQuery("#uid_value").val() == 'undefined'
                }, equalTo: "#password"},
            business_name: {required: false},
            suburb: {required: true},
            postcode: {required: true, minlength: 4},
            state: {required: true},
            abn: {checkZero: true},
            website: {validUrl: true},
            secureImg: {required: true}
        };
        var messages = {
            name: {required: 'Please enter name'},
            surname: {required: 'Please enter surname'},
            email: {required: 'Please enter email address', email: 'Please enter valid email address', remote: 'Email already in use. Please enter other email'},
            username: {required: 'Please enter public username', remote: 'Public username already in use, Please enter another username', minlength: 'Public username must be 6 character long', whitespaceValue: 'White space not allowed in public username', usernameValue: 'Public username should not start with underscore (_)'},
            phone: {required: 'Please enter phone', minlength: 'Phone must be 10 digit long', checkZero: 'Please enter valid phone'},
            password: {minlength: 'Password must be 6 character long.', required: 'Please enter password', passwordValue: "Password must have at least one uppercase letter, one digits and one special character", whitespaceValue: "whitespace not allowed in password"},
            conf_password: {required: 'Please re-enter password', equalTo: 'Password doesn\'t match'},
            business_name: {required: 'Please enter business name'},
            suburb: {required: 'Please enter suburb'},
            postcode: {required: 'Please enter postcode', minlength: 'Postcode must be 4 digit long'},
            state: {required: 'Please select state'},
            abn: {checkZero: 'Please enter valid ABN'},
            website: {validUrl: 'Please enter valid website url'},
            secureImg: {required: 'Please select checkbox'}
        };
        validateForm(jQuery("#<?php echo $form; ?>"), rules, messages<?php echo (isset($id)) ? ",':hidden'" : ""; ?>);
    });
</script>
<div class="formBox"> <input type="hidden" name="uid" id="uid_value" value="<?php echo (isset($id)) ? $id : ""; ?>">
    <div class="formBoxHead"><div class="formHeadLeft"><span class="stepNo">1</span> <span class="stepTitle">Personal Details</span></div>  
    </div>
    <div class="formBoxInner">
        <div class="row">
            <div class="col-md-14">
                <div class="row personal_detail">
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Name</label> 
                            <input maxlength="50" type="text" name="name" class="adminuser inputFils"   value="<?php echo (isset($name)) ? $name : ""; ?>" title="Name">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Surname</label> 
                            <input maxlength="50" type="text" name="surname" class="adminuser inputFils"   value="<?php echo (isset($surname)) ? $surname : ""; ?>" title="Surname">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label for="business_name" class="captionLabel">Business Name</label> 
                            <input id="business_name" maxlength="100" type="text" name="business_name"   value="<?php echo (isset($business_name)) ? $business_name : ""; ?>" title="Business name" class="inputFils">
                        </div>
                    </div>

                    <?php if (!isset($id)) { ?>
                        <div class="col-md-4 col-xs-7" >
                            <div class="inputBox">
                                <label class="captionLabel star">Public Username</label> 
                                <input maxlength="50" type="text" name="username"  value="<?php echo (isset($username)) ? $username : ""; ?>" class="adminuser inputFils" title="Public username" <?php echo (isset($id)) ? "readonly='readonly'" : ""; ?>>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Password</label> 
                            <input maxlength="50" type="password" name="password"  id="password" class="adminuser inputFils" title="Password" value="<?php echo (isset($password)) ? $password : ""; ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Confirm Password</label>  
                            <input maxlength="50" type="password" name="conf_password"   class="adminuser inputFils" title="Confirm password" value="<?php echo (isset($password)) ? $password : ""; ?>">
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Email</label> 
                            <input type="text" name="email"  value="<?php echo (isset($email)) ? $email : ""; ?>" class="adminuser inputFils" title="Email" id="email">
                        </div>  
                    </div>

                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Phone</label> 
                            <input type="text" name="phone"   class="numericOnly numbers inputFils" value="<?php echo (isset($phone)) ? $phone : ""; ?>" maxlength="10" title="Phone">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="formBox ">
    <div class="formBoxHead">

        <div class="formHeadLeft">
            <span class="stepNo">2</span>
            <span class="stepTitle ">Address Details</span>

        </div> 

    </div>
    <div class="formBoxInner">
        <div class="row">
            <div class="col-md-14">
                <div class="row ">


                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">  
                            <label class="captionLabel">Address</label> 
                            <input maxlength="150" type="text" name="address"  value="<?php echo (isset($phone)) ? $address : ""; ?>" title="Address" class="inputFils" id="gap_address">
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Suburb</label> 
                            <input maxlength="75" type="text" id="searchSuburb" name="suburb"   value="<?php echo (isset($suburb)) ? $suburb : ""; ?>" title="Suburb" class="inputFils"  >

                        </div>
                    </div>

                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">Postcode</label> 
                            <input type="text" name="postcode"   class="numericOnly numbers inputFils" value="<?php echo (isset($postcode)) ? $postcode : ""; ?>" maxlength="4" title="Postcode" id="gap_postcode">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel star">State</label>
                            <div class="customSelect"> 
                                <span class="spanOut state">State</span>
                                <select name="state" id="state"  title="State" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                    <option value="">Select state</option>
                                    <?php
                                    $stateData = getState();
                                    foreach ($stateData as $st) {
                                        ?>
                                        <option value="<?php echo $st; ?>" <?php if (isset($state) && $st == $state) { ?>selected='selected'<?php } ?>><?php echo $st; ?></option>
                                    <?php } ?>
                                </select>    
                            </div>
                            <label for="state" class="error" style="display: none;">Please enter state</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel">Website</label> 
                            <input type="text" name="website"   value="<?php echo (isset($website)) ? $website : ""; ?>" title="Website" class="inputFils">
                            <small class="exampleText">Ex : http://www.example.com</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-7">
                        <div class="inputBox">
                            <label class="captionLabel">ABN</label> 
                            <input type="text" name="abn"  value="<?php echo (isset($abn)) ? $abn : ""; ?>" class="numericOnly numbers inputFils" maxlength="11" title="ABN" >
                        </div>
                    </div>


                </div>
                <?php if(isset($id)) { 
                 $imgURL = Utility::getResizeURL($business_logo, "small", "users", $id,  $imgFolder );  
                 $mainImg=$business_logo;
                 ?>
                <div class="row">

                    <div class="col-xs-12">
                        <div class="addBannerSec"> 
                            <div class="bannerUpload userImg">
                                <div class="uploadBanner">
                                    <label class="captionLabel">Upload Business Logo</label>
                                    <div class="uploadBox" data-colorclass = 'popTBlue' > 
                                        <input id="upload_image" type="file" class="input-text uploadImage" title="Upload Image" name="files[0]" data-id="1" single>

                                        <div id="progress0" class="progress" style="display: none;" >
                                            <div style="float:left" class="uploading"> Uploading...</div>
                                            <div class="progress-bar progress-bar-success"  style="width:0%;display: none;"></div>
                                        </div>
                                        <div id="files1" class="files"></div>
                                        <input type="hidden" name="main_image" id="hndfileupload0" value="<?php echo $mainImg; ?>" />
                                        <img class="bannerImg" src="<?php echo $path; ?>/images/defalt-banner.jpg">

                                        <div id="imgPreview0" class="imgOverView" <?php if ($mainImg == "") { ?>  style="display:none" <?php } ?>>
                                            <img   src="<?php echo $imgURL; ?>" /> 
                                        </div>
                                        <?php if ($mainImg != "") { ?>
                                            <a data-url="<?php echo $imgURL; ?>"  data-hidden="hndfileupload0" data-preview="imgPreview0" onclick='delImg(this)' title="Delete">Delete</a>
                                        <?php } ?> 
                                    </div>

                                </div>
                            </div>
                            <div class="info">
                                <span class="infoNote">You can upload icons images up to <?php echo $maxSize; ?>.<br><b>Allowed extensions:</b> jpg,png<br><b> Recommended size: width: 800px, height: 600px</b></span> 
                                <div id="fileError0" class="validation-advice" style="display: none;"></div>
                            </div>

                        </div>
                    </div> 
                </div>
                <?php } ?>
            </div>
        </div>
    </div>		
</div>
<?php if ((!isset($id)) && (isAdmin()==false)) { ?>

    <div class="captchaBox  inputBox capnewBox regCaptcha">
        <?php
        $num = rand();
        $this->session->set_userdata('uniqueNumReg', $num);
        ?>
        <div id="captcha" class="bg" onclick="setCaptcha(jQuery(this))" title="I'm not robot">
            <span style="display: none;" id="encriptNum"><?php echo Utility::encryptPass($num); ?></span>
            <input value="" name="secureImg" id="secureImg" type="hidden">
            <span class="mandatory captchaText">I'm not a robot <em>*</em></span> 
            <label id="cptchaError" for="secureImg" generated="true" class="" style="display: none;">Please select checkbox</label>
        </div>                        
    </div>
<?php } 
?>