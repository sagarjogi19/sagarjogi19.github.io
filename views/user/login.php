<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
?> 
<script type="text/javascript">
    jQuery(document).ready(function () {
        var rules = {
            username: {required: true},
            password: {required: true},
        };
        var messages = {
            username: {required: 'Please enter username'},
            password: {required: 'Please enter password'},
        }
        validateForm(jQuery("#user-login-form"), rules, messages);
    });
</script>
 
<div class="loginBox">
    <div class="loginMain">
        <div class="loginCenter">
            <div class="logInn">
                <div class="userIcon"></div>
                <form class="form-horizontal" action="<?php echo current_url(); ?>" method="post" id="user-login-form" accept-charset="UTF-8">
                    <div class="frmTxt uname">
                        <input type="text" name="username" id="username" class="" title="Username" placeholder="Username" required="required" value="<?php echo (isset($username) && $username != "") ? $username : ""; ?>">
                    </div>
                    <div class="frmTxt pwd">
                        <input type="password" name="password" id="password" class="" placeholder="Password" title="Password" value="<?php echo (isset($password) && $password != "") ? $password : ""; ?>">
                    </div>
                    <div class="clearfix"></div>
                    <div class="frmTxt rememberMe">
                        <div class="chkInn chkClosedHrs">
                            <label>
                                <input id="remember_me" name="remember_me" class="chkSelect checkBox" title="Remember Me" value="1" type="checkbox" <?php if (isset($remember_me) && $remember_me != '') { ?>checked<?php } ?>><span><i class="fa fa-check" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="subBoxLink forGotPass">
                        <a href="<?php echo setLink('user/forgotpwd'); ?>" title="Forgot your password" class="trans">Forgot your password?</a>
                    </div>
                    <div class="subBox">
                        <div class="login-box login-btns">
                            <button type="submit" name="login" title="Login" id="user-login-button" class="btn loginBtn">Login <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                    <div class="subBoxLink">
                        Don't have an account? <a href="<?php echo setLink('user/register'); ?>" title="Register now" class="reg_a trans">Register now</a> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>