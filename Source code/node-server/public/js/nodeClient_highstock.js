$(function() {

  Highcharts.setOptions({
    global: {
      useUTC: false
    }
  });
  var chart = new Highcharts.StockChart({
    chart: {
      type: 'line',
      zoomType: 'x',
      animation: Highcharts.svg, // don't animate in old IE
      marginRight: 50,
      renderTo: chartContainer,
      height: 40 + '%'
    },
    rangeSelector: {
      allButtonsEnabled: true,
      buttons: [{
        type: 'hour',
        count: 1,
        text: '1h',
        dataGrouping: {
          forced: true,
          units: [
            ['minute', [1]]
          ]
        }
      }, {
        type: 'hour',
        text: '12h',
        count: 12,
        dataGrouping: {
          forced: true,
          units: [
            ['minute', [1]]
          ]
        }
      }, {
        type: 'day',
        text: 'Day',
        count: 1,
        dataGrouping: {
          forced: true,
          units: [
            ['minute', [1]]
          ]
        }
      }, {
        type: 'week',
        text: 'Week',
        count: 1,
        dataGrouping: {
          forced: true,
          units: [
            ['hour', [1]]
          ]
        }
      }, {
        type: 'month',
        text: 'Month',
        count: 1,
        dataGrouping: {
          enabled: true,
          forced: true,
          units: [
            ['day', [1]]
          ]
        }
      }, {
        type: 'year',
        text: 'Year',
        count: 1,
        dataGrouping: {
          forced: true,
          units: [
            ['day', [1]]
          ]
        }
      }],
      buttonSpacing: 10,
      buttonTheme: {
        padding: 5,
        width: 40
      },
      selected: 2,
      smoothed: true
    },
    title: {
      text: 'Bitcoin Price (USD)',
      style: {
        fontWeight: 'bold',
        fontSize: '24px'
      }
    },
    xAxis: {
      type: 'datetime',
    },
    yAxis: {
      title: {
        text: 'Value'
      }
    },

    tooltip: {
      formatter: function() {
        var s = Highcharts.dateFormat('%H:%M', this.x) +
          '<br/>' +
          Highcharts.dateFormat('%A, %b %e, %Y', this.x);

        $.each(this.points, function() {
          s += '<br/><b>BPI:    ' + ' $' + this.y + '</b>';
        });

        return s;
      }
    },

    series: [{
      name: 'Bitcoin',
      data: [],
      tooltip: {
        valueDecimals: 2
      },
      turboThreshold: 1000000
    }]
  });



  function createCoinChart(data) {
    chart.series[0].setData(data)
  }

  $.getJSON('http://localhost:3333/api/bitcoin', function(result) {
    createCoinChart(result);
  });

  var pusher = new Pusher('802fc577223f4567a8df', {
    cluster: 'ap1',
    encrypted: true
  });

  var channel = pusher.subscribe('bitcoin_rate');

  function addDataChart(data) {
    var series = chart.series[0];
    var x = (new Date()).getTime(), // current time
      y = Math.round(data * 100) / 100;
    series.addPoint([x, y], true, true);
  }

  channel.bind('broadcasting', function(data) {
    addDataChart(data.price);
  });
})