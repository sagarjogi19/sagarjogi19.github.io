<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url 
$blog=$formData['blogData'];
?> 
<script type="text/javascript">
   /* jQuery(document).ready(function () {
        var rules = {
            username: {required: true},
            password: {required: true},
        };
        var messages = {
            username: {required: 'Please enter username'},
            password: {required: 'Please enter password'},
        }
        validateForm(jQuery("#user-login-form"), rules, messages);
    });*/
</script>
 
  <!-- Featured Parts Section Start -->
<?php if(isset($formData['featured']) && !empty($formData['featured'])){ ?>
<section class="comSpacing feaSec align-center">
    
	<div class="container">
            <div class="secttl"><span class="mainTitle">Featured Parts</span></div>
            <div class="viewalltext"><a class="trans" href="<?php echo setLink('parts/parts-list'); ?>" title="View all">View all<img class="svgImg" src="<?php echo $path; ?>/images/arrow-right.svg" alt="View all" title="View all"></a></div>
                <div class="featuredPartMain clearfix">
                   <?php foreach($formData['featured'] as $k=>$v){ ?> 
                    <div class="featuredBox">
                        <div class="featuredBoxInn">   
                            <a href="<?php echo setLink('parts/parts-detail/').$v['alias']; ?>" title="<?php echo $v['part_name']; ?>">
                                <div class="featuredImg">
                                    <img src="<?php echo $path; ?>/images/trans-218X164.png" alt="trans-img" title="trans" />
                                    <?php if($v['main_image']) { ?>
                                    <img src="<?php echo Utility::getResizeURL($v['main_image'],'home_part','parts',$v['id'],'parts-image'); ?>" alt="<?php echo $v['part_name']; ?>" class="absoImg" title="<?php echo $v['part_name']; ?>" />
                                    <?php } else { ?>
                                    <img src="<?php echo $path; ?>/images/trans-218X164.png" alt="<?php echo $v['part_name']; ?>" class="absoImg" title="<?php echo $v['part_name']; ?>" />
                                    <?php } ?>
                                </div> 
                                <div class="featuredCon">
                                    <h3 class="feaTitle"><?php echo (strlen($v['part_name'])>30)?substr($v['part_name'],0,30).'...':$v['part_name']; ?></h3>
                                </div> 
                            </a>
                        </div>
                    </div>  
                   <?php } ?>
                   
                </div>
	</div>
    
        <div class="clearfix"></div>
        
        <div class="adverBannerMain align-center">
            <div class="container"> 
                <img src="<?php echo $path; ?>/images/aver-banner-img.jpg" alt="adver-img-1" title="adver img" />
            </div>
        </div>
        
</section>
<?php } ?>
<!-- Our Benefits Section Start -->



<!-- Our Benefits Section End -->

<section class="comSpacing benefitSec">
    
    <div class="container">
        
        <div class="ourBenefits"> <!-- Our Benefits Start -->
            <h1 class="mainTitle">Our Benefits</h1>
            <div class="benefitsMain clearfix">
                <div class="benefitBox">
                    <div class="benefitBoxInn">   
                        <div class="benefitImg">
                           <img src="<?php echo $path; ?>/images/benefit-img-1.jpg" alt="machinery-listing" title="Machinery Listing" />
                           <img src="<?php echo $path; ?>/images/trans-330X247.png" alt="machinery-listing" class="absoImg" title="Machinery Listing" />
                        </div>
                        <div class="benefitCap">
                           <div class="benefitTitle"> Machinery Listing</div>
                           <div class="benefitIcon">
                               <img src="<?php echo $path; ?>/images/machin-icon.png" alt="machinery-listing" title="Machinery Listing" />
                           </div>
                        </div>
                    </div>
                </div> 
                <div class="benefitBox">
                  <div class="benefitBoxInn">  
                    <div class="benefitImg">
                        <img src="<?php echo $path; ?>/images/benefit-img-2.jpg" alt="machinery-listing" title="Parts Listing" />
                        <img src="<?php echo $path; ?>/images/trans-330X247.png" alt="machinery-listing" class="absoImg" title="Parts Listing" />
                    </div>
                    <div class="benefitCap">
                        <div class="benefitTitle">Parts Listing</div>
                        <div class="benefitIcon">
                            <img src="<?php echo $path; ?>/images/part-icon.png" alt="machinery-listing" title="Parts Listing" />
                        </div>
                    </div>
                  </div>
                </div> 
            </div>
        </div> <!-- Our Benefits End -->
        
        <div class="tradingAct"> <!--  Trading Start  -->
            <h1 class="mainTitle">Trading Account</h1>
             <div class="benefitBox">
                <div class="benefitBoxInn">   
                    <div class="benefitImg">
                        <img src="<?php echo $path; ?>/images/trade-img.jpg" alt="machinery-listing" title="Machinery Listing" />
                        <img src="<?php echo $path; ?>/images/trans-470X248.png" alt="open-30-day" class="absoImg" title="Open a 30 day trading account" />
                    </div>
                    <div class="benefitCap">
                        <div class="benefitTitle">Open a 30 day trading account</div>
                        <div class="benefitIcon">
                            <img src="<?php echo $path; ?>/images/open-icon.png" alt="open-icon" title="Open a 30 day trading account" />
                        </div>
                    </div>
                </div>
            </div> 
        </div> <!--  Trading End  -->
        
        
    </div>
    
</section>


<!-- Our Feet Section End -->


<!-- Loved by our customer Section Start -->
<?php if(isset($formData['testimonial']) && !empty($formData['testimonial'])){ ?>
<section class="comSpacing customerSec align-center">
   
    <div class="container">
        <h1 class="mainTitle">Loved by Our Customer</h1>
        <div class="customerSlider">
            <?php foreach($formData['testimonial'] as $k=>$v){ ?>
            <div class="customerBox">
                <div class="customerBoxInn">
                    <div class="customerBoxImg">
                       <img src="<?php echo Utility::getResizeURL($v['image_name'],'tm','1','1','testimonial'); ?>" alt="<?php echo $v['customer_name']; ?>" title="<?php echo $v['customer_name']; ?>" /> 
                    </div>
                    <div class="customerBoxCon">
                        <div class="customerName"><?php echo $v['customer_name']; ?><?php echo ($v['business_name'])?' - '.$v['business_name']:''; ?></div>
                        <?php if(isset($v['designation']) && !empty($v['designation'])) { ?>
                        <div class="customerDesi"><?php echo $v['designation']; ?></div>
                        <?php } if(isset($v['description']) && !empty($v['description'])) { ?>
                        <p><?php echo $v['description']; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </div>
        
    </div>
    
</section>
<?php } ?>
<!-- Loved by our customer Section End -->
 <?php if(isset($blog) && !empty($blog)) { ?>
            <!-- Blog Sec Start -->
            <section class="blogsec comSpacing">
                <div class="container">
                    <div class="secttl"><span class="mainTitle">Latest Blog</span></div>
                    <div class="viewalltext"><a class="trans" href="<?php echo base_url().'blog'; ?>" title="View all">View all<img class="svgImg" src="<?php echo $path; ?>/images/arrow-right.svg" alt="View all" title="View all"></a></div>
                    <div class="blogrow">
                        <div class="blogslider">
                                <?php
//                    require_once(FCPATH . "/blog/wp-load.php");

                    if (!empty($blog))
                    {
                      
                        //print_r($data['blog']);
                        foreach ($blog as $key => $val) {
                             $title = $val['post_title'];
                        if($val['meta_value']!="")
                         {
                         $pathImage =  substr($val['meta_value'], 0,strrpos($val['meta_value'], '/'));
                         $imgname  = substr(strrchr($val['meta_value'], '/'), 1);}
                         $blogimagepath = "blog/wp-content/uploads";
                         $mainimagepath  = base_url().'/'.$blogimagepath.'/'.$pathImage.'/'.$imgname;
                          
                          
                         $blogPathImg=explode("/",$pathImage);
                            ?>
                            <div class="blogbox">
                                <div class="bloginner">
                                    <a href="<?php echo base_url() . '/blog/' . $val['post_name']; ?>" title="<?php echo $title; ?>">
                                        <div class="blogimg">
                                            <img src="<?php echo $path; ?>/images/blog-trans-370X278.png" alt="<?php echo $title; ?>" title="<?php echo $title; ?>">
                                            <img class="absoImg" src="<?php echo Utility::getResizeURL($imgname,"small","blogext", $blogPathImg[0], $blogPathImg[1]) ; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>">
                                        </div>
                                        <div class="blogdate"><?php echo $val['post_date'] ?></div>
                                        <div class="blogttl"><?php echo (strlen($title)>40)?$title.'...':$title; ?></div>
                                    </a>
                                </div>
                            </div>
                             <?php } } ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Blog Sec End -->
 <?php } ?>