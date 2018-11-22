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
    });
   
   function displayNotification(key){
       var notificationData=jQuery.parseJSON('<?php echo json_encode($this->notification_model->messageInfo()); ?>');
       return notificationData[key];
       
    }
   function createRows(data, obj) {
          var html = '';
        
          if (jQuery(data).length > 0) {
              jQuery(data).each(function (key, val) {
                  html += '<tr ' + (val.status == '0' ? "class=\'notificationUnread\'" : "class=\'notificationRead\'") + '><td class="chkInn"><label><input type="checkbox" class="chkSelect checkBox" id="chkSelect" value="' + val.id + '"  name="chkSelect[' + val.id + ']" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label> </td>';
                         <?php if(isAdmin()){  ?>
                            html +='<td class="text_left" data-title="User:">' + val.name + '</td>';
                        <?php } ?>
                              html +='<td class="text_left" data-title="Description:"><a class="checkForUpdatelink" href="'+baseURL+val.url_param+'">' + displayNotification(val.description) + '</a></td><td class="text_left">'+val.created_date+'</td><td class="statusCell" data-title="Status:"><span class="statusSpan ' + (val.status == '0' ? "inactive" : "") + '" title="' + (val.status == '1' ? "Read" : "Unread") + '"></span> ' + (val.status == '1' ? "Read" : "Unread") + '</td> <td class="S_action" data-title="Actions:"><a href="' + window.location.href.split('?')[0].replace(/list/g, "view?id=" + val.id) + '&page=' + getCurrentPage() + '" class="tEdit trans" title="Edit"><i class="fa fa-pencil-square-o trans" aria-hidden="true"></i></a><a class="chStatus" data-title="' + val.id + '" data-status="' + (val.status == '1' ? "0" : "1") + '" title="Change Status" href="javascript:;" class="tStatus trans"><i class="fa fa-exchange fa-1x trans" aria-hidden="true"></i></a></td></tr>';


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
            <div class="teamMain notificationMain inQuiryCommonList">
                <div class="notfiicationTabMain">
                    <div class="container"> 
                      <ul class="dTabLi"> 
                    <span class="int_overlay"></span>
                    <?php $setLink=setLink("user/notification_list"); ?>
                    <li class="tabing in <?php if($this->input->get("show")=="") { ?>current<?php } ?>" data-tab="latest_ten"><a href="<?php echo $setLink; ?>" title="Latest Ten">Latest Ten</a></li>
                    <li class="tabing in <?php if($this->input->get("show")=="approved") { ?> current <?php } ?>" data-tab="approved"><a href="<?php echo $setLink; ?>?show=approved" title="approved">Approved</a></li>
                    <li class="tabing in <?php if($this->input->get("show")=="disapproved") { ?>current <?php } ?>" data-tab="disapproved"><a href="<?php echo $setLink; ?>?show=disapproved" title="Disapproved">Disapproved</a></li>
                </ul>
                        <div class="dTabCon"> 
                            <div class="">
                                <input type="hidden" id="show_page" value="<?php echo $show_page; ?>" />
                                <input type="hidden" name="totalCount" id="totalCount" value="<?php echo $totalCount; ?>" />
                                <div class="teamHeader">

                                    <div class="searchSec">
                                        <div class="loader"><span>Loading...</span></div>
                                          <?php if(isAdmin()){  ?>
                                         <form id="searchFrm" name="searchFrm" onsubmit="return false;" data-drupal-form-fields="txtSearch">
                               <input type="text" title="Please enter business name" placeholder="Enter business name" id="txtSearch" name="search" class="inputFils" />
					 <button class="btn skyBlueBtn" id="btnSearch" type="submit" value="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i> </button>
                                         <button class="btn" id="btnReset" type="button" value="Reset" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                          </form> <?php } ?>
                                    </div>
                                    <div class="actionBtn">
                                        <div class="customSelect">
                                            <span class="spanOut action"></span>
                                            <select title="Bulk Action" name="action" id="action" onchange="setSpanValue(jQuery(this));" onkeyup="setSpanValue(jQuery(this));" >
                                                <option value="">Actions</option>
                                        <option value="active">Approved</option>
                                        <option value="inactive">Unapproved</option>
                                      <?php /*  <option value="delete">Delete</option>*/ ?>
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
                                             <?php if(isAdmin()){  ?>
                                            <th aria-sort="desc" data-title="name" class="is-active sortOrder">User</th>
                                             <?php } ?>
                                            <th aria-sort="desc" data-title="description" class="is-active sortOrder">Action</th>
                                             <th aria-sort="desc" data-title="n.created_date" class="is-active sortOrder">Date</th>
                                            <th aria-sort="desc" data-title="n.status" class="is-active sortOrder">Status</th>
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