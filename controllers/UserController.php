<?php

class UserController extends Controller{
    public static function login(){
        self::setSession();
        if(isset($_POST['login-submit'])){
            if(isset($_SESSION['user_id'])){
                //If user_id found in session, then someone already logged in
                header('Location: home?status=duplicate-login');
                exit();
            }
            //check for blanks
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if(empty($username) || empty($password)){
                header('Location home?status=incomplete-form');
                exit();
            }
            //check for existing username
            $user_model = new User();
            $user = $user_model->getUser($username);
            if(!$user){
                header('Location: home?status=user-notfound');
                exit();
            }
            //check for password match
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            if(!password_verify($password, $user['password'])){
                header('Location: home?status=password-incorrect');
                exit();
            }
            //successful login, update session ID
            if($user_model->updateSession($user)){
                header('Location: home?status=login-successful');
                exit();
            }
            else{
                header('Location: home?status=login-error');
                exit();
            }
        }
        else{
            //If login not clicked, redirect home
            header('Location: home?status=login-failed');
            exit();
        }
    }
    public static function logout(){
        self::setSession();
        $username = $_SESSION['username'];
        $user_model = new User();
        $user_model->logout($username);
        session_destroy();
        self::setSession();
        header('Location: home?status=logout-successful');
        exit();
    }
    
    public static function signup(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $type = $_POST['type'];
        $class = $_POST['class'];
        if(empty($username) || empty($password) || empty($first) || empty($last) || empty($type)){
            header('Location: teacher?status=form-incomplete');
            exit();
        }
        if($type =='STUDENT' && empty($class)){
            header('Location: teacher?status=classfield-empty');
            exit();
        }
        //check if user exists
        
        $user_model = new User();
        
        $user = $user_model->getUser($username);
        
        if($user){
            //user already taken
            header('Location: teacher?status=username-taken');
            exit();
        }
        
        
        $status = $user_model->insertUser($username, $password, $first, $last, $type);
        $user = $user_model ->getUser($username);
        switch($type){
                case 'STUDENT': $user_model->enrollStudent($user['user_id'], $class); break;
                case 'TEACHER': $user_model->enrollTeacher($user['user_id']); break;
            }
        
        if(!$status){
            header('Loation: teacher?status=error');
            exit();
        }
        //var_dump($_POST);
        header('Location: teacher?status=signup-success');
        exit();
    }
    
}
?>