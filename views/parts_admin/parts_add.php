<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__;
$currentPath = str_replace("parts_admin", "user", $currentPath);
$terms_condtion = str_replace("user", "", $currentPath);

$CI = setCodeigniterObj();
$imgFolder = 'parts-image';
$form = 'partsform';
$maxSize = $CI->config->item('max_upload_size_label');

$additional_image_limit = 14;
$parts_price = $CI->config->item('parts_price');
if (isset($partsdata))
    extract($partsdata);
$imgURL = "";
$mainImg = (isset($main_image) && $main_image != "") ? $main_image : "";
$isAdmin = isAdmin();
if ($mainImg != "") {
    if (!$isAdmin && isset($payment_token)) {
        $imgURL = Utility::getResizeURL($mainImg, "small", "parts", $use_folder, "parts-image");
    } else {
        $imgURL = Utility::getResizeURL($mainImg, "small", "parts", $id, "parts-image");
    }
}
if ($isAdmin == false) {
    $userData = getUserInfo();
}
$partList = setLink('user/parts/parts_list');
$partDetail = setLink('user/parts/parts_add');
?>
<script type="text/javascript"> jQuery(document).ready(function () {
   
    fileUploader(jQuery("#upload_image"), "<?php echo $imgFolder; ?>", jQuery("#imgPreview0 img"), "parts", jQuery("#hndfileupload0"), true);
    loadTinymce("1", "description");
<?php for ($i = 2; $i < $additional_image_limit; $i++) { ?>
        fileUploader(jQuery("#additional_image<?php echo $i; ?>"), "<?php echo $imgFolder; ?>", jQuery("#imgPreview<?php echo $i - 1; ?> img"), "parts", jQuery("#hndfileupload<?php echo $i - 1; ?>"), true);
<?php } ?>
<?php if (isset($user) && $user != "" && $isAdmin == true) { ?>loadUser();<?php } ?>
    var rules = {
    part_name: {required: true},
            part_code: {required: true, remote: {url: window.location.href, type: "post", data: {'checkPartCode':'true', 'partCode':jQuery("#part_code").val()<?php if (isset($id) && $id != "") { ?>, 'record_id':<?php
    echo $id;
}
?>}}},
            make: {required: true},
            model: {required: true},
            category: {required: true},
            condition: {required: true},
            price_type: {required: true},
            weight: { required: true},
            qty: {required: true},
            ad_type: { required: true},
            price: {required: true, checkZero: true},
            price_to: {required: true, checkZero: true},
            price_from: {required: true, checkZero: true},
            address: {required: true},
            suburb: {required: true},
            state: {required: true},
            postcode: {required: true, minlength: 4}
    };
    var messages = {
    part_name: {required: "Please enter part name"},
            part_code: {required: "Please enter part code", remote: "Part code must be unique"},
            make: {required: "Please select make"},
            model: {required: "Please select model"},
            category: {required: "Please select category"},
            condition: {required: "Please select condition"},
            price_type: {required: "Please select price type"},
            weight: { required: "Please enter weight"},
            qty: {required: "Please enter quantity"},
            ad_type: { required: "Please select ad type"},
            price: {required: "Please enter price", checkZero: "Please enter proper price"},
            price_from: {required: "Please enter from price", checkZero: "Please enter proper from price"},
            price_to: {required: "Please enter price to", checkZero: "Please enter proper price"},
            address: {required: "Please enter address"},
            suburb: {required: "Please enter suburb"},
            state: {required: "Please select state"},
            postcode: {required: "Please enter postcode", minlength: "Postcode must be 4 digit long"}
    };
    validateForm(jQuery('#<?php echo $form; ?>'), rules, messages, ':hidden');
    loadSelect2();
    jQuery("#make").on('select2:select', function (e) {
    if (jQuery(this).val() != "") {
    loadModel(jQuery(this).val());
    } else {
    html = '<option value="">Select Model</option>';
    jQuery("#model").html(html);
    setSpanValue(jQuery("#model"));
    jQuery("#model").select2();
    jQuery("#model").attr("disabled", "disabled");
    }
    });
<?php if (isset($make) && $make != "") { ?>
        jQuery('#make').val('<?php echo $make; ?>').trigger('change');
        loadModel(<?php echo $make; ?>);
<?php
}
if (isset($price_type) && $price_type != "") {
    ?>
        showPrice('<?php echo $price_type; ?>');
        jQuery("#price_type option[value=<?php echo $price_type; ?>]").attr('selected', 'selected');
        setSpanValue(jQuery("#price_type"));
<?php } if (isset($conditions) && $conditions != "") { ?>
        jQuery('#condition option[value=<?php echo $conditions; ?>').attr('selected', 'selected');
        jQuery("#condition").trigger("change");
        setSpanValue(jQuery("#condition"));
<?php } if (isset($ad_type) && $ad_type != "") { ?>
        jQuery('#ad_type option[value=<?php echo $ad_type; ?>]').attr('selected', 'selected');
        jQuery("#ad_type").trigger("change");
        setSpanValue(jQuery("#ad_type"));
<?php } ?>
    <?php if (!$isAdmin) { ?>
    jQuery(".tabing").bind("click", function () {
    checkPaymentMethod(jQuery(this).attr("data-paymentType"));
    });
    jQuery(".resp-accordion").find("span").bind("click", function () {
    checkPaymentMethod(jQuery(this).attr("data-paymentType"));
    });
    jQuery(".tabing").trigger("click");
    jQuery("#upgradeSub").hide();
    jQuery(".paymentPageMain").hide();
    <?php } ?>
<?php if (!$isAdmin) { ?>
        <?php if(isset($ad_type)) { ?>
            jQuery("#ad_type").trigger("change");
        <?php } ?>
        jQuery("#ad_type").bind("change", function(){
        if (jQuery(this).val() == "2") {
        jQuery(".paymentPageMain").show();
        jQuery(".saveBtnClass").hide();
        jQuery("#upgradeSub").show();
        } else {
        jQuery(".paymentPageMain").hide();
        jQuery(".saveBtnClass").show();
        jQuery("#upgradeSub").hide();
        }
        });
<?php } ?>
    });
    function setDirectoryValue(t) {

    if (t == "logo") {
    jQuery("#directory_id").val(jQuery("#dir_id").val());
    jQuery("#frmCropImg").find("#thumbUser").val(jQuery("#ucid").val());
    jQuery("div[data-preview=imgPreview2]").attr("data-user", jQuery("#ucid").val());
    // alert(jQuery("#thumbUser").val());
    } else {
    jQuery("#directory_id").val("<?php echo isset($use_folder) ? $use_folder : $id; ?>");
    jQuery("#frmCropImg").find("#thumbUser").val("parts");
    }
    }
    function showPrice(val) {
    jQuery("#gst_section").hide();
    switch (val) {
    case 'r':
            jQuery("#price_section_range").show();
    jQuery("#price").attr("title", "Please enter price from");
    jQuery("#price_to_section").show();
    jQuery(".price_from").html('Price From');
    jQuery("#price_section").hide();
    break;
    case 'f':
            jQuery("#price_section").show();
    jQuery("#price").attr("title", "Please enter price");
    jQuery(".price_from").html('Price');
    jQuery("#price_to_section").hide();
    jQuery("#gst_section").show();
    jQuery("#price_section_range").hide();
    break;
    case 'n':
            jQuery("#price_section").hide();
    jQuery("#price_to_section").hide();
    jQuery("#price_section_range").hide();
    break;
    case 'c':
            jQuery("#price_section").hide();
    jQuery("#price_to_section").hide();
    jQuery("#price_section_range").hide();
    break;
    default:
            jQuery("#price_section").hide();
    jQuery("#price_to_section").hide();
    jQuery("#price_section_range").hide();
    break;
    }
    }
    function loadSelect2() {
    jQuery("#make").select2(<?php if ($isAdmin == "true") { ?>{tags: true,
                createTag: function (params) {
                return {
                id: params.term,
                        text: params.term,
                        newOption: true
                }
                }}<?php } ?>);
    jQuery("#category_admin").select2();
    jQuery("#searchSuburb").select2({tags: true,
            createTag: function (params) {
            return {
            id: params.term,
                    text: params.term,
                    newOption: true
            }
            }});
    jQuery("#model").select2(<?php if ($isAdmin == "true") { ?>{tags: true,
                createTag: function (params) {
                return {
                id: params.term,
                        text: params.term,
                        newOption: true
                }
                }}<?php } ?>);
<?php if ($isAdmin == "true") { ?>
        jQuery("#user_id").select2();
<?php } ?>
    }
    function loadUser() {
    jQuery(".user_id").html("Loading...");
    jQuery("#user_id").attr("disabled", "disabled");
    jQuery("#user_id").select2();
    jQuery("#user_id").removeAttr("disabled");
    jQuery('#user_id').val('<?php echo (isset($user) ? $user : ''); ?>').trigger('change');
    }
    function loadModel(make_val) {
    jQuery(".model").html("Loading...");
    var url = window.location.href;
    jQuery.ajax({
    url: url,
            type: 'post',
            data: {makeValue: make_val},
            async: true,
            success: function (data) {
            var model = jQuery.parseJSON(data);
            var html = '';
            html = '<option value="">Select Model</option>';
            for (i = 0; i < model.models.length; i++) {

            html += '<option value="' + model.models[i].id + '" >' + model.models[i].model + '</option>';
            }
            jQuery("#model").removeAttr("disabled");
            jQuery("#model").html(html);
            setSpanValue(jQuery("#model"));
            jQuery("#model").select2({tags: true,
                    createTag: function (params) {
                    return {
                    id: params.term,
                            text: params.term,
                            newOption: true
                    }
                    }});
<?php if (isset($model) && $model != "") { ?>
                jQuery('#model').val('<?php echo $model; ?>').trigger('change');
<?php } ?>
            }
    });
    }
    <?php if ($isAdmin == false) { ?>
    function doProcess() {
    jQuery("#upgradeSub").attr("disabled", "disabled");
    jQuery.ajax({
    url: "<?php echo $partDetail; ?>?storeData=true",
            data: jQuery("#<?php echo $form; ?>").serialize(),
            type: "POST",
            success: function (data) {
            if (jQuery.trim(data) == "1") {
           
            jQuery("input[name=billing_first_name]").val('<?php echo $userData->name; ?>');
            jQuery("input[name=billing_last_name]").val('<?php echo $userData->surname; ?>');
            jQuery("input[name=billing_address1]").val('<?php echo $userData->address; ?>');
            jQuery("input[name=billing_state]").val('<?php echo $userData->state; ?>');
            jQuery("input[name=billing_city]").val('<?php echo $userData->suburb; ?>');
            jQuery("input[name=billing_zip]").val('<?php echo $userData->postcode; ?>');
            document.form_iframe.submit();
            jQuery("#hss_iframe").addClass("highlightBlack pamentFrame");
            jQuery("#hss_iframe").attr("style", "height:500px");
            jQuery("#hss_iframe").show();
            jQuery("#isPayClicked").val("true");
            }
            }
    });
    }
    function checkPaymentMethod(pm) {

    jQuery("#payment_type").val(pm);
    if (jQuery("#payment_type").val() == "PAYPAL_HOSTED_SOLUTIONS") {
    jQuery("#upgradeSub").html('Pay Now');
    jQuery("#upgradeSub").attr("title", 'Pay Now');
    jQuery("#upgradeSub").attr("type", "button");
    jQuery("#upgradeSub").attr("onclick", "doProcess();");
    if (jQuery("#upgradeSub").hasClass('disBtn') == false)
    {
    jQuery("#upgradeSub").removeAttr('disabled');
    }
    jQuery('.hostedSol').show();
    } else {
    jQuery("#upgradeSub").html('Proceed To Payment');
    jQuery("#upgradeSub").attr("title", 'Proceed To Payment');
    jQuery("#upgradeSub").attr("type", "submit");
    jQuery("#upgradeSub").attr("onclick", "submitFrm(jQuery('#<?php echo $form; ?>'))");
    if (jQuery("#upgradeSub").hasClass('disBtn') == false)
    {
    jQuery("#upgradeSub").removeAttr('disabled');
    }
    jQuery('.hostedSol').hide();
    }
    }
    <?php } ?>
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
                                                <a title="Back To List" href="<?php echo $partList; ?>" class="backBtnClass btn skyBlueBtn" ><i class="fa fa-arrow-left" aria-hidden="true"></i> List</a>  <a  title="Save & Continue" href="javascript:;" class="saveBtnClass btn" onclick="document.getElementById('saveBtn').value = '0';
                                                        submitFrm(jQuery('#<?php echo $form; ?>'));
                                                        return false;" >Save & Continue</a> <a href="javascript:;"  class="saveBtnClass btn" title="Save" onclick="document.getElementById('saveBtn').value = '1';
                                                            submitFrm(jQuery('#<?php echo $form; ?>'));
                                                            return false;">Save </a><?php   if (isset($isApproveRequest)) { ?><a target="_blank" href="<?php echo setLink('parts/parts-detail'); ?>?a_R=1"  class="btn skyBlueBtn" title="Check Updates"  >Check Updates</a><?php } else if (isset($id)) { ?><a target="_blank" href="<?php echo setLink('parts/parts-detail'); ?>"  class="btn skyBlueBtn" title="Preview"  >Preview</a><?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php if (isset($payment_token)) {
                                                                                                                                                                                                                                                 echo setLink('user/parts/payment-conformation'); ?><?php } else { ?><?php echo current_url(); ?><?php } ?>" method="post" name="<?php echo $form; ?>" id="<?php echo $form; ?>">
                                    <div class="formBoxInner"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <input type="hidden" name="edit" value="1">
                                                    <input type="hidden" name="parts_id" id="parts_id" value="<?php echo ( isset($id) && $id != "" ) ? $id : ""; ?>">

                                                    <div class="col-xs-12 note"><strong>Note:</strong> (<span class="redstar">*</span>) marked fields are mandatory</div>
                                                    <div class="formSepTitle mrgn-top-30">General</div> 
<?php if (isset($userData) && $isAdmin) { ?>
                                                        <div class="col-md-4 col-xs-6">
                                                            <div class="inputBox">  
                                                                <label class="captionLabel">User</label>
                                                                <div class="customSelect"> 
                                                                        <?php /* <span class="spanOut user_id">Select Existing User</span> */ ?>
                                                                    <select name="user_id" class="" id="user_id"  title="User Id" onkeyup="setSpanValue(jQuery(this));" >
                                                                        <option value="">Select User</option> 
                                                                        <?php foreach ($userData as $user) { ?>
                                                                            <option value="<?php echo $user['id']; ?>"><?php echo trim($user['name'] . " " . $user['surname']) . " (" . $user['email'] . ")"; ?></option>  
    <?php } ?>
                                                                    </select>    
                                                                </div>
                                                                <label for="user_id" class="error">Please select user</label>
                                                            </div>

                                                        </div> 
<?php } ?>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Parts Name</label>
                                                            <input type="text" name="part_name" id="part_name" title="Please enter parts name" class="inputFils required" value="<?php echo (isset($part_name) && $part_name != "") ? $part_name : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Part Code</label>
                                                            <input type="text" name="part_code" id="part_code" title="Please enter part code" class="inputFils" value="<?php echo (isset($part_code) && $part_code != "") ? $part_code : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel ">Year</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut year">Avaliable on request</span>
                                                                <select name="year"  id="year"  title="year" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                                    <option value="">Avaliable on request</option>
                                                                    <?php for ($y = 1990; $y <= date('Y'); $y++) { ?>
                                                                        <option value="<?php echo $y; ?>" <?php if (isset($year) && $year == $y) { ?>selected="selected"<?php } ?>><?php echo $y; ?></option>   
<?php } ?>
                                                                </select>    
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">Make</label>
                                                            <div class="customSelect"> 
                                                                    <?php /* <span class="spanOut make">Select make</span> */ ?>
                                                                <select name="make" class="makeDropDown" id="make"  title="Make" onkeyup="setSpanValue(jQuery(this));" >
                                                                    <option value="">Select Make</option>
                                                                    <?php foreach ($makeData as $m) { ?>
                                                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['make']; ?></option>   
<?php } ?>
                                                                </select>    
                                                            </div>
                                                            <label for="make" class="error">Please select make</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">Model</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut model">Select model</span>
                                                                <select disabled="disabled" name="model" class="" id="model"  title="Model" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                                    <option value="">Select Model</option>

                                                                </select> 
                                                            </div>    
                                                            <label for="model" class="error">Please select model</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">Category</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut category">Select condition</span>
                                                                <select name="category" class="" id="category_admin"  title="Category" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                                    <option value="">Select Category</option>
                                                                    <?php
                                                                    $c = 0;
                                                                    foreach ($categoryData as $cat) {
                                                                        if ($c != $cat['parent_id']) {
                                                                            ?>
                                                                            <option value="<?php echo $cat['parent_id']; ?>" <?php echo (isset($category) && $category == $cat['parent_id']) ? 'selected="selected"' : ''; ?>><?php echo $cat['parent_name']; ?></option>   
                                                                            <?php
                                                                        }
                                                                        if ($cat['parent_name'] != '') {
                                                                            if ($cat['child_id'] != "") {
                                                                                ?>
                                                                                <option value="<?php echo $cat['child_id']; ?>" <?php echo (isset($category) && $category == $cat['child_id']) ? 'selected="selected"' : ''; ?> >-- <?php echo $cat['child_name']; ?></option>   
                                                                                <?php
                                                                            }

                                                                            $c = $cat['parent_id'];
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>    
                                                            </div>
                                                            <label for="category" class="error">Please select category</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">Condition</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut condition">Select condition</span>
                                                                <select name="condition" class="" id="condition"  title="Condition" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                                    <option value="">Select Condition</option>
                                                                    <option value="used">Used</option>
                                                                    <option value="new">New</option>
                                                                    <option value="refurbish">Refurbish</option>
                                                                </select>    
                                                            </div>
                                                            <label for="condition" class="error">Please select condition</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">Ad Type</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut ad_type">Select Ad Type</span>
                                                                <select name="ad_type" class="" id="ad_type"  title="Ad Type" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                                    <option value="">Select Ad Type</option>
                                                                    <option value="1">Non Warranty</option>
                                                                    <option value="2">Warranty</option> 
                                                                </select>    
                                                            </div>
                                                            <label for="ad_type" class="error">Please select ad type</label>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="formSepTitle mrgn-top-30">Price</div> 
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">Price Type</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut price_type">Select price type</span>
                                                                <select name="price_type" class="" id="price_type"  title="Price Type" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this)); showPrice(this.value)">
                                                                    <option value="">Select Price Type</option>
                                                                    <option value="r">Range</option>
                                                                    <option value="f">Fix</option>
                                                                    <option value="n">Negotiable</option>
                                                                    <option value="c">P.O.A</option>
                                                                </select>    
                                                            </div>
                                                            <label for="price_type" class="error">Please select price type</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xs-6 hasCheckInput" id="gst_section" style="display:none">

                                                        <div class="inputBox priceField price_section" id="price_section" class="" style="display:none">
                                                            <label class="captionLabel star price_from">Price</label>
                                                            <input type="text" name="price" id="price" title="Please enter price" class="inputFils required numericOnly" value="<?php
                                                            if (isset($price) && $price != "0") {
                                                                echo $price;
                                                            }
                                                            ?>">
                                                        </div>                                     
                                                        <div class="inputBox hasCheckInput">
                                                            <div class="chkInn chkClosedHrs">
                                                                <label for="chkGst">
                                                                    <input type="checkbox" id="is_gst" name="is_gst" title="Including GST?" class="chkSelect checkBox" value="<?php
                                                                    if (isset($is_gst)) {
                                                                        echo $is_gst;
                                                                    } else {
                                                                        echo "0";
                                                                    }
                                                                    ?>" <?php if ((isset($is_gst) && $is_gst == '1') || (isset($id) && $id == 0)) { ?>checked='checked'<?php } ?> onclick="if (this.checked) {
                                                                        this.value = '1';
                                                                        } else {
                                                                        this.value = '0';
                                                                        }" /><span><i class="fa fa-check" aria-hidden="true"></i></span> Price Including GST<em style="color:#ff0000;">*</em></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6" >
                                                        <div class="inputBox priceField price_section" id="price_section_range" class="" style="display:none">
                                                            <label class="captionLabel star price_from">Price</label>
                                                            <input type="text" name="price_from" id="price_from" title="Please enter price" class="inputFils required numericOnly" value="<?php
                                                            if (isset($price) && $price != "0") {
                                                                echo $price;
                                                            }
                                                            ?>">
                                                        </div>
                                                        <div class="inputBox priceField price_to_section" id="price_to_section" style="display:none">
                                                            <label class="captionLabel star">Price To</label>
                                                            <input type="text" name="price_to" id="price_to" title="Please price to" class="inputFils required numericOnly" value="<?php
                                                            if (isset($price_to) && $price_to != "0") {
                                                                echo $price_to;
                                                            }
                                                            ?>">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="formSepTitle mrgn-top-30">Additional Details</div>          
                                                    <div class="clearfix"></div>
                                                    <div class="col-xs-12">
                                                        <div class="addBannerSec"> 
                                                            <div class="bannerUpload userImg">
                                                                <div class="uploadBanner">
                                                                    <label class="captionLabel">Upload Main Image</label>
                                                                    <div class="uploadBox" data-colorclass = 'popTBlue' onclick="setDirectoryValue('parts')"> 
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
                                                    <div class="col-md-3 col-sm-3 col-xs-5">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Weight</label>
                                                            <input type="text" name="weight" id="weight" title="Please entet weight" class="inputFils numericOnly" value="<?php echo (isset($total_weight)) ? $total_weight : ""; ?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3 col-sm-3 col-xs-5">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Quantity</label>
                                                            <input type="text" name="qty" id="qty" title="Please entet quantity" class="inputFils numericOnly" value="<?php echo (isset($quantity)) ? $quantity : ""; ?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3 col-sm-3 col-xs-5">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Width</label>
                                                            <input type="text" name="width" id="width" title="Please entet width" class="inputFils numericOnly" value="<?php echo (isset($width)) ? $width : ""; ?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3 col-sm-3 col-xs-5">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Height</label>
                                                            <input type="text" name="height" id="height" title="Please entet height" class="inputFils numericOnly" value="<?php echo (isset($height)) ? $height : ""; ?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3 col-sm-3 col-xs-5">
                                                        <div class="inputBox">
                                                            <label class="captionLabel">Length</label>
                                                            <input type="text" name="length" id="width" title="Please entet length" class="inputFils numericOnly" value="<?php echo (isset($length)) ? $length : ""; ?>">
                                                        </div>
                                                    </div>                 
                                                    <div class="col-md-12 col-xs-12">  
                                                        <div class="inputBox">  
                                                            <div class="descBtns">	
                                                                <input type="button" id="html-editor" onclick="tinymce.execCommand('mceImage', false, 'description');" value="Insert Image" title="Insert Image" class="btn backBtn pull-right"/>              <div class="editTab"></div>
                                                            </div> 
                                                            <label class="captionLabel">Brief Description</label>
                                                            <textarea name="description" id="description" title="Brief Description" class="inputFils msgBox" placeholder="Brief Description"><?php echo (isset($description) && $description != "") ? $description : ""; ?></textarea>
                                                        </div>  
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="formSepTitle mrgn-top-30">Parts Location</div>   
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Address</label>
                                                            <input type="text" name="address"   value="<?php echo (isset($address)) ? $address : ""; ?>" title="Address" class="inputFils" id="gap_address">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-4 col-xs-6"> 
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Suburb</label> 
                                                            <div class="customSelect"> 
                                                                <span class="spanOut suburb">Select suburb</span>
                                                                <select name="suburb"  id="searchSuburb"  title="Suburb" onkeyup="setSpanValue(jQuery(this));" >
                                                                    <option value="">Select suburb</option>
                                                                    <?php foreach ($suburbData as $sub) { ?>
                                                                        <option value="<?php echo $sub['suburb']; ?>" <?php if (isset($suburb) && $sub['suburb'] == $suburb) { ?>selected="selected"<?php } ?>><?php echo $sub['suburb']; ?></option>   
<?php } ?>
                                                                </select>    
                                                            </div>
                                                            <label for="searchSuburb" class="error" >Please enter suburb</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">  
                                                            <label class="captionLabel star">State</label>
                                                            <div class="customSelect"> 
                                                                <span class="spanOut state">Select state</span>
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
                                                            <label for="state" class="error">Please select state</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Postcode</label>
                                                            <input type="text" name="postcode"   value="<?php echo (isset($postcode)) ? $postcode : ""; ?>" title="Postcode" class="numericOnly numbers inputFils" maxlength="4" id="gap_postcode">
                                                        </div>
                                                    </div>


                                                    <input type="hidden" name="is_edit" id="is_edit"  value="<?php echo (isset($id)) ? $id : "0"; ?>" />

                                                    <input type="hidden" name="random_code" id="random_code" value="<?php echo (isset($use_folder)) ? $use_folder : ""; ?>" /> 
                                                    <input type="hidden" name="page" id="page" value="<?php echo (isset($page)) ? $page : ""; ?>" />
                                                    <div class="clearfix"></div>
                                                    <div class="formSepTitle mrgn-top-30">Additional Images</div>    
                                                    <div id="additional_images_section"  >
                                                        <?php
                                                        if (isset($additional_image))
                                                            $additional_image = json_decode($additional_image, true);

                                                        for ($i = 2; $i < $additional_image_limit; $i++) {
                                                            $additionalImgURL = "";
                                                            $additionalImgURL = (isset($additional_image[$i - 2]) && $additional_image[$i - 2] != "") ? $additional_image[$i - 2] : "";
                                                            $additionalImgVal = $additionalImgURL;
                                                            if ($additionalImgURL != "") {
                                                                if (!$isAdmin && isset($payment_token))
                                                                    $additionalImgURL = Utility::getResizeURL($additional_image[$i - 2], "small", "parts", $use_folder, $imgFolder);
                                                                else
                                                                    $additionalImgURL = Utility::getResizeURL($additional_image[$i - 2], "small", "parts", $id, $imgFolder);
                                                            }
                                                            ?>     
                                                            <div class="col-sm-2 col-xs-4">
                                                                <div class="bannerUpload userImg">
                                                                    <div class="uploadBanner"> 
                                                                        <div class="uploadBox" data-colorclass = 'popTBlue' onclick="setDirectoryValue('parts')"> 
                                                                            <input id="additional_image<?php echo $i; ?>" type="file" class="input-text uploadImage" title="Additional Image" name="files[<?php echo ($i - 1); ?>]" data-id="<?php echo $i; ?>" single>

                                                                            <div id="progress<?php echo ($i - 1); ?>" class="progress" style="display: none;" >
                                                                                <div style="float:left" class="uploading"> Uploading...</div>
                                                                                <div class="progress-bar progress-bar-success"  style="width:0%;display: none;"></div>
                                                                            </div>
                                                                            <div id="files<?php echo ($i - 1); ?>" class="files"></div>
                                                                            <input type="hidden" name="additional_image[]" id="hndfileupload<?php echo ($i - 1); ?>" value="<?php echo $additionalImgVal; ?>" />
                                                                            <img class="bannerImg" src="<?php echo $path; ?>/images/defalt-banner.jpg">

                                                                            <div id="imgPreview<?php echo ($i - 1); ?>" class="imgOverView" <?php if ($additionalImgURL == "") { ?>  style="display:none" <?php } ?>>
                                                                                <img   src="<?php echo $additionalImgURL; ?>" /> 
                                                                            </div>
                                                                            <?php if ($additionalImgURL != "") { ?>
                                                                                <a data-url="<?php echo $additionalImgURL; ?>"  data-hidden="hndfileupload<?php echo ($i - 1); ?>" data-preview="imgPreview<?php echo ($i - 1); ?>" onclick='delImg(this)' title="Delete">Delete</a>
    <?php } ?>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>             
<?php } ?>
                                                        <div class="info">
                                                            <span class="infoNote">You can upload images up to 5MB.<br><b>Allowed extensions:</b> jpg,png<br><b> Recommended size: width: 800px, height: 600px</b></span> 
                                                            <div id="fileError1" class="validation-advice" style="display: none;"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-xs-4"> 
                                                        <div class="inputBox chk_Box">
                                                            <label class="captionLabel">&nbsp;</label>
                                                            <label for="chkStatus">
                                                                <input id="chkStatus" type="checkbox" name="status" value="<?php
                                                                if (isset($status)) {
                                                                    echo (int) $status;
                                                                } else {
                                                                    ?>1<?php } ?>"   <?php if ((!isset($id)) || (isset($status) && $status == '1')) { ?>checked="checked"<?php } ?>  onclick="if (this.checked) {
                                                                        this.value = '1';
                                                                        } else {
                                                                        this.value = '0';
                                                                        }" title="Status" class="checkbox" /><span >Status</span></label>
                                                        </div>
                                                    </div>
                                                    <?php if($isAdmin==true) { ?>
                                                    <div class="col-md-2 col-xs-4"> 
                                                        <div class="inputBox chk_Box">
                                                            <label class="captionLabel">&nbsp;</label>
                                                            <label for="is_featured">
                                                                <input id="is_featured" type="checkbox" name="is_featured" value="<?php
                                                                if (isset($is_featured)) {
                                                                    echo (int) $is_featured;
                                                                } else {
                                                                    ?>1<?php } ?>"   <?php if  (isset($is_featured) && $is_featured == '1') { ?>checked="checked"<?php } ?>  onclick="if (this.checked) {
                                                                        this.value = '1';
                                                                        } else {
                                                                        this.value = '0';
                                                                        }" title="Set As Featured" class="checkbox" /><span >Set As Featured</span></label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <input type="hidden" name="saveBtn" id="saveBtn" value="1" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
<?php if (!$isAdmin) {
    if (isset($payment_token)) {
        ?>
                                            <input type="hidden" name="token" value="<?php echo $payment_token; ?>">
                                            <input type="hidden" name="PayerID" value="<?php echo $payment_PayerID; ?>">  
                                        <?php } ?>

                                        <input type="hidden" name="totalPayment" value="<?php echo $parts_price; ?>" />  
                                        <input type="hidden" name="payment_type" id="payment_type" value="<?php if ($isAdmin) { ?>ADMIN_PAY<?php } else { ?>PAYPAL_EXPRESS<?php } ?>">
                                <?php } ?>
                                </form>
<?php if ($isAdmin == false && !isset($id) && !isset($payment_token)) {
    ?>
                                    <div class='clearfix'></div>
                                    <section class="paymentPageMain payment_detail">
                                        <div class="formHeader">
                                            <div class="formBoxHead">
                                                <div class="pull-left">
                                                    <label class="lbl_title"><strong>Select Payment Method</strong></label>
                                                </div>
                                                <div class="editForm"> 
                                                    <strong>Per Part Charge $<?php echo $parts_price; ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="formBox">

                                            <div class="pymtformBox clearfix">
                                                <div class="pymtOptionBox">
                                                    <ul class="pymtul detailTab">

                                                        <li class="tabing active" data-tab="tab-2" data-paymentType="PAYPAL_EXPRESS"><span data-paymentType="PAYPAL_EXPRESS" class="span_paypal"><span class="innerPaypal">Paypal</span></span></li>
                                                        <li class="tabing" data-tab="tab-3" data-paymentType="PAYPAL_HOSTED_SOLUTIONS"><span data-paymentType="PAYPAL_HOSTED_SOLUTIONS" class="span_credit"><span class="innerCredit">Credit Card</span></span></li> 
                                                    </ul> 
                                                </div>
                                                <div class="pymtformBoxInner accMainDiv">
                                                    <div class="accoContain" id="tab-2">
                                                        <div class="inputBox">
                                                            Pay with paypal express.<br>You will be redirected on paypal website for payment.
                                                        </div>
                                                    </div>
                                                    <div class="accoContain" id="tab-3">
                                                        <div class="inputBox">
                                                            Please read below terms and conditions and click on "Pay Now" to enter your credit card details.  
                                                        </div>
                                                    </div>    
                                                </div>

                                            </div>	

                                        </div>


                                        <label class="lbl_title"><strong>Terms And Condition</strong></label>

                                        <div id="termsCondition" class="">
    <?php include $terms_condtion . '/terms-condition.php'; ?>
                                        </div>
                                        <small class="exampleText"><b>Note</b> : Scroll Down Terms And Condition To Bottom For Enable "Payment" Button.</small>


                                    </section>   
                                    <section class="container"> 
                                        <div class="row">
                                            <div class="col-md-12 hostedSol" >
                                                <iframe name="hss_iframe" id="hss_iframe" class="" width="100%" style="height:10px"></iframe>  
                                            </div>
                                        </div>
                                    </section>
                                    <input type="hidden" id="isPayClicked" value="false" />
                                    <form style="display:none" target="hss_iframe" name="form_iframe" id="form_iframe" method="post" action="https://<?php echo $CI->config->item('PayHost'); ?>/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess">

                                        <input type="hidden" name="cmd" value="_hosted-payment">
                                        <input type="hidden" name="item_name_0" value="Parts" />
                                        <input type="hidden" name="item_number_0" value="1" />
                                        <input type="hidden" name="quantity_0" value="1" />

                                        <input type="hidden" name="subtotal"   value="<?php echo $parts_price; ?>">
                                        <!--<input type="hidden" name="business" value="A3NXZ8P488FB4" /> -->
                                        <input type="hidden" name="business" value="<?php echo $CI->config->item('PayBusiness'); ?>"> 
                                        <input type="hidden" name="paymentaction" value="sale">
                                        <input type="hidden" name="template" value="templateD"> 
                                        <input type="hidden" name="currency_code" value="AUD">
                                        <input type="hidden" name="showHostedThankyouPage" value="false">
                                        <input type="hidden" name="return" value="<?php echo setLink('payment-thank-you'); ?>">
                                        <input type="hidden" name="cancel_return" value="<?php echo setLink('user/parts/parts_list'); ?>?payment_cancel=1">
                                        <input type="hidden" name="billing_first_name" value="" />
                                        <input type="hidden" name="billing_last_name" value="" />
                                        <input type="hidden" name="billing_address1" value="" />
                                        <input type="hidden" name="billing_state" value="" />
                                        <input type="hidden" name="billing_city" value="" />
                                        <input type="hidden" name="billing_zip" value="" />
                                    </form>
<?php } ?>
                            </div>  
                            <div  class="formBoxHead bottom_edit">
                                <div class="editForm">
                                    <a title="Back To List" href="<?php echo $partList; ?>" class="backBtnClass btn skyBlueBtn" ><i class="fa fa-arrow-left" aria-hidden="true"></i> List</a>  <a  title="Save & Continue" href="javascript:;" class="saveBtnClass btn" onclick="document.getElementById('saveBtn').value = '0';
                                            submitFrm(jQuery('#<?php echo $form; ?>'));
                                            return false;" >Save & Continue</a> <a href="javascript:;"  class="saveBtnClass btn" title="Save" onclick="document.getElementById('saveBtn').value = '1';
                                                submitFrm(jQuery('#<?php echo $form; ?>'));
                                                return false;">Save </a> <?php   if (isset($payment_token)) { ?> 
                                        <button type="submit" id="paySub"   class="btn skyBlueBt" title="Confirm & Save" onclick="
                                                 submitFrm(jQuery('#<?php echo $form; ?>'));">Confirm & Save</button>
                                            <?php } else  if (!$isAdmin)  { ?>
                                        <button type="submit" id="upgradeSub" disabled="disabled" class="btn skyBlueBtn disBtn" title="Proceed To Payment" onclick="if (jQuery('#isPayClicked').val() == 'true') {
                                submitFrm(jQuery('#<?php echo $form; ?>')); }">Pay & Save</button>    
<?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $currentPath . '/popup.php'; ?>