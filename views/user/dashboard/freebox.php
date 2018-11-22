 <div>
                     <div class="sb_box">
<div class="col-md-7 col-sm-7 col-xs-14">
                    <div class="servicePBox">
                        <h4 class="sb_BoxTitle">Free User</h4>
                        <p class="sb_BoxText">Add parts & edit your profile in worthy parts</p>
                        <div class="sb_Button">
                            <a id="introstep1" title="Add Parts"  href="<?php echo setLink('user/parts/parts_add');?>" class="sb_btn trans">Add Parts</a>
                            <a title="Edit Personal Details"  href="<?php echo setLink('user/edit_profile');?>" class="sb_btn trans">Edit Personal Details</a>
                            <a title="Transaction History"  href="<?php echo setLink('user/transaction_list');?>" class="sb_btn trans">Transaction History</a>
                        </div>
                    </div>
                </div>
                     </div>
          <?php /*Get Data From User Model*/
          $ci=setCodeigniterObj();
          $ci->load->model("user_model");
          $dashboardData = $ci->user_model->getFreeUserData($ci);
          ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <p class="subGrapTitle">Overview</p>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h4>Transaction History</h4>
                        <table id="tableData" class="table-bordered table-striped custom-table notifyListTable">
                            <thead> 
                                <tr>
                                    <th>Part</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    
                                    <?php /*<th>Payment Date</th> */ ?>
                                    <th>Download <br />Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($dashboardData->transactionData)!=0) { 
                                        foreach($dashboardData->transactionData as $tr) {
                                    ?>
                                <tr>
                                    <td><?php echo $tr->parts_name; ?></td>
                                    <td>$<?php echo number_format($tr->total,2); ?></td>
                                    <td><?php echo paymentMethod($tr->payment_mode); ?></td> 
                                    <?php /*<td><?php echo date('d-m-Y h:i:s a',strtotime($tr->payment_date)); ?></td>*/ ?>
                                    <td><a target="_blank" href="<?php echo setLink("parts-invoice-pdf")."/".$tr->id."/".$tr->uid; ?>" class="tEdit trans" title="Download Invoice" target="_blank"><i class="fa fa-download  trans" aria-hidden="true"></i></a></td>
                                </tr>    
                                    
                               <?php } 
                                } else { ?>
                                <tr><td colspan="4">No Records Found.</td></tr>
                                <?php }
                               ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h4>Latest Enquiry</h4>
                        <table id="tableData" class="table-bordered table-striped custom-table notifyListTable">
                            <thead> 
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Part</th>
                                    <th>View Enquiry</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php if(count($dashboardData->enquiryData)!=0) { 
                                        foreach($dashboardData->enquiryData as $eq) {
                                    ?>
                                <tr>
                                    <td><?php echo $eq->name; ?></td>
                                    <td>$<?php echo $eq->email; ?></td>
                                    <td><?php echo  $eq->phone; ?></td> 
                                    <td><?php echo  $eq->parts_name; ?></td> 
                                    <?php /*<td><?php echo date('d-m-Y h:i:s a',strtotime($tr->payment_date)); ?></td>*/ ?>
                                    <td><a target="_blank" href="<?php echo setLink("user/parts/enquiry_view")."?id=".$tr->id; ?>" class="tEdit trans" title="View Enquiry" target="_blank"><i class="fa fa-pencil-square-o trans" aria-hidden="true"></i></a></td>
                                </tr>    
                                    
                               <?php }
                                } else { ?>
                                <tr><td colspan="5">No Records Found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
 </div>