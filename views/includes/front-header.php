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
                                <li class="notificationli">    
                                   <span class="addtoCart notification">
                                    <span class="cartTotal totalNotification">01</span>
                                    <span class="notifyClick">
                                       <img src="<?php echo $path; ?>/images/notify_icon.png">
                                    </span>
                                     <nav class="mobileNav notfyNav">  
                                       <ul class="notificationList">    <li> 
                                         <a href="javascript:;" title="Discard" class="discardNoti" data-id="1534"><span class="cross trans"></span></a>
                                         <a href="#" class="notDesc">
                                        <div class="innerCartNav">
                                          <p><span class="codeTitle">Dhaval Sheth</span> </p>
                                          <p><span class="codeDate"><i class="fa fa-calendar" aria-hidden="true"></i>06-11-2018 13:23 PM</span></p>
                                          <p>User has been registered.</p>
                                        </div>
                                         </a>
                                        </li>
                                      </ul>
                                       <ul class="clearNotification">
                                         <li><a href="javascript:;" data-url="#" class="clearAllNotification btn black_btn " title="Clear All Actions">Clear All</a></li>
                                       </ul>
                                       <ul class="notificationAll">
                                         <li><a class="btn blue_btn" href="#" title="View All Actions">View All</a></li>
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
            <!-- Header End -->
               <?php if(isset($formData['displayFilter']) && $formData['displayFilter']==1) { 
                   include_once "filter_front.php";
               } else { ?>
                     <section class="mainbanner">
                <div class="homeslider">
                    <div class="bannerimg">
                        <img src="<?php echo $path; ?>/images/banner-img.jpg" alt="<?php echo $this->config->item('site_name'); ?>" title="<?php echo $this->config->item('site_name'); ?>">	
                    </div>
                </div>
                     </section>
               <?php } ?>

        

