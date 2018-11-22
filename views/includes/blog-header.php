<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url
// $displayFilter  make true from controller to display filter
$title=setTitle($title);
//print_r($formData);exit;

?> 
 <!-- Header Start -->
            <header class="header">
                <div class="container">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>" title="<?php echo $this->config->item('site_name'); ?>"><img src="<?php echo $path; ?>/images/logo_front.png" alt="<?php echo $this->config->item('site_name'); ?>" title="<?php echo $this->config->item('site_name'); ?>"></a>
                    </div>
                    <div class="rightmenu">
                        <?php 
                        $link = setLink('user/parts/parts_add');
                        if(!isUserLoggedIn()) { 
                        $link = setLink('user/login');     
                        } ?>
                        <div class="postad"><a class="trans webBtn" href="<?php echo $link; ?>" title="Post an ad"><img class="svgImg" src="<?php echo $path; ?>/images/postad-icon.svg" alt="Post An Ad" title="Post An Ad">Post An Ad</a></div>
                        <div class="cart"><a class="trans webBtn" href="#" title="Cart"><img class="svgImg" src="<?php echo $path; ?>/images/cart-icon.svg" alt="Cart" title="Cart"><span>2</span></a></div>
                        <div class="loginregi">				
                            <ul>
                                <?php if(!isUserLoggedIn()) { ?>
                                <li><a href="<?php echo setLink('user/login'); ?>" title="Log in"><img class="svgImg" src="<?php echo $path; ?>/images/login-icon.svg" alt="Log in" title="Log in">Login</a></li>
                                <li><a href="<?php echo setLink('user/register'); ?>" title="Register">Register</a></li>
                                <?php } else {  ?>
                                <li><a href="<?php echo setLink('dashboard'); ?>" title="My Account"><img class="svgImg" src="<?php echo $path; ?>/images/login-icon.svg" alt="Log in" title="Log in">Login</a></li>
                                <li><a href="<?php echo setLink('user/logout'); ?>" title="Logout">Logout</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Header End -->
               <?php 
                   include_once "filter_front.php";
              ?>

        

