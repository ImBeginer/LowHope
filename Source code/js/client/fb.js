// Khởi tạo facebook login
window.fbAsyncInit = function() {			
	FB.init({
		appId      			: '463997824000380',
		status				: true,
        xfbml      			: true,  			// parse social plugins on this page
        version    			: 'v2.8' 			// use graph api version 2.8
    });
};

(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=463997824000380';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function loginFB() {			
	FB.login(function(response) {
		if (response.authResponse) {
			FB.api('/me', {locale: 'vi_VN', fields: 'id,name,email,link,picture'}, function(response) {

				// Kiểm tra xem tài khoản đã có trong db chưa,
				$.ajax({
					url: base_url + 'login/fb_CheckUserExist',
					type: 'POST',
					dataType: 'JSON',
					data: {
						fb_id: response.id,
						fb_name:response.name,
						fb_email:response.email,
						fb_link:response.link,
						fb_avatar:response.picture.data.url
					},
				})
				.done(function(response) {
					if(response == 0){
						window.location.href = base_url +'login/fb_AddUser';
					}else if(response == 1){
						window.location.href = base_url +'login/fb_goHome';
					}else {
						$.toast({
							heading: 'Error',
							text: 'Có gì đó sai sai, bạn vui lòng thử lại sau giây lát ...',
							showHideTransition: 'slide',
							icon: 'info',
							position: 'bottom-right',
							hideAfter: 3000
						})
					}	
				})
				.fail(function() {
					$.toast({
						heading: 'Error',
						text: 'Có gì đó sai sai, bạn vui lòng thử lại sau giây lát ...',
						showHideTransition: 'slide',
						icon: 'info',
						position: 'bottom-right',
						hideAfter: 3000
					})
				})
				.always(function() {
					console.log("complete");
				});
			});
		} else {
			console.log('User cancelled login or did not fully authorize.');
		}
	},{scope: 'public_profile,email'});
}

function logoutFB(){
	FB.getLoginStatus(function(response) {
		if(response.status === 'connected'){
			var uid = response.authResponse.userID;
            var accessToken = response.authResponse.accessToken;

            FB.api('/'+ uid +'/permissions', 'delete', function(response){
            	//console.log(response);
        	});
		}

        $.ajax({
        	url: base_url + 'login/fb_Logout',
        	type: 'POST',
        	dataType: 'JSON',		            	
        })
        .done(function(response) {
        	if(response == 1){
        		window.location =  base_url;
        	}
        })
        .fail(function() {
        	console.log("error");
        })
        .always(function() {
        	console.log("complete");
        });
	});
}