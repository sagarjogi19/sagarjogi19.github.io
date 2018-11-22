if (!$) {
    var $ = jQuery.noConflict();
} else if (!jQuery) {
    var jQuery = $.noConflict();
}
jQuery(window).resize(function() {
if (jQuery(window).width() <= 1024) {
     jQuery("#map-canvas").after(jQuery("#panelContainer"));
jQuery(".detailBox .dircBoxInnerRight").after(jQuery(".detailBox .dircBoxInnerLeft"));
}
popUpImgBoxRezise();
LoginResize();
});

jQuery(window).load(function(){    
    if (jQuery(window).width() <= 1024) {
     jQuery("#map-canvas").after(jQuery("#panelContainer"));
     jQuery(".detailBox .dircBoxInnerRight").after(jQuery(".detailBox .dircBoxInnerLeft"));
}
if(jQuery('.dircBoxDetail ul.socialLinks li').length != 0){
    jQuery('.dirc_leftShare').css({'border-top':'1px solid #dedede','padding':'15px'});
}
popUpImgBoxRezise();
LoginResize();



/*---------------------------------------------- 
     CHEANGE SPAN COLOR 
     ------------------------------------------------*/
	 
	jQuery('.customSelect').each(function(k, v){
		//alert(k, v);
		if (jQuery(this).find('select').val() != '')
    {
        jQuery(this).find('span.spanOut').css('color', '#000');
    }
    else
    {
		jQuery(this).find('span.spanOut').css('color', '#999999');
    }
	
});
    
	
    jQuery(document).on('change', '.customSelect select', function(e) {

        if (jQuery(this).prop("selectedIndex") == 0) {
            jQuery(this).siblings('.spanOut').css('color', '#999999');
        }
        if (jQuery(this).val() != "") {
            jQuery(this).siblings('.spanOut').css('color', '#000000');
        }
    });
    jQuery('.customSelect select').keyup(function() {
        if (jQuery(this).prop("selectedIndex") == 0) {
            jQuery(this).siblings('.spanOut').css('color', '#999999');
        }
        if (jQuery(this).val() != "") {
            jQuery(this).siblings('.spanOut').css('color', '#000000');
        }
    });
	



jQuery('.customSelect.homecstSelect').each(function(k, v){
		//alert(k, v);
		if (jQuery(this).find('select').val() != '')
    {
        jQuery(this).find('span.spanOut').css('color', '#000000');
    }
    else
    {
		jQuery(this).find('span.spanOut').css('color', '#000000');
    }
	
});
    
	
    jQuery(document).on('change', '.customSelect.homecstSelect select', function(e) {

        if (jQuery(this).prop("selectedIndex") == 0) {
            jQuery(this).siblings('.spanOut').css('color', '#000000');
        }
        if (jQuery(this).val() != "") {
            jQuery(this).siblings('.spanOut').css('color', '#000000');
        }
    });
    jQuery('.customSelect.homecstSelect select').keyup(function() {
        if (jQuery(this).prop("selectedIndex") == 0) {
            jQuery(this).siblings('.spanOut').css('color', '#000000');
        }
        if (jQuery(this).val() != "") {
            jQuery(this).siblings('.spanOut').css('color', '#000000');
        }
    });



});
jQuery(document).ready(function() { 

jQuery('.float_callbtn').click(function(){
   jQuery('html, body').animate({
       scrollTop: jQuery(jQuery(this).attr('href') ).offset().top - 106
   }, 1200);
   return false;
});
var objFrmNewsletter = jQuery("#frmNewsletter");
		var nlrules = {
               txtnewsemail: {required:true,email:true},
            };
           var nlmessages = {
               txtnewsemail: {required:'Please enter email',email:'Please enter valid email'},
           };
	validateForm(objFrmNewsletter,nlrules,nlmessages);  


/*-----------------------------
     Mobile Myaccount menu
     ------------------------------*/
    jQuery('.accmenuIcon').click(function(){
        jQuery('.mobileaccnav').slideToggle();
        jQuery(this).toggleClass('activeMenu');
    });


if(jQuery("span.notification").length > 0 ) {
     getNotifications();
     var myVar = setInterval(function(){ getNotifications() }, 600000);
 }    

 /*-----------------------------
     07 Product Slider
     ------------------------------*/
    if(jQuery('.machineProSlider').length>0){
	jQuery('.machineProSlider').slick({
        slidesToShow: 1,
        infinite: false,
        slidesToScroll: 1,
        arrows: false,
		swipeToSlide: false,
        fade: false,
        asNavFor: '.machineProNav',
        autoplay: false,
        speed: 1500,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                   arrows: true,
                }
            }
        ]
    });
    }
    if(jQuery('.machineProNav').length>0){
    jQuery('.machineProNav').slick({
        slidesToShow: 4,
        infinite: false,
        slidesToScroll: 1,
        asNavFor: '.machineProSlider',
        focusOnSelect: true,
        dots: false,
		swipeToSlide: false,
        autoplay: false,
        speed: 1500,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 668,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });
    }
    svgConvert();
    if (jQuery(window).width() <= 1024) {
     jQuery("#map-canvas").after(jQuery("#panelContainer"));
     jQuery(".detailBox .dircBoxInnerRight").after(jQuery(".detailBox .dircBoxInnerLeft"));
    
}
     jQuery('.popclick').off('click');
    jQuery(document).on('click', '.popclick', function(e) {
        jQuery('body').addClass('popup_bodyfixed');
    });
    jQuery(document).on('click', '.closePopup, .overlayer', function(e) {
        jQuery('body').removeClass('popup_bodyfixed');
    });
    jQuery('#toolbar-administration').hide();
   jQuery(".messages--error").wrap("<div class='container'></div>");
/*if(! jQuery(".messages--error").parents().find('.container')){
     jQuery(".messages--error").wrap("<div class='container'></div>");
}*/
    jQuery(".messages--status.dirSuccess").wrap("<div class='container'></div>");
	/*if(jQuery('input').length > 0 && jQuery('textarea').length > 0){
		jQuery('input, textarea').placeholder({customClass: 'my-placeholder'});
	}*/
    /*---------------------------------------
     Scroll  to top start
     ----------------------------------------*/
    jQuery(window).scroll(function() {
		
        //alert('hi');
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.scrollTop').addClass('visibleSCroll')
        } else {
            jQuery('.scrollTop').removeClass('visibleSCroll')
        }
    });
    // Script for click to scroll body	
    jQuery('.scrollTop').click(function() {
        jQuery('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
	jQuery(".clearAllNotification").click(function(){
		if(jQuery('.notificationList li').length == 0) {
                    jQuery('.notfyNav').hide();
//			alert('Notifications are already cleared');
//			return false;
		}
		var yesno=confirm('Are you sure want to clear all notification?');
		if(yesno){
		 jQuery.ajax({
                                                    url:jQuery(this).attr('data-url'),
                                                    data:{"clearAll":"true"},
                                                    type:'post',
                                                    success:function(data){ 
                                                    if(data!='fail'){
                                                            jQuery('.notificationList').html('');
                                                            jQuery('.totalNotification').html('0');
                                                            jQuery('.notfyNav').hide();
                                                            alert('All notifications are cleared.');
                                                    }else {
                                                            alert('There is something goes wrong. Please try again');
                                                    }    
                                                    }
                                            });
		}
	});
    /*---------------------------------------
     Mobile menu start
     ----------------------------------------*/
//    jQuery(', ').click(function() {
//     jQuery(this).toggleClass('menuActive');
//     jQuery(this).siblings('.mobileNav').slideToggle('slow');
//     jQuery('body').toggleClass('bodyFix');
//     });
    jQuery('.menuIcon').click(function() {
        //alert('hi');
        jQuery(this).toggleClass('menuActive');
        jQuery(this).siblings('.menuMain').slideToggle('slow');
        if (jQuery(this).hasClass("menuActive")) {
            jQuery('body').addClass('bodyFix');
        } else {
            jQuery('body').removeClass('bodyFix');
        }
        if (jQuery(".mobileNav").is(":visible")) {
            jQuery('.accountNav').slideUp('fast');
            jQuery('.cartNav').slideUp('fast');
            jQuery('.notfyNav').slideUp('fast');
            jQuery('.accutClick').removeClass('menuActive');
            jQuery('.addCartClick').removeClass('menuActive');
            jQuery('.notifyClick').removeClass('menuActive');
            //jQuery('body').removeClass('bodyFix');
        }
    });
    /*Account*/
    jQuery('.accutClick').click(function() {
        //alert('hi');
        jQuery(this).toggleClass('menuActive');
        if (jQuery(this).hasClass("menuActive")) {
            jQuery('body').addClass('bodyFix');
        } else {
            jQuery('body').removeClass('bodyFix');
        }
        if (jQuery(".mobileNav").is(":visible")) {
            jQuery('.menuMain').slideUp('fast');
            jQuery('.cartNav').slideUp('fast');
            jQuery('.notfyNav').slideUp('fast');
            jQuery('.menuIcon').removeClass('menuActive');
            //jQuery('body').removeClass('bodyFix');
        }
        jQuery(this).siblings('.accountNav').slideToggle('slow');
    });
    /*Add to Cart*/
    jQuery('.addCartClick').click(function() {
        //alert('hi');
        jQuery(this).toggleClass('menuActive');
        if (jQuery(this).hasClass("menuActive")) {
            jQuery('body').addClass('bodyFix');
        } else {
            jQuery('body').removeClass('bodyFix');
        }
        if (jQuery(".mobileNav").is(":visible")) {
            jQuery('.menuMain').slideUp('fast');
            jQuery('.accountNav').slideUp('fast');
            jQuery('.notfyNav').slideUp('fast');
            jQuery('.menuIcon').removeClass('menuActive');
        }
        jQuery(this).siblings('.cartNav').slideToggle('slow');
    });
    /*Notification to Click*/
    jQuery('.notifyClick').click(function() {
        // alert('hi');
        jQuery(this).toggleClass('menuActive');
        if (jQuery(this).hasClass("menuActive")) {
            jQuery('body').addClass('bodyFix');
        } else {
            jQuery('body').removeClass('bodyFix');
        }
        if (jQuery(".mobileNav").is(":visible")) {
            jQuery('.menuMain').slideUp('fast');
            jQuery('.accountNav').slideUp('fast');
            jQuery('.cartNav').slideUp('fast');
            jQuery('.menuIcon').removeClass('menuActive');
        }
        jQuery(this).siblings('.notfyNav').slideToggle('slow');
    });



    /*---------------------------------------
     Footer	category Slider start
     ----------------------------------------*/
    if (jQuery('.catSlider').length > 0) {
        jQuery('.catSlider').slick({
            dots: false,
            infinite: true,
            speed: 2000,
            slidesToShow: 9,
            slidesToScroll: 1,
            //autoplay:true,
            // autoplaySpeed: 6000,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 8,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 6,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 568,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });
    }
    /*---------------------------------------------
     footer mobile togle 
     ------------------------------------------------*/
    jQuery('.footTitle').click(function() {
        if (jQuery(this).hasClass('footTitleActive')) {
            jQuery(this).next().slideUp();
            jQuery(this).removeClass('footTitleActive');
            jQuery(this).parent().removeClass('openBox');
        } else {
            jQuery('.footTitle').removeClass('footTitleActive');
            jQuery(this).addClass('footTitleActive');
            jQuery('.footBox').removeClass('openBox');
            jQuery(this).parent().addClass('openBox');
            jQuery('.footBoxCon').slideUp();
            jQuery(this).next().slideDown();
            setTimeout(function() {
                    jQuery("html,body").animate({
                        scrollTop: jQuery('.footTitleActive').offset().top
                    }, "slow");
                }, 500);
        }
    });
    /*---------------------------------------------
     Edit Profile Toggle 
     ------------------------------------------------*/
    jQuery('.editPro .formBoxHead:first').addClass('formBoxHeadActive');
    jQuery('.editPro .formBoxHead:first').next().slideDown();
    jQuery('.editPro .formBoxHead').click(function() {

        if (jQuery(this).hasClass('formBoxHeadActive')) {
            jQuery(this).toggleClass('formBoxHeadActive');
            jQuery(this).next().slideUp();
        }
        else {
            jQuery(this).toggleClass('formBoxHeadActive');
            jQuery(this).next().slideDown();
        }
    });
    /*---------------------------------------------- 
     Custom select span
     ------------------------------------------------*/
    jQuery("select").each(function(key, val) {
        setSpanValue(jQuery(this));
    }); 
	if (jQuery('.customSelect select').val() != '')
                {  

                    jQuery('.customSelect span.spanOut').css('color', '#000');
                }
                else
                {
                    jQuery('.customSelect span.spanOut').css('color', '#8c8c8c');
                }
                //jQuery('input, textarea').placeholder({customClass: 'my-placeholder'});

                jQuery('.customSelect select').change(function() {
                    if (jQuery(this).prop("selectedIndex") == 0) {
                        jQuery(this).siblings('.spanOut').css('color', '#aaaaaa');
                    }
                    if (jQuery(this).val() != "") {
                        jQuery(this).siblings('.spanOut').css('color', '#1c1c1c');
                    }

                });
                jQuery('.customSelect select').keyup(function() {
                    if (jQuery(this).prop("selectedIndex") == 0) {
                        jQuery(this).siblings('.commonForm .spanOut').css('color', '#aaaaaa');
                    }
                    if (jQuery(this).val() != "") {
                        jQuery(this).siblings('.spanOut').css('color', '#1c1c1c');
                    }

                });

	
	
	
    jQuery(".detailTab li").click(function() {

        var tabId = jQuery(this).attr('data-tab');
        jQuery('.detailTab li').removeClass("active");
        jQuery(".accoContain").removeClass("active in");
        jQuery(this).addClass("active");
        jQuery("#" + tabId).addClass("active");
        setTimeout(function() {
            jQuery("#" + tabId).addClass("in");
        }, 100);
    });
    /*---------------------------------------------
     fatching data and make accordian
     --------------------------------------------*/
    //jQuery(".accoContain").hide();
    //jQuery(".accoContain:first").show(); // THIS LINE IS ADDED FOR FIRST ACCORDIAN OPEN!!!
    jQuery(".accoContain").before("<h4 class='resp-accordion' role='tab'></h4>");
//    var itemCount = 0;
//    jQuery('.resp-accordion').each(function() {
//        var innertext = jQuery('.tabing:eq(' + itemCount + ')').html();
//        jQuery('.resp-accordion:eq(' + itemCount + ')').append(innertext);
//        itemCount++;
//    });

//    if (jQuery(window).width() < 767) {
//        jQuery(".accoContain").removeClass("active in");
//        jQuery(".resp-accordion").click(function() {
//            if (jQuery(this).hasClass("minus")) {
//                jQuery(this).removeClass("minus").next().slideUp();
//            }
//            else {
//                jQuery(".resp-accordion").removeClass("minus");
//                jQuery(".accoContain").slideUp();
//                jQuery(this).addClass("minus");
//                jQuery(this).next().slideDown();                            
//            }
//        }).filter(':first').click();
//    } 
    /*---------------------------------------------- 
     TEXT SWIP SCRIPT IN MOBILE FOR CAR LISTING
     ------------------------------------------------*/
    jQuery('.mobiSwipe').click(function() {
        jQuery(this).next().toggleClass('ulHide');
        jQuery(this).next().slideToggle('slow');
        jQuery(this).toggleClass('minusLink');
    });
    /*---------------------------------------------- 
     Read More Category
     ------------------------------------------------*/
//    jQuery('.catBox').slice(18).hide();
//    jQuery('.catBox').slice(18).addClass('hideSerc');
//    var lessHeight = jQuery('.visibleCon').height();
//    jQuery('.visibleCon').parent('.visibleConMain').height(lessHeight);
//    jQuery('.readMore').click(function() {
//        var lessHeight = jQuery('.visibleCon').height();
//        if (jQuery(".hideSerc").is(":visible")) {
//            jQuery('.catBox').slice(18).hide();
//            jQuery(this).text('View More');
//            var hideheight = jQuery('.visibleCon').height();
//            jQuery('.visibleCon').parent('.visibleConMain').animate({height: hideheight}, 100);
//        } else {
//            jQuery('.catBox').slice(18).show();
//            jQuery(this).text('Less');
//            var showheight = jQuery('.visibleCon').height();
//            jQuery('.visibleCon').parent('.visibleConMain').animate({height: showheight}, 300);
//            
//        }
//    });
    
     // jQuery('.catBox').hide().filter(':lt(18)').show();  
      jQuery('.readMore').click(function() {     
        jQuery(this).toggleClass('viewLess');
        jQuery('.toggleDiv').slideToggle('slow');
	if (jQuery(this).hasClass('viewLess')) {
            jQuery(this).children('.readMore').text('View Less');
            jQuery(this).attr('title', 'View Less');
            //jQuery('.toggleDiv').slideDown(1000);
        }
        else {
            jQuery(this).children('.readMore').text('View More');
            jQuery(this).attr('title', 'View More');
            //jQuery('.toggleDiv').slideUp(1000);
        }
   //     jQuery(this).parent().siblings('.toggleDiv').slideToggle('slow');
        jQuery(this).html() == "View More" ? jQuery(this).html('View Less') : jQuery(this).html('View More');
    });
   jQuery('.visibleCon .catBox').not(':lt(18)').wrapAll('<div class="toggleDiv" ></div>');
    if (jQuery(window).width() < 768) {
        jQuery('.toggleDiv').show();
        jQuery('.catBox.hideSerc').css('display', 'inline-block');
        jQuery('.shareBtnClick.share').removeClass('share');
/*         jQuery(".userListMain .actionBtn").after(jQuery(".S_addNew"));
         jQuery(".userListMain .actionBtn").next('.S_addNew').css("display",'block');
         jQuery(".userListMain .limitDrp.actionBtn").next('.S_addNew').css("display",'none');
         jQuery(".userListMain .pageNav .S_addNew").remove();*/
    }
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
    jQuery('.up-Btn').change(function() {
        jQuery(this).siblings('.text').text(this.value)
    });
    jQuery(document).on('click', '.shareClick', function(e) {
        //alert('hi');
        jQuery('.shareListPop').slideUp('fast');
        if (jQuery(this).siblings('.shareListPop').is(":visible")) {
            jQuery('.shareListPop').slideUp('slow');
        } else {
            jQuery(this).siblings('.shareListPop').slideDown('slow');
        }
    });
//    jQuery(document).bind("click touchstart",function(e) {
//		if (jQuery('.shareListPop').is(":visible")) {
//			if (!jQuery(e.target).is('.shareListPop')) {
//			   jQuery(".shareListPop").slideUp('slow');
//		   }
//		}
//   });
    jQuery(document).mouseup(function(e) {
        var popup = jQuery(".shareListPop");
        if (!jQuery('.shareListPop').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
            popup.slideUp(500);
        }
    });
jQuery('.notificationMain').parents('.innerMain').addClass('notifyMainDiv');
if(jQuery.fn.mCustomScrollbar){
 jQuery("#panelContainer, #termsCondition").mCustomScrollbar({
            scrollButtons: {
                enable: !1
            },
            theme: "light-thick",
            scrollbarPosition: "outside",
            scrollInertia: 800,
            callbacks:{
                onTotalScroll:function(){
                    if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
                        jQuery('#upgradeSub').removeAttr('disabled');
                        jQuery('#upgradeSub').removeClass('disBtn');
                    }
                }
            }
});
}
if (jQuery(window).height() < 768) {
    if(jQuery.fn.mCustomScrollbar){
jQuery("#sendEmail  .popDetails").mCustomScrollbar({
            scrollButtons: {
                enable: !1
            },
            theme: "light-thick",
            scrollbarPosition: "outside",
            scrollInertia: 800,
//            callbacks:{
//                onTotalScroll:function(){
//                    if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
//                        jQuery('#upgradeSub').removeAttr('disabled');
//                        jQuery('#upgradeSub').removeClass('disBtn');
//                    }
//                }
//            }
});
}
}
popUpImgBoxRezise();
if(jQuery.fn.mCustomScrollbar){
 jQuery(".popUpImgScroll").mCustomScrollbar({
            scrollButtons: {
                enable: !1
            },
            theme: "light-thick",
            scrollbarPosition: "outside",
            scrollInertia: 800
}); 
}

if (jQuery(window).width() < 768) {
    if(jQuery.fn.mCustomScrollbar){
jQuery('.catlist').addClass('mCustomScrollbar');
jQuery("#requstQuote .popDetails, #callMeBack .popDetails, #sendEnquiry .popDetails").mCustomScrollbar({
            scrollButtons: {
                enable: !1
            },
            theme: "light-thick",
            scrollbarPosition: "outside",
            scrollInertia: 800
});
}
}
mobileCall();
 jQuery.validator.addMethod('checkZero', function(value, element, param) {
        if(value != "")
            return parseFloat(value) > 0 ;
        else
            return true;
    }, 'Must not be greater Than 0.' );
    jQuery.validator.addMethod('validUrl', function(value, element) {
        var url = jQuery.validator.methods.url.bind(this);
        return url(value, element) || url('http://' + value, element);
    }, 'Please enter a valid URL');
    // validate password. It must have at least on uppercase letter, one digit and one special character
    jQuery.validator.addMethod("passwordValue", function(value, element) {
                                                             if(jQuery.trim(value) == "")
                                                                    return true;
                                                             var expreText = /(?=.*[A-Z]+)(?=.*\d+)(?=.*\W+)/g;								
                                                             return expreText.test(value);	// validate element							 
    }, "Password must have at least one uppercase letter, one digits and one special character");
    jQuery.validator.addMethod("whitespaceValue", function(value, element) {
							if(jQuery.trim(value) == "")
							 	return true;
	 						 var expreText = /\s/g;								
 							 return !expreText.test(value);	// validate element							 
}, "White space not allowed");
    // validate user name. It must not begin with undersocre(_)
jQuery.validator.addMethod("usernameValue", function(value, element) {
	 						 var expreText = /^_/g;							 
 							 return !expreText.test(value);	// validate element							 
}, "Username should not start with underscore (_)");
 jQuery.fn.numericOnly =
            function()
            {
                return this.each(function()
                {
                    if (jQuery(this).hasClass('select_text')) {
                        jQuery(this).focus(function() {
                            jQuery(this).select();
                        });
                    }
                    jQuery(this).on('dragstart drop', function() {
                        return false;
                    })
                    /* ends here */
                    jQuery(this).keydown(function(e)
                    {
                        if (typeof(jQuery(this).attr('readonly')) == "undefined") {
                            key = e.keyCode;
                            if (key == 8 || key == 46) {
                                
                            }
                        }
                        if (jQuery(this).hasClass('hasDatepicker') || jQuery(this).hasClass('isDate')) {
                            return false;
                        }
                        var key = e.charCode || e.keyCode || 0;
                        var shift = false;
                        if (e.shiftKey && key != 9) {
                            shift = true;
                        }
                        // restrict to only numbers do not add '.'
                        if (jQuery(this).hasClass('numbers') && (key == 110 || key == 190)) {
                            return false;
                        }
// allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
// home, end, period, and numpad decimal                       
                        return (!shift && (
                                key == 8 ||
                                key == 9 ||
                                key == 13 ||
                                key == 46 ||
                                key == 110 ||
                                key == 190 ||
                                (key >= 35 && key <= 40) ||
                                (key >= 48 && key <= 57) ||
                                (key >= 96 && key <= 105)));
                    });
                });
            };
    jQuery(".numericOnly").numericOnly();
	//   Front Listing Page js
	jQuery( function() {
		if(jQuery( "#category" ).length > 0) {
			jQuery( "#category" ).selectmenu();
		} else if(jQuery( "#type" ).length > 0) {
			jQuery( "#type" ).selectmenu();
		}
   
  } );
 
	/* -------------------------------------------
			Sidebar box togle
	---------------------------------------------*/
	jQuery('.catTogleClick').click(function() {
       jQuery(this).toggleClass('closeBox');
	   jQuery(this).next('.togleBody').slideToggle('slow'); 
    });
	
	/* -------------------------------------------
			category accordion
	---------------------------------------------*/
	jQuery('.catLists > li').has('ul').prepend('<span class="catAccor trans"><i class="fa fa-plus-square" aria-hidden="true"></i></span>');
    jQuery('.catAccor').click(function() {
        jQuery(this).children('.fa').toggleClass('fa-minus-square');
		jQuery(this).siblings('.subCat').slideToggle('slow');
    });
/* -------------------------------------------
			Mobile sidepanal
	---------------------------------------------*/	
	jQuery('.partsIcon').click(function() {
        jQuery('.searchForm').addClass('slideLeft');
		jQuery('body').addClass('bodyFix');
    });
	
	jQuery('.filterIcon').click(function() {
        jQuery('.filterSidebar').addClass('slideLeft');
		jQuery('body').addClass('bodyFix');		
    });
	
	jQuery('.closePenal').click(function() {
		 jQuery('.filterSidebar, .searchForm').removeClass('slideLeft');
		 jQuery('body').removeClass('bodyFix');	
        
    });
    
    /*---------------------------------
            TABBED CONTENT
---------------------------------*/
 
    jQuery(".tab_content").hide();
    jQuery(".tab_content:first").show();

  /* if in tab mode */
    jQuery("ul.tabs li").click(function() {
		
      jQuery(".tab_content").hide();
      var activeTab = jQuery(this).attr("data-tab"); 
      jQuery("#"+activeTab).fadeIn();		
		
      jQuery("ul.tabs li").removeClass("active");
      jQuery(this).addClass("active");

	  jQuery(".tab_drawer_heading").removeClass("d_active");
	  jQuery(".tab_drawer_heading[data-tab^='"+activeTab+"']").addClass("d_active");
	  
    });

	
        
			jQuery(".tab_content").removeClass("active");
			jQuery(".tab_drawer_heading").click(function() {
				if (jQuery(this).hasClass("d_active")) {
					jQuery(this).removeClass("d_active").next().slideUp();
				}
				else {
					jQuery(".tab_drawer_heading").removeClass("d_active");
					jQuery(".tab_content").slideUp();
					jQuery(this).addClass("d_active");
                                        setTimeout(function() {
                                            jQuery("html,body").animate({
                                                scrollTop: jQuery('.d_active').offset().top - 10
                                                }, "slow");
                                            }, 500); 
					jQuery(this).next().slideDown();                            
				}
			}).filter('tab_content:first').click();
            
	jQuery('ul.tabs li').last().addClass("tab_last");
   



    
});

/*-----------| B. Mobile call action |-----------*/		
function mobileCall(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {		
	jQuery('.m_call').each(function(){
	var value = jQuery(this).text();
	jQuery(this).addClass('mobileCall');
jQuery(this).html('<a class="trans" href="tel:' + value + '">' + value + '</a>');
	});		
    }
}

/*---------------------------------------------- 
 PAYMENT METHOD 
 ------------------------------------------------*/
function setSpanValue(drp) {
    var str = "";
    var id = drp.attr("id");
    str = jQuery("#" + id + " option:selected").text();
    jQuery("." + id).text(str);
}
function isPhoneChar(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 8)
        return false;
    if (charCode == 46)
        return false;

    return true;
}
function popUpImgBoxRezise(){
    if (jQuery(window).width() < 768) {
var mHeight = jQuery( window ).height();
var mtopSecH = 40;
var mbottomSecH = 93;
var totalHeight = mHeight - (mtopSecH + mbottomSecH);
jQuery('.popUpImgScroll').css({"max-height":totalHeight+"px"});
}
}
function LoginResize(){
    if (jQuery(window).width() < 360) {
//    jQuery(".forGotPass").after(jQuery(".rememberMe"));
}
}

function svgConvert() {
jQuery('.svgImg').each(function() {
  //  alert('test');
         var $img = jQuery(this);
         var imgID = $img.attr('id');
         var imgClass = $img.attr('.svgImg');
         var imgURL = $img.attr('src');

         jQuery.get(imgURL, function(data) {
            
             // Get the SVG tag, ignore the rest
             var $svg = jQuery(data).find('svg');
             // Add replaced image's ID to the new SVG
             if (typeof imgID !== 'undefined') {
                 $svg = $svg.attr('id', imgID);
             }
             // Add replaced image's classes to the new SVG
             if (typeof imgClass !== 'undefined') {
                 $svg = $svg.attr('class', imgClass + ' replaced-svg');
             }

             // Remove any invalid XML tags as per http://validator.w3.org
             $svg = $svg.removeAttr('xmlns:a');

             // Replace image with new SVG
             $img.replaceWith($svg);
            
         }, 'xml');

     });

}
function validateForm(obj,rulesData,messagesData,ignore){
	     if(!ignore){
			 ignore=new Array();
		 } 
		 
	   	 obj.validate({
		ignore: ignore,	 
		onkeyup:false,
		rules:rulesData,
		messages:messagesData,
		errorClass: "error",
                highlight: function(obj) {
                    jQuery(obj).addClass("error");
                    jQuery(obj).parent('.customSelect').addClass("error");
                },
                unhighlight: function(obj) {
                    jQuery(obj).removeClass("error");
                    jQuery(obj).parent('.customSelect').removeClass("error");
                }
	 });
   }
function setCaptcha(e){
	var t=e.attr("id"),i=jQuery("#encriptNum").attr("id"),s=jQuery("#secureImg").attr("id");
	jQuery("#"+s).val(jQuery("#"+i).text()),animate=0;
	var n=setInterval(function(){
		document.getElementById(t).style.backgroundPosition=animate+"px 27px",-297==animate?(clearInterval(n),document.getElementById(t).style.pointerEvents="none"):animate-=27},50);
	jQuery("#cptchaError").hide(),jQuery("#cptchaError1").hide()
	}   
 
 
