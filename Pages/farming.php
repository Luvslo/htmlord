<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	
	$upgrade_error="";
	$upgrade_error2="";
	$upgrade_error3="";
	
	$workforce_input_error="";
	
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
	$levels=$Levels->getUser ($user_id);
	
	foreach($levels as $l){
		$food_work=$l->food_work;
		$food_fert=$l->food_fert;
		$food_tools=$l->food_tools;
	}
	
	$WorkRes=$Levels->getStep ($food_work);
	$FertRes=$Levels->getStep ($food_fert);
	$ToolsRes=$Levels->getStep ($food_tools);
	
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
			$Modifiers->update($user_id, 0, 0, 0, 0, 0, 1);
			$Levels->update($user_id, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0);
			header("Location: farming.php");
		} else {
			$upgrade_error="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if (isset($_GET["fert"])) {
		
		if($coins >= $FertRes->res*2){
			$Resources->updateCoins($user_id, $FertRes->res*-2);
			$Modifiers->update($user_id, 0, 0, 0, 0, 0, 1);
			$Levels->update($user_id, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0);
			header("Location: farming.php");
		} else {
			$upgrade_error2="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if (isset($_GET["tools"])) {
		
		if($iron >= $ToolsRes->res and $wood >= $ToolsRes->res){
			$Resources->updateIron($user_id, $ToolsRes->res*-1);
			$Resources->updateWood($user_id, $ToolsRes->res*-1);
			$Modifiers->update($user_id, 0, 0, 0, 0, 0, 1);
			$Levels->update($user_id, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
			header("Location: farming.php");
		} else {
			$upgrade_error3="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if(isset($_POST['workforce_input'])and isset ($_POST['time_input'])){
		if ($_POST['workforce_input']>=1 and $_POST['workforce_input']<=$workforce ){
			$Actions->save($user_id, 'farming', cleanInput($_POST['workforce_input']), cleanInput($_POST['time_input']));
			$Resources->updateWorkforce($user_id, cleanInput($_POST['workforce_input']*-1));
			header("Location: data.php");
		} else {
			$workforce_input_error="min=1, max=sinu toojoud";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Farms</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
		<h1>Your farms</h1>
		<p>
			Siin saad sa hallata oma farme.<br>
		</p>
		<p>Sisesta mitu inimest soovid pollumajandusse rakendada: </p>
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
			<button type="submit" name="workforce_input" value="<?php echo $workforce;?>">Rakenda koik (<?php echo $workforce;?>)</button>
		</form>
		<p>
			Sinu pollumajanduse tase on <?php echo $food_work;?><br>
			Sul on vaja <?php echo $WorkRes->res;?> kivi ja <?php echo $WorkRes->res;?> raha, et pollumajandust uuendada.<br>
			<a href="farming.php?work=true">Uuenda!</a> <?php echo $upgrade_error;?><br><br>
			Sinu pollumajanduse vaetise tase on <?php echo $food_fert;?><br>
			Sul on vaja <?php echo $FertRes->res*2;?> raha, et vaetist uuendada.<br>
			<a href="farming.php?fert=true">Uuenda!</a> <?php echo $upgrade_error2;?><br><br>
			Sinu pollumajanduse tooriistade tase on <?php echo $food_tools;?><br>
			Sul on vaja <?php echo $ToolsRes->res;?> puitu ja <?php echo $ToolsRes->res;?> rauda, et tooriistu uuendada.<br>
			<a href="farming.php?tools=true">Uuenda!</a> <?php echo $upgrade_error3;?><br><br>
		</p>
		<?php require("../layout2.php");?>
	</body>
</html>

