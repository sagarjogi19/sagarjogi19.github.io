<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$path = getTemplateLivePath(); // Set live path in url
 
?> 
<section class="">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="notFound">
                        <img src="<?php echo $path; ?>/images/404.jpg" alt="Page Not Found!!" title="Page Not Found!!"/>
                        <h1 class="nontFoundTitle">Page Not Found!!</h1>
                        <p class="notFoundText">Sorry! The page that you are looking for does not exist or appear on this site.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>