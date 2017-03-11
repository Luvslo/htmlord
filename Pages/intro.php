<?php
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Ulevaade</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	
	<body>
		<?php require("../layout1.php");?>
		
		<h1>Ulevaade mangust</h1>
		<p>
			Antud lehekulg on taiendamisel, srry..
		</p>
		<?php require("../layout2.php");?>
	</body>
</html>
