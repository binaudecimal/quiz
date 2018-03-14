<?php

class User extends Database{

	public function getAllUsers(){
		$pdo = self::connect();
		$stmt = $pdo->prepare('SELECT * from users');
		$stmt->execute();

		$result = $stmt->fetchAll();
		return $result;
	}

	public function insertUser($username, $password, $first, $last, $type){
		try{
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO users(username, password, first, last, type) values (?,?,?,?,?)');
            $stmt->execute(array($username, $hashed_pw, $first, $last, $type));
            $pdo->commit();
            
            //var_dump($type);
            return array('username'=>$username,
                         'password'=>$password,
                         'first'=>$first,
                         'last'=>$last,
                         'type'=>$type,
                        );
        }
        catch(Exception $e){
            echo "Error occurred ". $e->getMessage();
            $pdo->rollBack();
            return false;
        }
	}

    public function enrollTeacher($user_id){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO teachers (user_id) VALUES (?)');
            $stmt->execute(array($user_id));
            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            $pdo->rollBack();
            return false;
        }
        
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