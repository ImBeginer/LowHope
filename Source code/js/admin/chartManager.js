// var categories = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
//             'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
//             'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
//         ];
var categories = ['T 1', 'T 2', 'T 3', 'T 4',
            'T 5', 'T 6', 'T 7', 'T 8',
            'T 9', 'T 10', 'T 11', 'T 12'
        ];
var data = [0, 50, 70, 42, 83, 60, 78, 89, 55, 76, 83, 88];
Highcharts.chart('chart', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Biểu đồ biểu diễn số lượng thành viên'
    },
    subtitle: {
        text: 'Biểu diễn tăng trưởng thành viên'
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