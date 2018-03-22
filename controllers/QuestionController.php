<?php

class QuestionController extends Controller{
    
    public static function getAllQuiz(){
        $question_model = new Question();
        var_dump($question_model->getAllQuiz());
    }
    
    /**
        Generate quiz for a section
    */
    public static function generateQuiz(){
        if(!isset($_POST['class_id']) || !isset($_POST['items']) || !isset($_POST['duration']) || !isset($_POST['region'])){
            echo 'Missing field';
        }
        else{
            $class_id = $_POST['class_id'];
            $items = $_POST['items'];
            $duration = $_POST['duration'];
            $region = $_POST['region'];
            
            $question_model = new Question();
            $status = $question_model->generateQuiz($class_id, $items, $duration, $region);
            if(!$status){
                header('Location: teacher?status=startQuiz-failed');
                exit();
            }
            else{
                header('Location: teacher?status=startQuiz-success');
                exit();
            }
            
        }
    }
    
    public static function startQuiz(){
        self::setSession();
        if(!isset($_SESSION['student_id'])){
            echo 'Go back home!';
        }
        $student_id = $_SESSION['student_id'];
        $question_model = new Question();
        $quiz = $question_model->isQuizActive($student_id);
        if(!$quiz) {
            header('Location: student?status=quiz-noActive');
            exit();
        }
        $next_question = $question_model->processQuiz($student_id, $quiz['qinstance_id'], $quiz['region'], $quiz['items']);
        if(!$question_model->processQuiz($student_id, $quiz['qinstance_id'], $quiz['region'], $quiz['items'])){
            header('Location: student?status=quiz-allComplete');
            exit();
        }
        else{
            $_SESSION['question_id'] = $next_question;
            $_SESSION['qinstance_id'] = $quiz['qinstance_id'];
            $_SESSION['duration'] = $quiz['duration'];
            header('Location: quiz-take');
            exit();
        }
        
    }
    
    public static function getQuestion(){
        self::setSession();
        $question_model = new Question();
        return $question_model->getQuestion($_SESSION['question_id']);
    }
    
    public static function processAnswer(){
        self::setSession();
        $answer = $_POST['answer-value'];
        $question_id = $_SESSION['question_id'];
        $student_id = $_SESSION['student_id'];
        $question_model = new Question();
        $question_model->processAnswer($answer, $question_id, $student_id);
        header('Location: quiz-start');
        exit();
    }
    
    public static function addQuestion(){
        self::setSession();
        $region = $_POST['region'];
        $question = $_POST['question'];
        $answer_correct = $_POST['answer_correct'];
        $answer_wrong1 = $_POST['answer_wrong1'];
        $answer_wrong2 = $_POST['answer_wrong2'];
        $answer_wrong3 = $_POST['answer_wrong3'];
        $question_model = new Question();
        if($question_model->addQuestion($region, $question, $answer_correct, $answer_wrong1, $answer_wrong2,$answer_wrong3)){
            header('Location: teacher?status=adding-successful');
            exit();
        }
        else{
            header('Location: teacher?status=adding-failed');
            exit();
        }
    }
    
    public static function getAllQuestionsByRegion(){
        $question_model = new Question();
        return $question_model->getAllQuestionsByRegion();
        
    }
    
    public static function fetchQuestion(){
        self::setSession();
        $question_model = new Question();
        if(!isset($_GET['question_id'])){
            header('Location: home');
            exit();
        }
        
        $status = $question_model->fetchQuestion($_GET['question_id']);
        return($status);
    }
    
    public static function getQuestionNumber(){
        self::setSession();
        $question_model = new Question();
        $qinstance_id = $_SESSION['qinstance_id'];
        return $question_model->getQuestionNumber($qinstance_id);
    }
    public static function questionDelete(){
        self::setSession();
        $question_model = new Question();
        $question_id = $_POST['question_id'];
        $status=  $question_model->questionDelete($question_id);
        
        if(!$status){
            header('Location: teacher?status=questionDelete-failed');
            exit();
        }
        header('Location: teacher?status=questionDelete-success');
        exit();     
    }
    
    public static function questionEdit(){
        self::setSession();
        $question_id = $_POST['question_id'];
        $question = $_POST['question'];
        $region = $_POST['region'];
        $answer_correct = $_POST['answer_correct'];
        $answer_wrong1 = $_POST['answer_wrong1'];
        $answer_wrong2 = $_POST['answer_wrong2'];
        $answer_wrong3 = $_POST['answer_wrong3'];
        if(empty($question_id) || empty($question) || empty($region) || empty($answer_correct) || empty($answer_wrong1) || empty($answer_wrong2) || empty($answer_wrong3)){
            header('Location: edit-question?status=field-incomplete');
            exit();
        }
        $question_model = new Question();
        $status = $question_model->questionEdit($question_id, $question, $region, $answer_correct, $answer_wrong1, $answer_wrong2, $answer_wrong3);
        if(!$status){
            header('Location: teacher?status=questionEdit-failed');
            exit();
        }
        header('Location: teacher?status=questionEdit-success');
        exit();  
    }
}