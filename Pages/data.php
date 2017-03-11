<?php
	require("../function.php");
	
	$current_date=date("Y-m-d");
	$current_time=date("H:i:s");
	$current_datetime=strtotime("now");
	$value=strtotime("+1 Hours");
	
	$user_id=($_SESSION["userId"]);

	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	$res=$Resources->getUser ($user_id);
	$mods=$Modifiers->getUser ($user_id);
	$action=$Actions->getUser ($user_id);
	$count=$Message->getUnReadCount ($user_id);
	$unread_count=$count->unread_count;
	
	foreach($mods as $m) {
		$wood_mod=$m->wood_mod;
		$stone_mod=$m->stone_mod;
		$iron_mod=$m->iron_mod;
		$coins_mod=$m->coins_mod;
		$population_mod=$m->population_mod;
		$food_mod=$m->food_mod;
	}
	
	if (isset($_GET["action_id"])){
		$SRes=$Actions->getSingle ($_GET["action_id"]);
		$action_user_id=$SRes->user_id;
		$action_category=$SRes->category;
		$action_workforce_input=$SRes->workforce_input;
		$action_time_input=$SRes->time_input;
	
		if($action_category=='populate'){
			$Resources->updateWorkforce($action_user_id,$action_workforce_input*$population_mod*$action_time_input);
			$Resources->updatePopulation($action_user_id,$action_workforce_input*$population_mod*2*$action_time_input);
			$Resources->updateWorkforce($action_user_id,$action_workforce_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='woodcutting'){
			$Resources->updateWood($action_user_id,$action_workforce_input*$wood_mod*$action_time_input);
			$Resources->updateWorkforce($action_user_id,$action_workforce_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='ironmining'){
			$Resources->updateIron($action_user_id,$action_workforce_input*$iron_mod*$action_time_input);
			$Resources->updateWorkforce($action_user_id,$action_workforce_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='stonemining'){
			$Resources->updateStone($action_user_id,$action_workforce_input*$stone_mod*$action_time_input);
			$Resources->updateWorkforce($action_user_id,$action_workforce_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='trading'){
			$Resources->updateCoins($action_user_id,$action_workforce_input*$coins_mod*$action_time_input);
			$Resources->updateWorkforce($action_user_id,$action_workforce_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='farming'){
			$Resources->updateFood($action_user_id,$action_workforce_input*$food_mod*$action_time_input);
			$Resources->updateWorkforce($action_user_id,$action_workforce_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='attack_training'){
			$Combat->updateStats($action_user_id,0.005*$action_time_input,0);
			$Actions->delet($_GET["action_id"]);
			$_SESSION["war_training"]=false;
			header("Location: data.php");
		}
		if($action_category=='defence_training'){
			$Combat->updateStats($action_user_id,0,0.005*$action_time_input);
			$Actions->delet($_GET["action_id"]);
			$_SESSION["war_training"]=false;
			header("Location: data.php");
		}
	}
	
	$html2="<table>";
		$html2 .="<tr>";
			$html2 .="<th>Action</th>";
			$html2 .="<th>Workforce</th>";
			$html2 .="<th>Created</th>";
			$html2 .="<th>Status</th>";
		$html2 .="</tr>";

		foreach($action as $a) {
			$strcreated=strtotime($a->created)+$a->time_input*3600-$current_datetime;
			if ($strcreated <= 0){
				$msg="<td><a href='data.php?action_id=".$a->id."'>Ready!</a></td>";
			} else {
				$msg="<td>".gmdate('H:i:s', $strcreated)."</td>";
			}
			$html2 .="<tr>";
				$html2 .="<td>".$a->category."</td>";
				$html2 .="<td>".$a->workforce_input."</td>";
				$html2 .="<td>".$a->created."</td>";
				$html2 .=$msg;
			$html2 .="</tr>";

		}	
	$html2 .="</table>";

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sinu territoorium</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php include_once("../analyticstracking.php") ?>
	
		<?php require("../layout1.php");?>
		<h2>Your actions</h2>
		<?php echo $html2;?>
		<?php require("../layout2.php");?>
	</body>
</html>