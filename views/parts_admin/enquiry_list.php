<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__;
$currentPath = str_replace("parts_admin", "user", $currentPath);
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
<?php if (isset($searchSession)) { ?>
            setSearchedData('<?php echo $searchSession; ?>');
<?php } ?>
        doPaging(jQuery("#show_page").val(), 'loader', jQuery('#tableData'), createRows);
        loadNextPrev(jQuery('#tableData'));
        var dateProp = {"dateOnly": true, "dateFormat": "dd-mm-yy", maxDate: new Date()};
        jQuery("#dateFrom").datepicker(dateProp);
        jQuery("#dateTo").datepicker(dateProp);
<?php /* Overwrite button events */ ?>
        jQuery("#btnReset").click(function () {
            resetBtn = true;
            jQuery("#txtSearch").val('');
            jQuery("#dateFrom").val('');
            jQuery("#dateTo").val('');
            doPaging(0, 'loader', jQuery('#tableData'), createRows);
            createPages(0);
        });
        jQuery("#btnSearchEnquiry").click(function () {
            if (jQuery("#txtSearch").val() != "" || jQuery("#dateFrom").val() != "" || jQuery("#dateTo").val() != "") {
                var dataObj = jQuery("#searchFrm").serialize();
                doPaging(0, 'loader', jQuery('#tableData'), createRows, '', dataObj);
            } else {
                var msgBox = "enter any keyword or select from/to date";
                alert('Please ' + msgBox + ' to search');
                return false;
            }
        });
    });
   function createRows(data, obj) {
          var html = '';
        
          if (jQuery(data).length > 0) {
              jQuery(data).each(function (key, val) {
                  html += '<tr ' + (val.status == '0' ? "class=\'notificationUnread\'" : "class=\'notificationRead\'") + '><td class="chkInn"><label><input type="checkbox" class="chkSelect checkBox" id="chkSelect" value="' + val.id + '"  name="chkSelect[' + val.id + ']" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label> </td><td class="checkId" data-title="Id:">' + val.id + '</td><td class="text_left" data-title="Name:">' + val.name + '</td> <td class="text_left" data-title="Email:">' + val.email + '</td> <td  data-title="Phone:">' + (val.phone?val.phone:"") + '</td><td class="text_left" data-title="Machine:"><a target="_blank" href="' + val.slug + '" title="' + val.machine_name + '" class="checkForUpdatelink">' + val.machine_name + '</a></td><td class="text_left" data-title="Enquiry Page:">' + val.enquiry_page + '</td><td class="text_left" data-title="Enquiry Date:">' + val.created_date + '</td><td class="S_action" data-title="Actions:"><a href="' + window.location.href.split('?')[0].replace(/list/g, "view?id=" + val.id) + '&page=' + getCurrentPage() + '" class="tEdit trans" title="Edit"><i class="fa fa-pencil-square-o trans" aria-hidden="true"></i></a><a class="chStatus" data-title="' + val.id + '" data-status="' + (val.status == '1' ? "0" : "1") + '" title="Change Status" href="javascript:;" class="tStatus trans"><i class="fa fa-exchange fa-1x trans" aria-hidden="true"></i></a></td></tr>';


              });
          } else {
              html += '<tr><td colspan="9" align="center">No records found</td></tr>';
          }
          obj.find('tbody').html(html);

      }
</script>
<style type="text/css">
    .dtInput { width:150px !important; }
</style>
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="teamMain categoryMain notfiicationTabMain inQuiryCommonList">
                <div class="">
                    <div class="container"> 
                        <?php include 'sub_tabs.php'; ?>
                        <div class="dTabCon"> 
                            <div class="">
                                <input type="hidden" id="show_page" value="<?php echo $show_page; ?>" />
                                <input type="hidden" name="totalCount" id="totalCount" value="<?php echo $totalCount; ?>" />
                                <div class="teamHeader">

                                    <div class="searchSec">
                                        <div class="loader"><span>Loading...</span></div>

                                         <form id="searchFrm" name="searchFrm" onsubmit="return false;" data-drupal-form-fields="txtSearch">
                                    <input type="text" title="Search keyword" placeholder="Search keyword" id="txtSearch" name="search" class="inputFils">
                                    <span class="dateCalender"><input type="text" id="dateFrom" name="dateFrom" title="Select from date" placeholder="Select from date" class="dtInput inputFils " /></span>
                                    <span class="dateCalender"><input type="text" id="dateTo" name="dateTo" title="Search to date" placeholder="Select to date" class="dtInput inputFils " /></span>
                                    <button class="btn skyBlueBtn" id="btnSearchEnquiry" type="submit" value="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i> </button>
                                    <button class="btn" id="btnReset" type="button" value="Reset" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                </form>
                                    </div>
                                    <div class="actionBtn">
                                        <div class="customSelect">
                                            <span class="spanOut action"></span>
                                            <select title="Bulk Action" name="action" id="action" onchange="setSpanValue(jQuery(this));" onkeyup="setSpanValue(jQuery(this));" >
                                                <option value="">Actions</option>
                                        <option value="active">Read</option>
                                        <option value="inactive">Unread</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="teamListMain">
                                    <form id="frmData" name="frmData">
                                        <table id="tableData" class="table-bordered table-striped custom-table notifyListTable">
                                            <thead>
                                                 <tr>
                                            <th class="chkInn">
                                                <label><input type="checkbox" name="selectAll" id="selectAll" class="checkBox" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label>
                                            </th>
                                            <th aria-sort="desc" data-title="id" class="is-active sortOrder">Id</th>
                                            <th aria-sort="desc" data-title="name" class="is-active sortOrder">Name</th>
                                            <th aria-sort="desc" data-title="email" class="is-active sortOrder">Email</th> 
                                            <th aria-sort="desc" data-title="phone" class="is-active sortOrder">Phone</th>
                                            <th aria-sort="desc" data-title="machine_name" class="is-active sortOrder">Machine</th>
                                            <th aria-sort="desc" data-title="enquiry_page" class="is-active sortOrder">Enquiry Page</th>
                                            <th aria-sort="desc" data-title="created_date" class="is-active sortOrder">Enquiry Date</th> 
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