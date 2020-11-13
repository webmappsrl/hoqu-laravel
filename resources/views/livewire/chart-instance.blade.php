
                <div class="panel-body">
                    <canvas id="canvas2" height="280" width="600"></canvas>
                </div>

<script>


    window.addEventListener('load', (event) => {
        var hour = <?php echo $hour; ?>;
    var job = <?php echo $job; ?>;
    var barChartData = {
        labels: hour,
        datasets: [{
            label: 'Instance',
            backgroundColor: "indingo",
            data: job
        }]
    };
        var ctx = document.getElementById("canvas2").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'instance'
                }
            }
        });
    });
</script>

