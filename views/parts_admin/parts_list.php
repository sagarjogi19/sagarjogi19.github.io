<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url    
$currentPath = __DIR__;
$currentPath = str_replace("parts_admin", "user", $currentPath);
$isTrash=1;
if ($showData=="list") { 
    $isTrash=0;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
<?php if (isset($searchSession)) { ?>
            setSearchedData('<?php echo $searchSession; ?>');
<?php } ?>
      
        doPaging(jQuery("#show_page").val(), 'loader', jQuery('#tableData'), createRows);
        loadNextPrev(jQuery('#tableData'));
        onTrash();
        jQuery("#btnSearchPart").click(function () {

            if (jQuery("#txtSearch").val() != "" || jQuery("#make").val() != "" || jQuery("#category").val() != "") {
                var dataObj = jQuery("#searchFrm").serialize();
                doPaging(0, 'loader', jQuery('#tableData'), createRows, '', dataObj);
            } else {
                var msgBox = "enter any keyword or select make,model or category";
                if (jQuery("#txtSearch").attr("placeholder") != "") {
                    msgBox = jQuery("#txtSearch").attr("placeholder").toLowerCase();
                }
                alert('Please ' + msgBox + ' to search');
                return false;
            }
        });
        jQuery("#btnResetPart").click(function () {
            resetBtn = true;
            jQuery("#txtSearch").val('');
            jQuery("#make").val('');
            jQuery("#model").val('');
            jQuery(".divModel").hide();
            jQuery("#category").val('');
            setSpanValue(jQuery("#make"));
            setSpanValue(jQuery("#model"));
            setSpanValue(jQuery("#category"));
            doPaging(0, 'loader', jQuery('#tableData'), createRows);
            createPages(0);
        });
        jQuery("#make").on("change", function () {
            if (jQuery(this).val() != "") {
                jQuery(".model").html("Loading...");
                jQuery(".divModel").show();
                var url = window.location.href.split('?')[0];
                jQuery.ajax({
                    url: url.replace(/list/g, 'add'),
                    type: 'POST',
                    data: {makeValue: jQuery(this).val()},
                    async: true,
                    success: function (data) {
                        var modelData = jQuery.parseJSON(data);
                        var html = '<option value="">Select model</option>';
                        for (var mo = 0; mo < modelData.models.length; mo++) {
                            html += '<option value="' + modelData.models[mo].id + '">' + modelData.models[mo].model + '</option>';
                        }
                        jQuery("#model").html('');
                        jQuery("#model").append(html);
                        jQuery(".model").html("Select Model");
                    }
                });
            } else {
                jQuery("#model").val('');
                setSpanValue(jQuery("#model"));
                jQuery(".divModel").hide();
            }

        });
    });
    function createRows(data, obj) {
        var html = ''; 
        if (jQuery(data).length > 0) {
            jQuery(data).each(function (key, val) {
                var cls = "";
                var invoice = "";
                var currency ="$";
                var price=parseFloat(val.price).toFixed(2);
                var price_to="";
                if (val.price_to!=""){
                    price_to=parseFloat(val.price_to).toFixed(2);
                }
                console.log(val);
                if ((val.approved && val.approved == '0') || (val.user_request && val.user_request == '1')) {
                    cls = "class='redRow'";
                }
                if (((val.payment_mode != "ADMIN_PAY") && (val.payment_status == "COMPLETE")) && val.payment_id != null) {
                    invoice = '<a target="_blank" href="' + window.location.href.split('?')[0].replace('/user/parts/parts_list', "/parts-invoice-pdf/" + val.payment_id+"/"+val.id) + '" class="tEdit trans" title="Download Invoice" target="_blank"><i class="fa fa-download  trans" aria-hidden="true"></i></a>';
                }
                html += '<tr ' + cls + '><td class="chkInn"><label><input type="checkbox" class="chkSelect checkBox" id="chkSelect" value="' + val.id + '"  name="chkSelect[' + val.id + ']" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label> </td><td class="checkId" data-title="Id:">' + val.id + '</td><td class="text_left" data-title="Part Name:"><a href="' + window.location.href.split('?')[0].replace(/list/g, "add?id=" + val.id) + '&page=' + getCurrentPage() + '" class="tdTitle" style="font-weight:bold">' + val.part_name + '</a></td> <td class="text_left" data-title="Part Code:">' +val.part_code + '</td><td class="text_left" data-title="Ad Type:">' + (val.ad_type==1?"Non Warranty":"Warranty") + '</td> <td class="text_left" data-title="Weight:">' +val.total_weight + '</td><td class="text_left" data-title="Quantity:">' +val.quantity + '</td>  <td class="text_left" data-title="Make:">' + getMake(val.make) + '</td> <td class="text_left" data-title="Model:">' + val.model + '</td> <td class="text_left" data-title="Category:">' + getCategory(val.category) + '</td><td class="text_left" data-title="Suburb:">' + val.suburb + '</td><td class="text_left" data-title="Created By:">' + val.created_by + '</td><td class="statusCell" data-title="Status:"><span class="statusSpan ' + (val.status == '0' ? "inactive" : "") + '" title="' + (val.status == '1' ? "Active" : "Inactive") + '"></span> ' + (val.status == '1' ? "Active" : "Inactive") + '</td><td class="S_action" data-title="Actions:"><a href="' + window.location.href.split('?')[0].replace(/list/g, "add?id=" + val.id) + '&page=' + getCurrentPage() + '" class="tEdit trans" title="Edit"><i class="fa fa-pencil-square-o trans" aria-hidden="true"></i></a>' + invoice + '<a class="delRecord" data-title="' + val.id + '" href="javascript:;" title="Delete" class="tDelete trans"><i class="fa fa-trash-o fa-1x trans" aria-hidden="true"></i></a><a class="chStatus" data-title="' + val.id + '" data-status="' + (val.status == '1' ? "0" : "1") + '" title="Change Status" href="javascript:;" class="tStatus trans"><i class="fa fa-exchange fa-1x trans" aria-hidden="true"></i></a>' + restoreHTML(val.id) + '</td></tr>';


            });
        } else {
            html += '<tr><td colspan="14" align="center">No records found</td></tr>';
        }
        obj.find('tbody').html(html);

    }
    var make= jQuery.parseJSON('<?php echo json_encode($makeData); ?>'); 
    var category= jQuery.parseJSON('<?php echo json_encode($categoryData); ?>'); 
    function getMake(make_id){
        var mkName="";
        jQuery.each(make, function(i, v) {
          if(v.id==make_id) { 
              mkName=v.make;
           }
       });  
       return mkName;
    }
    
   function getCategory(cat_id){
        var catName="";
        jQuery.each(category, function(i, v) {
          if(v.parent_id==cat_id) { 
              catName=v.parent_name;
           }
         else if(v.child_id==cat_id) { 
              catName=v.child_name;
         }
       });  
       return catName;
    }

</script>
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="teamMain categoryMain notfiicationTabMain">
                <div class="">
                    <div class="container"> 
                        <?php include 'sub_tabs.php'; ?>
                         <?php if (isset($showData)) { ?>
                            <ul class="dTabLi"> 
                            <span class="int_overlay"></span>
                            <li class="tabing in <?php if ($isTrash==0) { ?> current <?php } ?>" data-tab="list"><a href="<?php echo setLink('user/parts/parts_list'); ?>" title="Published / Unpublished">Publish / Unpublish</a></li>
                            <li class="tabing in <?php if ($isTrash==1) { ?> current <?php } ?>" data-tab="trash"><a href="<?php echo setLink('user/parts/parts_list'); ?>?show=trash" title="Trash">Trash</a></li>
                            </ul> 
                            <input type="hidden" id="isTrash" value="<?php if ($isTrash==0) { ?>0<?php } else { ?>1<?php } ?>" />
                         <?php } ?>
                        <div class="dTabCon"> 
                            <div class="">
                                <input type="hidden" id="show_page" value="<?php echo $show_page; ?>" />
                                <input type="hidden" name="totalCount" id="totalCount" value="<?php echo $totalCount; ?>" />
                                <div class="teamHeader">

                                    <div class="searchSec">
                                        <div class="loader"><span>Loading...</span></div>

                                        <form id="searchFrm" name="searchFrm" onsubmit="return false;" data-drupal-form-fields="txtSearch">
                                            <div class="customSelect selectUserDl"> 
                                                <span class="spanOut make">Select make</span>
                                                <select name="make" id="make"  title="Make" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                    <option value="">Select make</option> 
                                                    <?php foreach ($makeData as $m) { ?>
                                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['make']; ?></option>     
                                                    <?php } ?>
                                                </select>    
                                            </div>
                                            <div class="customSelect selectUserDl divModel" style="display:none"> 
                                                <span class="spanOut model">Select model</span>
                                                <select name="model" id="model"  title="Model" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                    <option value="">Select model</option> 
                                                </select>    
                                            </div>
                                            <div class="customSelect selectUserDl"> 
                                                <span class="spanOut category">Select category</span>
                                                <select name="category" id="category"  title="Category" onkeyup="setSpanValue(jQuery(this));" onchange="setSpanValue(jQuery(this));">
                                                    <option value="">Select category</option> 
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
                                            <input type="text" title="Search keyword" placeholder="Search keyword" id="txtSearch" name="search" class="inputFils">
                                            <button class="btn skyBlueBtn" id="btnSearchPart" type="submit" value="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i> </button>
                                            <button class="btn" id="btnResetPart" type="button" value="Reset" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                    <div class="actionBtn">
                                        <div class="customSelect">
                                            <span class="spanOut action"></span>
                                            <select title="Bulk Action" name="action" id="action" onchange="setSpanValue(jQuery(this));" onkeyup="setSpanValue(jQuery(this));" >
                                                <option value="">Actions</option>
                                                <?php if($isTrash==0) { ?>
                                                <option value="inactive">Inactive</option>
                                                <option value="active">Active</option>
                                                <option value="delete">Delete</option>
                                                <?php } else {  ?>
                                                 <option value="restore">Restore</option>
                                                <option value="delete">Permanent Delete</option> 
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="S_addNew"> 
                                        <a href="<?php echo setLink('user/parts/parts_add'); ?>" title="Add New" class="btn skyBlueBtn">Add New</a>
                                    </div>
                                </div>
                                <div class="teamListMain">
                                    <form id="frmData" name="frmData">
                                        <table id="tableData" class="table table-bordered table-striped custom-table">
                                            <thead>
                                                <tr>
                                                    <th class="chkInn">
                                                        <label><input type="checkbox" name="selectAll" id="selectAll" class="checkBox" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label>
                                                    </th>
                                                    <th aria-sort="desc" data-title="id" class="is-active sortOrder">Id</th>
                                                    <th aria-sort="desc" data-title="part_name" class="is-active sortOrder">Part Name</th> 
                                                    <th aria-sort="desc" data-title="part_code" class="is-active sortOrder">Part Code</th> 
                                                     <th aria-sort="desc" data-title="ad_type" class="is-active sortOrder">Ad Type</th>
                                                    <th aria-sort="desc" data-title="weight" class="is-active sortOrder">Weight</th> 
                                                    <th aria-sort="desc" data-title="qty" class="is-active sortOrder">Quantity</th> 
                                                    <th aria-sort="desc" data-title="make" class="is-active sortOrder">Make</th>
                                                    <th aria-sort="desc" data-title="model" class="is-active sortOrder">Model</th>
                                                    <th aria-sort="desc" data-title="category" class="is-active sortOrder">Category</th> 
                                                   <th aria-sort="desc" data-title="suburb" class="is-active sortOrder">Suburb</th>
                                                    <th aria-sort="desc" data-title="created_by" class="is-active sortOrder">Created By</th>
                                                    <th aria-sort="desc" data-title="status" class="is-active sortOrder">Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </form>
                                </div> 
                                <?php include $currentPath . '/pagging.php'; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>