<?php

	require("../../config.php");
	
	session_start();
	
	$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	
	function cleanInput($input) {
		
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		
		return $input;
	}
	
	require("../Classes/User.class.php");
	$User = new User($mysqli);
	
	require("../Classes/Resources.class.php");
	$Resources = new Resources($mysqli);
	
	require("../Classes/Modifiers.class.php");
	$Modifiers = new Modifiers($mysqli);
	
	require("../Classes/Actions.class.php");
	$Actions = new Actions($mysqli);
	
	require("../Classes/Levels.class.php");
	$Levels = new Levels($mysqli);
	
	require("../Classes/Leaderboard.class.php");
	$Leaderboard = new Leaderboard($mysqli);
	
	require("../Classes/Forum.class.php");
	$Forum = new Forum($mysqli);
	
	require("../Classes/Combat.class.php");
	$Combat = new Combat($mysqli);
	
	require("../Classes/Attacks.class.php");
	$Attacks = new Attacks($mysqli);
?>