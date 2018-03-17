<?php
    $stat = StatController::getScoresPerSectionPerRegion();
?>

<div class='container-fluid mt-5 pt-3'>
    <ul class='nav nav-tabs'>
        <li class='nav-item'>
            <a href='#ncr' class='nav-link' data-toggle='tab'>NCR</a>
        </li>
        <li class='nav-item'>
            <a href='#region1' class='nav-link' data-toggle='tab'>Region 1</a>
        </li>
        <li class='nav-item'>
            <a href='#car' class='nav-link' data-toggle='tab'>CAR</a>
        </li>
        <li class='nav-item'>
            <a href='#region2' class='nav-link' data-toggle='tab'>Region 2</a>
        </li>
        <li class='nav-item'>
            <a href='#region3' class='nav-link' data-toggle='tab'>Region 3</a>
        </li>
        <li class='nav-item'>
            <a href='#region4a' class='nav-link' data-toggle='tab'>Region 4A</a>
        </li>
        <li class='nav-item'>
            <a href='mimaropa' class='nav-link' data-toggle='tab'>MIMAROPA</a>
        </li>
        <li class='nav-item'>
            <a href='#region5' class='nav-link' data-toggle='tab'>Region 5</a>
        </li>
        <li class='nav-item'>
            <a href='#region6' class='nav-link' data-toggle='tab'>Region 6</a>
        </li>
        <li class='nav-item'>
            <a href='#region7' class='nav-link' data-toggle='tab'>Region 7</a>
        </li>
        <li class='nav-item'>
            <a href='#region8' class='nav-link' data-toggle='tab'>Region 8</a>
        </li>
        <li class='nav-item'>
            <a href='#region9' class='nav-link' data-toggle='tab'>Region 9</a>
        </li>
        <li class='nav-item'>
            <a href='#region10' class='nav-link' data-toggle='tab'>Region 10</a>
        </li>
        <li class='nav-item'>
            <a href='#region11' class='nav-link' data-toggle='tab'>Region 11</a>
        </li>
        <li class='nav-item'>
            <a href='#region12' class='nav-link' data-toggle='tab'>Region 12</a>
        </li>
        <li class='nav-item'>
            <a href='#region13' class='nav-link' data-toggle='tab'>Region 13</a>
        </li>
        <li class='nav-item'>
            <a href='#armm' class='nav-link' data-toggle='tab'>ARMM</a>
        </li>
    </ul>
    <div class='tab-content'>
        <div role='tabpanel' class='tab-pane' id='ncr'>
                NCR
            <canvas id='ncr-graph'></canvas>
            <script>
                var ncrChart = new Chart(document.getElementById('ncr-graph').getContext('2d'), 
                                        <?php  echo $stat['ncr'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region1'>
                Region 1
            <canvas id='region1-graph'></canvas>
            <script>
                var region1Chart = new Chart(document.getElementById('region1-graph').getContext('2d'), 
                                        <?php  echo $stat['region1'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='car'>
                CAR
            <canvas id='car-graph'></canvas>
            <script>
                var carChart = new Chart(document.getElementById('car-graph').getContext('2d'), 
                                        <?php  echo $stat['car'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region2'>
                Region 2
            <canvas id='region2-graph'></canvas>
            <script>
                var region2Chart = new Chart(document.getElementById('region2-graph').getContext('2d'), 
                                        <?php  echo $stat['region2'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region3'>
                Region 3
            <canvas id='region3-graph'></canvas>
            <script>
                var region3Chart = new Chart(document.getElementById('region3-graph').getContext('2d'), 
                                        <?php  echo $stat['region3'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region4a'>
                Region 4a
            <canvas id='region4a-graph'></canvas>
            <script>
                var region4aChart = new Chart(document.getElementById('region4a-graph').getContext('2d'), 
                                        <?php  echo $stat['region4a'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='mimaropa'>
                MIMAROPA
            <canvas id='mimaropa-graph'></canvas>
            <script>
                var mimaropaChart = new Chart(document.getElementById('mimaropa-graph').getContext('2d'), 
                                        <?php  echo $stat['mimaropa'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region5'>
                Region 5
            <canvas id='region5-graph'></canvas>
            <script>
                var region5Chart = new Chart(document.getElementById('region5-graph').getContext('2d'), 
                                        <?php  echo $stat['region5'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region6'>
                Region 6
            <canvas id='region6-graph'></canvas>
            <script>
                var region6Chart = new Chart(document.getElementById('region6-graph').getContext('2d'), 
                                        <?php  echo $stat['region6'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region7'>
                Region 7
            <canvas id='region7-graph'></canvas>
            <script>
                var region7Chart = new Chart(document.getElementById('region7-graph').getContext('2d'), 
                                        <?php  echo $stat['region7'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region8'>
                Region 8
            <canvas id='region8-graph'></canvas>
            <script>
                var region8Chart = new Chart(document.getElementById('region8-graph').getContext('2d'), 
                                        <?php  echo $stat['region8'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region9'>
                Region 9
            <canvas id='region9-graph'></canvas>
            <script>
                var region9Chart = new Chart(document.getElementById('region9-graph').getContext('2d'), 
                                        <?php  echo $stat['region9'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region10'>
                Region 10
            <canvas id='region10-graph'></canvas>
            <script>
                var region10Chart = new Chart(document.getElementById('region10-graph').getContext('2d'), 
                                        <?php  echo $stat['region10'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region11'>
                Region 11
            <canvas id='region11-graph'></canvas>
            <script>
                var region11Chart = new Chart(document.getElementById('region11-graph').getContext('2d'), 
                                        <?php  echo $stat['region11'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region12'>
                Region 12
            <canvas id='region12-graph'></canvas>
            <script>
                var region12Chart = new Chart(document.getElementById('region12-graph').getContext('2d'), 
                                        <?php  echo $stat['region12'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='region13'>
                Region 13
            <canvas id='region13-graph'></canvas>
            <script>
                var region13Chart = new Chart(document.getElementById('region13-graph').getContext('2d'), 
                                        <?php  echo $stat['region13'];?>);
            </script>
        </div>
        <div role='tabpanel' class='tab-pane' id='armm'>
                ARMM
            <canvas id='armm-graph'></canvas>
            <script>
                var armmChart = new Chart(document.getElementById('armm-graph').getContext('2d'), 
                                        <?php  echo $stat['armm'];?>);
            </script>
        </div>
    </div>
</div>