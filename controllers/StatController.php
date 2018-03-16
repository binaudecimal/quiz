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
        $stat_model = new Stat();
        return $stat_model->getScoresPerSectionPerRegion();
    }
}