<?php
    $question = QuestionController::fetchQuestion();
    $graph_data = StatController::getQuestionStat();
?>

<div class='container-fluid'>
    <div class='jumbotron mt-2'>
        <div class='container'>
            <div class="alert alert-success" role="alert">
              Status goes here
            </div>
            <h5 class='hero text-align-center'>Edit Question</h5>
            <hr class='my-4'>
            <div class='container'>
                <form>
                    <div class='form-group'>
                        <label for="region">Region</label>
                        <select class="form-control" id="region" name='region' value='<?php echo $question['region'];?>'>
                          <option value='ncr'>National Capital Region (NCR)</option>
                            <option value='region1'>Ilocos Region (Region 1)</option>
                            <option value='car'>Cordillera Administrative Region (CAR)</option>
                            <option value='region2'>Cagayan Valley (Region 2)</option>
                            <option value='region3'>Central Luzon (Region 3)</option>
                            <option value='region4a'>CALABARZON (Region 4A)</option>
                            <option value='mimaropa'>Southwestern Tagalog Region (MIMAROPA)</option>
                            <option value='region5'>Bicol Region (Region 5)</option>
                            <option value='region6'>Western Visayas (Region 6)</option>
                            <option value='region7'>Central Visayas (Region 7)</option>
                            <option value='region8'>Eastern Visayas (Region 8)</option>
                            <option value='region9'>Zamboanga Peninsula (Region 9)</option>
                            <option value='region10'>Northern Mindanao (Region 10)</option>
                            <option value='region11'>Davao Region (Region 11)</option>
                            <option value='region12'>SOCCSLSARGEN (Region 12)</option>
                            <option value='region13'>Caraga Region (Region 13)</option>
                            <option value='armm'>Autonomous Region in Muslim Mindanao (ARMM)</option>
                        </select>

                        <label for="question">Question</label>
                        <input class='form-control' type='text' placeholder='Question' name='question' id='question' value='<?php echo $question['question'];?>'>

                        <label for="answer_correct">Answer 1 (Correct)</label>
                        <input class='form-control' type='text' placeholder='Answer 1 (Correct)' name='answer_correct' id='answer_correct' value='<?php echo $question['answer_correct'];?>'>

                        <label for="answer_wrong1">Answer 2 (Wrong)</label>
                        <input class='form-control' type='text' placeholder='Answer 2 (Wrong)' name='answer_wrong1' id='answer_wrong1' value='<?php echo $question['answer_wrong1'];?>'>

                        <label for="answer_wrong2">Answer 3 (Wrong)</label>
                        <input class='form-control' type='text' placeholder='Answer 3 (Wrong)' name='answer_wrong2' id='answer_wrong2' value='<?php echo $question['answer_wrong2'];?>'>

                        <label for="answer_wrong3">Answer 4 (Wrong)</label>
                        <input class='form-control' type='text' placeholder='Answer 4 (Wrong)' name='answer_wrong3' id='answer_wrong3' value='<?php echo $question['answer_wrong3'];?>'>

                        <div class='container-fluid mt-3'>
                            <button class='btn btn-primary'>SUBMIT</button>
                            <button class='btn btn-secondary'>CANCEL</button>
                            <button class='btn btn-danger float-right'>DELETE</button>
                            
                        </div>
                        
                    </div>
                    <div class='container'>
                        <canvas id='question-graph'>
                            Your browser doesn't support html5
                        </canvas>
                        <script>
                            var questionGraph = new Chart(document.getElementById('question-graph').getContext('2d'),
                                                         <?php echo $graph_data; ?>);
                        </script>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>