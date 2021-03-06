<?php
	require_once('Routes.php');
    Controller::setSession();
	function __autoload($class_name){

		if(file_exists('./classes/'.$class_name.'.php')){
			require_once './classes/'.$class_name.'.php';
		}
		elseif(file_exists('./controllers/'.$class_name.'.php')){
			require_once './controllers/'.$class_name.'.php';
		}
		elseif(file_exists('./models/'.$class_name.'.php')){
			require_once './models/'.$class_name.'.php';

		}elseif(file_exists('./views/'.$class_name.'.php')){
			require_once './views/'.$class_name.'.php';
		}
	}
?>
