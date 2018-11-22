<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url
$partsAction =array("user/parts/parts_list","user/parts/parts_add","user/parts/category_list","user/parts/category_add","user/parts/enquiry_list","user/parts/enquiry_view");
?>
 <a href="javascript:;" class="mobiSwipe">Dashboard</a>
<ul class="dTabLi">
                <span class="int_overlay"></span>
                <li class="tabing in <?php setCurrentClass("dashboard","current"); ?>" data-tab="dashboard"><a href="<?php echo setLink('dashboard'); ?>" title="Dashboard">Dashboard</a></li>
                <li class="tabing in <?php setCurrentClass("user/notification_list","current"); ?>" data-tab="Action List"><a href="<?php echo setLink("user/notification_list"); ?>" title="Action List">Action List</a></li>
                <li class="tabing in <?php setCurrentClass("user/transaction_list","current"); ?>" data-tab="Transaction List"><a href="<?php echo setLink("user/transaction_list"); ?>" title="Transactions">Transactions</a></li>
                <?php //Admin links ?>
                <?php if(Utility::hasAccess("user_list",1)==true) { ?><li class="tabing in <?php setCurrentClass("user/user_list","current"); ?>" data-tab="user list"><a href="<?php echo setLink("user/user_list"); ?>" title="User List">User List</a></li><?php } ?>
                     <?php if(isAdmin()==false) { ?><li class="tabing in <?php setCurrentClass("user/edit_profile","current"); ?>" data-tab="edit profile"><a href="<?php echo setLink("user/edit_profile"); ?>" title="Edit Profile">Edit Profile</a></li> 
                         <?php } ?>
                <li class="tabing in <?php setCurrentClass($partsAction,"current"); ?>" data-tab="parts list"><a href="<?php echo setLink('user/parts/parts_list'); ?>" title="Parts">Parts</a></li> 
                <?php if(Utility::hasAccess("make_list",1)==true) { ?><li class="tabing in <?php setCurrentClass(array("user/make_list","user/make_add"),"current"); ?>" data-tab="part list"><a href="<?php echo setLink('user/make_list'); ?>" title="Make">Make/Model</a></li><?php } ?>
                
            </ul>  