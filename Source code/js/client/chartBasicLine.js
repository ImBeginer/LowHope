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
    text: '*Giá chung cư tại khu vực Cầu Giấy',
  },
  subtitle: {
		text: document.ontouchstart === undefined ?
    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
  },
  xAxis: {
    maxPadding: 3,
    type: 'date',
    title: {
    	enabled: true,
    	text: 'Ngày'
    }
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
    name: 'Giá thấp nhất',
    data: [1.25 , 1.5, 1.3  , 1.7, 2.0, 1.75 , 2.75 , 1.88, 2.2, 2.1, 2.3, 2.01]
  }, {
    name: 'Giá trung bình',
    data: [4.375, 4.5, 4.775, 5.1, 5.4, 5.625, 5.975, 4.94, 5  , 5.3, 5.9, 6.005]
  }, {
    name: 'Giá cao nhất',
    data: [7.5  , 7.5, 8.25 , 8.5, 8.8, 9.5  , 9.2  , 8.0, 7.8 , 8.5, 9.5, 10.0]
  }]
});

Highcharts.setOptions({
  lang: {
    resetZoom: "Trở về"
  }
});