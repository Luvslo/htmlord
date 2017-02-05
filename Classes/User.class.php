<?php 
class User {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function signUp ($email, $username, $password) {
		
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, username, password) VALUES (?,?,?)");

		$stmt->bind_param("sss", $email, $username, $password);
		
		if ($stmt->execute()) {
			
			echo "Kasutaja loomine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function login ($email, $password) {
		
		$error = "";
		
		$stmt = $this->connection->prepare("
		
			SELECT id, email, username, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $usernameFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				$_SESSION["username"] = $usernameFromDb;
				
				header("Location: data.php");
				exit();
				
			} else {
				$error = "Parool vale, proovi uuesti!";
			}
			
		} else {	
			
			$error = "Sellise ".$email." emailiga kasutajat ei ole salvestatud";
		}
		
		$stmt->close();
		return $error;
	}
	
	function get($username){

		$stmt = $this->connection->prepare("SELECT id, username FROM user_sample WHERE username=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("s", $username);
		$stmt->bind_result($id, $username);
		$stmt->execute();
		
		$User = new Stdclass();

		if($stmt->fetch()){

			$User->id = $id;
			$User->username = $username;
			
		}else{

			exit();
		}
		
		$stmt->close();
		
		return $User;
		
	}
} 
?>