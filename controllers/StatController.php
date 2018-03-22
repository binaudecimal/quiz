<?php

class StatController extends Controller{
    public static function getStudentScores(){
        self::setSession();
        $stat_model = new Stat();
        $student_id = $_SESSION['student_id'];
        return $stat_model->getStudentScores($student_id);
    }
    
    public static function getScoresPerSectionPerRegion(){
        self::setSession();
        if(!isset($_GET['section'])){
            header('Location: home');
            exit();
        }
        $stat_model = new Stat();
        $section = $_GET['section'];
        return $stat_model->getScoresPerSectionPerRegion($section);
    }
    
    public static function getQuestionStat(){
        if(!isset($_GET['question_id'])){
            header('Location: home');
            exit();
        }
        $question_id = $_GET['question_id'];
        $stat_model = new Stat();
        return $stat_model->getQuestionStat($question_id);
    }
    
    public static function getStudentQuizReport(){
        if(!isset($_SESSION['student_id'])){
            return array();
        }
        else{
            $student_id = $_SESSION['student_id'];
            $stat_model = new Stat();
            return $stat_model->getStudentQuizReport($student_id);
        }
    }
    
    
}