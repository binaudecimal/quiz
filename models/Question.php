<?php

class Question extends Database{
	
	function addQuestion(){

	}

	function editQuestion(){

	}

	function processAnswer(){

	}

	function getAllQuestions(){

	}
	
    public function getAllQuiz(){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * FROM quiz_instance NATURAL JOIN students NATURAL JOIN class');
            $stmt->execute();
            $result = $stmt->fetchAll();
            if(!$result){
                echo "There is nothing";
            }
            else{
                var_dump($result);
            }
        }   
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function generateQuiz($class_id, $items, $duration, $region){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT students.student_id from students NATURAL JOIN class WHERE class.class_id = ?');
            $stmt->execute(array($class_id));
            $students = $stmt->fetchAll();
            if(!$students){
                return false;
            }
            $pdo->beginTransaction();
            $questions = $stmt->fetchAll();
            foreach($students as $item){    
                $stmt = $pdo->prepare('INSERT INTO quiz_instance (student_id, items, duration, region) values (?,?,?,?)');
                $stmt->execute(array($item['student_id'], $items, $duration, $region));
            }
            
            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
        }
        
    }
}