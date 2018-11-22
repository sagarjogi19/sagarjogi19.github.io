<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
if($uid!=0) {
?> 
<script type="text/javascript">
jQuery(document).ready(function(){
        
       var rules = {
            old_password: {required:function() { return jQuery("#password").val() != ''}},
            password: {required:function() { return jQuery("#old_password").val() != ''} ,minlength:6,passwordValue: true,whitespaceValue: true},
            conf_password:{equalTo: "#password"},
        };
      var  messages = {
            password: {required:'Please enter new password',minlength:'Password must be 6 character long',passwordValue: "Password must have at least one uppercase letter, one digits and one special character",whitespaceValue: "whitespace not allowed in password"},
            old_password: {required:'Please enter current password'},
            conf_password: {required:'Please enter confirm password',equalTo:'Password doesn\'t match'},
        }; 
        validateForm(jQuery("#user-change-password-form"),rules,messages);
});
</script>
<?php }  ?>
<div class="loginBox">
	<div class="loginMain">
		<div class="loginCenter"><?php if($uid!=0) {  ?>
			<div class="logInn" style="padding-top: 40px">
                                      
                                        <form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" id="user-change-password-form" name="user-change-password-form" accept-charset="UTF-8">
                                            <input type="hidden" name="action" value="<?php echo base64_encode('1'); ?>" />
                                            <input type="hidden" id="uid_value" name="uid" value="<?php echo $uid; ?>">
                                            
                                            <div class="frmTxt pwd">
							<input name="password" id="password" class="required" placeholder="New Password" title="New password" type="password">
                                            </div>
                                            <div class="frmTxt pwd">
							<input name="conf_password" id="conf_password" class="required" placeholder="Confirm Password" title="Confirm password" type="password">
                                            </div>
                                            <div class="subBox">
                                                    <div class="login-box login-btns">
                                                            <button type="submit" name="submit" title="Update" id="user-pass-button" class="btn loginBtn">Update <i class="fa fa-arrow-circle-right"></i></button>
                                                    </div>
                                            </div>
                                           
					</form>
                                        
			</div>
		 <?php } ?> </div>    
	</div>
</div>