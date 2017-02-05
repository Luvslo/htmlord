<?php 
class Levels {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function signUp($user_id){

		$stmt = $this->connection->prepare("INSERT INTO user_levels (user_id, wood_work, wood_tools, stone_work, stone_tools, iron_work, iron_tools, coins_work, coins_tools, population_work, food_work, food_fert, food_tools) VALUES (?,1,1,1,1,1,1,1,1,1,1,1,1)");
		
		$stmt->bind_param("i", $user_id);
		
		if ($stmt->execute()) {
			
			echo " Levelite loomine onnestus! Void nuud sisse logida.";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();

	}
	
	function getStep($level){

		$stmt = $this->connection->prepare("SELECT res FROM `levels` WHERE level=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $level);
		$stmt->bind_result($res);
		$stmt->execute();

		$LRes = new Stdclass();

		if($stmt->fetch()){
			$LRes->res = $res;
		}else{
			exit();
		}
		$stmt->close();
		
		return $LRes;
	}
	
	function update($user_id, $wood_work, $wood_tools, $stone_work, $stone_tools, $iron_work, $iron_tools, $coins_work, $coins_tools, $population_work, $food_work, $food_fert, $food_tools){
		
		$stmt = $this->connection->prepare("
		UPDATE user_levels 
		SET wood_work=wood_work+?, wood_tools=wood_tools+?, stone_work=stone_work+?, stone_tools=stone_tools+?, iron_work=iron_work+?, iron_tools=iron_tools+?, coins_work=coins_work+?, coins_tools=coins_tools+?, population_work=population_work+?, food_work=food_work+?, food_fert=food_fert+?, food_tools=food_tools+?
		WHERE user_id=?
		");
		
		$stmt->bind_param("iiiiiiiiiiiii",$wood_work, $wood_tools, $stone_work, $stone_tools, $iron_work, $iron_tools, $coins_work, $coins_tools, $population_work, $food_work, $food_fert, $food_tools, $user_id);
		
		if ($stmt->execute()) {
			
			echo "levelite uuendamine onnestus! ";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
	function getUser ($user_id) {
		
		$stmt = $this->connection->prepare("SELECT user_id, wood_work, wood_tools, stone_work, stone_tools, iron_work, iron_tools, coins_work, coins_tools, population_work, food_work, food_fert, food_tools FROM user_levels WHERE user_id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($user_id, $wood_work, $wood_tools, $stone_work, $stone_tools, $iron_work, $iron_tools, $coins_work, $coins_tools, $population_work, $food_work, $food_fert, $food_tools);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$levels = new StdClass();
			$levels->user_id=$user_id;
			$levels->wood_work=$wood_work;
			$levels->wood_tools=$wood_tools;
			$levels->stone_work=$stone_work;
			$levels->stone_tools=$stone_tools;
			$levels->iron_work=$iron_work;
			$levels->iron_tools=$iron_tools;
			$levels->coins_work=$coins_work;
			$levels->coins_tools=$coins_tools;
			$levels->population_work=$population_work;
			$levels->food_work=$food_work;
			$levels->food_fert=$food_fert;
			$levels->food_tools=$food_tools;

			array_push($result, $levels);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	

	
} 
?>