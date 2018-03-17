<?php

class IssueController extends Controller{
    public static function addIssue(){
        if(!isset($_POST['issue-header']) || !isset($_POST['issue-body'])){
            header('Location: student?status=addIssue-failed');
            exit();
        }
        else{
            self::setSession();
            $issue_model = new Issue();
            $issue_header = $_POST['issue-header'];
            $issue_body = $_POST['issue-body'];
            $issuant_id = $_SESSION['student_id'];
            
            $status = $issue_model->addIssue($issue_header,$issue_body, $issuant_id);
            if(!$status){
                header('Location: student?status=addIssue-failed');
                exit();
            }
            else{
                header('Location: student?status=addIssue-success');
                exit();
            }
        }
    }
    
    public static function getAllIssues(){
        self::setSession();
        $issue_model = new Issue();
        
        return $issue_model->getAllIssues();
    }
}