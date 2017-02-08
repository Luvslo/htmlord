<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$lb=$Leaderboard->get ();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edetabel</title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1>Edetabel</h1>
		<a href="data.php">Tagasi</a><br><br>
		
	</body>
</html>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Koht</th>";
			$html .="<th>Kasutajanimi</th>";
			$html .="<th>Populatsioon</th>";
			$html .="<th>Liitus</th>";
		$html .="</tr>";
		$counter=1;
		foreach($lb as $l) {
			
			$html .="<tr>";
				$html .="<td>".$counter."</td>";
				$html .="<td><a href='user.php?user_id=".$l->user_id."'>".$l->username."</td>";
				$html .="<td>".$l->population."</td>";
				$html .="<td>".$l->created."</td>";
			$html .="</tr>";
			$counter=$counter+1;
		}	
	$html .="</table>";
	echo $html;
?>