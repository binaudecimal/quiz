<?php
    Controller::setSession();
    $teachers = SectionController::getAllTeachers();
?>
<div clsas='container'>
    <a class='btn btn-primary' role='button' href='signup'>SIGNUP</a>
    <button class='btn btn-primary' role='button' data-toggle='modal' data-target='#add-class-modal'>ADD CLASS</button>
    <div class='row h-100'>
        <div class='container col-3' style='bg-color:#e3e3e3;'>
            <h4 class='display-4'>Class List</h4>
            <?php
                $classes = SectionController::getAllClasses();
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