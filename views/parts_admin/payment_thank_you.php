<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url  
if (isset($partsdata))
    extract($partsdata);
?>
<section class="">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="thankUBox">
                        <img src="<?php echo $path; ?>/images/thankyou.jpg" alt="Thank You" title="Thank You"/>
                        <p class="thankyouText">Great! Your enquiry has been sent successfully.<br/> We will review your enquiry & get back to you shortly.</p>
                        <br>
                        <p>You will be redirect to profile page in <span id="timecount">10</span> seconds.</p>
                        <p>If you are not auto redirected to the profile page, Please <a title="Click here" href="<?php echo $backURL; ?>"><b>click here</b></a></p>    

                    </div>
                </div>
            </div>
        </div>
    </section>
<script type="text/javascript">
    var time = 10; // Time coutdown
    var page = "<?php echo $backURL; ?>";
    function countDown(){
    time--;
    if(time > -1)
    {
        gett("timecount").innerHTML = time;
    }
    if(time == -1){
    window.location = page;
    }
    }
    function gett(id){
    if(document.getElementById) return document.getElementById(id);
    if(document.all) return document.all.id;
    if(document.layers) return document.layers.id;
    if(window.opera) return window.opera.id;
    }
    function init(){
    if(gett('timecount')){
    setInterval(countDown, 1000);
    gett("timecount").innerHTML = time;
    }
    else{
    setTimeout(init, 50);
    }
    }
    document.onload = init();
</script>