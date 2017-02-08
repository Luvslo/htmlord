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
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sinu territoorium</title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1>Sinu territoorium</h1>
		<a href="?logout=1">Logi valja</a><br>
		<a href="forum.php">Foorum</a><br>
		<a href="leaderboard.php">Edetabel</a>
		<br>
		<p>
			Tere tulemast <?=$_SESSION["username"];?>!
			<br>
			Siin saad sa valitseda oma rahva ule.<br>
			Mangid esimest korda? Vaikese ulevaate saad <a href="intro.php">siit!</a>
			<br><br>
			Sinu ressursid:
		</p>
	</body>
</html>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Wood</th>";
			$html .="<th>Food</th>";
			$html .="<th>Coins</th>";
			$html .="<th>Stone</th>";
			$html .="<th>Iron</th>";
			$html .="<th>Workforce</th>";
		$html .="</tr>";

		foreach($res as $r) {
			$html .="<tr>";
				$html .="<td><div align='center'>".$r->wood."</div></td>";
				$html .="<td><div align='center'>".$r->food."</div></td>";
				$html .="<td><div align='center'>".$r->coins."</div></td>";
				$html .="<td><div align='center'>".$r->stone."</div></td>";
				$html .="<td><div align='center'>".$r->iron."</div></td>";
				$html .="<td><div align='center'>".$r->workforce."</div></td>";
			$html .="</tr>";
		}	
	$html .="</table>";
	echo $html;
?> 
<p>Command: <br>
	<a href="woodcutting.php">Woodcutters huts</a><br>
	<a href="farming.php">Farms</a><br>
	<a href="trading.php">Market</a><br>
	<a href="stonemining.php">Quarry</a><br>
	<a href="ironmining.php">Iron mines</a><br>
	<a href="people.php">Houses</a><br>
	<a href="war.php">War office</a>
</p>

<p>Sinu tegevused: </p>
<?php

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
		if($action_category=='attack_mod'){
			$Combat->updateStats($action_user_id,0.005*$action_time_input,0);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
		if($action_category=='defence_mod'){
			$Combat->updateStats($action_user_id,0,0.005*$action_time_input);
			$Actions->delet($_GET["action_id"]);
			header("Location: data.php");
		}
	}

	$html="<table>";
		$html .="<tr>";
			$html .="<th>Action</th>";
			$html .="<th>Workforce</th>";
			$html .="<th>Created</th>";
			$html .="<th>Status</th>";
		$html .="</tr>";

		foreach($action as $a) {
			$strcreated=strtotime($a->created)+$a->time_input*3600-$current_datetime;
			if ($strcreated <= 0){
				$msg="<td><a href='data.php?action_id=".$a->id."'>Ready!</a></td>";
			} else {
				$msg="<td>".gmdate('H:i:s', $strcreated)."</td>";
			}
			$html .="<tr>";
				$html .="<td>".$a->category."</td>";
				$html .="<td>".$a->workforce_input."</td>";
				$html .="<td>".$a->created."</td>";
				$html .=$msg;
			$html .="</tr>";

		}	
	$html .="</table>";
	echo $html;
?> 