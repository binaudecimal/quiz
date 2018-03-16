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
    
    public function isQuizActive($student_id){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * from quiz_instance where student_id = ?');
            $stmt->execute(array($student_id));
            return ($quiz = $stmt->fetch()) ? array('qinstance_id'=>$quiz['qinstance_id'], 'region'=>$quiz['region'], 'items'=>$quiz['items']) : false;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function processQuiz($student_id, $qinstance_id, $region, $items){
        try{
            $pdo = self::connect();
            //check if ainstance not yet initialized
            //if not init, create all questions
            //get next question
            $stmt = $pdo->prepare('SELECT * FROM answer_instance where qinstance_id = ?');
            $stmt->execute(array($qinstance_id));
            if(!$stmt->fetch()){
                $stmt = $pdo->prepare('SELECT * FROM questions where region= :region ORDER BY RAND() limit :limit ');
                $stmt->bindParam(':region', $region, PDO::PARAM_STR);
                $stmt->bindParam(':limit', $items, PDO::PARAM_INT);
                $stmt->execute();
                $questions = $stmt->fetchAll();
                $pdo->beginTransaction();
                foreach($questions as $item){
                    $stmt = $pdo->prepare('INSERT INTO answer_instance (qinstance_id, question_id) values (?,?)');
                    $stmt->execute(array($qinstance_id, $item['question_id']));
                }
                $pdo->commit();
            }
            return $this->getNextQuestion($qinstance_id);
        }
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }
    
    public function getNextQuestion($qinstance_id){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT questions.question_id from answer_instance NATURAL JOIN quiz_instance NATURAL JOIN questions where quiz_instance.qinstance_id = ? and weighted_score is NULL limit 1');
            $stmt->execute(array($qinstance_id));
            $next_question = $stmt->fetch();
            if(!$next_question) return false;
            return $next_question['question_id'];
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function getQuestion($question_id){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * FROM questions where question_id = ?');
            $stmt->execute(array($question_id));
            $question = $stmt->fetch();
            if(!$question) return false;
            $answers = array($question['answer_correct'],$question['answer_wrong1'],$question['answer_wrong2'],$question['answer_wrong3']);
            shuffle($answers);
            $result = array('question' => $question['question'],
                           'region'=>$question['region'],
                           'answers'=>$answers);
            return $result;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}