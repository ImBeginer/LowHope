Highcharts.setOptions({
  global: {
    useUTC: false
  }
});

Highcharts.chart('chart', {
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
      text: 'Live Bitcoin price'
    },
    xAxis: {
      type: 'datetime',
      dateTimeLabelFormats: {
        minute: '%H:%M',
        // second: '%Y-%m-%d<br/>%H:%M:%S',
        // minute: '%d/%m/%Y<br/>%H:%M',
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
      useHTML:true,
      crosshairs: true,
      formatter: function () {
          return  '<strong>' + Highcharts.numberFormat(this.y) + '</strong>' + '<br/>' +
                  '<small>' + Highcharts.dateFormat('%H:%M, %d/%m/%Y ', this.x) + '<small>' ;              
      }
    },
    legend: {
      enabled: false
    },
    exporting: {
      enabled: true
    },
    series: [{
      name: 'Bitcoin price',
      data: data1
    }]
});

$(document).ready(function() {
  $('#testPusher').on('click',function(event) {
    event.preventDefault();
    /* Act on the event */
    $.post(base_url + 'test/testPusher', function(data, textStatus, xhr) {
      /*optional stuff to do after success */
    });
  });
});