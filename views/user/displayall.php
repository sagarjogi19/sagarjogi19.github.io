<?php
$str =""; 
if ($ctrl && $ctrl==1) {
     $str="1";
   }
?>
<div class="limitDrp actionBtn <?php if ($str=="1"){ ?>topDisplay<?php } ?>">
       <span class="txtDisplay">Display</span>
       <div class="customSelect"> <span class="spanOut limit<?php echo $str; ?>">10</span><select title="Display Records" name="limit<?php echo $str; ?>" id="limit<?php echo $str; ?>" class="drpL" onchange="<?php if ($str=="1"){ ?> jQuery('#limit').val(jQuery(this).val());setSpanValue(jQuery('#limit'));<?php }  else { ?>jQuery('#limit1').val(jQuery(this).val());setSpanValue(jQuery('#limit1'));<?php } ?>setSpanValue(jQuery(this)); doPaging(0, 'loader', jQuery('#tableData'), createRows);" onkeyup="<?php if ($str=="1"){ ?>  jQuery('#limit').val(jQuery(this).val());setSpanValue(jQuery('#limit'));<?php }  else { ?>jQuery('#limit1').val(jQuery(this).val());setSpanValue(jQuery('#limit1'));<?php } ?>setSpanValue(jQuery(this));doPaging(0, 'loader', jQuery('#tableData'), createRows);">
                <option value="10" selected="selected">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="0">All</option>
            </select></div>
</div>