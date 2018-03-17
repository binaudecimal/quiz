<?php
    $scores = StatController::getStudentScores();
    $quizzes = StatController::getStudentQuizReport();
?>

<div class='container-fluid'>
    <div class='jumbotron h-75 mt-1'>
        <div class='container'>
            <!-- status starts -->
            <?php
                if(isset($_GET['status'])){
                    $status = $_GET['status'];
                    switch($status){
                        case 'quiz-noActive':
                            echo "
                                <div class='alert alert-warning'>There is currently no active quiz.</div>
                            ";break;
                        case 'quiz-allComplete':
                            echo "
                                <div class='alert alert-success'>Quiz completed. Graph of scores updated.</div>
                            ";break;
                    }
                }
            ?>
            <!--status ends-->
        </div>
        <div class='row w-100'>
            <div class='container col-3' style='bg-color:#efefef;'>
                <div class='row h-50 w-100'>
                    <div class='container-fluid h-100 w-100'>
                        <h5 class='display-5'>Sidebar</h5>
                        <div class='list-group'>
                            <a href="quiz-start" class="list-group-item list-group-item-action list-group-item-primary" role="button">Start Quiz</a>
                            <a href="#" class="list-group-item list-group-item-action list-group-item-info" data-toggle="modal" data-target="#quiz-review-modal" role="button">Review Quizzes</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container col-9 float-left'>
                <div class='container col-3'>
                    <canvas id='score' height='600' width='800'></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- start of review modal-->
<div class='modal fade' id='quiz-review-modal'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Quiz Summary and Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-content'>
                <div class='container'>
                    <dl class='row'>
                        
                    <?php
                        foreach($quizzes as $item){
                            echo "
                                <dt class='col-3'>
                                    Region
                                </dt>
                                <dd class='col-9'>
                                    ".$item['region']."
                                </dd>
                                
                                <dt class='col-3'>
                                    Date Finished
                                </dt>
                                <dd class='col-9'>
                                    ".$item['date_finished']."
                                </dd>
                                
                                <dt class='col-3'>
                                    Total Score
                                </dt>
                                <dd class='col-9'>
                                    ".$item['total_score']."
                                </dd>
                                <hr class='my-4'>
                            ";
                        }
                    ?>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end of review modal-->
<script>
    $('document').ready(function(){
        var ctx = document.getElementById('score').getContext('2d');
        var myChart = new Chart(ctx, <?php  echo $scores?>);
    });
</script>