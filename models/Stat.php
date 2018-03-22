<?php

class Stat extends Database{
    public function jsonify($type, $labels, $label, $data){
         $dataset = array('type'=>$type, 'data'=>array('labels'=>$labels, 'datasets'=>array(array('label'=>$label, 'data'=>$data))), 'options'=>array('scales'=>array('yAxes'=>array(array('ticks'=>array('beginAtZero'=>'true'))))));

        return json_encode($dataset, JSON_NUMERIC_CHECK);
    }
    
    public function getStudentScores($student_id){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT region, total_score from quiz_instance WHERE student_id = ?');
            $stmt->execute(array($student_id));
            $instances = $stmt->fetchAll();
            if(!$instances) return false;
            $score_array = array('labels'=>[], 'total_score'=>[]);
            foreach($instances as $item){
                //$score_array['labels'] += $item['region'];
                //$score_array['total_score'] += $item['total_score'];
                array_push($score_array['labels'], $item['region']);
                array_push($score_array['total_score'], $item['total_score']);
            }
            
            return ($this->jsonify('bar', $score_array['labels'], 'Scores', $score_array['total_score']));
            
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    public function getScoresPerSectionPerRegion($section){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT quiz_instance.total_score, quiz_instance.region, class.section_name, users.first, users.last from quiz_instance NATURAL JOIN students NATURAL JOIN class NATURAL JOIN users where class.section_name = ?');
            $stmt->execute(array($section));
            $instances = $stmt->fetchAll();
            if(!$instances) return false;
            $score_array = array();
            foreach($instances as $item){
                $score_array[$item['region']]['labels'][] = $item['last'] . ", " . $item['first'];
                $score_array[$item['region']]['data'][] = $item['total_score'];
            }

            $jsoned_data = [];
            foreach($score_array as $key=>$item){
                $jsoned_data[$key] = $this->jsonify('bar', $item['labels'], 'Scores', $item['data']);
            }
           
            return $jsoned_data;
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    public function getQuestionStat($question_id){
        try{
            $pdo = self::connect();
            //get the question first
            $stmt = $pdo->prepare('SELECT * FROM questions WHERE question_id = ?');
            $stmt->execute(array($question_id));
            $question = $stmt->fetch();
            
            $answer_correct = $question['answer_correct'];
            $answer_wrong1 = $question['answer_wrong1'];
            $answer_wrong2 = $question['answer_wrong2'];
            $answer_wrong3 = $question['answer_wrong3'];

            if(!$question) return false;
            $stmt = $pdo->prepare('SELECT answer FROM answer_instance WHERE question_id = ?');
            $stmt->execute(array($question_id));
            $answers = $stmt->fetchAll();
            if(!$answers) return false;
            $answer_stat = [];
            $answer_stat['NA'] = [];
            $answer_stat[$answer_correct] = [];
            $answer_stat[$answer_wrong1] = [];
            $answer_stat[$answer_wrong2] = [];
            $answer_stat[$answer_wrong3] = [];
            
            foreach($answers as $item){
                if($item['answer']==''){
                    $answer_stat['NA'][]=$item['answer'];
                }
                else $answer_stat[$item['answer']][]=$item['answer'];
            }
            $labels = [$answer_correct, $answer_wrong1, $answer_wrong2, $answer_wrong3, 'NA'];
            $data = [count($answer_stat[$answer_correct]), count($answer_stat[$answer_wrong1]), count($answer_stat[$answer_wrong2]), count($answer_stat[$answer_wrong3]), count($answer_stat['NA'])];
            
            return $this->jsonify('pie', $labels, 'Distributed Scores', $data);
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    public function getStudentQuizReport($student_id){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * FROM quiz_instance WHERE student_id = ?');
            $stmt->execute(array($student_id));
            $quizzes = $stmt->fetchAll();
            if(!$quizzes) return array();
            return $quizzes;
        }
        catch(Exception $e){
            echo $e->getMessage();
            return array();
        }
    }
    
   