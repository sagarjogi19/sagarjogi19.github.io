<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
?> 
<script type="text/javascript">
jQuery(document).ready(function(){
      var rules = {
               email: {required:true},
            };
           var messages = {
               email: {required:'Please enter username or email'},
           };
        validateForm(jQuery("#user-password-form"),rules,messages);
});
</script>
<div class="loginBox">
	<div class="loginMain">
		<div class="loginCenter">
			<div class="logInn">
				<div class="userIcon"></div>
					<form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" id="user-password-form" accept-charset="UTF-8">
						<div class="frmTxt uname">
							<input type="text" name="email" id="email" class="" title="Username or email" placeholder="Username or email" required>
                                                </div>
						<div class="subBoxLink">
                                                       Password reset instructions will be sent to your registered email address.
                                                </div>
						<div class="subBox">
                                                        <div class="login-box login-btns">
								<button type="submit" name="login" title="Submit" id="user-login-button" class="btn loginBtn">Submit <i class="fa fa-arrow-circle-right"></i></button>
							</div>
                                                </div>
                                                <div class="subBoxLink">
                                                        Back to <a href="<?php echo setLink('user/login'); ?>" title="Login" class="reg_a trans">Login</a>
                                                </div>
					</form>
			</div>
		</div>
	</div>
</div>