<?php
    $question = QuestionController::getQuestion();
    
?>

<div class='container-fluid'>
    <div class='jumbotron h-100'>
        <div class='container'>
            <div class="alert alert-success" role="alert">
              Status goes here
            </div>
            <div class='row'>
                <h6 class='display-6 mr-auto' >Question #</h6>
                <h6 class='display-6 al-auto'>Timer</h6>
            </div>
            <div class='row justify-content-center'>
                <h4 class='display-4'><?php echo $question['region']; ?></h4>
            </div>
            <div class='row'>
                <p class='lead'><?php echo $question['question']; ?></p>
            </div>
            <div class='row'>
                <div class='container'>
                    <button class='btn btn-light' type='button' accesskey='z'><?php echo $question['answers'][0]; ?></button>
                    <button class='btn btn-light' type='button' accesskey='x'><?php echo $question['answers'][1]; ?></button>
                    <button class='btn btn-light' type='button' accesskey='c'><?php echo $question['answers'][2]; ?></button>
                    <button class='btn btn-light' type='button' accesskey='v'><?php echo $question['answers'][3]; ?></button>
                </div>
            </div>
        </div>
    </div>
</div>