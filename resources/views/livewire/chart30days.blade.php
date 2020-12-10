
                <div class="panel-body">
                    <canvas id="canvas1" height="280" width="600"></canvas>
                </div>

<script>


    window.addEventListener('load', (event) => {
        var hour = <?php echo $hour; ?>;
    var job = <?php echo $job; ?>;
    var barChartData = {
        labels: hour,
        datasets: [{
            label: 'Task',
            backgroundColor: "blue",
            data: job
        }]
    };


        var ctx = document.getElementById("canvas1").getContext("2d");
        window.myBar = new Chart(ctx, {
            backgroundColor: "#F5DEB3",
            type: 'bar',
            data: barChartData,
            options: {
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
                    text: '30 days'
                }
            }
        });
    });
</script>

