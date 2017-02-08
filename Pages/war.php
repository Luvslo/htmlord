<?php
	require("../function.php");
	
	$resource_error="";

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$res=$Resources->getUser ($user_id);
	$cstats=$Combat->getUserStats ($user_id);
	
	foreach($cstats as $cs){
		$attack_mod=$cs->attack_mod;
		$defence_mod=$cs->defence_mod;
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

	if(isset($_POST['category_input'])and isset ($_POST['time_input'])){
		if($_POST['time_input']*1000<=$food and $_POST['time_input']*2000<=$coins){
				if($_POST['category_input']=='attack_training'){
					$Actions->save($user_id, 'attack_training', 1,$_POST['time_input']);
				}else{
					$Actions->save($user_id, 'defence_training', 1,$_POST['time_input']);
				}
			$Resources->updateCoins($user_id, $_POST['time_input']*-2000);
			$Resources->updateFood($user_id, $_POST['time_input']*-1000);
			header("Location: data.php");
		}else{
			$resource_error="You dont have enough resources";
		}
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