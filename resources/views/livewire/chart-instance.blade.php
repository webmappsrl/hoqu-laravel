
                <div class="panel-body">
                    <canvas id="canvas2" width="800" height="650"></canvas>
                </div>

<script>


    window.addEventListener('load', (event) => {
        var hour = <?php echo $hour; ?>;
    var job = <?php echo $job; ?>;
    var barChartData = {
        labels: <?php echo $percentage; ?>,
        datasets: [{
            label: 'Instance',
            backgroundColor: ["indingo","red","yellow","blue","purple","orange","cyan","brown","pink","olive"],
            data: job
        }]
    };
        var ctx = document.getElementById("canvas2");
        window.myBar = new Chart(ctx, {
            type: 'pie',
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

