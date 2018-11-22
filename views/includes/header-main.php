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
        <link href="<?php echo $path; ?>/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i|Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
        <?php include_once 'seo_script.php'; ?>
        <script type="text/javascript">var baseURL="<?php echo base_url(); ?>";</script>
        <script src="<?php echo $path; ?>/js/jquery.min.js" type="text/javascript"></script> 
        <script src="<?php echo $path; ?>/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo $path; ?>/js/jquery.mCustomScrollbar.js" type="text/javascript"></script>
        <script src="<?php echo $path; ?>/js/custom.js" type="text/javascript"></script> 
        <?php if(isUserLoggedIn()==true) { ?>
            <script src="<?php echo $path; ?>/js/notification.js" type="text/javascript"></script>   
        <?php } 
        if($this->uri->segment(3)=="parts_add" || $this->uri->segment(1)=="dashboard" || $this->uri->segment(2)=="dashboard") {  ?>
        <script src="//cloud.tinymce.com/stable/tinymce.min.js?apiKey=qmrq01l4wwknyfqnh1i77lfwf60ws5c6nrwje1cwpjlmz7mf"></script>
        <?php
        }
        if (isset($addJS)) {
            for ($j = 0; $j < count($addJS); $j++) {
                ?>
                <script src="<?php echo $path; ?>/js/<?php echo $addJS[$j]; ?>.js" type="text/javascript"></script> 
                <?php
            }
        }
        ?>	

        <script src="<?php echo $path; ?>/js/home.js" type="text/javascript"></script> 
        <?php // Add css ?>
        <link href="<?php echo $path; ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
         <link href="<?php echo $path; ?>/css/style.css" rel="stylesheet" type="text/css">
           <link href="<?php echo $path; ?>/css/general_style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/style01.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/style_front.css" rel="stylesheet" type="text/css">
      
       <?php /*<link href="<?php echo $path; ?>/css/footer.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $path; ?>/css/index_v5.css" rel="stylesheet" type="text/css">*/ ?>

        <?php
        if (isset($addCSS)) {
            for ($c = 0; $c < count($addCSS); $c++) {
                ?>
                <link href="<?php echo $path; ?>/css/<?php echo $addCSS[$c]; ?>.css" rel="stylesheet" type="text/css">	  
            <?php
            }
        }
        ?>
    </head> 
    <body class="<?php echo (Query::$app_type != 'front')?"afterLoginPage":"" ?>">
        <div class="wrapper"><?php
        // Wrapper Starts ?>