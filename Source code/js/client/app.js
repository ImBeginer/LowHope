$(document).ready(function() {
	// $('#msg_block').hide();

	// $('#nickname').keyup(function(event) {
	// 	/* Act on the event */
	// 	var nickname = $(this).val();
	// 	if(nickname == ''){
	// 		$('#msg_block').hide();
	// 	}else{
	// 		$('#msg_block').show();
	// 	}

	// 	// initial nickname check
	// 	$('#nickname').trigger('keyup');
	// });
	

	// setInterval(function (){
	// 	update_chats();
	// }, 1500);
	
	// alert(google_id);


});

var update_chats = function () {
	
	$.getJSON('http://localhost:8888/project_final/chat_controller/getMessage', function (data){
		//append_chat_data(data);			
	});      
}

var append_chat_data = function (chat_data) {
	chat_data.forEach(function (data) {		
		
			var html = '<li class="left clearfix">';				
			html += '	<div class="chat-body clearfix">';
			html += '		<div class="header">';
			html += '			<strong class="primary-font">' + data.user_id + '</strong>';
			html += '			<small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>' + parseTimestamp(data.timestamp) + '</small>';
			
			html += '		</div>';
			html += '		<p>' + data.message + '</p>';
			html += '	</div>';
			html += '	</li>';
		
		$("#received").html( $("#received").html() + html);
	});
  
	$('#received').animate({ scrollTop: $('#received').height()}, 1000);
}