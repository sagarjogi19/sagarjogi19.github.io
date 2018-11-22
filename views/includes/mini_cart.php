<?php $userName = getUserInfo(); ?> 
<ul class="topRegisterUl">     
    <?php if (isUserLoggedIn() == false) { ?>   
        <li class="topLoginLi"><a href="<?php echo setLink("user/login"); ?>" title="Login"><span class="loginsvgImg"><img class="svgImg" src="<?php echo $path; ?>/images/login_icon.svg" /></span> Login</a></li>
        <li><a href="<?php echo setLink("user/register"); ?>" title="Register">Register</a></li>
    <?php } else {
        ?>
        <li class="topLoginLi"><a href="<?php echo setLink('user/dashboard'); ?>" title="Dashboard"><span class="loginsvgImg"><img class="svgImg" src="<?php echo $path; ?>/images/login_icon.svg" /></span>Welcome <?php echo $userName->name; ?></a></li>
        <li><a href="<?php echo setLink('user/logout'); ?>" title="Logout">Logout</a></li>
    <?php } ?>
    <li class="topAddToCart">
        <a href="#">
            <span class="topAddToCartImgTag"><img class="svgImg"  src="<?php echo $path; ?>/images/add_to_cart.svg"/></span>
            <span class="topAddToCartCount">0</span>
        </a>
    </li>
</ul> 