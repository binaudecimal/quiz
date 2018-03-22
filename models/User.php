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
    
    public function enrollStudent($user_id, $class_id){
        try{
            $pdo = self::connect();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO students (user_id, class_id) VALUES (?,?)');
            $stmt->execute(array($user_id, $class_id));
            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            echo "Error occured" . $e->getMessage();
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
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['session_id'] = $session_id;
            if($user['type'] == 'STUDENT'){
                $stmt = $pdo->prepare('SELECT student_id FROM students where user_id = ?');
                $stmt->execute(array($user['user_id']));
                $student_obj = $stmt->fetch();
                $_SESSION['student_id'] = $student_obj['student_id'];
            }
            return true;
        }
        catch(Exception $e){
            echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }
    
    public function dbExist(){
        try{
            $pdo = self::connect();
            $stmt = $pdo->prepare('SELECT * from users limit 1');
            $stmt->execute();
            if($stmt->fetch()) return true;
            return false;
        }
        catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    public function initDatabase($first, $last,$username,$password){
        define('DB_HOST', '127.0.0.1'); // use ip address instead of `localhost`
        // existing user that has permission to create database and grant access
        define('DB_ROOT_USER', 'root');
        define('DB_ROOT_PASS', '');
        // the database you want to create
        $dbname = 'quiz';
        // specific user for this particular database
        $dbuser = 'root';
        $dbpass = '';
        try {
            // login with root user
            $dbh = new PDO('mysql:host='.DB_HOST, DB_ROOT_USER, DB_ROOT_PASS);
            // create database
            $dbh->beginTransaction();
            $dbh->exec(
                "CREATE DATABASE `$dbname`;
                CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpass';
                GRANT ALL ON `$dbname`.* TO '$dbuser'@'localhost';
                FLUSH PRIVILEGES;"
            ) 
            or die(print_r($dbh->errorInfo(), true));
            $sql = file_get_contents('build.sql');
            $pdo = self::connect();
            $pdo->exec($sql);
            $stmt = $pdo->prepare("INSERT INTO users (first, last, username, password, type) VALUES (?,?,?,?, 'ADMIN')");
            $stmt->bindParam(1, $first);
            $stmt->bindParam(2, $last);
            $stmt->bindParam(3, $username);
            $stmt->bindParam(4, $password);
            $stmt->execute();
            $dbh->commit();
            return true;
            
        } catch (PDOException $e) {
            die("DB ERROR: ". $e->getMessage());
            $dbh->rollBack();
            $dbh->exec("DROP DATABASE 'quiz'");
            return false;
        }
    }
}
?>