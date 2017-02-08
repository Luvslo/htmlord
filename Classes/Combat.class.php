<?php 
class Combat {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function signUp($user_id){
		
		$stmt = $this->connection->prepare("INSERT INTO user_combat (user_id, attack_mod, defence_mod, wpn_rock) VALUES (?,1,1,0)");
		
		$stmt->bind_param("i", $user_id);
		
		if ($stmt->execute()) {
			
			echo " Combat andmete loomine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}

	function getUserStats($user_id) {

		$stmt =$this->connection->prepare("SELECT user_id, attack_mod, defence_mod FROM user_combat WHERE user_id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($user_id, $attack_mod, $defence_mod);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$cstats = new StdClass();
			$cstats->user_id=$user_id;
			$cstats->attack_mod=$attack_mod;
			$cstats->defence_mod=$defence_mod;
			
			array_push($result, $cstats);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function updateStats($user_id, $attack_mod, $defence_mod){
		
		$stmt = $this->connection->prepare("UPDATE user_combat SET attack_mod=attack_mod+?, defence_mod=defence_mod+? WHERE user_id=?");
		
		$stmt->bind_param("ddi",$attack_mod, $defence_mod, $user_id);
		
		if ($stmt->execute()) {
			
			echo "combat statide uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
}
?>