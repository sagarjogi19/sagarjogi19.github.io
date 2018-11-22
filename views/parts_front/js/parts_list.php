<?php
$path = getTemplateLivePath();
$currenturl = $_SERVER['REQUEST_URI'];
?>

<?php /*<script type="text/javascript" src="<?php echo $path . '/js/jquery.placeholder.js' ?>"></script>
<script type="text/javascript" src="<?php echo $path . '/js/jquery.lazy.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo $path . '/js/cookie.js' ?>"></script>
<script type="text/javascript" src="<?php echo $path . '/js/slick.min.js' ?>"></script>*/ ?>
<script type="text/javascript">
   var $ = jQuery;

   $(document).ready(function () {
//       showViewSearch();
       //make
       $('.makeLi').click(function () {
           $('.makeLi').removeClass('active');
           $(this).addClass('active');
           setUrl();
       });
       $('#makeRemove').click(function () {
           $('.makeLi').removeClass('active');
           $('.modelsLi').removeClass('active');
           setUrl();
       });

       //model
       $('.modelsLi').click(function () {
           $('.modelsLi').removeClass('active');
           $(this).addClass('active');
           setUrl();
       });
       $('#modelRemove').click(function () {
           $('.modelsLi').removeClass('active');
           setUrl();
       });

       //price priceGo
       $('.priceGo').click(function () {
           setUrl();
       });

       //year
       $('.yearGo').click(function () {
           setUrl();
       });

       //category
       $('.catLi').click(function () {
           $('.catLi').removeClass('active');
           $(this).addClass('active');
           setUrl();
       });
       $('#categoriesRemove').click(function () {
           $('.catLi').removeClass('active');
           setUrl();
       });

       //region
       $('.regionLi').click(function () {
           $('.regionLi').removeClass('active');
           $(this).addClass('active');
           setUrl();
       });
       $('#regionRemove').click(function () {
           $('.regionLi').removeClass('active');
           setUrl();
       });

       //conditions
       $('.conditionsLi').click(function () {
           $('.conditionsLi').removeClass('active');
           $(this).addClass('active');
           setUrl();
       });
       $('#conditionsRemove').click(function () {
           $('.conditionsLi').removeClass('active');
           setUrl();
       });

       //keyword
       $('.searchBtnkey').click(function () {
           if ($('#keywords').val() == '') {
               alert('Please enter keyword');
           } else {
               setUrl();
           }
       });

       //sorting
       $('#sorting').change(function () {
           setUrl();
       });

       $(".btnCookieSave").bind("click", function () {
           var cookieData = {"name": $("#cookie_name").val(), "url": window.location.href};
           if ($("#cookie_name").val() != "") {
               var setCookieData = $.parseJSON(getCookie(getCookieID()));
               if (setCookieData) {
                   var overwriteC = false;
                   for (var co = 0; co < setCookieData.length; co++) {
                       if (setCookieData[co].name == $("#cookie_name").val()) {
                           setCookieData[co] = cookieData;
                           overwriteC = true;
                       }
                   }
                   if (overwriteC == false) {
                       setCookieData[setCookieData.length] = cookieData;
                   }
               } else {
                   var setCookieData = new Array();
                   setCookieData[0] = cookieData;
               }
               setCookie($(this).attr("data-id"), JSON.stringify(setCookieData));
               alert("Search is saved");
               showViewSearch();
               $(".closePopup").trigger("click");
           }
       });

       $(".saveSea").bind("click", function () {
           $(".dircTitle").html("Save Search");
           $(".popupSection").hide();
           $("#saveSection").show();
           $("#cookie_name").val("");
       });

       $(".clearSea").bind("click", function () {
           /*var c = confirm('Are you sure wanted to delete all search?');
           if (c) {
               rmCookie(getCookieID());
               alert("All saved searches are cleared.");
               showViewSearch();
           }*/
        window.location = '<?php echo setLink('parts/parts-list'); ?>';
       });

       $(".rmveCookie").bind("click", function () {
           removeCooKey(getCookieID());
       });

       $(".viewSea").bind("click", function () {
           $(".dircTitle").html("View Saved Search");
           $(".popupSection").hide();
           var machineSaveData = $.parseJSON(getCookie(getCookieID()));
           var html = "";
           var style = "text-decoration:underline";
           if (machineSaveData.length > 0) {
               for (var m = machineSaveData.length - 1; m >= 0; m--) {
                   html += '<tr><td><a href="' + machineSaveData[m].url + '">' + machineSaveData[m].name + '</a></td><td><a href="' + machineSaveData[m].url + '" title="View" style="' + style + '">View</a> | <a href="javascript:;" class="rmveCookie" onclick="removeCooKey(\'' + machineSaveData[m].name + '\')"   title="Delete" style="' + style + '">Delete</a></td></tr>';
               }
           } else {
               html += '<tr><td colspan="3" align="center">No Records Found</td></tr>';
           }
           $("#viewCookieData").html(html);
           //viewCookieData
           $("#viewSearch").show();
       });

       $('#keywords').on("keypress", function (e) {
           if (e.keyCode == 13) {
               $('.searchBtnkey').trigger('click');
           }
       });

       $('.loadMore').click(function () {

           var url = setUrl(true);
           var len = $(".machineData .machineListBox").length;
           $('#loader').show();
           var seprator = "&";
           if (url.indexOf('?') == -1) {
               seprator = "?";
           }
           $('.machineSldder').slick('unslick');
           $.ajax({
               url: url + seprator + "get_ajax=yes&limitStart=" + len,
               type: "GET",
               async: true,
               success: function (data) {
                   var data = $.parseJSON(data);
                   $(".machineData").append(data.list);
                   $('#loader').hide();
                   if ($(".machineData .machineListBox").length >= $('#totalRecord').val()) {
                       $('.loadMore').hide();
                       return false;
                   }
               },
               complete: function () {
                   getSliderSettings();
	        $('.lazy').lazy();
                   $('#loader').hide();
               }
           });
       });
       getSliderSettings();
       jQuery('.lazy').lazy();
   });
$(document).ready(function() {

  $( function() {
    $( "#category" ).selectmenu();
 $( "#type" ).selectmenu();
   
  } );
 
	/* -------------------------------------------
			Sidebar box togle
	---------------------------------------------*/
	$('.catTogleClick').click(function() {
       $(this).toggleClass('closeBox');
	   $(this).next('.togleBody').slideToggle('slow'); 
    });
	
	/* -------------------------------------------
			category accordion
	---------------------------------------------*/
	$('.catLists > li').has('ul').prepend('<span class="catAccor trans"><i class="fa fa-plus-square" aria-hidden="true"></i></span>');
    $('.catAccor').click(function() {
        $(this).children('.fa').toggleClass('fa-minus-square');
		$(this).siblings('.subCat').slideToggle('slow');
    });
/* -------------------------------------------
			Mobile sidepanal
	---------------------------------------------*/	
	$('.partsIcon').click(function() {
        $('.searchForm').addClass('slideLeft');
		$('body').addClass('bodyFix');
    });
	
	$('.filterIcon').click(function() {
        $('.filterSidebar').addClass('slideLeft');
		$('body').addClass('bodyFix');		
    });
	
	$('.closePenal').click(function() {
		 $('.filterSidebar, .searchForm').removeClass('slideLeft');
		 $('body').removeClass('bodyFix');	
        
    });
    
    /*---------------------------------
            TABBED CONTENT
---------------------------------*/
 
    $(".tab_content").hide();
    $(".tab_content:first").show();

  /* if in tab mode */
    $("ul.tabs li").click(function() {
		
      $(".tab_content").hide();
      var activeTab = $(this).attr("data-tab"); 
      $("#"+activeTab).fadeIn();		
		
      $("ul.tabs li").removeClass("active");
      $(this).addClass("active");

	  $(".tab_drawer_heading").removeClass("d_active");
	  $(".tab_drawer_heading[data-tab^='"+activeTab+"']").addClass("d_active");
	  
    });

	
        
			$(".tab_content").removeClass("active");
			$(".tab_drawer_heading").click(function() {
				if ($(this).hasClass("d_active")) {
					$(this).removeClass("d_active").next().slideUp();
				}
				else {
					$(".tab_drawer_heading").removeClass("d_active");
					$(".tab_content").slideUp();
					$(this).addClass("d_active");
                                        setTimeout(function() {
                                            $("html,body").animate({
                                                scrollTop: $('.d_active').offset().top - 10
                                                }, "slow");
                                            }, 500); 
					$(this).next().slideDown();                            
				}
			}).filter('tab_content:first').click();
            
	$('ul.tabs li').last().addClass("tab_last");
    
    
});

   function setUrl(flag) {

       var URL = '<?php echo setLink('parts/parts-list'); ?>';

       if ($('.makeLi').hasClass('active')) {
           URL += '/make-' + $('.makeLi.active').data('make');
       }
       if ($('.modelsLi').hasClass('active')) {
           URL += '/model-' + $('.modelsLi.active').data('model');
       }

       var seprator = '?';

       //searchKeyword
       if ($('#searchKeyword').val() != '' && $('#searchKeyword').val() != undefined) {
           URL += seprator + 'searchKeyword=' + $('#searchKeyword').val();
           seprator = '&';
       }

       //searchCategory
       if ($('#searchCategory').val() != '' && $('#searchCategory').val() != undefined) {
           URL += seprator + 'searchCategory=' + $('#searchCategory').val();
           seprator = '&';
       }

       //searchRegion
       if ($('#searchRegion').val() != '' && $('#searchRegion').val() != undefined) {
           URL += seprator + 'searchRegion=' + $('#searchRegion').val();
           seprator = '&';
       }

       //price
       if ($('#minprice').val() != '' && $('#minprice').val() != undefined) {
           URL += seprator + 'minprice=' + $('#minprice').val();
           seprator = '&';
       }
       if ($('#maxprice').val() != '' && $('#maxprice').val() != undefined) {
           URL += seprator + 'maxprice=' + $('#maxprice').val();
           seprator = '&';
       }

       //year
       if ($('#minyears').val() != '' && $('#minyears').val() != undefined) {
           URL += seprator + 'minyear=' + $('#minyears').val();
           seprator = '&';
       }
       if ($('#maxyears').val() != '' && $('#maxyears').val() != undefined) {
           URL += seprator + 'maxyear=' + $('#maxyears').val();
           seprator = '&';
       }

       //cat
       if ($('.catLi').hasClass('active')) {
           URL += seprator + 'cat=' + $('.catLi.active').data('cat');
           seprator = '&';
       }

       //region
       if ($('.regionLi').hasClass('active')) {
           URL += seprator + 'region=' + $('.regionLi.active').data('region');
           seprator = '&';
       }

       //conditions
       if ($('.conditionsLi').hasClass('active')) {
           URL += seprator + 'conditions=' + $('.conditionsLi.active').data('conditions');
           seprator = '&';
       }

       //conditions
       if ($('#keywords').val() != '' && $('#keywords').val() != undefined) {
           URL += seprator + 'keywords=' + $('#keywords').val();
           seprator = '&';
       }

       //conditions
       if ($('#sorting').val() != '' && $('#sorting').val() != undefined) {
           URL += seprator + 'sorting=' + $('#sorting').val();
           seprator = '&';
       }

       if (flag == true) {
           return URL;
       }
       
       window.location = URL;
   }
   function ucwords(str) {
       return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
           return $1.toUpperCase();
       });
   }
   function showViewSearch() {
       var machineSaveData = $.parseJSON(getCookie(getCookieID()));
       if (machineSaveData) {
           $(".viewSea").show();
       } else {
           $(".viewSea").hide();
       }
   }
   function getCookieID() {
       return $(".btnCookieSave").attr("data-id");
   }
   function removeCooKey(name) {
       var c = confirm('Are you sure wanted to delete ' + name + ' search?');
       if (c) {
           var cookieID = getCookieID();
           var machineSaveData = $.parseJSON(getCookie(cookieID));
           var newmachineData = new Array();
           var newIndex = 0;
           for (var m = 0; m < machineSaveData.length; m++) {
               if (machineSaveData[m].name == name) {
                   delete machineSaveData[m];
               } else {
                   newmachineData[newIndex] = machineSaveData[m];
                   newIndex++;
               }
           }
           rmCookie(cookieID);
           setCookie(cookieID, JSON.stringify(newmachineData));
           alert('Save search ' + name + ' is deleted ');
           if (newmachineData.length == 0) {
               $(".closePopup").trigger("click");
           } else {
               $(".viewSea").trigger("click");
           }
       }
       showViewSearch();
   }
   function saveClearSearch(op) {
       var msg = "";
       if (op == "save") {
           msg = "Search saved";
       } else {
           msg = "Search cleared";
       }
       alert(msg);
   }
   function getSliderSettings() {
       $('.machineSldder').slick(
               {
                   dots: false,
                   infinite: true,
                   speed: 2000,
                   slidesToShow: 1,
                   slidesToScroll: 1,
//autoplay:true,
// autoplaySpeed: 6000,
                   arrows: true
               });
   }
</script>