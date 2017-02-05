<?php 
class Resources {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function signUp($user_id){

		$stmt = $this->connection->prepare("INSERT INTO user_resource (user_id, wood, stone, iron, coins, workforce, population, food) VALUES (?,10,10,10,100,50,100,100)");
		
		$stmt->bind_param("i", $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside loomine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function getUser ($user_id) {

		$stmt = $this->connection->prepare("SELECT user_id, wood, stone, iron, coins, workforce, population, food FROM user_resource WHERE user_id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($user_id, $wood, $stone, $iron, $coins, $workforce, $population, $food);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$res = new StdClass();
			$res->user_id=$user_id;
			$res->wood=$wood;
			$res->stone=$stone;
			$res->iron=$iron;
			$res->coins=$coins;
			$res->workforce=$workforce;
			$res->population=$population;
			$res->food=$food;
			
			array_push($result, $res);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function updateIron($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET iron=iron+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function updateCoins($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET coins=coins+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function updateFood($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET food=food+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function updateWood($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET wood=wood+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function updateStone($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET stone=stone+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function updateWorkforce($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET workforce=workforce+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function updatePopulation($user_id, $amount){
		
		$stmt = $this->connection->prepare("UPDATE user_resource SET population=population+? WHERE user_id=?");
		
		$stmt->bind_param("di",$amount, $user_id);
		
		if ($stmt->execute()) {
			
			echo "Ressursside uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
} 
?>