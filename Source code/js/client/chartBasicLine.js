Highcharts.chart('chart', {
  chart: {
    zoomType: 'x',
    // animation: {
    //   duration: 10000,
    //   easing: 'easeOutBounce',
    //   // animationLimit: Infinity
    // }
  },

	title: {
    text: '*Giá Bitcoin',
  },
  subtitle: {
		text: document.ontouchstart === undefined ?
    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
  },
  xAxis: {
    maxPadding: 3,
    type: 'datetime',
    maxZoom: 48 * 3600 * 1000,
    tickInterval: 3600 * 1000
    // title: {
    // 	enabled: true,
    // 	text: 'Ngày'
    // }
  },
  yAxis: {
    title: {
      text: 'Tỷ VNĐ'
    },
    plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
    }]
  },
  tooltip: {
    valueSuffix: ' Tỷ VNĐ'
  },
  legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    borderWidth: 0
  },
  plotOptions: {
    series: {
      animation: {
        duration: 6000,
      },
      animationLimit: 3
    }
  },
  series: [
  {
    name: 'Giá BTC',
    data: [4.375, 4.5, 4.775, 5.1, 5.4, 5.625, 5.975, 4.94, 5, 5.3, 5.9, 6.005],
    pointStart: Date.now(),
    pointInterval: 24 * 3600 * 1000 // one day
  }]
});

Highcharts.setOptions({
  lang: {
    resetZoom: "Trở về",
    months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',  'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
    shortMonths: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',  'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
    weekdays: ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7']
  }
});