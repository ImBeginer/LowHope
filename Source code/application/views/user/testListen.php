<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<script	src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
	<script>
	    // Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('711b956416d9d15de4b8', {
	    	cluster: 'ap1',
	    	encrypted: true
	    });

	    var channel = pusher.subscribe('my-channel');
	    channel.bind('my-event', function(data) {
	    	console.log(data.message);
	    });
  </script>
</head>

<body>
	
	<input type="text" id="mes" value="" placeholder="">
	<button type="button" class="btn btn-primary" onclick="sendMessage()">Send message</button>
	
</body>
<script type="text/javascript">
	function getChange () {		
		$.post('test/getChange', {userId: 1} , function(data, textStatus, xhr) {
			/*optional stuff to do after success */
		});
		
	}

	//setInterval(getChange, 2000);
</script>
</html>