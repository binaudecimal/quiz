<?php

class SectionController extends Controller{
    public static function addClass(){
        if(!isset($_POST['class'])){
            header('Location: admin?status=missing-class');
            exit();
        }
        $classname = $_POST['class'];
        $teacher_id = $_POST['teacher'];
        $section_model = new Section();
        $section_model->addClass($classname, $teacher_id);
        header('Location: admin?status=class-added');
        exit();
    }
    
    public static function getAllTeachers(){
        $section_model = new Section();
        $teachers = $section_model->getAllTeachers();
        return $teachers;
    }
    
    public static function getAllClasses(){
        $section_model = new Section();
        $classes = $section_model->getAllClasses();
        return $classes;
    }
    
    public static function getAllStudents(){
        $section_model = new Section();
        $students = $section_model->getAllStudents();
        return $students;
    }
    
    public static function teacherExist(){
        $section_model = new Section();
        $status = $section_model->teacherExist();
        return $status;
    }
}