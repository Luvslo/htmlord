<?php 
class Attacks {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	/*function getUser ($user_id) {

		$stmt = $this->connection->prepare("SELECT id, user_id, category, workforce_input, time_input, created FROM user_actions WHERE user_id=? AND deleted IS NULL");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($id, $user_id, $category, $workforce_input, $time_input, $created);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$action = new StdClass();
			$action->id=$id;
			$action->user_id=$user_id;
			$action->category=$category;
			$action->workforce_input=$workforce_input;
			$action->time_input=$time_input;
			$action->created=$created;
			
			array_push($result, $action);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function getSingle($action_id){

		$stmt = $this->connection->prepare("SELECT id, user_id, category, workforce_input, time_input FROM `user_actions` WHERE id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $action_id);
		$stmt->bind_result($id, $user_id, $category, $workforce_input, $time_input);
		$stmt->execute();

		$SRes = new Stdclass();

		if($stmt->fetch()){
			$SRes->id = $id;
			$SRes->user_id = $user_id;
			$SRes->category = $category;
			$SRes->workforce_input = $workforce_input;
			$SRes->time_input = $time_input;
		}else{
			exit();
		}
		$stmt->close();
		
		return $SRes;
	}
	
	function delet($action_id){

		$stmt = $this->connection->prepare("UPDATE user_actions SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		
		$stmt->bind_param("i", $action_id);
		
		if ($stmt->execute()) {
			
			echo "Tegevuse kustutamine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	*/
	function save($attacker_id, $victim_id, $workforce_input){
		
		$stmt = $this->connection->prepare("INSERT INTO user_attacks (attacker_id, victim_id, category, workforce_input) VALUES (?,?,'attack',?)");
		
		$stmt->bind_param("iii", $attacker_id, $victim_id, $workforce_input);
		
		if ($stmt->execute()) {
			
			echo " Kasu salvestamine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}

} 
?>