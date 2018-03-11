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
	}
?>
