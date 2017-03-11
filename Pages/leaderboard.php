<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$lb=$Leaderboard->get ();
	
	$html2="<table>";
		$html2 .="<tr>";
			$html2 .="<th>Koht</th>";
			$html2 .="<th>Kasutajanimi</th>";
			$html2 .="<th>Populatsioon</th>";
			$html2 .="<th>Liitus</th>";
		$html2 .="</tr>";
		$counter=1;
		foreach($lb as $l) {
			
			$html2 .="<tr>";
				$html2 .="<td>".$counter."</td>";
				$html2 .="<td><a href='user.php?user_id=".$l->user_id."'>".$l->username."</td>";
				$html2 .="<td>".$l->population."</td>";
				$html2 .="<td>".$l->created."</td>";
			$html2 .="</tr>";
			$counter=$counter+1;
		}	
	$html2 .="</table>";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Leaderboard</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
		<h1>Leaderboard</h1>
		<?php echo $html2; ?>
		<?php require("../layout2.php");?>
	</body>
</html>
