<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);

	$workforce_input_error="";
	$upgrade_error="";
	$upgrade_error2="";
	
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	$res=$Resources->getUser ($user_id);
	$levels=$Levels->getUser ($user_id);
	
	foreach($levels as $l){
		$wood_work=$l->wood_work;
		$wood_tools=$l->wood_tools;
	}
	
	$WorkRes=$Levels->getStep ($wood_work);
	$ToolsRes=$Levels->getStep ($wood_tools);

	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Puutoostus</title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1>Sinu puutoostus</h1>
		<a href="data.php">Tagasi</a>
		<br>
		<p>
			Siin saad sa hallata oma puutoostust.
			
			<br><br>
			Sinu ressursid:
		</p>
	</body>
</html>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Puit</th>";
			$html .="<th>Kivi</th>";
			$html .="<th>Raud</th>";
			$html .="<th>Raha</th>";
			$html .="<th>Toojoud</th>";
			$html .="<th>Toit</th>";
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
			$workforce=$r->workforce;
			$food=$r->food;
			$stone=$r->stone;
			$coins=$r->coins;
			$iron=$r->iron;
			$wood=$r->wood;
		}	
	$html .="</table>";
	echo $html;
	
	if (isset($_GET["work"])) {
		
		if($stone >= $WorkRes->res and $coins >= $WorkRes->res){
			$Resources->updateStone($user_id, $WorkRes->res*-1);
			$Resources->updateCoins($user_id, $WorkRes->res*-1);
			$Modifiers->update($user_id, 1, 0, 0, 0, 0, 0);
			$Levels->update($user_id, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			header("Location: woodcutting.php");
		} else {
			$upgrade_error="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if (isset($_GET["tools"])) {
		
		if($iron >= $ToolsRes->res and $wood >= $ToolsRes->res){
			$Resources->updateIron($user_id, $ToolsRes->res*-1);
			$Resources->updateWood($user_id, $ToolsRes->res*-1);
			$Modifiers->update($user_id, 1, 0, 0, 0, 0, 0);
			$Levels->update($user_id, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			header("Location: woodcutting.php");
		} else {
			$upgrade_error2="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if(isset($_POST['workforce_input'])and isset ($_POST['time_input'])){
		if ($_POST['workforce_input']>=1 and $_POST['workforce_input']<=$workforce and $_POST['workforce_input']*$_POST['time_input']<=$food){
			$Actions->save($user_id, 'woodcutting', $_POST['workforce_input'],$_POST['time_input']);
			$Resources->updateWorkforce($user_id, $_POST['workforce_input']*-1);
			$Resources->updateFood($user_id, $_POST['workforce_input']*-1*$_POST['time_input']);
			header("Location: data.php");
		} else {
			$workforce_input_error="min=1, max=sinu toojoud/sinu toit";
		}
	}
?> 
<p>Sisesta mitu inimest soovid puutoostusesse rakendada: </p>
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
		Sinu puutoostuse tase on <?php echo $wood_work;?><br>
		Sul on vaja <?php echo $WorkRes->res;?> kivi ja <?php echo $WorkRes->res;?> raha, et puutoostust uuendada.<br>
		<a href="woodcutting.php?work=true">Uuenda!</a> <?php echo $upgrade_error;?><br><br>
		Sinu puutootajate tooriistade tase on <?php echo $wood_tools;?><br>
		Sul on vaja <?php echo $ToolsRes->res;?> puitu ja <?php echo $ToolsRes->res;?> rauda, et tooriistu uuendada.<br>
		<a href="woodcutting.php?tools=true">Uuenda!</a> <?php echo $upgrade_error2;?><br><br>
	</p>		
		
</form>