  <!-- Main Banner Start -->
  <?php   $filter=filterData();?>
  
            <section class="mainbanner">
                <div class="homeslider">
                    <div class="bannerimg">
                        <img src="<?php echo $path; ?>/images/banner-img.jpg" alt="<?php echo $this->config->item('site_name'); ?>" title="<?php echo $this->config->item('site_name'); ?>">	
                        <div class="mobileSearchBox comSpacing visible-xs">
                            <div class="mobiileInput">I'm Looking for...</div>
                       </div>
                    </div>
                    <div class="bannercontent">
                        <div class="bannerFrmHeader visible-xs"><span class="bannerFrmHeaderTxt">Search</span><span class="closeFrm">+</span></div>
                        <div class="container">
                            <div class="contentdiv">
                                <div class="contentttl">Sell, Machine and Parts</div>
                                <div class="userfrm">
                                    <div class="userfrmbox">
                                       <form method="get" action="<?php echo setLink('parts/parts-list'); ?>">
                                            <div class="formgroup keywordsearch">
                                                <input class="formfield" id="searchKeyword" name="searchKeyword" placeholder="I'm Looking for..." value="" type="text">
                                            </div>
                                            <div class="formgroup categoryselect">
                                                <div class="sortDown"> 
                                                    <span class="spanOut searchCategory">Categories</span>
                                                    <select onchange="setSpanValue($(this))" onkeyup="setSpanValue($(this))" name="searchCategory" id="searchCategory" title="">
                                                        <option value="">Categories</option> 
                                                         <?php
			       $cate = $filter['categories'];
			       if (count($cate['cat']) > 0) {
			          foreach ($cate['cat'] as $k => $v) {
				  if ($v['cat_cnt'] == 0) {
                                       echo '<optgroup data-select="' . $k . '" label="' .$v['cat_name']. '">' . $v['cat_name'];
//				     echo "<option value='' disable='true'>" . $v['cat_name'] . "</option>";
				  } else {
//				     echo "<option value='" . $vs['sef_cat'] . "' ".(isset($_GET['searchCategory']) && $_GET['searchCategory'] == $vs['sef_cat'] ? 'selected="selected"' : '')." >" . $v['cat_name'] . "</option>";
                                       echo '<optgroup data-select="' . $k . '" label="' .$v['cat_name']. '">' . $v['cat_name'];
				  }
				  if (count($cate['subcat'][$k]) > 0) {
				     foreach ($cate['subcat'][$k] as $ks => $vs) {
				        echo "<option value='" . $vs['sef_cat'] . "' ".(isset($_GET['searchCategory']) && $_GET['searchCategory'] == $vs['sef_cat'] ? 'selected="selected"' : '')." >" . $vs['cat_name'] . "</option>";
				     }
                                       echo '</optgroup>';
				  }
			          }
			       }
			       ?>                              
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="formgroup regionselect">
                                                <div class="sortDown"> 
                                                    <span class="spanOut searchRegion">Region</span>
                                                    <select onchange="setSpanValue($(this))" onkeyup="setSpanValue($(this))" name="searchRegion" id="searchRegion" title="">
                                                        <option value="">Region</option>
                                                          <?php
			       if (count($filter['region']) > 0) {
			          foreach ($filter['region'] as $k => $v) {
				  echo '<optgroup data-select="' . $k . '" label="' . $k . '">';
				  foreach ($v as $kr => $vr) {
				     echo "<option value='" . $vr['sef_region'] . "' ".(isset($_GET['searchRegion']) && $_GET['searchRegion'] == $vr['sef_region'] ? 'selected="selected"' : '')." >" . $vr['region_name'] . "</option>";
				  }
				  echo '</optgroup>';
			          }
			       }
			       ?>                            
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="searchBtn">
                                                <button class="searchButton webBtn trans" type="submit" id="searchButton" title="Search"><img class="svgImg" src="<?php echo $path; ?>/images/search-icon.svg" alt="Search" title="Search"></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Main Banner End -->