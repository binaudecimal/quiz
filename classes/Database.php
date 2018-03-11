<?php
	class Database{

		public static $host = 'localhost';
		public static $dbname = 'quiz_game';
		public static $username ='root';
		public static $password = '';

		private static function connect(){
			$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$username, self::$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}

		public static function insertSignup($first, $last, $username, $password, $type){ //return true if success, fail if not
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  $pdo->beginTransaction();
			  $statement = $pdo->prepare("INSERT into users (first, last, username, password, type) values (?,?,?,?,?)");
				$statement->execute(array($first, $last, $username, $password, $type));
			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}

		public static function insertAddQuestion($question, $region, $answer_correct, $answer_wrong1, $answer_wrong2, $answer_wrong3){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $pdo->beginTransaction();
			  $statement = $pdo->prepare("INSERT into questions (question, region, answer_correct, answer_wrong1,answer_wrong2,answer_wrong3, active_status) values (?,?,?,?,?,?,?)");
				$statement->execute(array($question, $region, $answer_correct, $answer_wrong1, $answer_wrong2, $answer_wrong3, true));
			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}
		public static function insertActivateQuiz($items, $duration){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if(($students = self::selectStudents())!=null){
					$pdo->beginTransaction();
					//deactivate all quizzes
					$statement = $pdo->prepare("UPDATE quiz_instance set date_finished = NOW() where date_finished IS NULL");
					$statement->execute();

					foreach($students as $row){
						$user_id = $row['user_id'];
						$statement = $pdo->prepare("INSERT into quiz_instance (user_id, items, duration, date_activated) values (?,?,?, NOW())");
						$statement->execute(array($user_id, $items, $duration));
					}
					$pdo->commit();
					return true;
				}
				else return false;
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function insertQuiz($user_id, $qinstance_id, $region, $limit){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $pdo->beginTransaction();
				//setting region
			  $statement = $pdo->prepare("UPDATE quiz_instance set region = ? where qinstance_id = ?");
				$result = $statement->execute(array($region, $qinstance_id));
				//generate the quiz itself
				$sql = "SELECT * from questions where region = ? order by RAND() limit " . $limit;
				$statement = $pdo->prepare("SELECT * from questions where region = ? order by RAND() limit " . $limit);
				$statement->execute(array($region));
				$question_set = $statement->fetchAll();
				foreach($question_set as $row){
					//insert into ainstance for each questions
					$statement = $pdo->prepare("INSERT into answer_instance (user_id, question_id, qinstance_id) values (?,?,?)");
					$statement->execute(array($user_id, $row['question_id'], $qinstance_id));
				}
			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}



		public static function selectStudents(){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $statement = $pdo->prepare("SELECT * from users where type='STUDENT'");
				$statement->execute();
				return $statement->fetchAll();
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function selectNextQuestion($qinstance_id){
			$pdo = self::connect();
			$question_row = self::fetch("SELECT question_id, ainstance_id from answer_instance where qinstance_id = ? and weighted_score is NULL order by RAND() limit 1",array($qinstance_id));
			if(!$question_row){
				//check if null or not
				if(self::fetch("SELECT * from quiz_instance where qinstance_id = ? and date_finished is NULL", array($qinstance_id))){
					//update date finished
					self::query("UPDATE quiz_instance SET date_finished = NOW() WHERE qinstance_id = ?",array($qinstance_id));
				}
				header('Location: home?status=quiz-complete');
				exit();
			}
			else{
				Controller::setSession();
				$_SESSION['question_id'] = $question_row['question_id'];
				header('Location: quiz-take');
				exit();
			}
		}

		public static function selectTopStudents(){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->beginTransaction();
			  $statement = $pdo->prepare("SELECT COUNT(*) from users WHERE type='STUDENT'");
			  $statement->execute();
			  $students = $statement->fetch()[0];

			  $statement = $pdo->prepare("SELECT users.user_id, total_score, first, last FROM quiz_instance, users WHERE users.user_id = quiz_instance.user_id GROUP BY qinstance_id ORDER BY date_activated DESC, total_score DESC limit ?");
				$statement->bindParam(1, $students, PDO::PARAM_INT);
				$statement->execute();
				$student_names = array();
				$student_scores = array();
				$data = $statement->fetchAll();
				if($data){
					foreach($data as $row){
						$student_names[] = $row['last']. ', ' . $row['first'];
						$student_scores[] = $row['total_score'];
					}
					$dataset = array('type'=>'bar', 'data'=>array('labels'=>$student_names, 'datasets'=>array(array('label'=>'Students', 'data'=>$student_scores))), 'options'=>array('scales'=>array('yAxes'=>array(array('ticks'=>array('beginAtZero'=>'true'))))));

					return json_encode($dataset, JSON_NUMERIC_CHECK);
				}
				else return false;
			} catch (Exception $e) {
					echo 'error';
					$pdo->rollBack();
				//return false;
			}
		}

		public static function selectAllQuestions(){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $statement = $pdo->prepare("SELECT * from questions where active_status = true");
				$statement->execute();
				return $statement->fetchAll();
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function selectQuestion($question_id){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $statement = $pdo->prepare("SELECT * from questions where active_status = true and question_id = ?");
				$statement->execute(array($question_id));
				return $statement->fetch();
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function selectQuestionNumber($qinstance_id){
			$pdo = self::connect();
			try {

			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $statement = $pdo->prepare("select count(*) from answer_instance where qinstance_id = ? and weighted_score is not null");
				$statement->execute(array($qinstance_id));
				return $statement->fetch()[0]+1;
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function selectStudentScores($user_id){
			$pdo = self::connect();
		  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement = $pdo->prepare("SELECT region, total_score FROM quiz_instance where region is NOT NULL and user_id = ?");
			$statement->execute(array($user_id));
			$scores = $statement->fetchAll();
			return ($scores) ? $scores: false;
		}

		public static function updateScores($weighted_score, $ainstance_id){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $pdo->beginTransaction();
			  //sample
			  $statement = $pdo->prepare('SELECT qinstance_id FROM answer_instance where ainstance_id = ?');
			  $statement->execute(array($ainstance_id));
			  $ainstance_row = $statement->fetch();
			  $qinstance_id = $ainstance_row['qinstance_id'];

			  //get qinstance id
			  $statement = $pdo->prepare('SELECT total_score FROM quiz_instance WHERE qinstance_id = ?');
			  $statement->execute(array($qinstance_id));
			  $total_score = $statement->fetch()['total_score'];

			  $statement = $pdo->prepare('UPDATE answer_instance SET weighted_score = ? where ainstance_id = ?');
			  $statement->execute(array($weighted_score, $ainstance_id));

			  $statement = $pdo->prepare('UPDATE quiz_instance SET total_score = ? where qinstance_id = ?');
			  $statement->execute(array(($total_score + $weighted_score), $qinstance_id));

			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}

		public static function updateQuestion(){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $pdo->beginTransaction();
			  //sample
				$question_id = $_POST['question_id'];
				$question = $_POST['question'];
				$answer_correct = $_POST['answer_correct'];
				$answer_wrong1 = $_POST['answer_wrong1'];
				$answer_wrong2 = $_POST['answer_wrong2'];
				$answer_wrong3 = $_POST['answer_wrong3'];

				$statement = $pdo->prepare('UPDATE questions SET question = ? where question_id = ?');
				$statement->execute(array($question, $question_id));

				$pdo->commit();
				header('Location: populate-question?status=updateQuestion-success');
				exit();
			} catch (Exception $e) {
			  $pdo->rollBack();
				header('Location: populate-question?status=updateQuestion-failed');
				exit();
			}
		}

		public static function deleteQuestion(){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if(!isset($_GET['question_id'])){
					header('Location: populate-question?status=delete-failed');
					exit();
				}
				else{
					$question_id = $_GET['question_id'];
					$statement = $pdo->prepare("UPDATE questions SET active_status = 0 where question_id = ?");
					$statement->execute(array($question_id));
					header('Location: populate-question?status=delete-success');
					exit();
				}

			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function query($query, $params = array()){
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			if(explode(' ', $query)[0] == 'SELECT'){
				$data = $statement->fetchAll();
				//print_r($data);
				return $data;
			}
			elseif(explode(' ', $query)[0] == 'INSERT'){

				//do something for insert
				return true;
			}
		}

		public static function quote($string){
			return self::connect()->quote($string);
		}

		public static function isExist($query, $params = array()){
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			if($row==null){
				return false;

			}
			else {

				return true;
			}
		}

		public static function fetch($query, $params = array()){
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			$data = $statement->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

	}
?>
