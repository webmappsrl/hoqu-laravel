
<div class="panel-body">
    <canvas id="canvas5" height="280" width="600"></canvas>
</div>

<script>


    window.addEventListener('load', (event) => {
        var hour = <?php echo $hour; ?>;
        var job = <?php echo $job; ?>;
        var barChartData = {
            labels: hour,
            datasets: [{
                label: 'Error',
                backgroundColor: "red",
                data: job
            }]
        };


        var ctx = document.getElementById("canvas5").getContext("2d");
        window.myBar = new Chart(ctx, {
            backgroundColor: "#F5DEB3",
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawOnChartArea: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            drawOnChartArea: false
                        }
                    }]
                },
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c2',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Error last 7 days'
                }
            }
        });
    });
</script>
