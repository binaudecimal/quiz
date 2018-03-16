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
        //check for student ID
        /*
            if quiz active, get next question
                
            if no quiz active, clean session first before throw back home
        */
    }
    
}