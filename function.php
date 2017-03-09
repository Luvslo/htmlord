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
	
	require("../Classes/Data.class.php");
	$Data = new Data($mysqli);
	
	require("../Classes/Message.class.php");
	$Message = new Message($mysqli);
	
	function casCalc ($att_points, $def_points){
		$def_cas=0;
		$att_cas=0;
		$max_def_cas=0.1;
		$max_att_cas=0.2;
		$rand_pro=rand(-0.03,0.03);
		$multiplier=5;
		$sum=$att_points+$def_points;
		$dis=abs($att_points-$def_points);
		$lose_pro=$dis/$sum;
		
		if ($att_points<=$def_points){
			$att_cas=$lose_pro+$rand_pro;
		}else{
			$def_cas=$lose_pro+$rand_pro;
		}
		if($att_cas>$max_att_cas){$att_cas=$max_att_cas;}
		if($def_cas>$max_def_cas){$def_cas=$max_def_cas;}
		
		$procent=array($att_cas,$def_cas);
		return $procent;
	}
?>