<?php

class Section extends Database{
    public function addClass($classname, $teacher_id){
        $pdo = self::connect();
        try{
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO class(section_name,teacher_id) values (?,?)');
            $stmt->execute(array($classname, $teacher_id));
            $pdo->commit();
            return $classname;
        }
        catch(Exception $e){
            $pdo->rollBack();
            return false;
        }
    }
    public function getAllTeachers(){
        $pdo = self::connect();
        $stmt = $pdo->query('SELECT users.first, users.last, teachers.teacher_id from teachers NATURAL JOIN users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAllClasses(){
       $pdo = self::connect();
        $stmt = $pdo->query('SELECT class.section_name, users.first, users.last, class.class_id from class NATURAL JOIN teachers NATURAL JOIN users');
        $stmt->execute();
        return $stmt->fetchAll(); 
    }
    
    public function getAllStudents(){
       $pdo = self::connect();
        $stmt = $pdo->query('SELECT class.section_name, users.first, users.last, class.class_id from students NATURAL JOIN class LEFT JOIN users ON users.user_id = students.user_id');
        $stmt->execute();
        return $stmt->fetchAll(); 
    }
    
    public static function teacherExist(){
        $pdo = self::connect();
        $stmt = $pdo->query('SELECT * FROM teachers limit 1');
        $stmt->execute();
        return ($stmt->fetch()) ? true: false;
    }
}