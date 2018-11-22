<div class="col-md-12 col-sm-12 col-xs-12 subGraphdiv">
                <p class="subGrapTitle"><?php if($isAdmin==true) { ?>Overview<?php } else { ?>Engagement Overview <?php } ?></p>
                <div class="col-md-6 col-sm-12 col-xs-12 dirGraphone">
                    <div class="graphtotalRow">
                        <div class="totalShow">
                            <span class="subGraphSubtitle">Total Click(s)</span>
                            <span id="totalClick" class="graphTotal">0</span>
                        </div>
                        <div class="totalShow">
                            <span class="subGraphSubtitle">Total View(s)</span>
                            <span id="totalView" class="graphTotal">0</span>
                        </div>
                    </div>       
                    <div class="graphdiv">
                        <canvas id="myChart2" style="max-height: 200px;" height="200" ></canvas>
                        <div class="showProcess small_loading"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 dirGraphtwo">
                    <div class="graphtotalRow">
                        <div class="totalShow totalDir">
                            <span class="subGraphSubtitle">Total Parts Enquiry(s)</span>
                            <span id="totalEnqCount" class="graphTotal">0</span>
                        </div>
                      <?php /*  <div class="totalShow totalCallBk">
                            <span class="subGraphSubtitle">Total Callback Request(s)</span>
                            <span id="totalCallback" class="graphTotal">0</span>
                        </div>        
                        <div class="totalShow totalQuot">
                            <span class="subGraphSubtitle">Total Quotation Request(s)</span>
                            <span id="totalQuote" class="graphTotal">0</span>
                        </div>*/ ?>
                    </div>        
                    <a title="Export To Excel" class="export-enq-csv btn skyBlueBtn <?php echo $clsFor; ?>ExportEnqBtn" style="display: none" href="<?php echo setLink('user/export_enquiries'); ?>" data-href="<?php echo setLink('user/export_enquiries'); ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Enquiries</a>
                    <div class="graphdiv">
                        <canvas id="myChart3" style="max-height: 200px;" height="200" ></canvas>
                        <div class="showProcess small_loading"></div>
                    </div>

                </div>
            </div>