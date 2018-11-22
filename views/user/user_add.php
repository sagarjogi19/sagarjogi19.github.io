<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
$currentPath = __DIR__;  
$form ="signupform";
?> 
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="categoryAdd notfiicationTabMain">
                <div class="container">
                    <div class="dTabCon">
                        <div class="">

                            <div class="formBox edit_frm">
                                <div class="editForm">
                                    <div  class="editTabBtn">
                                        <div class="tabsBtnGroup">
                                        
                                            <div class="pull-right button_append">
                                                <?php displayButton($form, 'user/user_list'); ?> 
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                             <form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" id="<?php echo $form; ?>" name="<?php echo $form; ?>" accept-charset="UTF-8">
                                <?php include 'user_form.php'; ?> 
                                  <input type="hidden" name="saveBtn" id="saveBtn" value="1" />
                             </form>     
                            <div  class="formBoxHead bottom_edit">
                                <div class="editForm">
                                    <?php displayButton($form, 'user/user_list'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if((isset($id)) || (isAdmin()==true)){ include 'popup.php'; } ?>