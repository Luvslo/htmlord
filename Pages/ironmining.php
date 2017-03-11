<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	$upgrade_error="";
	$upgrade_error2="";
	
	$workforce_input_error="";

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$res=$Resources->getUser ($user_id);
	$levels=$Levels->getUser ($user_id);
	
	foreach($levels as $l){
		$iron_work=$l->iron_work;
		$iron_tools=$l->iron_tools;
	}
	
	$WorkRes=$Levels->getStep ($iron_work);
	$ToolsRes=$Levels->getStep ($iron_tools);
	
	foreach($res as $r) {
		$workforce=$r->workforce;
		$food=$r->food;
		$stone=$r->stone;
		$coins=$r->coins;
		$iron=$r->iron;
		$wood=$r->wood;
	}
	
	if (isset($_GET["work"])) {
		
		if($stone >= $WorkRes->res and $coins >= $WorkRes->res){
			$Resources->updateStone($user_id, $WorkRes->res*-1);
			$Resources->updateCoins($user_id, $WorkRes->res*-1);
			$Modifiers->update($user_id, 0, 0, 1, 0, 0, 0);
			$Levels->update($user_id, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0);
			header("Location: ironmining.php");
		} else {
			$upgrade_error="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if (isset($_GET["tools"])) {
		
		if($iron >= $ToolsRes->res and $wood >= $ToolsRes->res){
			$Resources->updateIron($user_id, $ToolsRes->res*-1);
			$Resources->updateWood($user_id, $ToolsRes->res*-1);
			$Modifiers->update($user_id, 0, 0, 1, 0, 0, 0);
			$Levels->update($user_id, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0);
			header("Location: ironmining.php");
		} else {
			$upgrade_error2="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if(isset($_POST['workforce_input'])and isset ($_POST['time_input'])){
		if ($_POST['workforce_input']>=1 and $_POST['workforce_input']<=$workforce and $_POST['workforce_input']*$_POST['time_input']<=$food){
			$Actions->save($user_id, 'ironmining', cleanInput($_POST['workforce_input']),cleanInput($_POST['time_input']));
			$Resources->updateWorkforce($user_id, cleanInput($_POST['workforce_input']*-1));
			$Resources->updateFood($user_id, cleanInput($_POST['workforce_input'])*-1*cleanInput($_POST['time_input']));
			header("Location: data.php");
		} else {
			$workforce_input_error="min=1, max=sinu toojoud/sinu toit";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Rauakaevandus</title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1>Sinu rauakaevandus</h1>
		<a href="data.php">Tagasi</a>
		<br>
		<p>
			Siin saad sa hallata oma rauakaevandust.<br>
			
			<br><br>
			Sinu ressursid:
			<?php require("../resources_table.php"); echo $html;?>
		</p>
		<p>Sisesta mitu inimest soovid rauakaevandusse rakendada: </p>
		<form method="POST">
			<select name="time_input">
				<option value="1">1h</option>
				<option value="2">2h</option>
				<option value="3">3h</option>
				<option value="4">4h</option>
				<option value="5">5h</option>
				<option value="6">6h</option>
				<option value="7">7h</option>
			</select>		
			<input name="workforce_input" type="number"> <?php echo $workforce_input_error;?><br>
			<input type="submit" value="Rakenda"><br>
			<button type="submit" name="workforce_input" value="<?php echo $workforce;?>">Rakenda koik (<?php echo $workforce;?>)</button><br>
			<br><p>PS! Iga sisestatud inimese jaoks on vaja 1 toiduyhik.</p>
			<p>
				Sinu rauakaevanduse tase on <?php echo $iron_work;?><br>
				Sul on vaja <?php echo $WorkRes->res;?> kivi ja <?php echo $WorkRes->res;?> raha, et kaevandust uuendada.<br>
				<a href="ironmining.php?work=true">Uuenda!</a> <?php echo $upgrade_error;?><br><br>
				Sinu kaevandamise tooriistade tase on <?php echo $iron_tools;?><br>
				Sul on vaja <?php echo $ToolsRes->res;?> puitu ja <?php echo $ToolsRes->res;?> rauda, et tooriistu uuendada.<br>
				<a href="ironmining.php?tools=true">Uuenda!</a> <?php echo $upgrade_error2;?><br><br>
			</p>
				
		</form>
	</body>
</html>
