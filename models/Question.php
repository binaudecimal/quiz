<?php

class Question extends Database{
	
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
                $stmt = $pdo->prepare('INSERT INTO quiz_instance (student_id, items, duration, region, total_score) values (?,?,?,?, 0)');
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
            $stmt = $pdo->prepare('SELECT * from quiz_instance where student_id = ? and date_finished is NULL');
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
                $stmt = $pdo->prepare('SELECT * FROM questions where region= :region  and status = 1 ORDER BY RAND() limit :limit ');
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
            if(!$next_question){
                //cleanse session and put date_completed on qinstance
                $stmt = $pdo->prepare('UPDATE quiz_instance set date_finished = NOW() where qinstance_id = ?');
                $stmt->execute(array($qinstance_id));
                return false;
            }
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
    public function processAnswer($answer, $question_id, $student_id){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT quiz_instance.qinstance_id, questions.answer_correct from quiz_instance NATURAL JOIN questions WHERE quiz_instance.student_id = ? and questions.question_id = ?');
            $stmt->execute(array($student_id, $question_id));
            $datarow = $stmt->fetch();
            $score = 0;
            if($datarow['answer_correct'] == $answer){
                $score = 1;
            }
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('UPDATE answer_instance NATURAL JOIN quiz_instance SET answer_instance.answer = ?, answer_instance.weighted_score = ?, quiz_instance.total_score = quiz_instance.total_score + ? WHERE quiz_instance.student_id = ? and answer_instance.question_id = ?');
            $stmt->execute(array($answer, $score, $score, $student_id, $question_id));
            $pdo->commit();
            return true;
            
            //$commit();
        }
        catch(Exception $e){
            $pdo->rollBack();
            return false;
        }
    }
    public function addQuestion($region, $question, $answer_correct, $answer_wrong1, $answer_wrong2,$answer_wrong3){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO questions (region, question, answer_correct, answer_wrong1, answer_wrong2, answer_wrong3, status) VALUES (?,?,?,?,?,?,1)');
            $stmt->execute(array($region, $question, $answer_correct, $answer_wrong1, $answer_wrong2,$answer_wrong3));
            $pdo->commit();
            return true;
        }   
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }
    
    public function getAllQuestionsByRegion(){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * FROM questions where status = 1');
            $stmt->execute();
            $question_per_region = array();
            foreach($stmt->fetchAll() as $items){
                $question_per_region[$items['region']][$items['question_id']] = $items;
                array_push($question_per_region[$items['region']], $items);
            }
            return $question_per_region;
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
}