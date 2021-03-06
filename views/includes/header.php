<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url
// $displayFilter  make true from controller to display filter
$title=setTitle($title);
?>
   <header class="header">
                <div class="container">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>" title="<?php echo $this->config->item('site_name'); ?>"><img src="<?php echo getLogo(); ?>" alt="<?php echo $this->config->item('site_name'); ?>" title="<?php echo $this->config->item('site_name'); ?>"></a>
                    </div>
                    <div class="rightmenu">
                        <?php 
                        $link = setLink('user/parts/parts_add');
                        if(!isUserLoggedIn()) { 
                        $link = setLink('user/login');     
                        } ?>
                        <div class="postad"><a class="trans webBtn" href="<?php echo $link; ?>" title="Post an ad"><img class="svgImg" src="<?php echo $path; ?>/images/postad-icon.svg" alt="Post An Ad" title="Post An Ad">Post An Ad</a></div>
                        <div class="cart"><a class="trans webBtn" href="#" title="Cart"><img class="svgImg" src="<?php echo $path; ?>/images/cart-icon.svg" alt="Cart" title="Cart"><span>2</span></a></div>
                        <div class="loginregi"  >				
                            <ul>
                                <?php if(!isUserLoggedIn()) { ?>
                                <li><a href="<?php echo setLink('user/login'); ?>" title="Log in"><img class="svgImg" src="<?php echo $path; ?>/images/login-icon.svg" alt="Log in" title="Log in">Login</a></li>
                                <li><a href="<?php echo setLink('user/register'); ?>" title="Register">Register</a></li>
                                <?php } else {  ?>
                                <li class="notificationli">    
                                   <span class="addtoCart notification">
                                    <span class="cartTotal totalNotification">01</span>
                                    <span class="notifyClick">
                                       <img src="<?php echo $path; ?>/images/notify_icon.png">
                                    </span>
                                     <nav class="mobileNav notfyNav">  
                                       <ul class="notificationList">   
                                           <li>No Records Found</li>
                                      </ul>
                                       <ul class="clearNotification">
                                         <li><a href="javascript:;" data-url="<?php echo setLink("user/notification_list"); ?>" class="clearAllNotification btn black_btn " title="Clear All Actions">Clear All</a></li>
                                       </ul>
                                       <ul class="notificationAll">
                                         <li><a class="btn blue_btn" href="<?php echo setLink("user/notification_list"); ?>" title="View All Actions">View All</a></li>
                                       </ul>
                                      </nav>
                                    </span> 
                                </li>
                                <li class="mobaccmenu">
                                    <span class="accmenuIcon"><span></span></span>
                                    <div class="mobileaccnav">
                                        <ul>
                                            <li><a href="<?php echo setLink('dashboard'); ?>" title="My Account"><img class="svgImg" src="<?php echo $path; ?>/images/user.svg" alt="My Account" title="My Account">My Account</a></li>
                                            <li><a href="#" title="Dashboard">Dashboard</a></li>
                                            <li><a href="#" title="Edit Profile">Edit Profile</a></li>
                                            <li><a href="<?php echo setLink('user/logout'); ?>" title="Log Out">Log Out</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a href="<?php echo setLink('dashboard'); ?>" title="My Account"><img class="svgImg" src="<?php echo $path; ?>/images/user.svg" alt="My Account" title="My Account">My Account</a>
                                    <div class="submenu">
                                        <ul>
                                            <li><a href="#" title="Dashboard">Dashboard</a></li>
                                            <li><a href="#" title="Edit Profile">Edit Profile</a></li>
                                            <li><a href="<?php echo setLink('user/logout'); ?>" title="Log Out">Log Out</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="<?php echo setLink('user/logout'); ?>" title="Logout">Logout</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </header> 
			<section class="innerMain"> <?php // Section start ?>

