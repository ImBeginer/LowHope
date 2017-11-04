var categories = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];
// var categories = ['T1', 'T2', 'T3', 'T4',
//             'T5', 'T6', 'T7', 'T8',
//             'T9', 'T10', 'T11', 'T12'
//         ];

var data = [];
var objectDataFromIndex = document.getElementById('chart');
var dataString = objectDataFromIndex.getAttribute('data-user');
var arrayString = dataString.split (',');
var elNum, i;
if (arrayString.length > 0) {
  for (i = 0; i < 12; i++) {
    elNum = parseInt(arrayString[i]);
    if (!isNaN (elNum)) {
      data[i] = elNum;
    }
  }
}


Highcharts.chart('chart', {
  chart: {
    type: 'line'
  },
  title: {
    text: 'Biểu đồ biểu diễn số lượng thành viên'
  },
  subtitle: {
    text: 'Biểu diễn tăng trưởng thành viên theo tháng'
  },
  xAxis: {
    categories: categories
  },
  yAxis: {
    title: {
      text: 'Số lượng thành viên'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
    }
  },
  credits: {
    enabled: false
  },
  exporting: { enabled: false },
  series: [{
    name: 'Thành viên',
    data: data
  }]
});