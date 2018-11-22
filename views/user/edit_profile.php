<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
$form ="signupform";
$currentPath = __DIR__;
?> 
<div class="deshMain">
    <div class="container">
        <div class="deshTabMain">
            <?php include $currentPath . '/tabs.php'; ?>
            <div class="categoryAdd notfiicationTabMain">
                <div class="container">
                    <div class="dTabCon">
                        <div class=""> 

        <form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" id="<?php echo $form; ?>" name="<?php echo $form; ?>" accept-charset="UTF-8">
            <?php include 'user_form.php'; ?> 
            <div class="stepsBtn">
                <button class="btn skyBlueBtn toPaymentStep" type="submit" name="submit" value="Update Details" title="Update Details" >
                    <span id="butNxtText">Update Details</span>
                </button></div>
             <div class="loaderAjax pull-right" style="display:none">
                <img src="<?php echo $path; ?>/images/loader.gif"  />
            </div>
        </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<?php if((isset($id)) || (isAdmin()==true)){ include 'popup.php'; } ?>