<?php

class Stat extends Database{
    public function jsonify($type, $labels, $label, $data){
         $dataset = array('type'=>'bar', 'data'=>array('labels'=>$labels, 'datasets'=>array(array('label'=>$label, 'data'=>$data))), 'options'=>array('scales'=>array('yAxes'=>array(array('ticks'=>array('beginAtZero'=>'true'))))));

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
    
    public function getScoresPerSectionPerRegion(){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT quiz_instance.total_score, quiz_instance.region, class.section_name, users.first, users.last from quiz_instance NATURAL JOIN students NATURAL JOIN class NATURAL JOIN users');
            $stmt->execute();
            $instances = $stmt->fetchAll();
            if(!$instances) return false;
            $score_array = array('section'=>array());
            foreach($instances as $item){
                //$score_array['labels'] += $item['region'];
                //$score_array['total_score'] += $item['total_score'];
                array_push($score_array[$item['section_name']][$item['region']['labels']], $item['last']. ", " $item['first']);
                array_push($score_array[$item['section_name']][$item['region']['data']], $item['total_score']);
                //array_push($score_array['total_score'], $item['total_score']);
            }
            
            //return ($this->jsonify('bar', $score_array['labels'], 'Scores', $score_array['total_score']));
            
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
}