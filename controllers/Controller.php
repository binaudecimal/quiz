<?php
	class Controller extends Database{

		public function __construct(){
			session_start();
		}
		public static function createView($viewName){
			include './header.php';
			require_once './views/' .$viewName.'.php';
		}

		public static function setSession(){
			if(!isset($_SESSION)){
				session_start();
			}
		}

		public static function getAllUsers(){
			$umodel = new User();
			print_r($umodel->getAllUsers());
		}
        
        public static function findHome(){
            self::setSession();
            $type = $_SESSION['type'];
            switch($type){
                case 'STUDENT': header('Location: student');
                    exit();
                    break;
                case 'TEACHER': header('Location: teacher');
                    exit();
                    break;
                case 'ADMIN': header('Location: admin');
                    exit();
                    break;
                default: header('Location: index');
                    exit();
                    break;
            }
        }
        
        public static function checkUser(){
            self::setSession();
            $session_id = $_SESSION['session_id'];
            $user_id = $_SESSION['user_id'];
            
            $user_model = new User();
            return $user_model->checkUser($session_id, $user_id);
        }
	}
?>
