<?php defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath();

foreach ($parts as $k => $v) {
   if($this->router->fetch_method() == 'parts_detail'){
        $v['user_logo']=$v['company_logo'];
   }
        
   /*$image = array();
   if ($v['main_image'] != '') {
      $image[] = UTIL::getImageSrc($v['main_image'], "listing", 'machine/'.$v['id'].'/machine-image');
   }
   $additional_image = json_decode($v['additional_image'], true);
   if (count($additional_image) > 0) {
      foreach ($additional_image as $ak => $av) {
         $image[] = UTIL::getImageSrc($av, "listing", 'machine/'.$v['id'].'/machine-image');
      }
   }*/

   $url = setLink('parts/parts-detail/') . $v['alias'];

   $seller_logo = $path . '/images/logo.png';
   if ($v['user_logo'] != '') {
      $seller_logo = ($v['user_logo'] != '' ? Utility::getResizeURL($v['user_logo'], "small", "users", $v['user'],  "logo" ) : '');
   }

//   $description = strip_tags($v['description']);
   ?>
<div class="directoryBox machineListBox">
    <div class="dircBoxDetail">
        <div class="dircBoxLeft eqheight">
            <div class="dircImages">
                <a href="<?php echo $url; ?>">
                    <img src="<?php echo $path; ?>/images/blank_detail.png" title="" alt=""/>
                    <?php if($v['main_image']) { ?>
                    <img class="absoImg" src="<?php echo Utility::getResizeURL($v['main_image'],'list_page','parts',$v['id'],'parts-image'); ?>" title="<?php echo $v['part_name']; ?>" alt="<?php echo $v['part_name']; ?>"/>
                     <?php } else { ?>
                                    <img src="<?php echo $path; ?>/images/blank_detail.png" alt="<?php echo $v['part_name']; ?>" class="absoImg" title="<?php echo $v['part_name']; ?>" />
                    <?php } ?>
                </a>
            </div>
            <div class="dircBoxInnerLeft">
                <h2 class="dircTitle"><a href="<?php echo $url; ?>"><?php echo (strlen($v['part_name'])>40)?substr($v['part_name'],0,40).'...':$v['part_name']; ?></a></h2>
                <p><span class="dircdecTitle">Fits to: </span><?php echo ($v['make_name'])?$v['make_name']:'-'; ?> / <?php echo ($v['model_name'])?$v['model_name']:'-'; ?> </p>
                <p><span class="dircdecTitle">Condition: </span><?php echo ($v['conditions'])?ucfirst($v['conditions']):'-'; ?></p>
                <div class="dirLT">
                    <p class="p_loc"><?php echo $v['suburb'] . ', ' . $v['state']; ?></p>
                    <p class="time"><?php echo Utility::calculateDays($v['updated_date']); ?></p>
                </div>
                <div class="dircbtnBox">
                    <div class="inputBox">
                        <input class="inputFils" placeholder="Qty" value="1"/>
                    </div>

                    <a href="#" class="dircBtn trans " title="Add To Quote">Add To Quote</a>
                    <a href="<?php echo $url; ?>#enqFrm" class="dircBtn trans greenBtn " title="Enquiry Now">Enquiry Now</a>
                    <a class="viewParts trans" href="<?php echo $url; ?>" title="View Parts">View parts <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>

                    <!-- <a href="#" class="dircBtn trans  freightQuote" title="Freight Quote" >Freight Quote</a> -->
                </div>
            </div>
        </div>
        <div class="dircBoxRight eqheight">
          <div class="dircrightinner">
            <div class="dircPrPrice"><?php echo Utility::displayPrice($v['price_type'], $v['price'], $v['price_to'],$v['is_gst'], "list"); ?></div>
            <?php if (isset($seller_logo) && $seller_logo != ''  || isset($v['user_name']) && $v['user_name'] != '') { ?>
            <div class="company_info">
                <div class="compnay_logo"><a href="#!" class="trans"><img src="<?php echo $seller_logo; ?>" title="" alt=""></a></div>
                <div class="company_name"><a href="#!" class="trans"><p class="blue_text"><?php echo $v['user_name']; ?></p></a></div>
            </div>
            <?php } ?>
          </div>
        </div>
    </div>
</div>
<?php } ?>
