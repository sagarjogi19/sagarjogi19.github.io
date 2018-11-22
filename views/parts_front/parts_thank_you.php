<?php
    if (isset($_SESSION['contact']) && $_SESSION['contact'] == true) 
    {
        $_SESSION['ref'] = $_SESSION['contact'];
        unset($_SESSION['contact']);
    }    else 
    {
        $ref = $_SESSION['ref'];
        unset($_SESSION['ref']);
     
        if(isset($ref))
        {
            header("Location:".$ref);
        }
        else
        {
            redirect(base_url());
        }
    } 

    //$crumb = array('lastchild' => 0, 'name' => 'Book A Test Drive', 'url' => URI::getURL('mod_enquiry', 'book_test_drive_enquiry'));
   /* $crumb2 = array('lastchild' => 1, 'name' => 'Thank You', 'url' => URI::getURL('mod_page', 'contact_us'));

    $mainTitle = 'Thank You';
    $breadCrumb = array($crumb2);
    display_banner($breadCrumb, $mainTitle);*/

    $path = getTemplateLivePath();
?>

<section class="midSec clearfix">
      <div class="container">
            <div class="row">
                  <div class="col-xs-14">
                        <div class="thanku"> 
                              <img src="<?php echo $path; ?>/images/thnaku_img.jpg" alt="Thank you" title="Thank you" />
                              <h2>THANK YOU</h2>
                              <p>Your enquiry has been sent successfully, <br> we will get back to you shortly.</p>
                        </div>                                              
                  </div>
            </div>
      </div>
</section>

<div class="clear"></div>