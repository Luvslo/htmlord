<?php 
class Leaderboard {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function get () {

		$stmt = $this->connection->prepare("
		SELECT user_sample.username, user_resource.population, user_sample.created
		FROM user_resource
		JOIN user_sample
		ON user_resource.user_id=user_sample.id
		ORDER BY user_resource.population DESC 
		");
		
		echo $this->connection->error;

		$stmt->bind_result($username, $population, $created);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$lb = new StdClass();
			$lb->username=$username;
			$lb->population=$population;
			$lb->created=$created;
			
			array_push($result, $lb);
			
		}
		
		$stmt->close();
		
		return $result;
	}
} 
?>