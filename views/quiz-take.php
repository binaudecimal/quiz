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
                <form action='quiz-submit-answer' method='POST' id='answer-form'>
                    <div class='container'>
                        <input type='hidden' name='answer-value' value="novalue" id='hidden-answer'> 
                        <button class='btn btn-light' type='button' id='answer-button1' accesskey='z' value='<?php echo $question['answers'][0]; ?>'><?php echo $question['answers'][0]; ?></button>
                        <button class='btn btn-light' type='button' id='answer-button2' accesskey='x'value='<?php echo $question['answers'][1]; ?>'><?php echo $question['answers'][1]; ?></button>
                        <button class='btn btn-light' type='button' id='answer-button3' accesskey='c'value='<?php echo $question['answers'][2]; ?>'><?php echo $question['answers'][2]; ?></button>
                        <button class='btn btn-light' type='button' id='answer-button4' accesskey='v' value='<?php echo $question['answers'][3]; ?>'><?php echo $question['answers'][3]; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('document').ready(function(){
        $('#answer-button1').click(function(){
            $('#hidden-answer').val($(this).val());
            $('#answer-form').submit();
        });
    });
    $('#answer-button2').click(function(){
            $('#hidden-answer').val($(this).val());
            alert($('#hidden-answer').val());
            $('#answer-form').submit();
        });
    $('#answer-button3').click(function(){
            $('#hidden-answer').val($(this).val());
            alert($('#hidden-answer').val());
            $('#answer-form').submit();
        });
    $('#answer-button4').click(function(){
            $('#hidden-answer').val($(this).val());
            alert($('#hidden-answer').val());
            $('#answer-form').submit();
        });
</script>