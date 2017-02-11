<?php 
class Data {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function signUp($user_id){
		
		$stmt = $this->connection->prepare("INSERT INTO user_data (user_id, reputation, authority) VALUES (?,100,0)");
		
		$stmt->bind_param("i", $user_id);
		
		if ($stmt->execute()) {
			
			echo " Data loomine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}

	function getUser($user_id) {

		$stmt =$this->connection->prepare("SELECT user_id, reputation, authority FROM user_data WHERE user_id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($user_id, $reputation, $authority);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$data = new StdClass();
			$data->user_id=$user_id;
			$data->reputation=$reputation;
			$data->authority=$authority;
			
			array_push($result, $data);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function update($user_id, $reputation, $authority){
		
		$stmt = $this->connection->prepare("UPDATE user_data SET reputation=reputation+?, authority=authority+? WHERE user_id=?");
		
		$stmt->bind_param("iii",$reputation, $authority, $user_id);
		
		if ($stmt->execute()) {
			
			echo "data uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
} 
?>