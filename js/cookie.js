function setCookie(key, value) {
	var exMins=1;
			if(value==''){
				 exMins=0;
			} 
            var expires = new Date();
            expires.setTime(expires.getTime() + (exMins * 3600 * 1000 * 24 * 365 ));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString()+'; Path=/;';
}

function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
}
function rmCookie(key){
	setCookie(key,'');
}
