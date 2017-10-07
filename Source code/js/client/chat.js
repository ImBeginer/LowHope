$(document).ready(function() {

	getChatOnLoad();

	$(document).on('click', '#submit', function(event) {
		event.preventDefault();
		/* Act on the event */

		var message = $('#message').val();
		$.post(base_url + 'chat_controller/sendMessage', {google_id: google_id, message:message}, function(data) {
			/*optional stuff to do after success */			

		},"json");

		$('#message').val('');	

	});	

	setInterval(update_chats, 2000);
});

function update_chats(){
	$.post(base_url + 'chat_controller/updateChat', {lastID:lastID}, function(data) {
		/*optional stuff to do after success */		
		lastID = data.lastID;		
		append_new_chats(data.messages);
		
	},"json");
}

function append_new_chats(data){
	
	var html = '';
	for (var i = 0; i < data.length; i++) {
		html += '<li>' + data[i].google_id + ': ' + data[i].message + ': ' +  data[i].time_chat +'</li>';
	}

	$("#received").html( $("#received").html() + html);
}

function getChatOnLoad(){
	$.post(base_url + 'chat_controller/getChatOnLoad', function(data) {
		/*optional stuff to do after success */		
		append_new_chats(data);
	},"json");
}