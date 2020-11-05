<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    window.addEventListener('load', (event) => {
        var hour = <?php echo $hour; ?>;
    var job = <?php echo $job; ?>;
    var barChartData = {
        labels: hour,
        datasets: [{
            label: 'Task',
            backgroundColor: "orange",
            data: job
        }]
    };
        var ctx = document.getElementById("canvas").getContext("2d");
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
                    text: '24 hour'
                }
            }
        });
    });

</script>

