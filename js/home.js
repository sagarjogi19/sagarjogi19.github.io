/*---------- Script Function List -------------- *
 * 
 * A. Feature Part Slider
 * B. Find Service Slider
 * C. Find Machine Slider
 * D. Testimonial Slider
 * E. Equal Height
 * F. Remove contentSideAdds Class
 * 
 * --------------------------------------------- */



if (!$) {
    var $ = jQuery.noConflict();
} else if (!jQuery) {
    var jQuery = $.noConflict();
}


/*----------| a. Document Ready Start |----------*/
jQuery(document).ready(function() {

    featurePartSlider();
    findServiceSlider();
    findMachineSlider();
    homeTestimonialSlider();
    homeBlogSlider();



    jQuery(".newsLetterInnerBlock").click(function() {
        jQuery(this).hide();
        jQuery(".newsLatterFrmDiv").fadeIn();
        jQuery(".newsLetterBlock").addClass('removePointer');
    });

 jQuery('.closeTopAds').click(function() {
    jQuery('.topadds').hide();
  });
 
 jQuery('.topnavUl li.topsubnavLi.subNav i.fa').click(function() {
    jQuery('.topnavUl > li > ul').toggleClass('ulOpen');
  });

    if (jQuery('.topnavUl > li > ul').hasClass("ulOpen")) {
 jQuery('body').on('click', function() {
     
    jQuery('.topnavUl > li > ul').removeClass('ulOpen');
  });
    }


});


/*----------| b. Window Load Start |----------*/
jQuery(window).load(function() {
    equalheight('.eqHeight');
    remove_contentSideAdds();
    swapDiv();
    
    if (jQuery(window).width() < 770) {

        var nav = jQuery('.mobileNav');
        //nav_height = nav.outerHeight();

        jQuery('.mobileNav ul li:has(ul)').prepend('<span class="arrow"></span>');
        jQuery('.arrow').click(function() {
            jQuery(this).siblings('ul').slideToggle('slow');
            jQuery(this).toggleClass('minus');
        });
        nav.find('a').on('click', function() {
            jQuery('.menu-icon').removeClass('activeMenu');
            jQuery('.mobileNav').slideUp('slow');
            var $el = jQuery(this), id = $el.attr('href');
            jQuery('html, body').animate({scrollTop: jQuery(id).offset().top}, 1000);
            return false;
        });
    }
});


/*----------| c. Window Resize Start |----------*/
jQuery(window).resize(function() {
    equalheight('.eqHeight');
    remove_contentSideAdds();
    swapDiv();
});


/*---------| Function Sart |---------*/

/*---------| A. Feature Part Slider|---------*/
function featurePartSlider() {
    if (jQuery('.featurePartSlider').length > 0) {
        jQuery('.featurePartSlider').slick({
            dots: false,
            arrows: true,
            infinite: false,
            slidesToShow: 5,
            slidesToScroll: 5,
            speed: 3000,
            autoplaySpeed: 4000,
            appendArrows: jQuery('.slideArrow'),
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                        breakpoint: 970,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll:4
                        }
                    },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 350,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
}

/*---------| B. Find Service Slider|---------*/
function findServiceSlider() {
    if (jQuery('.findServiceSlider').length > 0) {

        if (jQuery('.findServiceSlider').hasClass("contentSideAdds")) {

            jQuery('.findServiceSlider').slick({
                dots: false,
                arrows: true,
                infinite: false,
                slidesToShow: 5,
                slidesToScroll: 5,
                speed: 3000,
                rows: 2,
                autoplaySpeed: 4000,
                appendArrows: jQuery('.slideSArrow'),
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 350,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

        }
        else {
            jQuery('.findServiceSlider').slick({
                dots: false,
                arrows: true,
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                speed: 3000,
                rows: 2,
                autoplaySpeed: 4000,
                appendArrows: jQuery('.slideSArrow'),
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 970,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll:3
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 350,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        }

    }
}

/*---------| C. Find Machine Slider |---------*/
function findMachineSlider() {
    if (jQuery('.findMachineSlider').length > 0) {
        jQuery('.findMachineSlider').slick({
            dots: false,
            arrows: true,
            infinite: false,
            slidesToShow: 5,
            slidesToScroll: 5,
            speed: 3000,
            autoplaySpeed: 4000,
            appendArrows: jQuery('.slideMArrow'),
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                        breakpoint: 970,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll:4
                        }
                    },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 350,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
}

/*---------| D. Testimonial Slider |---------*/
function homeTestimonialSlider() {
    if (jQuery('.homeTestimonialSlider').length > 0) {
        jQuery('.homeTestimonialSlider').slick({
            dots: true,
            arrows: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 1500,
            adaptiveHeight: true,
            fade: true,
            cssEase: 'linear'
        });
    }
}

/*---------| E. Equal Height |---------*/

equalheight = function(container) {

    var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = new Array(),
            $el,
            topPosition = 0;
    jQuery(container).each(function() {

        $el = jQuery(this);
        jQuery($el).height('auto')
        topPostion = $el.position().top;

        if (currentRowStart != topPostion) {
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
        }
    });
}


/*---------| F. Remove contentSideAdds Class |---------*/

function remove_contentSideAdds() {
    if (jQuery(window).width() <= 767) {

        jQuery('.findServiceDiv').removeClass("contentSideAdds");


    }
    else {
        jQuery('.findServiceDiv').addClass("contentSideAdds");

    }
}



function homeBlogSlider() {

    if (jQuery('.latestBlogMain').length > 0) {
        jQuery('.latestBlogMain').slick({
            dots: false,
            arrows: false,
            infinite: false,
            slidesToShow: 2,
            slidesToScroll: 2,
            speed: 3000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
            ]
        });
    }
}

function swapDiv() {
    if ($(window).width() < 768) {
        $('#topnavUl').appendTo('#mobileNav');
        $('.bottomHeader').insertBefore('.rightBanner');
        $('.rightBannerAdds').insertAfter('.featurePartDiv');
    }
    else {
        $('#topnavUl').appendTo('.topheaderLeft');
        $('.bottomHeader').insertAfter('.middleHeader');
        $('.rightBannerAdds').insertAfter('.leftBannerAdds');
    }
    
    if ($(window).width() < 767) {
        $('.rightBannerAdds').insertAfter('.featurePartDiv');
    }
    else {
        $('.rightBannerAdds').insertAfter('.leftBannerAdds');
    }
}