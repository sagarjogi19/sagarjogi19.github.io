<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url   
?> 
<div class="commonBtnul"> 
     <button   class="btn skyBlueBtn  <?php setCurrentClass(array("user/parts/parts_list","user/parts/parts_add"),"active"); ?>"   type="button" name="button"   title="Parts List" onclick="location.href = '<?php echo setLink("user/parts/parts_list"); ?>'">
                        <span id="butNxtText">Parts List</span>
                    </button> 
                       <?php if(Utility::hasAccess("category_list",1)==true) { /* Show button only when user role is admin */ ?> 
 
  <button   class="btn skyBlueBtn <?php setCurrentClass(array("user/parts/category_list","user/parts/category_add"),"active"); ?>" type="button" name="button"   title="Categories" onclick="location.href = '<?php echo setLink("user/parts/category_list"); ?>';">
                        <span id="butNxtText">Categories</span>
                    </button>
                       <?php } ?>
                        <button   class="btn skyBlueBtn  <?php setCurrentClass(array("user/parts/enquiry_list","user/parts/enquiry_view"),"active"); ?>" type="button" name="button"   title="Enquiry Manager" onclick="location.href = '<?php echo setLink("user/parts/enquiry_list"); ?>';">
                        <span id="butNxtText">Enquiry Manager</span>
                    </button>
 
</div>   