<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__;
$currentURL = setLink('user/make_add');
if (isset($makeData))
    extract($makeData);

$form = 'formMachineAdd';
?>
<script type="text/javascript">
    jQuery.validator.addMethod("uniqLead", function (value, element) {
    var ret = true;
    jQuery(".modelName").each(function (k, v) {

    if (jQuery(v).val() != "" && v != element && jQuery(v).val().toLowerCase().trim() == value.toLowerCase().trim() && ret) {
    ret = false;
    }
    });
    return ret;
    }, "Model must be unique");
    var cntModel = 1;
    jQuery(".commonBtnul").remove();
    jQuery(document).ready(function () {
<?php if (isset($id) && $id != "") { ?>
    <?php if (isset($searchSession)) { ?>
            setSearchedData('<?php echo $searchSession; ?>');
    <?php } ?>
        doPaging(jQuery("#show_page").val(), 'loader', jQuery('#tableData'), createRows, null, "makeid=<?php echo $id; ?>");
        loadNextPrev(jQuery('#tableData'));
        jQuery("#btnResetModel").click(function(){
        resetBtn = true;
        jQuery("#txtSearch").val('');
        doPaging(0, 'loader', jQuery('#tableData'), createRows, null, "makeid=<?php echo $id; ?>");
        createPages(0);
        });
<?php } ?>
    var rules = {
    make: {required: true, remote: {url: '<?php echo $currentURL; ?>', type: "post", data: {'checkMake': 'true', 'id': jQuery("#is_edit").val()}}},
            "model[]": {required: function () {
            return parseInt(jQuery("#is_edit").val()) == 0
            }, uniqLead: true<?php if (isset($id) && $id != "") { ?>, remote: function (element) {
                return {url: '<?php echo $currentURL; ?>', type: "post", data: {'checkModel': 'true', 'id': jQuery("#is_edit").val(), 'modelData': jQuery(element).val()}}
                }<?php } ?>}
    };
    var messages = {
    make: {required: "Please enter make", remote: 'Make already exists'},
            "model[]": {required: "Please enter model", uniqLead: "Model must be unique"<?php if (isset($id) && $id != "") { ?>, remote: "Model must be unique"<?php } ?>}
    };
    validateForm(jQuery('#<?php echo $form; ?>'), rules, messages);
    jQuery(".addModel").bind("click", function () {
    jQuery(".modelSection").append(modelInputBox(cntModel, ''));
    cntModel++;
    });
    });
    function modelInputBox(i, modelVal) {
    var modelHTML = '';
    modelHTML = '<div id="modelSec' + i + '"><div class="col-sm-3 col-xs-12 withDeleteRow"><div class="inputBox"><input type="text" name="model[]" class="inputFils modelName" id="model' + i + '"  value="' + modelVal + '" /></div><div class="delModel col-xs-1 delWebsite"  onclick="deleteModel(' + i + ')"><i title="Delete" class="fa fa-trash-o" aria-hidden="true"></i></div></div></div>';
    return modelHTML;
    }
<?php if (isset($id) && $id != "") { ?>
        function createRows(data, obj) {
        var html = '';
        if (jQuery(data).length > 0) {
        jQuery(data).each(function (key, val) {

        html += '<tr><td class="chkInn"><label><input type="checkbox" class="chkSelect checkBox" id="chkSelect" value="' + val.id + '@del"  name="chkSelect[' + val.id + ']" /><span><i class="fa fa-check" aria-hidden="true"></i></label></td><td id="modelRow' + val.id + '" class="text_left modelRow checkId" data-title="' + val.id + '" data-old="' + val.model + '" onclick="createInput(' + val.id + ');">' + val.model + '</td><td class="S_action" data-title="Actions:"><a class="delRecord" data-title="' + val.id + '@del" href="javascript:;" title="Delete" class="tDelete trans"><i class="fa fa-trash-o fa-1x trans" aria-hidden="true"></i></a></td></tr>';
        });
        } else {
        html += '<tr><td colspan="6" align="center"><div class="norecord">No records found </div></td></tr>';
        }
        obj.find('tbody').html(html);
        }
        function deleteModel(id) {
        var yn = confirm('Are you sure want to delete this record?');
        if (yn == true) {
        jQuery("#modelSec" + id).remove();
        }

        }

        function createInput(id){
        jQuery.each(jQuery(".clsModel"), function(){
        var mid = jQuery.trim(jQuery(this).attr("id").replace('txtModelText', ''));
        if (mid != id){
        jQuery(this).remove();
        jQuery(this).closest("a").remove();
        cancelModel(mid);
        }
        });
        if (jQuery("#txtModelText" + id).length == 0){
        var inputHTML = ' <input type="text" title="Please enter model" id="txtModelText' + id + '" name="txtModelName" value="' + jQuery("#modelRow" + id).html() + '" onblur="saveModelData(' + id + ')" class="inputFils clsModel" />';
        jQuery("#modelRow" + id).html(inputHTML);
        jQuery("#modelRow" + id).addClass('modelTxtRow');
        }
        }

        function saveModelData(id){
        if (jQuery("#txtModelText" + id).val() != jQuery("#modelRow" + id).attr("data-old") && jQuery("#txtModelText" + id).val() != "") {
        var yn = confirm('Are you sure want to update this record?');
        if (yn == true){
        jQuery(".loader").show();
        jQuery.ajax({
        url:'<?php echo $currentURL; ?>',
                type:'post',
                data:{'action':'update_model', 'modelData':jQuery("#txtModelText" + id).val(), 'id':jQuery('#is_edit').val(), 'modelid':jQuery("#modelRow" + id).attr("data-title")},
                success:function(data){
                jQuery(".loader").hide();
                if (data == '1'){
                jQuery("#modelRow" + id).attr("data-old", jQuery("#txtModelText" + id).val());
                }
                showMsg(data);
                }
        });
        }

        }   cancelModel(id);
        }
        function cancelModel(id){
        jQuery("#modelRow" + id).html(jQuery("#modelRow" + id).attr("data-old"));
        jQuery("#modelRow" + id).removeClass('modelTxtRow');
        }
        function showMsg(data){
        if (data == "1"){
             alert('Model is updated successfully');
        } else {
            alert('Model is already exists');
        }
        doPaging(jQuery("#show_page").val(), 'loader', jQuery('#tableData'), createRows, null, "makeid=<?php echo $id; ?>");
        }
<?php } ?>
</script>            
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/user/tabs.php'; ?>
            <div class="categoryAdd notfiicationTabMain">
                <div class="container">
                    <div class="dTabCon">
                        <div class="">

                            <div class="formBox edit_frm">
                                   <div class="editForm">
<?php displayButton($form, 'user/make_list'); ?>
                                </div> 
                                <form name="<?php echo $form; ?>" id="<?php echo $form; ?>" action="<?php echo current_url(); ?>"   method="post" enctype="multipart/form-data">
                                    <div class="formBoxInner"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-xs-12 note"><strong>Note:</strong> (<span class="redstar">*</span>) marked fields are mandatory</div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="inputBox">
                                                            <label class="captionLabel star">Make</label> 
                                                            <input type="text" name="make" class="inputFils required" id="make" title="Please enter make"   value="<?php echo (isset($make) ? $make : ""); ?>" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-xs-4">
                                                          <div class="inputBox chk_Box">
                                                            <label class="captionLabel">&nbsp;</label>
                                                            <label for="chkStatus">
                                                                <input id="chkStatus" type="checkbox" name="status" value="<?php if(isset($status)){ echo (int)$status; } else { ?>0<?php } ?>"  <?php if ((isset($id) && $id == "")  || (isset($status) && $status == '1')) { ?>checked="checked"<?php } ?> onclick="if (this.checked) {
                                                                this.value = '1';
                                                            } else {
                                                                this.value = '0';
                                                            }" title="Status" class="checkbox" /><span >Status</span></label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="is_edit" id="is_edit"  value="<?php
                                                    if ((isset($id) && $id != "")) {
                                                        echo $id;
                                                    } else {
                                                        ?>0<?php } ?>" />
                                                    <input type="hidden" name="saveBtn" id="saveBtn" value="1" />  
                                                    <input type="hidden" name="page" id="page" value="<?php echo (int) $this->input->get('page'); ?>" />

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="formBox">
                                                            <div class="formSepTitle mrgn-top-30">Models</div>
                                                            <div class="modelSection row">   
                                                                <div id="modelSec0">
                                                                    <div class="col-sm-3 col-xs-12 withDeleteRow">
                                                                        <div class="inputBox"> 
                                                                            <input type="text" name="model[]" class="inputFils modelName" id="model0"   value="" />
                                                                        </div>
                                                                        <div class="delWebsite col-xs-1 delMbl" onclick="document.getElementById('model0').value = '';">
                                                                            <i title="Reset" class="fa fa-refresh" aria-hidden="true"></i>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="addModel trans addNew"><i class="fa fa-plus" aria-hidden="true"></i> Add New</div>



                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </form> 
                                <div class="clearfix"></div>
<?php // Model List   ?>
<?php if (isset($id) && $id != 0) { ?>
                                    <div class="formBoxHead formBoxHeadActive">
                                        <div class="formHeadLeft">                                
                                            <span class="stepTitle">Models Listing</span>
                                        </div> 
                                    </div>
                                    <div class="teamHeader"> 
                                        <?php
                                        $totalCnt=$totalCount;
                                        ?> 
                                        <div class="searchSec">
                                            <div class="loader"><span>Loading...</span></div>
                                            <input type="hidden" id="show_page" value="<?php
    if (isset($show_page) && $show_page != '') {
        echo $show_page;
    } else {
        ?>0<?php } ?>" />
                                            <input type="hidden" name="totalCount" id="totalCount" value="<?php echo $totalCount; ?>" />
                                            <form id="searchFrm" name="searchFrm" onsubmit="return false;">
                                                <input type="text" title="Please enter model to search" id="txtSearch" name="search" class="inputFils" />
                                                <input type="hidden"  id="makeid" name="makeid" value="<?php echo $id; ?>" />
                                                <button class="btn skyBlueBtn" id="btnSearch" type="submit" value="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i> </button>
                                                <button class="btn" id="btnResetModel" type="button" value="Reset" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                            </form>
                                        </div> 
                                        <div class="actionBtn">
                                            <div class="customSelect">
                                                <span class="spanOut action"></span>
                                                <select title="Bulk Action" name="action" id="action" onchange="setSpanValue(jQuery(this));" onkeyup="setSpanValue(jQuery(this));" >
                                                    <option value="">Actions</option>
                                                    <option value="delete">Delete</option> 
                                                </select>
                                            </div>
                                        </div>


                                    </div>                  
                                    <div class="teamListMain">
                                        <form id="frmData" name="frmData">
                                            <table id="tableData" class="table table-bordered table-striped custom-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;" class="chkInn">
                                                            <label><input type="checkbox" name="selectAll" id="selectAll" class="checkBox" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label>
                                                        </th> 
                                                        <th aria-sort="desc" data-title="model" class="is-active sortOrder">Model</th>
                                                        <th style="width: 100px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                       
                                    <?php include $currentPath . '/user/pagging.php';     } ?>
                            </div>  
                            <div  class="formBoxHead bottom_edit">
                                <div class="editForm">
<?php displayButton($form, 'user/make_list'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>