<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__; 
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
<?php if (isset($searchSession)) { ?>
            setSearchedData('<?php echo $searchSession; ?>');
<?php } ?>
        doPaging(jQuery("#show_page").val(), 'loader', jQuery('#tableData'), createRows);
        loadNextPrev(jQuery('#tableData'));
    });
    function createRows(data, obj) {
        var html = '';
        console.log(data);
        if (jQuery(data).length > 0) {
            jQuery(data).each(function (key, val) {
                 
                html += '<tr><td class="chkInn"><label><input type="checkbox" class="chkSelect checkBox" id="chkSelect" value="' + val.id + '"  name="chkSelect[' + val.id + ']" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label> </td><td class="checkId" data-title="Id:">' + val.id + '</td><td class="text_left" data-title="Customer Name:">' + val.customer_name + '</td> <td class="text_left" data-title="Designation:">' +  val.designation + '</td> <td  data-title="Sort Order:">' + val.sort_order + '</td><td class="statusCell" data-title="Status:"><span class="statusSpan ' + (parseInt(val.status) == 1 ? "active" : "inactive") + '" title="' + (parseInt(val.status) == 1 ? "Active" : "Inactive") + '"></span> ' + (parseInt(val.status) == 1 ? "Active" : "Inactive") + '</td><td class="S_action" data-title="Actions:"><a href="' + window.location.href.split('?')[0].replace(/list/g, "add?id=" + val.id) + '&page=' + getCurrentPage() + '" class="tEdit trans" title="Edit"><i class="fa fa-pencil-square-o trans" aria-hidden="true"></i></a><a title="Delete" class="delRecord" data-title="' + val.id + '" href="javascript:;" class="tDelete trans"><i class="fa fa-trash-o fa-1x trans" aria-hidden="true"></i></a><a class="chStatus" data-title="' + val.id + '" data-status="' + (val.status == '1' ? "0" : "1") + '" title="Change Status" href="javascript:;" class="tStatus trans"><i class="fa fa-exchange fa-1x trans" aria-hidden="true"></i></a></td></tr>';
            });
        } else {
            html += '<tr><td colspan="7" align="center">No records found</td></tr>';
        }
        obj.find('tbody').html(html);
    }
</script>
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="teamMain categoryMain notfiicationTabMain">
                <div class="">
                    <div class="container">  
                        <div class="dTabCon"> 
                            <div class="">
                                <input type="hidden" id="show_page" value="<?php echo $show_page; ?>" />
                                <input type="hidden" name="totalCount" id="totalCount" value="<?php echo $totalCount; ?>" />
                                <div class="teamHeader">

                                    <div class="searchSec">
                                        <div class="loader"><span>Loading...</span></div>

                                        <form id="searchFrm" name="searchFrm" onsubmit="return false;" data-drupal-form-fields="txtSearch">
                                            <input type="text" title="Search keyword" placeholder="Search keyword" id="txtSearch" name="search" class="inputFils">
                                            <button class="btn skyBlueBtn" id="btnSearch" type="submit" value="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i> </button>
                                            <button class="btn" id="btnReset" type="button" value="Reset" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                    <div class="actionBtn">
                                        <div class="customSelect">
                                            <span class="spanOut action"></span>
                                            <select title="Bulk Action" name="action" id="action" onchange="setSpanValue(jQuery(this));" onkeyup="setSpanValue(jQuery(this));" >
                                                <option value="">Actions</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="active">Active</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="S_addNew"> 
                                        <a href="<?php echo setLink('user/testimonial_add'); ?>" title="Add New" class="btn skyBlueBtn">Add New</a>
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
                                                    <th aria-sort="desc" data-title="customer_name" class="is-active sortOrder">Customer Name</th>
                                                    <th aria-sort="desc" data-title="designation" class="is-active sortOrder">Designation</th> 
                                                    <th aria-sort="desc" data-title="sort_order" class="is-active sortOrder">Sort Order</th>
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