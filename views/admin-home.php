<?php
    Controller::setSession();
    $teachers = SectionController::getAllTeachers();
    $classes = SectionController::getAllClasses();
?>
<div class='container-fluid pt-5 mt-5'>
    <a class='btn btn-primary' role='button' href='signup'>SIGNUP</a>
    <button class='btn btn-primary' role='button' data-toggle='modal' data-target='#add-class-modal'>Add Section</button>
    <button class='btn btn-primary' role='button' data-toggle='modal' data-target='#generate-quiz-modal'>Start a Quiz</button>
    <?php
    ?>
    <div class='row h-100 pt-5'>
        <div class='container col-3' style='bg-color:#e3e3e3;'>
            <h4 class='display-4'>Class List</h4>
            <?php
                foreach($classes as $item){
                    echo"
                    <p>
                        <strong>Section:</strong>".$item['section_name']."</br>
                        <strong>Teacher:</strong>".$item['last'].", ".$item['first']."</br>
                    </p>
                    ";
                }
            ?>
        </div>
        <div class='container col-3' style='bg-color:#e1e1e1;'>
            <h4 class='display-4'>Teachers List</h4>
            <?php
                $teachers = SectionController::getAllTeachers();
                foreach($teachers as $item){
                    echo"
                    <p>
                        <strong>Teacher:</strong>".$item['last'].", ".$item['first']."</br>
                    </p>
                    ";
                }
            ?>
        </div>
        <div class='container col-3' style='bg-color:#d2d2d2;'>
            <h4 class='display-4'>Students List</h4>
            <?php
                $students = SectionController::getAllStudents();
                foreach($students as $item){
                    echo"
                    <p>
                        <strong>Student:</strong>".$item['last'].", ".$item['first']."</br>
                        <strong>Section:</strong>".$item['section_name']."</br>
                    </p>
                    ";
                }
            ?>
        </div>
    </div>
</div>


<div class='modal fade' id='add-class-modal' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class="modal-title" id="exampleModalLabel">Add Class (Section)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class='modal-body'>
                <div class='container'>
                    <form class='form-group' action='add-class' method='POST'>
                        <p class='lead'>
                            You are about to add another class(section) for the students. This will be used in activating quizzes for the students.
                        </p>
                        <label for='class'>Class Name</label>
                        <input class='form-control' name='class' placeholder='Class Name' id='class'>
                        <select class='form-control' name='teacher'>
                            <?php
                                if($teachers){
                                    foreach($teachers as $item){
                                        echo "
                                            <option value='".$item['teacher_id']."'>".$item['last'].", ".$item['last']."</option>
                                        ";
                                    }
                                }
                            ?>
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

<div class='modal fade' id='generate-quiz-modal' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class="modal-title" id="exampleModalLabel">Start a Quiz</h5>
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
