<?php

class Issue extends Database{
    
    public function addIssue($issue_header,$issue_body, $issuant_id){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO issues (issue_heading, issue_body, date_issued, issuant_id) values (?,?,NOW(), ?)');
            $stmt->execute(array($issue_header,$issue_body, $issuant_id));
            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }
    
    public function getAllIssues(){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * FROM issues WHERE date_resolved IS NULL');
            $stmt->execute();
            $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$issues){
                return array();
            }
            else{
                return $issues;
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    public function resolveIssue($issue_id){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('UPDATE issues SET date_resolved = NOW() where issue_id = ?');
            $stmt->execute(array($issue_id));
            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }
}