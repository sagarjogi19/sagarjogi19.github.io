<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url
$imgFolder ='parts_category_icon';
?> 
</section><?php // Inner main close ?>
            <footer class="footerMain">
                <section class="footCatSec">
                    <div class="container catContainer">
                        <div class="col-md-12">   

                            <div class="catlist">
                                <div class="visibleCon">
                                    <?php
                                    $cat=footerIcons();  
                                    foreach($cat as $c) {  
                                    ?>
                                    <div class="catBox">
                                        <a href="#" title="<?php echo $c['name']; ?>">
                                            <div class="catIcon">
                                                <div class="originalIcon">
                                                    
                                                    <img src="<?php echo Utility::getResizeURL((isset($c['image_name']) && $c['image_name']!="")?$c['image_name']:"genral-ic.png","small","1","1",$imgFolder); ?>" />
                                                </div>
                                                <div class="hoverIcon">
                                                      <img src="<?php echo Utility::getResizeURL((isset($c['image_name_hover']) && $c['image_name_hover']!="")?$c['image_name_hover']:"genral-ic_hover.png","small","1","1",$imgFolder); ?>" />
                                                </div>
                                            </div>
                                            <div class="catName"><?php echo $c['name']; ?></div>
                                        </a>
                                    </div>
                                    <?php } ?>     
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <!--          <div class="readMorediv">
                                           <span class="readMore dircBtn trans" title="View More">View More</span>
                                        </div>-->
                        </div>
                    </div>

                </section>




                <div class="footMidSec">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5 col-sm-7 col-xs-12">
                                <div class="footBox">
                                    <div class="footTitle">Quick Links</div>
                                    <div class="footBoxCon">
                                        <ul class="quick_links">
                                            <li><a href="#" title="Home">Home</a></li>
                                            <li><a href="#" title="Blog/Community">Blog/Community</a></li>
                                            <li><a href="#" title="Terms &amp; Conditions">Terms &amp; Conditions</a></li>
                                            <li><a href="#" title="About">About</a></li>
                                            <li><a href="#" title="Videos">Videos</a></li>
                                            <li><a href="#" title="Privacy Policy">Privacy Policy</a></li>
                                            <li><a href="#" title="Sell">Sell</a></li>
                                            <li><a href="#" title="Job Seekers">Job Seekers</a></li>
                                            <li><a href="#" title="Contact Us">Contact Us</a></li>
                                            <li><a href="#" title="Directory">Directory</a></li>
                                            <li><a href="#" title="Commodity ">Commodity </a></li>
                                            <li><a href="#" title="Sitemap">Sitemap</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-5 col-xs-12">
                                <div class="footBox">
                                    <div class="footTitle">Follow Us</div>
                                    <div class="footBoxCon">
                                        <ul class="socialLinks">
                                            <li><a href="#" title="follow on facebook" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                            <li><a href="#" title="follow on google plus" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                                            <li><a href="#" title="follow on linkedin" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                                            <li><a href="#" title="follow on skype" target="_blank"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
                                            <li><a href="#" title="follow on youtube" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-5 col-xs-12 footerSubNewsletter">
                                <div class="footBox">
                                    <div class="footTitle">Subscribe Newsletter</div>
                                    <div class="footBoxCon">
                                        <div class="newsLetterBlock">
                                            <div class="newsLetterInnerBlock" title="Subscribe Newsletter">
                                                <div class="newsIconDiv">
                                                    <span class="newsIcon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
                                                </div>
                                                <div class="newsTextDiv">
                                                    <span class="newsText">SUBSCRIBE</span>
                                                    <span class="newsFooterLogo"><img src="<?php echo $path; ?>/images/ourBenefitsLogo.png" /></span>
                                                    <span class="newsText">NEWSLETTER</span>
                                                </div>
                                            </div>
                                            <div class="newsLatterFrmDiv">
                                                <?php 
                                                $email="";
                                                if (isUserLoggedIn() == true) { 
                                                    $email=getUserInfo();
                                                }
?>
                                                <div class="footerNewsTitle">Subscribe Newsletter</div>
                                                <form id="frmNewsletter" class="newslatterForm" action="" name="frmNewsletter" >
                                                    <input class="inputBox" type="email" name="txtnewsemail" id="txtnewsemail" title="Enter email address" placeholder="Enter email address..." value="<?php echo ($email!="")?$email->email:""; ?>" />
                                                    <button class="subcribeBtn" type="submit" title="Subscribe"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="copyRight">Site contents &copy; <?php echo date('Y'); ?> <a href="index.html" title="Worthy Parts">Worthy Parts</a>. All Rights Reserved.</div>
				<?php /*<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>	*/ ?>
            </footer>
 <a title="Scroll Top" class="scrollTop" href="javascript:;" ><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
  </div> <?php // Wrapper ends ?>
</body>
</html>