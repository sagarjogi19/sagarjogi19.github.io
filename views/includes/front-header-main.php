<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$title = setTitle($title);
$path = getTemplateLivePath(); 
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo (isset($meta_title) && $meta_title != "") ? $meta_title : "Worthy Parts"; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <!-- icons -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo $path; ?>/images/bookmark-icon.jpg">
        <link rel="shortcut icon" sizes="144x144" href="<?php echo $path; ?>/images/bookmark-icon.jpg">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $path; ?>/images/favicon.ico" />
        <link href="<?php echo $path; ?>/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
       
        <?php include_once 'seo_script.php'; ?>
        <script type="text/javascript">var baseURL="<?php echo base_url(); ?>";</script>
        <script src="<?php echo $path; ?>/js/jquery.min.js" type="text/javascript"></script> 
         <!--<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>-->
        <script src="<?php echo $path; ?>/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo $path; ?>/js/jquery.mCustomScrollbar.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo $path; ?>/js/lightgallery.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>/js/slick.min.js"></script>
        <script src="<?php echo $path; ?>/js/custom_front.js" type="text/javascript"></script>
        
        <?php
        if (isset($addJS)) {
            for ($j = 0; $j < count($addJS); $j++) {
                ?>
                <script src="<?php echo $path; ?>/js/<?php echo $addJS[$j]; ?>.js" type="text/javascript"></script> 
                <?php
            }
        }
        ?>	

        
        
       

        <?php
        if (isset($addCSS)) {
            for ($c = 0; $c < count($addCSS); $c++) {
                ?>
                <link href="<?php echo $path; ?>/css/<?php echo $addCSS[$c]; ?>.css" rel="stylesheet" type="text/css">	  
            <?php
            }
        }
        ?>

        <?php // Add css ?>
        <link href="<?php echo $path; ?>/css/slick.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
        <?php if(isUserLoggedIn()) { ?>
         <link href="<?php echo $path; ?>/css/style.css" rel="stylesheet" type="text/css">
         <link href="<?php echo $path; ?>/css/general_style.css" rel="stylesheet" type="text/css"> 
        <?php } ?>  
        <link href="<?php echo $path; ?>/css/style01.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/style_front.css" rel="stylesheet" type="text/css">
    </head> 
    <body>
        <div class="wrapper"><?php
        // Wrapper Starts ?>