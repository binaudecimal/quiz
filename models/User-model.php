<?php

class User extends Database{

	public function getAllUsers(){
		$pdo = Database::connect();
		$stmt = $pdo->prepare('SELECT * from users');
		$stmt->execute();

		$result = $stmt->fetchAll();
		return $result;
	}

}
?>