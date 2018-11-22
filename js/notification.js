 

jQuery( document ).on( 'click', '.notDesc', function() {
    var id =  jQuery(this).prev('.discardNoti').attr('data-id');
    setNotificationCookie("deleteNotification", id, 30);
});
jQuery( document ).on( 'click', '.discardNoti', function() {
    
    var notificationId = jQuery(this).attr('data-id');
    jQuery(this).parents('li').remove();
    
    var totalNot = jQuery('.totalNotification').html()-1;
    
    jQuery('.totalNotification').html(minTwoDigits(totalNot));
    var ajaxUrl = baseURL+'/notification/list';
    jQuery.ajax({"url": ajaxUrl,data: { notificationId : notificationId , action : 'delete' },"success": function (data) 
    {
        
    }
    });
    if(jQuery('ul.notificationList li').length < 1)
        jQuery('.notfyNav').hide();
    else
        jQuery('.notfyNav').show();
});
      

function getNotifications(){
	 
        var ajaxUrl = baseURL+'user/notification_list?isAjaxIcon=true';
        
        jQuery.ajax({"url": ajaxUrl,"success": function (data) 
        {
            if(data)
            {
		if(window.width >767){
                    jQuery('.notfyNav').show();
		}
            }
            else
            {
                jQuery('.notfyNav').hide();
            }
           jQuery('.notificationList').html(data);
            var TotalNotification = jQuery('.notificationList li').length;
			
            jQuery('.totalNotification').html(minTwoDigits(TotalNotification));
			 
			if(minTwoDigits(TotalNotification)=='0'){
				jQuery(".notification").attr("style","cursor:pointer");
				jQuery(".notification").bind("click",function(){
					location.href=baseUrl+'user/notification_list';
				});
			}
            
        }
    });
}

function minTwoDigits(n) {
  if(n == '0')
      return '0';
  else
    return (n < 10 ? '0' : '') + n;
}

function setNotificationCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}