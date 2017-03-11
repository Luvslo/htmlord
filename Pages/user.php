<?php
	require("../function.php");
	
	$resource_error="";

	$player_id=($_SESSION["userId"]);
	$user_id=($_GET["user_id"]);
	$Username=$User->getUsername($user_id);
	$username=$Username->username;
	
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
	$pres=$Resources->getUser ($player_id);
	$cstats=$Combat->getUserStats ($user_id);
	$data=$Data->getUser ($user_id);
	
	foreach($cstats as $cs){
		$attack_mod=$cs->attack_mod;
		$defence_mod=$cs->defence_mod;
	}
	foreach($pres as $pr){
		$pfood=$pr->food;
		$pcoins=$pr->coins;
		$pworkforce=$pr->workforce;
		$ppopulation=$pr->population;
	}
	foreach($res as $r){
		$wood=$r->wood;
		$food=$r->food;
		$coins=$r->coins;
		$stone=$r->stone;
		$iron=$r->iron;
		$population=$r->population;
	}
	foreach($data as $d){
		$reputation=$d->reputation;
		$authority=$d->authority;
	}
	
	$available_res=$wood+$food+$coins+$stone+$iron;
	
	if(isset($_POST['workforce_input'])){
		if($user_id==$player_id){
			$resource_error="You can't attack your own land.";
		}else{
			if($_POST['workforce_input']<=$pfood and $_POST['workforce_input']*2<=$pcoins and $_POST['workforce_input']>=1 and $_POST['workforce_input']<=$pworkforce ){
				$Attacks->save($player_id, $user_id, cleanInput($_POST['workforce_input']));
				$Resources->updateWorkforce($player_id, cleanInput($_POST['workforce_input']*-1));
				$Resources->updateCoins($player_id, cleanInput($_POST['workforce_input']*-2));
				$Resources->updateFood($player_id, cleanInput($_POST['workforce_input']*-1));
				$Message->save(47, $user_id, "Your land is under attack!", "Get more information at war office.");
				$Message->save(47, $player_id, "You are attacking!", "Get more information at war office.");
					if($population*2<$ppopulation){
						$Data->update($player_id,$reputation/2*-1);
					}else{
						$Data->update($player_id,$reputation/4*-1);
					}
				header("Location: data.php");
				$resource_error="Sorry, you can't attack people jet.";
			}else{
				$resource_error="Invalid input";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $username; ?></title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
	
		<h1><?php echo $username; ?></h1>
		<a href="send.php?user_id=<?php echo $user_id;?>">Send a message</a>

		<p>
			You are visiting <?php echo $username;?>'s lands
			<br>
			Information: <br>
			Population: <?php echo $population;?> <br>
			Available resources: <?php echo $available_res;?> <br>
			Reputation: <?php echo $reputation;?><br>
			Authority: <?php echo $authority;?>
			<br><br>
		</p>
		
		<form method="POST">
			<p>
				You can attack these lands to steal its resources <br>
				but consider the fact that war is harsh and people will die.<br>
				This may ruin your diplomatic relations with that kingdom<br><br>
				*An attack will take 1h to complete.<br>
				*Victim will be notified about the attack and he/she can prepare.<br>
				*Each deployed soldier needs 1 food (you have <?php echo $pfood;?>) and 2 coins (you have <?php echo $pcoins;?>).<br><br>
				Insert the number of soldiers to depoly (you have <?php echo $pworkforce;?> available workforce).
			</p>	
			<input name="workforce_input" type="number"><br>
			<input type="submit" value="Attack"><?php echo $resource_error;?>
		</form>
		<?php require("../layout2.php");?>
	</body>
</html>

