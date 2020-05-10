export default function(milestones) {
    var ctx = document.getElementById('chart-daily').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [js.text_daily_points],
            datasets: [{
                data: [milestones],
                backgroundColor: [
                    'green',
                ],
            }]
        },
        options: {
            title: {
                display: true,
                text: js.text_daily_title,
                fontSize: 14
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        max: 100
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });
}