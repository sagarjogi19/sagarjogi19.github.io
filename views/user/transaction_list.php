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
        jQuery("#btnSearchPay").click(function () {
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
                  var invoice="";
                   if (((val.payment_mode != "ADMIN_PAY") && (val.payment_status == "COMPLETE")) ) {
                    invoice = '<a target="_blank" href="'+baseURL + 'parts-invoice-pdf/' + val.id+"/"+val.uid + '" class="tEdit trans" title="Download Invoice" target="_blank"><i class="fa fa-download  trans" aria-hidden="true"></i></a>';
                }
                  html += '<tr>';
                                     <?php /* <td class="chkInn"><label><input type="checkbox" class="chkSelect checkBox" id="chkSelect" value="' + val.id + '"  name="chkSelect[' + val.id + ']" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label> </td>'; */ ?>
                         <?php if(isAdmin()){  ?>
                            html +='<td class="text_left" data-title="Name:">' + val.name + '</td>';
                            html +='<td class="text_left" data-title="Email:">' + val.email + '</td>';
                            html +='<td class="text_left" data-title="Phone:">' + val.phone + '</td>';
                        <?php } ?>
                              html +='<td class="text_left" data-title="Part:">' + val.parts_name + '</td><td class="text_left" data-title="Payment Mode:">' + getPaymentLabel(val.payment_mode) + '</td><td class="text_right" data-title="Total:">$' + parseFloat(val.total).toFixed(2) + '</td><td class="text_left" data-title="Transcation ID:">' + (val.transcation_id?val.transcation_id:"-") + '</td><td class="text_left" data-title="Payment Date:">'+val.payment_date+'</td><td class="S_action" data-title="Actions:">'+invoice+'</td></tr>';


              });
          } else {
              html += '<tr><td colspan="9" align="center">No records found</td></tr>';
          }
          obj.find('tbody').html(html);

      }
      function getPaymentLabel(payment_mode){
        if(payment_mode=="ADMIN_PAY"){
            return "Paid by Admin";
        } 
        else if(payment_mode=="PAYPAL_EXPRESS"){
            return "Paypal Express Checkout";
            
        } else if(payment_mode=="PAYPAL_HOSTED_SOLUTIONS"){
            return "Paypal Hosted Solutions";
        } else {
            return "";
        }        
     }
</script>
<style type="text/css">
    .dtInput { width:150px !important; }
</style>
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="teamMain notfiicationTabMain inQuiryCommonList">
                <div class="notfiicationTabMain">
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
                                    <span class="dateCalender"><input type="text" id="dateFrom" name="dateFrom" title="Select from date" placeholder="Select from date" class="dtInput inputFils " /></span>
                                    <span class="dateCalender"><input type="text" id="dateTo" name="dateTo" title="Search to date" placeholder="Select to date" class="dtInput inputFils " /></span>
                                    <button class="btn skyBlueBtn" id="btnSearchPay" type="submit" value="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i> </button>
                                    <button class="btn" id="btnReset" type="button" value="Reset" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                </form>
                                    </div>
                                    
                                </div>
                                <div class="teamListMain">
                                    <form id="frmData" name="frmData">
                                        <table id="tableData" class="table-bordered table-striped custom-table notifyListTable">
                                            <thead>
                                                 <tr>
                                           <?php /* <th class="chkInn">
                                                <label><input type="checkbox" name="selectAll" id="selectAll" class="checkBox" /><span><i class="fa fa-check" aria-hidden="true"></i></span></label>
                                            </th> */ ?>
                                             <?php if(isAdmin()){  ?>
                                            <th aria-sort="desc" data-title="name" class="is-active sortOrder">Name</th>
                                            <th aria-sort="desc" data-title="email" class="is-active sortOrder">Email</th>
                                            <th aria-sort="desc" data-title="phone" class="is-active sortOrder">Phone</th>
                                             <?php } ?>
                                            <th aria-sort="desc" data-title="parts_name" class="is-active sortOrder">Parts</th>
                                             <th aria-sort="desc" data-title="parts_name" class="is-active sortOrder">Payment Method</th>
                                              <th aria-sort="desc" data-title="total" class="is-active sortOrder">Total</th>
                                             <th aria-sort="desc" data-title="transaction_id" class="is-active sortOrder">Transaction ID</th> 
                                            <th aria-sort="desc" data-title="payment_date" class="is-active sortOrder">Payment Date</th>
                                            
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