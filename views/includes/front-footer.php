<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url
$imgFolder ='parts_category_icon';
if(Query::$app_type != 'front'){
?> 
</section>
<?php } ?>
<!-- Footer Start -->
            <footer>
                <div class="footer">
                    <div class="footCatSec comSpacing">
                        <div class="container catContainer footMidSec">
                            <div class="col-md-14 col-sm-14 col-xs-14 footBox">
                                <div class="footTitle">Directory Category</div>
                                <div class="footBoxCon catlist ">
                                    <div class="visibleConMain">
                                        <div class="visibleCon">
                                              <?php
                                    $cat=footerIcons();  
                                    foreach($cat as $c) {  
                                    ?>
                                            <div class="catBox">
                                                <a href="<?php echo setLink('parts/parts-list'); ?>?cat=<?php echo $c['alias']; ?>" title="<?php echo $c['name']; ?>">
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
                                </div>
<!--                                <div class="readMorediv">
                                    <span class="readMore dircBtn trans  webBtn" title="View More">View More</span>
                                </div>-->
                            </div>
                        </div>
                    </div>
                   
                    <div class="bootomfooter">
                        <div class="container">
                            <div class="footerrow">				
                                <div class="fcol3 fquicklink">
                                    <div class="footBox">
                                        <div class="footTitle">Quick Links</div>
                                        <div class="footBoxCon">
                                            <ul class="quicklinks">
                                                <li <?php echo ($this->router->fetch_method() == 'home')?"class='active'":''; ?>><a href="<?php echo base_url(); ?>" title="Home">Home</a></li>
                                                <li><a href="#" title="Directory">Directory</a></li>
                                                <li><a href="#" title="Sell">Sell</a></li>
                                                <li><a href="#" title="About">About</a></li>
                                                <li id="blogLi"><a href="<?php echo base_url().'blog'; ?>" title="Blog">Blog</a></li>
                                                <li><a href="#" title="Contact Us">Contact Us</a></li>
                                                <li><a href="#" title="Sitemap">Sitemap</a></li>
                                                <li><a href="#" title="Terms & Conditions">Terms & Conditions</a></li>
                                                <li><a href="#" title="Privacy Policy">Privacy Policy</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="fcol3 fnewsletter">
                                    <div class="footBox">
                                        <div class="footTitle">Subscribe Newsletter</div>
                                        <div class="footBoxCon">
                                            <div class="subdesc">Sign up to get latest Worthy Parts listings and news of service providers in mining and construction from around Australia.</div>
                                            <div class="tmpNews"></div>
                                            <div class="newsletterfrm">
                                                <form id="frmNewsletter" class="newslatterForm" method="post" name="frmNewsletter" >
                                                    <div class="formgroup">
                                                        <input class="subfield" type="text" name="txtname" id="txtname" value="" placeholder="Enter name" title="Enter name">
                                                    </div>
                                                    <div class="formgroup">
                                                        <input class="subfield" type="email" name="txtnewsemail" id="txtnewsemail" value="" placeholder="Enter email address" title="Enter email address">
                                                    </div>
                                                    <div class="newsletterbtn">
                                                        <button type="button" value="" title="Sign up" class="subscribebtn webBtn">Sign up</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fcol3 followus">
                                    <div class="footBox">
                                        <div class="footTitle">Follow us</div>
                                        <div class="footBoxCon">
                                            <div class="social">
                                                <ul>
                                                    <?php if($this->config->item('facebook')) { ?>
                                                    <li class="facebook"><a href="<?php echo $this->config->item('facebook'); ?>" title="Facebook"><i class="fab fa-facebook-square"></i></a></li>
                                                    <?php } if($this->config->item('google_plus')) { ?>
                                                    <li class="gplus"><a href="<?php echo $this->config->item('google_plus'); ?>" title="Google Plus"><i class="fab fa-google-plus-square"></i></a></li>
                                                    <?php } if($this->config->item('linkedIn')) { ?>
                                                    <li class="linkedin"><a href="<?php echo $this->config->item('linkedIn'); ?>" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                                    <?php } if($this->config->item('twitter')) { ?>
                                                    <li class="twitter"><a href="<?php echo $this->config->item('twitter'); ?>" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                    <?php } if($this->config->item('instagram')) { ?>
                                                    <li class="instagram"><a href="<?php echo $this->config->item('instagram'); ?>" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="iedalogo"><img src="<?php echo $path; ?>/images/ieda-logo-img.png" alt="IEDA" title="IEDA"></div>
                                    </div>
                                </div>								
                            </div>
                        </div>
                    </div>
                    <div class="copydiv">
                        <div class="container">
                            <div class="copyright">Site contents &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>" class="trans" title="<?php echo $this->config->item('site_name'); ?>">Worthy Parts</a>. All Rights Reserved.</div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- Footer End -->
  </div> <?php // Wrapper ends ?>
  <script type="text/javascript">
     jQuery(document).ready(function () {
 jQuery("#frmNewsletter").validate({
            onkeyup: false,
            ignore: [],
            rules: {
                txtname: {required: true},
                txtnewsemail: {required: true, email: true}
            },

            messages: {
                txtname: {required: 'Please enter name'},
                txtnewsemail: {required: 'Please enter email', email: "Please enter valid email"}
            }

        });
          jQuery('.subscribebtn').click(function(){
            if(jQuery("#frmNewsletter").valid()){
                
                
                jQuery('#email_chimp-error').hide();
            
                jQuery.ajax({
                    url:'<?php echo base_url().'mailchimp.php'; ?>',
                    data: jQuery('#frmNewsletter').serialize(),
                    method:'POST',
                    success: function(data){
//                        console.log(data);
                    
                        jQuery('.tmpNews').html('<div id="mailchimpText">'+data+'</div>');
                        jQuery('.tmpNews').show();
                       
                       /* $('html, body').animate({
                            scrollTop: $("#mailchimp").offset().top
                        }, 2000);*/
//                        $("#mailchimp").hide();
//                        if(data!='Subscription has been done successfully') {
//                            setTimeout(function(){   $('.tmpNews').hide();$("#mailchimp").show(); }, 5000);
                    },
                });
            } else {
                jQuery('#email_chimp-error').show();
            }
           
        });    
        });
</script>
</body>
</html>