<?php
$path =getTemplateLivePath();
$currenturl = $_SERVER['REQUEST_URI'];
?>


<?php /*<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/lazyload.js' ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/cookie.js' ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/slick.min.js' ?>"></script>*/ ?>
<script type="text/javascript">
  var saveC = "save_machine";
  var $=jQuery;
    jQuery(document).ready(function () {
//        checkMachine();
        var rulesData = {
            constomerFName: {required: true},
            constomerEmail: {required: true, email: true},
            constomerPhone: {minlength: 10},
            constomerMessage: {required: true},
            secureImg: {required: true},
        };
        var messagesData = {
            constomerFName: {required: 'Please enter  name'},
            constomerEmail: {required: 'Please enter email', email: 'Please enter valid email'},
            constomerPhone: {minlength: 'Phone must be 10 digit long'},
            constomerMessage: {required: 'Please enter enquiry'},
            secureImg: {required: 'Please select checkbox'},
        };
        jQuery("#frmenquireNow").validate({
            onkeyup: false,
            ignore: [],
            rules: rulesData,
            messages: messagesData,
            errorClass: "error"
        });
        var rulesData1 = {
            constomerFName1: {required: true},
            constomerLName1: {required: true},
            constomerSuburb1: {required: true},
            constomerEmail1: {required: true, email: true},
            constomerPhone1: {minlength: 10, checkZero: true},
            secureImg_enq: {required: true},
        };
        var messagesData1 = {
            constomerFName1: {required: 'Please enter first name'},
            constomerLName1: {required: 'Please enter last name'},
            constomerSuburb1: {required: 'Please enter suburb'},
            constomerEmail1: {required: 'Please enter email', email: 'Please enter valid email'},
            constomerPhone1: {minlength: 'Phone must be 10 digit long', checkZero: 'Please enter valid phone'},
            secureImg_enq: {required: 'Please select checkbox'},
        };
        jQuery("#frmenquireNow1").validate({
            onkeyup: false,
            ignore: [],
            rules: rulesData1,
            messages: messagesData1,
            errorClass: "error"
        });
        if (jQuery(".dirc_spanul").find("li").length % 2 != 0) {
            jQuery(".dirc_spanul li:last").addClass("bdrClass");
        }
         jQuery(document).on("click",".smachine", function () {
            saveMachine("<?php echo $data['id']; ?>", "<?php echo $data['part_name']; ?>", "<?php echo setLink('parts/parts-detail/') . $data['alias']; ?>");
            setSaveLabel('');
        });
         jQuery(document).on("click",".rmachine",function () {
            var newmachineData = new Array();
            var newIndex = 0;
            var setCookieData = jQuery.parseJSON(getCookie(saveC));
            if (setCookieData) {
                for (var m = 0; m < setCookieData.length; m++) {
                    if (setCookieData[m].id == "<?php echo $data['id']; ?>") {
                        delete setCookieData[m];
                    } else {
                        newmachineData[newIndex] = setCookieData[m];
                        newIndex++;
                    }
                }
                rmCookie(saveC);
                setCookie(saveC, JSON.stringify(newmachineData));
                alert('Machine is unsaved');
                setSaveLabel('m');
            }
        });
        jQuery('.viewMore').on('click',function(){
            jQuery('.machineListBox').show();
            jQuery(this).hide();
        });
    });
 

    function setSaveLabel(c) {
        if (c != '') {
            var obj = jQuery(".rmachine");
            obj.find(".fa-star").addClass("disableStar");
            obj.html(obj.html().replace(/Saved machine/g, "Save this machine"));
            obj.attr("title",obj.attr("title").replace(/Saved machine/g, "Save this machine"));
            obj.removeClass("rmachine").addClass("smachine");
            jQuery(".smachine").bind("click");
        } else {
            var obj = jQuery(".smachine");
            obj.find(".disableStar").removeClass("disableStar");
            obj.html(obj.html().replace(/Save this machine/g, "Saved machine"));
            obj.attr("title",obj.attr("title").replace(/Save this machine/g, "Saved machine"));
            obj.removeClass("smachine").addClass("rmachine");
            jQuery(".rmachine").bind("click");
        }
    }
    function checkMachine() {
        var setCookieData = jQuery.parseJSON(getCookie(saveC));
        if (setCookieData) {
            for (var m = 0; m < setCookieData.length; m++) {
                if (setCookieData[m].id == "<?php echo $data['id']; ?>") {
                    setSaveLabel('');
                }
            }
        }
    }
    function saveMachine(id, name, url) {
        var cookieData = {"id": id, "name": name, "url": url};
        var setCookieData = jQuery.parseJSON(getCookie(saveC));
        if (setCookieData) {
            setCookieData[setCookieData.length] = cookieData;
        } else {
            var setCookieData = new Array();
            setCookieData[0] = cookieData;
        }
        setCookie(saveC, JSON.stringify(setCookieData));
        alert('Machine is saved');
    }
    
  
  
    function sendEnquiry(uid,directory_id,url,sid,cond,sname,price)
{
        jQuery('#sendEnquiryUid').val(uid);
        jQuery('#sendEnquiryUName').val(directory_id);
        jQuery('#backUrlU').val(url);
        jQuery('#ustockid').val(sid);
        jQuery('#ucondition').val(cond);
        jQuery('#useller').val(sname);
        jQuery('#uprice').val(price);
        
}
   
    jQuery(document).ready(function() {

jQuery('.shareBtnClick').click(function() {
    jQuery(this).toggleClass('active');
	jQuery(this).siblings('.shareListPop').toggle()
});


if(jQuery.fn.lightGallery){
jQuery('#lightgallery').lightGallery({
                download:false
    				});
}

if(jQuery.fn.selectmenu){
  jQuery( function() {
    jQuery( "#category" ).selectmenu();
 jQuery( "#type" ).selectmenu();
   jQuery( "#filter" ).selectmenu();
  } );
}
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
    
   /*---------------------------------------------
        Edit Profile Toggle 
------------------------------------------------*/	
jQuery('.tbltitleBox:first').addClass('formTagHeadActive');
jQuery('.tbltitleBox:first').next().slideDown();
jQuery('.tbltitleBox').click(function() {
        
if (jQuery(this).hasClass('formTagHeadActive')) {
    jQuery(this).toggleClass('formTagHeadActive');
    jQuery(this).next().slideUp();
}
else{jQuery(this).toggleClass('formTagHeadActive');
    jQuery(this).next().slideDown();
        }
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
    
    /*Product Gallary*/
    
    jQuery( ".phBox:nth-child(5)" ).nextAll().addClass( "ch-hide" );
    var hid_li = jQuery(".ch-hide").length;
    
   jQuery( ".phBox:nth-child(5)" ).append( "<div class='cdivBox'><span id='counttext' class='counttext'></span> More Images</div>" );
//  document.getElementById( "counttext" ).innerHTML = hid_li;
    jQuery("#counttext").html(hid_li);
});

    
</script>