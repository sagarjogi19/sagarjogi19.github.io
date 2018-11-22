 <div class="pageNav">
<?php
$ctrl=0; 
include 'displayall.php';
 
?> 
    <div class="paging-section pageBox">
        <a href="javascript:;" class="prev" title="Previous"></a>
        <?php for ($i=0;$i<$totalCount;$i++) { ?>
            <a id="pagging<?php echo $i; ?>" class="pagging <?php if($i==0){ ?> active <?php } ?>" href="javascript:;"  ><?php echo $i+1; ?></a>
        <?php } ?>
        <a href="javascript:;" class="next" title="Next"></a>
    </div>
</div>
 