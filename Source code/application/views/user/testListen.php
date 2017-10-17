<!-- <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<script	src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script>
	    //Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('711b956416d9d15de4b8', {
	    	cluster: 'ap1',
	    	encrypted: true
	    });

	    var channel = pusher.subscribe('my-channel');

	    // channel.bind('my-event', function(data) {
	    // 	console.log(data.message);
	    // });



	    var prices =   JSON.parse(' $prices; ?>');

	    console.log(prices);

	    var data1 = [];
	    for (var i = 0; i < prices.length; i++) {
	    	
	    	data1[i] = [ (new Date(prices[i].DATA_DATE)).getTime() , parseFloat(prices[i].DATA_PRICE) ];
	    	
	    }
	    console.log(data1);
  </script>
</head>

<body>
	
	<input type="text" id="mes" value="" placeholder="">
	<button type="button" class="btn btn-primary" onclick="sendMessage()">Send message</button>
	<div id="container"></div>
</body>
<script type="text/javascript">

	Highcharts.setOptions({
	    global: {
	        useUTC: false
	    }
	});

	 Highcharts.chart('container', {
        chart: {
            type: 'spline',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function () {

                    // set up the updating of the chart each minutes
                    var series = this.series[0];

                    channel.bind('my-event', function(data) {
				    	
				    	//dung ajax de lay du lieu roi quay lai cap nhat
				    	console.log('data pusher: ' + data);
				    	series.addPoint([data.p.datee, data.p.price], true, true);
				    	
				    });
                    
                }
            }
        },
        title: {
            text: 'Live random data'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
	            // second: '%Y-%m-%d<br/>%H:%M:%S',
	            minute: '%d/%m/%Y<br/>%H:%M',
	            // hour: '%Y-%m-%d<br/>%H:%M',
	            // day: '%Y<br/>%m-%d',
	            // week: '%Y<br/>%m-%d',
	            // month: '%Y-%m',
	            // year: '%Y'
	        }
        },
        yAxis: {
            title: {
                text: 'Nghìn USD'
            },
            plotLines: [{
                value: 0,
                width: 2,
                color: '#808080'
            }]
        },
        tooltip: {
            // formatter: function () {
            //     return '<b>' + this.series.name + '</b><br/>' +
            //         Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
            //         Highcharts.numberFormat(this.y, 2);
            // }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: true
        },
        series: [{
            name: 'Random data',
            data: data1
        }]
    });

	 function sendMessage(){
	 	// body...
	 	$.post('test/testPusher', function(data, textStatus, xhr) {
	 		/*optional stuff to do after success */
	 	});
	 }
</script>
</html> -->