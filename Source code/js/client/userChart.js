google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Số người', 'Giá (tỷ VNĐ)'],
    [ 200,      4.5],
    [ 500,      5.5],
    [ 450,      4.75],
    [ 300,      4.88],
    [ 350,      5.03],
    [ 445,      5.5]
  ]);

  // data.addColumn('number', 'people');
  // data.addColumn('number', 'price');
  // // A column for custom tooltip content
  // data.addColumn({type: 'string', role: 'tooltip'});
  // data.addRows([
  //   [200, 4.5,'$600K in our first year!'],
  //   [500, 5.5, 'Sunspot activity made this our best year ever!'],
  //   [450, 4.75, '$800K in 2012.'],
  //   [300, 4.88, '$1M in sales last year.'],
  //   [350, 4.5,'$600K in our first year!'],
  //   [445, 5.5, 'Sunspot activity made this our best year ever!'],
  // ]);

  var options = {
    title: 'Age vs. Weight comparison',
    vAxis: {title: 'Giá Tỷ (VNĐ)', minValue: 0, maxValue: 15}, //, minValue: 0, maxValue: 15
    hAxis: {title: 'Số Người', minValue: 0, maxValue: 15}, // , minValue: 0, maxValue: 15
    backgroundColor: '#3e3e40',
    crosshair: { 
      trigger: 'both',
      color: '#90ee7e'
    },
    tooltip: { 
      isHtml: true,
      showColorCode: true,
      // trigger: 'selection',
    },
    animation: {
      "startup": true,
      duration: 1000,
      easing: 'inAndOut',
    },
    legend: 'none',
  };

  var chart = new google.visualization.ScatterChart(document.getElementById('user-chart'));

  chart.draw(data, options);
}