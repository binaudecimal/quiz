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

	public function logout(){

	}



}
?>