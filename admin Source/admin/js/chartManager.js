var categories = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];
// var categories = ['T1', 'T2', 'T3', 'T4',
//             'T5', 'T6', 'T7', 'T8',
//             'T9', 'T10', 'T11', 'T12'
//         ];

var data = [0, 50, 70, 42, 83, 60, 78, 89, 55, 76, 83, 88];
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