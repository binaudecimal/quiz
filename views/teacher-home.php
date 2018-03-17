<?php
    $questions = QuestionController::getAllQuestionsByRegion();
    $classes = SectionController::getAllClasses();
    Controller::setSession();
    if($_SESSION['type']!= 'TEACHER'){
        header('Location: home');
        exit();
    }
    $issues = IssueController::getAllIssues();
?>

<div class='container-fluid'>
    <div class='jumbotron h-100'>
        <div class='row justify-content-center'>
            <div class='container'>
                <!-- status starts -->
                <?php
                    if(isset($_GET['status'])){
                        $status = $_GET['status'];
                        switch($status){
                            case 'startQuiz-failed':
                                echo "
                                    <div class='alert alert-danger'>Error generating the quiz. Contact admin.</div>
                                ";break;
                            case 'startQuiz-success': echo "
                                <div class='alert alert-success'>Quiz successfully started.</div>
                            ";break;
                                
                            case 'adding-successful': echo "
                                <div class='alert alert-success'>Question Successfully added.</div>
                            ";break;
                            case 'adding-failed' : echo "
                                <div class='alert alert-danger'>Failed to add question. Contact admin.</div>
                            ";break;
                        }
                    }
                ?>
                <!--status end-->
            </div>
        </div>
        <div class='container-fluid'>
            
            
            <div class='container-fluid w-25 h-100 float-left' style='bg-color:#efefef;'>
                <div class='row h-50 w-100'>
                    <div class='container-fluid h-100 w-100'>
                        <h5 class='display-5'>Sidebar</h5>
                        <div class='list-group'>
                            <a href="#" class="list-group-item list-group-item-action list-group-item-primary" data-toggle="modal" data-target="#liveModal" role="button" id='live-modal-toggle'>Start a Quiz?</a>
                            <a href="#" class="list-group-item list-group-item-action list-group-item-secondary" data-toggle="modal" data-target="#add-question-modal" role="button" id='add-question-toggle'>Add Question</a>
                            <a href="#" class="list-group-item list-group-item-action list-group-item-secondary" data-toggle="modal" data-target="#edit-question-modal" role="button" id='edit-question-toggle'>Edit Question</a>
                            <a href="#" class="list-group-item list-group-item-action list-group-item-dark"  data-toggle="modal" data-target="#enroll-student-modal" role="button" id='enroll-student-modal-toggle'>Enroll a Student</a>
                            <a href="#" class="list-group-item list-group-item-action list-group-item-info" data-toggle="modal" data-target="#issues-modal" role="button" id='issue-modal-toggle'>View Issues</a>
                        </div>
                    </div>
                </div>
                <div class='row h-50 w-100'>
                    <div class='row h-100 w-100'>
                        <div class='container-fluid h-100'>
                            <h5 class='display-5'>View Statistics</h5>
                            <div class='list-group'>
                                <?php
                                    foreach($classes as $item){
                                        echo "
                                            <a href='section-statistics?section=".$item['section_name']."' class='list-group-item list-group-item-action'>".$item['section_name']."</a>
                                        ";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>  
                    <div class='container float-left'>
                        <canvas id='class-chart'>Browser does not support html5</canvas>
                    </div>
                </div>
            </div>
            
                
        </div>
    </div>
    

<!--popup sections -->

<div class='modal fade' id='liveModal'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">You are about to activate a quiz...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <div class='container'>
                    <form class='form-group' action='generate-quiz' method='POST'>
                        <p class='lead'>
                            You are about to start a new quiz for a selected Section. Please note that all unfinished quizzes will be automagically submitted and scored according to the student's progress. 
                        </p>
                        <label for='class-quiz'>For Section: </label>
                        <select class='form-control' name='class_id' id='class-quiz'>
                            <?php
                                if($classes){
                                    foreach($classes as $item){
                                        echo "
                                            <option value='".$item['class_id']."'>".$item['section_name']."</option>
                                        ";
                                    }
                                }
                            ?>
                        </select>
                        <label for='class-items'>Items: </label>
                        <input class='form-control' name='items' id='class-items' placeholder='Number of Items'>
                        
                        <label for='class-duration'>Duration: </label>
                        <input class='form-control' name='duration' id='class-duration' placeholder='Duration (seconds)'>
                        
                        <label for="class-region">Region</label>
                        <select class="form-control" id="class-region" name='region'>
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
                        
                        <div class='container-fluid mt-3'>
                            <button class='btn btn-primary' type='submit'>Submit</button>
                            <button class='btn btn-secondary' role='button' data-dismiss='modal'>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--start of modal for questions -->
<div class='modal fade' id='edit-question-modal'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Questions List (EDIT)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-content'>
                <div class='modal-body mx-auto mw-100'>
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
                        <div class='tab-content'>
                            <div role='tabpanel' class='tab-pane' id='ncr'>
                                <table class='table'>
                                    <thead>
                                        <th scope='col'>Question ID</th>
                                        <th scope='col'>Question</th>
                                        <th scope='col'>Correct Answer</th>
                                        <th scope='col'>Wrong Answer 1</th>
                                        <th scope='col'>Wrong Answer 2</th>
                                        <th scope='col'>Wrong Answer 3</th>
                                        <th scope='col'>View Page</th>
                                    </thead>
                                    <?php
                                        foreach($questions['ncr'] as $item){
                                            echo "
                                                <tr>
                                                  <th scope='row'>".$item['question_id']."</th>
                                                  <td>".$item['question']."</td>
                                                  <td>".$item['answer_correct']."</td>
                                                  <td>".$item['answer_wrong1']."</td>
                                                  <td>".$item['answer_wrong3']."</td>
                                                  <td>".$item['answer_wrong2']."</td>
                                                  <td><a class='btn btn-primary' role='button' href='edit-question?question_id=".$item['question_id']."'>Edit</td>
                                                </tr>
                                            ";
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end of modal for questions-->

<!-- start of issues modal-->
<div class='modal fade' id='issues-modal'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Currently Posted Issues</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-content'>
                <div class='container'>
                    <!--start of issues-->
                <div class='container'>
                    <div class='card'>
                        <div class='card-header'>
                            Issue # 100
                        </div>
                        <div class='card-body'>
                            <p class='card-text'>
                                Issue on {xxx} submitted by {someone}
                            </p>
                            <a class='btn btn-primary' role='btn' href='#'>Mark as resolved</a>
                        </div>
                    </div>
                </div>
                <!--end of issues-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end of issues modal-->
    
<!-- add question modal start-->
    <div class='modal fade' id='add-question-modal'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Currently Posted Issues</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-content'>
                <div class='container'>
            <h5 class='hero text-align-center'>Add Question</h5>
            <hr class='my-4'>
            <div class='container'>
                <form action='add-question-submit' method='POST'>
                    <div class='form-group'>
                        <label for="region">Region</label>
                        <select class="form-control" id="region" name='region'>
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
                        <input class='form-control' type='text' placeholder='Question' name='question' id='question' required>

                        <label for="answer_correct">Answer 1 (Correct)</label>
                        <input class='form-control' type='text' placeholder='Answer 1 (Correct)' name='answer_correct' id='answer_correct' required>

                        <label for="answer_wrong1">Answer 2 (Wrong)</label>
                        <input class='form-control' type='text' placeholder='Answer 2 (Wrong)' name='answer_wrong1' id='answer_wrong1' required>

                        <label for="answer_wrong2">Answer 3 (Wrong)</label>
                        <input class='form-control' type='text' placeholder='Answer 3 (Wrong)' name='answer_wrong2' id='answer_wrong2' required>

                        <label for="answer_wrong3">Answer 4 (Wrong)</label>
                        <input class='form-control' type='text' placeholder='Answer 4 (Wrong)' name='answer_wrong3' id='answer_wrong3' required>

                        <div class='container-fluid mt-3'>
                            <button class='btn btn-primary' type='submit'>SUBMIT</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>
<!-- add question modal end-->

<!-- start of enroll student modal-->
<div class='modal fade' id='enroll-student-modal'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enroll a Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-content'>
                <div class='container'>
                    <form action='signup-submit' method='POST'>
                        <div class='form-group'>
                            <label for="first">First Name</label>
                            <input class='form-control' type='text' placeholder='First Name' name='first' id='first' required>
                            <label for="last">Last Name</label>
                            <input class='form-control' type='text' placeholder='Last Name' name='last' id='last' required>
                            <label for="username">Username</label>
                            <input class='form-control' type='text' placeholder='Username' name='username' id='username' required>
                            <label for="password">Password</label>
                            <input class='form-control' type='password' placeholder='Password' name='password' id='password' required>
                            <input type='hidden' name='type' value='STUDENT'>
                            <div id='additional-form'>
                                <label for="class">Class</label>
                                <select class="form-control" id="class" name='class'>
                                    <?php
                                        $classes = SectionController::getAllClasses();
                                        foreach($classes as $item){
                                            echo "
                                                <option value='".$item['class_id']."'>
                                                    ".$item['section_name']."
                                                </option>
                                            ";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class='container-fluid mt-3'>
                                <button class='btn btn-primary'>SUBMIT</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">CANCEL</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end of enroll student modal-->