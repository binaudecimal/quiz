<?php
    $question = QuestionController::getQuestion();
    Controller::setSession();
    
?>

<div class='background-image'>
    <div class='content'>
        <div class='container mt-5 pt-5' style='opacity:30%;'>
            <div class='card'>
                <div class='card-content'>
                    <div class='card-header'>
                        <div class='row'>
                            <h6 class='display-6 mr-auto' >Question #<?php echo QuestionController::getQuestionNumber();?></h6>
                            <h6 class='display-4 al-auto' id='timer'><?php echo $_SESSION['duration']?></h6>
                        </div>
                        <div class='row justify-content-center'>
                            <h4 class='display-4'><?php echo $question['region']; ?></h4>
                        </div>
                    </div>
                    <div class='card-body'>
                        <div class='row'>
                            <p class='lead'><?php echo $question['question']; ?></p>
                        </div>

                        <form action='quiz-submit-answer' method='POST' id='answer-form'>
                            <input type='hidden' name='answer-value' value="NA" id='hidden-answer'> 
                            <button class='btn btn-light btn-lg btn-block' type='button' id='answer-button1' accesskey='z' value='<?php echo $question['answers'][0]; ?>'><?php echo $question['answers'][0]; ?></button>
                            <button class='btn btn-light btn-lg btn-block' type='button' id='answer-button2' accesskey='x'value='<?php echo $question['answers'][1]; ?>'><?php echo $question['answers'][1]; ?></button>
                            <button class='btn btn-light btn-lg btn-block' type='button' id='answer-button3' accesskey='c'value='<?php echo $question['answers'][2]; ?>'><?php echo $question['answers'][2]; ?></button>
                            <button class='btn btn-light btn-lg btn-block' type='button' id='answer-button4' accesskey='v' value='<?php echo $question['answers'][3]; ?>'><?php echo $question['answers'][3]; ?></button>
                        </form>
                    </div>
                </div>
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
            //$('#timer').val(x);
            $('#timer').html(x);
			if(x<=0){
				$('#answer-form').submit();
                clearTimeout($(this));
                
			};
			
		}, 1000);
	});
</script>