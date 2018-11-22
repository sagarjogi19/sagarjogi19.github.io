<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
$form ="signupform";
?> 
<section class="innerMain" style="padding-top:0px">
    <div class="container">  

        <form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" id="<?php echo $form; ?>" name="<?php echo $form; ?>" accept-charset="UTF-8">
            <?php include 'user_form.php'; ?> 
            <div class="stepsBtn">
                <button class="btn skyBlueBtn toPaymentStep" type="submit" name="submit" value="register" title="Register" >
                    <span id="butNxtText">Register</span>
                </button></div>
             <div class="loaderAjax pull-right" style="display:none">
                <img src="<?php echo $path; ?>/images/loader.gif"  />
            </div>
        </form>


    </div>
</section>