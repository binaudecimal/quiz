<?php
    $question = QuestionController::getQuestion();
    Controller::setSession();
    
?>

<div class='container-fluid'>
    <div class='jumbotron h-100'>
        <div class='container'>
            <div class="alert alert-success" role="alert">
              Status goes here
            </div>
            <div class='row'>
                <h6 class='display-6 mr-auto' >Question #<?php echo QuestionController::getQuestionNumber();?></h6>
                <h6 class='display-6 al-auto'><input class='form-control' id='timer' disabled></h6>
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
                        <input type='hidden' name='answer-value' value="NA" id='hidden-answer'> 
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
    $('#answer-button1').click(function(){
        $('#hidden-answer').val($(this).val());
        $('#answer-form').submit();
    });
    
    $('#answer-button2').click(function(){
            $('#hidden-answer').val($(this).val());
            $('#answer-form').submit();
        });
    $('#answer-button3').click(function(){
            $('#hidden-answer').val($(this).val());
            $('#answer-form').submit();
        });
    $('#answer-button4').click(function(){
            $('#hidden-answer').val($(this).val());
            $('#answer-form').submit();
        });
    
    $(document).ready(function(){
		var x = <?php echo $_SESSION['duration']?>;
		$('#timer').val(x);
		setInterval(function(){
			x= x-1;
            $('#timer').val(x);
			if(x<=0){
				$('#answer-form').submit();
                clearTimeout($(this));
                
			};
			
		}, 1000);
	});
</script>