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
	
	/*function update($user_id, $wood_mod, $stone_mod, $iron_mod, $coins_mod, $population_mod, $food_mod){
		
		$stmt = $this->connection->prepare("UPDATE user_modifiers SET wood_mod=wood_mod+?, stone_mod=stone_mod+?, iron_mod=iron_mod+?, coins_mod=coins_mod+?, population_mod=population_mod+?, food_mod=food_mod+? WHERE user_id=?");
		
		$stmt->bind_param("iiiiiii",$wood_mod, $stone_mod, $iron_mod, $coins_mod, $population_mod, $food_mod, $user_id);
		
		if ($stmt->execute()) {
			
			echo "modide uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}*/
	
}
?>