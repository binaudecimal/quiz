<?php

class User extends Database{

	public function getAllUsers(){
		$pdo = self::connect();
		$stmt = $pdo->prepare('SELECT * from users');
		$stmt->execute();

		$result = $stmt->fetchAll();
		return $result;
	}

	public function enroll(){
		
	}

	public function login(){

	}

	public function logout($username){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('UPDATE users SET session_id = NULL where username = ?');
            $stmt->execute(array($username));
            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            echo 'Error occured '. $e->getMessage();
            $pdo->rollBack();
            return false;
        }
	}
    
    public function getUser($username){
        $pdo = self::connect();
        $stmt = $pdo->prepare('SELECT * FROM users where username = ? limit 1');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }
    
    public function updateSession($user){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $session_id = hash('md5', date('Y-m-d H:i:s'));
            $stmt = $pdo->prepare('UPDATE users SET session_id = ?, last_login = NOW() where username = ?');
            $stmt->execute(array($session_id, $user['username']));
            $pdo->commit();
            
            $_SESSION['username'] = $user['username'];
            $_SESSION['first'] = $user['first'];
            $_SESSION['last'] = $user['last'];
            $_SESSION['type'] = $user['type'];
            $_SESSION['session_id'] = $session_id;
            return true;
        }
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }



}
?>