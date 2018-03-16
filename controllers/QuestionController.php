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
            var_dump($question_model->generateQuiz($class_id, $items, $duration, $region));
            
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
        if(!$quiz) echo 'No quiz is active!';
        $next_question = $question_model->processQuiz($student_id, $quiz['qinstance_id'], $quiz['region'], $quiz['items']);
        if(!$question_model->processQuiz($student_id, $quiz['qinstance_id'], $quiz['region'], $quiz['items'])){
            header('Location: student?status=quizStart-failed');
            exit();
        }
        else{
            $_SESSION['question_id'] = $next_question;
            header('Location: quiz-take');
            exit();
        }

        
    }
    
    public static function getQuestion(){
        self::setSession();
        $question_model = new Question();
        return $question_model->getQuestion($_SESSION['question_id']);
        
    }
    
}