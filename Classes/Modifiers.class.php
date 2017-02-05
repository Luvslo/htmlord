<?php 
class Modifiers {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function signUp($user_id){
		
		$stmt = $this->connection->prepare("INSERT INTO user_modifiers (user_id, wood_mod, stone_mod, iron_mod, coins_mod, population_mod, food_mod) VALUES (?,1,1,1,5,1,1)");
		
		$stmt->bind_param("i", $user_id);
		
		if ($stmt->execute()) {
			
			echo " Modifierite loomine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}

	function getUser($user_id) {

		$stmt =$this->connection->prepare("SELECT user_id, wood_mod, stone_mod, iron_mod, coins_mod, population_mod, food_mod FROM user_modifiers WHERE user_id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($user_id, $wood_mod, $stone_mod, $iron_mod, $coins_mod, $population_mod, $food_mod);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$mods = new StdClass();
			$mods->user_id=$user_id;
			$mods->wood_mod=$wood_mod;
			$mods->stone_mod=$stone_mod;
			$mods->iron_mod=$iron_mod;
			$mods->coins_mod=$coins_mod;
			$mods->population_mod=$population_mod;
			$mods->food_mod=$food_mod;
			
			array_push($result, $mods);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function update($user_id, $wood_mod, $stone_mod, $iron_mod, $coins_mod, $population_mod, $food_mod){
		
		$stmt = $this->connection->prepare("UPDATE user_modifiers SET wood_mod=wood_mod+?, stone_mod=stone_mod+?, iron_mod=iron_mod+?, coins_mod=coins_mod+?, population_mod=population_mod+?, food_mod=food_mod+? WHERE user_id=?");
		
		$stmt->bind_param("iiiiiii",$wood_mod, $stone_mod, $iron_mod, $coins_mod, $population_mod, $food_mod, $user_id);
		
		if ($stmt->execute()) {
			
			echo "modide uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
} 
?>