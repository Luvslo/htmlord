<?php
	require("../function.php");
	
	$resource_error="";

	$player_id=($_SESSION["userId"]);
	$user_id=($_GET["user_id"]);
	$Username=$User->getUsername($user_id);
	$username=$Username->username;
	
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$res=$Resources->getUser ($user_id);
	$pres=$Resources->getUser ($player_id);
	$cstats=$Combat->getUserStats ($user_id);
	
	foreach($cstats as $cs){
		$attack_mod=$cs->attack_mod;
		$defence_mod=$cs->defence_mod;
	}
	foreach($pres as $pr){
		$pfood=$pr->food;
		$pcoins=$pr->coins;
		$pworkforce=$pr->workforce;
	}
	foreach($res as $r){
		$wood=$r->wood;
		$food=$r->food;
		$coins=$r->coins;
		$stone=$r->stone;
		$iron=$r->iron;
		$population=$r->population;
	}
	$available_res=$wood+$food+$coins+$stone+$iron;

?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $username; ?></title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1><?php echo $username; ?></h1>
		<a href="leaderboard.php">Back</a>
		<br>
		<p>
			You are visiting <?php echo $username;?>'s lands
			<br>
			<?php echo $username;?>'s population is <?php echo $population;?>
			<br>
			People here have <?php echo $available_res;?> available resources.
			<br><br>
		</p>
	</body>
</html>
<?php

	if(isset($_POST['workforce_input'])){
		if($user_id==$player_id){
			$resource_error="You can't attack your own land.";
		}else{
			if($_POST['workforce_input']<=$pfood and $_POST['workforce_input']*2<=$pcoins and $_POST['workforce_input']>=1 and $_POST['workforce_input']<=$pworkforce ){
				$Attacks->save($player_id, $user_id, $_POST['workforce_input']);
				$Resources->updateWorkforce($player_id, $_POST['workforce_input']*-1);
				$Resources->updateCoins($player_id, $_POST['workforce_input']*-2);
				$Resources->updateFood($player_id, $_POST['workforce_input']*-1);
				header("Location: data.php");
			}else{
				$resource_error="Invalid input";
			}
		}
	}
?> 

<form method="POST">
	<p>
		You can attack these lands to steal its resources <br>
		but consider the fact that war is harsh and people will die.<br>
		This may ruin your diplomatic relations with that kingdom<br><br>
		*An attack will take 1h to complete.<br>
		*Victim will be notified about the attack and he/she can prepare.<br>
		*Each deployed soilder needs 1 food (you have <?php echo $pfood;?>) and 2 coins (you have <?php echo $pcoins;?>).<br><br>
		Insert the number of soilders to depoly (you have <?php echo $pworkforce;?> available workforce).
	</p>	
	<input name="workforce_input" type="number"><br>
	<input type="submit" value="Attack"><?php echo $resource_error;?>
</form>