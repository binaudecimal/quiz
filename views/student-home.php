<?php
    $scores = StatController::getStudentScores();
?>

<div class='container-fluid'>
    <div class='jumbotron h-75 mt-1'>
        <div class='container'>
            <div class="alert alert-success" role="alert">
                  Status goes here
            </div>
            
            <a class='btn btn-primary float-left' role='btn' href='quiz-start'>Start Quiz</a> 
            <div class='container col-3'>
                <canvas id='score' height='400' width='400'></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $('document').ready(function(){
        var ctx = document.getElementById('score').getContext('2d');
        var myChart = new Chart(ctx, <?php  echo $scores?>);
    });
</script>