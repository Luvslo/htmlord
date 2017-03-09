<?php
	require("../function.php");
	
	$current_datetime=strtotime("now");
	
	$resource_error="";

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$res=$Resources->getUser ($user_id);
	$cstats=$Combat->getUserStats ($user_id);
	$attacks=$Attacks->getUser ($user_id);
	$defences=$Attacks->getUserDefences ($user_id);
	
	
	foreach($cstats as $cs){
		$attack_mod=$cs->attack_mod;
		$defence_mod=$cs->defence_mod;
	}
	foreach($res as $r) {
		$food=$r->food;
		$coins=$r->coins;
		$iron=$r->iron;
		$stone=$r->stone;
		$workforce=$r->workforce;
		$wood=$r->wood;
	}
	
	if (isset($_GET["victim_id"])) {
		$attack_id=$_GET["attack_id"];
		$victim_id=$_GET["victim_id"];
		
		$victim_cstats=$Combat->getUserStats ($victim_id);
		foreach($victim_cstats as $vcs){$victim_defence_mod=$vcs->defence_mod;}
		
		$victim_res=$Resources->getUser ($victim_id);
		foreach($victim_res as $vr){
			$victim_workforce=$vr->workforce;
			$victim_wood=$vr->wood;
			$victim_stone=$vr->stone;
			$victim_iron=$vr->iron;
			$victim_coins=$vr->coins;
			$victim_food=$vr->food;
			
		}
		
		$def_points=$victim_defence_mod*$victim_workforce;
		
		$single_attack=$Attacks->getSingle($attack_id);
		$attack_workforce=$single_attack->workforce_input;
		
		$att_points=$attack_mod*$attack_workforce;
		
		$casualties=casCalc($att_points, $def_points);
		$att_cas=$casualties[0];
		$def_cas=$casualties[1];
		
		$Resources->updateIron($user_id, round($victim_iron*$def_cas));
		$Resources->updateIron($victim_id, round($victim_iron*$def_cas*(-1)));
		
		$Resources->updateWood($victim_id, round($victim_wood*$def_cas*(-1)));
		$Resources->updateWood($user_id, round($victim_wood*$def_cas));
		
		$Resources->updateCoins($user_id, round($victim_coins*$def_cas));
		$Resources->updateCoins($victim_id, round($victim_coins*$def_cas*(-1)));
		
		$Resources->updateStone($victim_id, round($victim_stone*$def_cas*(-1)));
		$Resources->updateStone($user_id, round($victim_stone*$def_cas));
		
		$Resources->updateFood($user_id, round($victim_food*$def_cas));
		$Resources->updateFood($victim_id, round($victim_food*$def_cas*(-1)));
		
		$Resources->updateWorkforce($victim_id, round($victim_workforce*$def_cas*(-1)));
		$Resources->updateWorkforce($user_id, round($attack_workforce*(1-$att_cas)));
		
		$Resources->updatePopulation($user_id, round($attack_workforce*$att_cas*(-2)));
		$Resources->updatePopulation($victim_id, round($victim_workforce*$def_cas*(-2)));
		
		$Attacks->delet($attack_id);
		
		if ($att_points>=$def_points){
			
			$Message->save(47, $user_id, "Attack report", "
			You won! \n
			Your army defeated user ".$victim_id."'s defences and collected: \n
			".round($victim_iron*$def_cas)." iron \n
			".round($victim_wood*$def_cas)." wood \n
			".round($victim_stone*$def_cas)." stone \n
			".round($victim_coins*$def_cas)." coins \n
			".round($victim_food*$def_cas)." food \n
			All your soldiers returned.");	
			
			$Message->save(47, $victim_id, "Defence report", "
			Your defences got defeated by user ".$user_id."'s army and you lost: \n
			".round($victim_iron*$def_cas)." iron \n
			".round($victim_wood*$def_cas)." wood \n
			".round($victim_stone*$def_cas)." stone \n
			".round($victim_coins*$def_cas)." coins \n
			".round($victim_food*$def_cas)." food \n
			You lost ".round($victim_workforce*$def_cas*(-1)." good men."));
			
		}else{
			
			$Message->save(47, $user_id, "Attack report", "Your army wasn't able to \n 
			defeat user ".$victim_id."s defences. \n
			".$attack_workforce." of sent forces returned ".$attack_workforce*(1-$att_cas)."");
			
			$Message->save(47, $victim_id, "Defence report", "You were able to defend \n 
			user ".$user_id."s attack against you. \n
			");
		}
		
		header("Location: war.php");
	}
	
	if (isset($_GET["attacker_id"])) {
		$attack_id=$_GET["attack_id"];
		$attacker_id=$_GET["attacker_id"];
		
		$attacker_cstats=$Combat->getUserStats ($attack_id);
		foreach($attacker_cstats as $acs){$attacker_attack_mod=$acs->attack_mod;}
		
		$attacker_res=$Resources->getUser ($attacker_id);
		foreach($attacker_res as $ar){
			$attacker_workforce=$ar->workforce;
			$attacker_wood=$ar->wood;
			$attacker_stone=$ar->stone;
			$attacker_iron=$ar->iron;
			$attacker_coins=$ar->coins;
			$attacker_food=$ar->food;
			
		}
		
		$single_attack=$Attacks->getSingle($attack_id);
		$attack_workforce=$single_attack->workforce_input;
		
		$att_points=$attacker_attack_mod*$attack_workforce;
		$def_points=$defence_mod*$workforce;
		
		$casualties=casCalc($att_points, $def_points);
		$att_cas=$casualties[0];
		$def_cas=$casualties[1];
		
		$Resources->updateIron($user_id, round($iron*$def_cas*(-1)));
		$Resources->updateIron($attacker_id, round($iron*$def_cas));
		
		$Resources->updateWood($attacker_id, round($wood*$def_cas));
		$Resources->updateWood($user_id, round($wood*$def_cas*(-1)));
		
		$Resources->updateCoins($user_id, round($coins*$def_cas*(-1)));
		$Resources->updateCoins($attacker_id, round($coins*$def_cas));
		
		$Resources->updateStone($attacker_id, round($stone*$def_cas));
		$Resources->updateStone($user_id, round($stone*$def_cas*(-1)));
		
		$Resources->updateFood($user_id, round($food*$def_cas*(-1)));
		$Resources->updateFood($attacker_id, round($food*$def_cas));
		
		$Resources->updateWorkforce($attacker_id, round($attack_workforce*(1-$att_cas)));
		$Resources->updateWorkforce($user_id, round($workforce*$def_cas*(-1)));
		
		$Resources->updatePopulation($attacker_id, round($attack_workforce*$att_cas*(-2)));
		$Resources->updatePopulation($user_id, round($workforce*$def_cas*(-2)));
		
		$Attacks->delet($attack_id);
		
		if ($att_points>=$def_points){
			
			$Message->save(47, $attacker_id, "Attack report", "
			You won! \n
			Your army defeated user ".$user_id."'s defences and collected: \n
			".round($iron*$def_cas)." iron \n
			".round($wood*$def_cas)." wood \n
			".round($stone*$def_cas)." stone \n
			".round($coins*$def_cas)." coins \n
			".round($food*$def_cas)." food \n
			All your soldiers returned.");	
			
			$Message->save(47, $user_id, "Defence report", "
			Your defences got defeated by user ".$attacker_id."'s army and you lost: \n
			".round($iron*$def_cas)." iron \n
			".round($wood*$def_cas)." wood \n
			".round($stone*$def_cas)." stone \n
			".round($coins*$def_cas)." coins \n
			".round($food*$def_cas)." food \n
			You lost ".round($workforce*$def_cas*(-1)." good men."));
			
		}else{
			
			$Message->save(47, $attacker_id, "Attack report", "Your army wasn't able to \n 
			defeat user ".$user_id."s defences. \n
			".$attack_workforce." of sent forces returned ".$attack_workforce*(1-$att_cas)."");
			
			$Message->save(47, $user_id, "Defence report", "You were able to defend \n 
			user ".$attacker_id."s attack against you. \n
			");
		}
		
		header("Location: war.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>War office</title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1>Your war office</h1>
		<a href="data.php">Back</a>
		<br>
		<p>
			Here you can learn new tactics and war strategies to be<br>
			more efficent in combat.
			<br><br>
			Your attackers efficiency is <?php echo $attack_mod;?><br>
			Your defenders efficiency is <?php echo $defence_mod;?>
			<br><br>
			Your resources:
		</p>
	</body>
</html>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Wood</th>";
			$html .="<th>Stone</th>";
			$html .="<th>Iron</th>";
			$html .="<th>Coins</th>";
			$html .="<th>Workforce</th>";
			$html .="<th>Food</th>";
		$html .="</tr>";

		foreach($res as $r) {
			$html .="<tr>";
				$html .="<td>".$r->wood."</td>";
				$html .="<td>".$r->stone."</td>";
				$html .="<td>".$r->iron."</td>";
				$html .="<td>".$r->coins."</td>";
				$html .="<td>".$r->workforce."</td>";
				$html .="<td>".$r->food."</td>";
			$html .="</tr>";
			$food=$r->food;
			$coins=$r->coins;
		}	
	$html .="</table>";
	echo $html;

	if(isset($_POST['category_input'])and isset ($_POST['time_input']) and $_SESSION["war_training"]==false){
		if($_POST['time_input']*1000<=$food and $_POST['time_input']*2000<=$coins){
			$Resources->updateCoins($user_id, cleanInput($_POST['time_input'])*-2000);
			$Resources->updateFood($user_id, cleanInput($_POST['time_input'])*-1000);
			if($_POST['category_input']=='attack_training'){
				$Actions->save($user_id, 'attack_training', 1,cleanInput($_POST['time_input']));
			}else{
				$Actions->save($user_id, 'defence_training', 1,cleanInput($_POST['time_input']));
			}
			header("Location: data.php");
		}else{
			$resource_error="You dont have enough resources";
		}
	}
	if($_SESSION["war_training"]==true){
		$resource_error="You are already training";
	}
?> 
<p>
	New strategies and outlandish teachers are very difficult<br>
	to come by so learning is very costly and meant for<br>
	end-game players only.<br>
</p>
<form method="POST">
	<p>Select what kind of strategies do you want to study.</p>
	<select name="category_input">
		<option value="attack_training">Attack strategies</option>
		<option value="defence_training">Defence strategies</option>
	</select><br>
	
	<p>How many hours do you want to study?</p>
	<select name="time_input">
		<option value="1">1h - 2k coins, 1k food</option>
		<option value="2">2h - 4k coins, 2k food</option>
		<option value="3">3h - 6k coins, 3k food</option>
		<option value="4">4h - 8k coins, 4k food</option>
		<option value="5">5h - 10k coins, 5k food</option>
		<option value="6">6h - 12k coins, 6k food</option>
		<option value="7">7h - 14k coins, 7k food</option>
	</select>
	<br><br>
	<input type="submit" value="Submit"><?php echo $resource_error;?>
		
</form>
<p>Your current attacks: </p>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Attacker</th>";
			$html .="<th>Victim</th>";
			$html .="<th>Category</th>";
			$html .="<th>Army size</th>";
			$html .="<th>Attack points</th>";
			$html .="<th>Started</th>";
			$html .="<th>Status</th>";
		$html .="</tr>";

		foreach($attacks as $a) {
			$strcreated=strtotime($a->created)+3600-$current_datetime;
			if ($strcreated <= 0){
				$msg="<td><a href='war.php?attack_id=".$a->id."&victim_id=".$a->victim_id."'>Ready!</a></td>";
			} else {
				$msg="<td>".gmdate('H:i:s', $strcreated)."</td>";
			}
			$html .="<tr>";
				$html .="<td>".$a->attacker_id."</td>";
				$html .="<td>".$a->victim_id."</td>";
				$html .="<td>".$a->category."</td>";
				$html .="<td>".$a->workforce_input."</td>";
				$html .="<td>".$attack_mod*$a->workforce_input."</td>";
				$html .="<td>".$a->created."</td>";
				$html .=$msg;
			$html .="</tr>";

		}	
	$html .="</table>";
	echo $html;
?>
<p>Your current defences: </p>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Attacker</th>";
			$html .="<th>Victim</th>";
			$html .="<th>Category</th>";
			$html .="<th>Started</th>";
			$html .="<th>Status</th>";
		$html .="</tr>";

		foreach($defences as $d) {
			$strcreated=strtotime($d->created)+3600-$current_datetime;
			if ($strcreated <= 0){
				$msg="<td><a href='war.php?attack_id=".$d->id."&attacker_id=".$d->attacker_id."'>Ready!</a></td>";
			} else {
				$msg="<td>".gmdate('H:i:s', $strcreated)."</td>";
			}
			$html .="<tr>";
				$html .="<td>".$d->attacker_id."</td>";
				$html .="<td>".$d->victim_id."</td>";
				$html .="<td>".$d->category."</td>";
				$html .="<td>".$d->created."</td>";
				$html .=$msg;
			$html .="</tr>";

		}	
	$html .="</table>";
	echo $html;
?>