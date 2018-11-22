<div class="smryTadiv">
    <div class="row">
        <div class="col-md-12">
            <div class="dasbox dashboxU">
                <p class="dashTitle">Summary</p>
                <div class="clearfix"></div>
                <div class="summarytbl">
                    <table class="tblData deviceTable" border="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>

                                <td  width="50%">
                                    <table class="directory_head" style="width: 100%">
                                        <thead>

                                            <tr>
                                                <th class="tablecell diviceTitle" align="center">
                                                    Region 
                                                </th>
                                                <th class="tablecell diviceTitle" align="center">
                                                    Category 
                                                </th>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <table class="referel_head" width="100%">
                                                        <thead>

                                                            <?php foreach ($topRegions as $region) { ?>
                                                                <tr>
                                                                    <th class="tablecell cursor text_left ">
                                                                        <?php if (isset($region->region_name) && $region->region_name != "") {
                                                                            echo $region->region_name; ?> (<?php echo $region->totalView; ?>)    
                                                                        <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            <?php } ?>

                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </td>
                                                <td width="50%">
                                                    <table class="referel_head" width="100%">
                                                        <thead>

                                                            <?php foreach ($topCategory as $category) { ?>
                                                                <tr>
                                                                    <th class="tablecell cursor text_left ">
                                                                        <?php if (isset($category->category_name) && $category->category_name != "") {
                                                                            echo $category->category_name; ?> (<?php echo $category->totalView; ?>)    
                                                                        <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            <?php } ?>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="deviceInner">
                                        </tbody>
                                    </table>
                                </td>
                                <td  width="50%">
                                    <table class="directory_head" style="width: 100%">
                                        <thead>
                                            <tr><th class="tabletitle tablecell" colspan="2" align="center">Parts </th></tr>
                                            <tr>
                                                <th class="divcIcon">
                                                    <div class="smallhead tablecell">View</div>
                                                </th>
                                                <th class="divcIcon">
                                                    <div class="smallhead tablecell">Enquiries</div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <table class="referel_head" width="100%">
                                                        <thead>


                                                            <?php foreach ($topViewParts as $parts) { ?>
                                                                <tr>
                                                                    <th class="tablecell cursor text_left ">
                                                                        <?php if ($parts->part_name != "") { ?>
                                                                            <?php echo $parts->part_name; ?> (<?php echo $parts->parts_click; ?>)    
                                                                        <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            <?php } ?>

                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </td>
                                                <td width="50%">
                                                    <table class="referel_head" width="100%">
                                                        <thead>


                                                            <?php foreach ($topPartsEnqury as $partsEnq) { ?>
                                                                <tr>
                                                                    <th class="tablecell cursor text_left ">
                                                                        <?php if (isset($partsEnq->parts_name) && $partsEnq->parts_name != "") {
                                                                            echo $partsEnq->parts_name; ?> (<?php echo $partsEnq->total; ?>)    
                                                                        <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            <?php } ?>

                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="deviceInner">
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>