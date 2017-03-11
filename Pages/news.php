<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Welcome</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
			<h2>Welcome, <?php echo $_SESSION["username"];?>!</h2>
			
			<h3>Visual update is out!</h3>
			<p>Don't forget to report all the bugs or just give feedback.</p>
			
			<h3>Pvp is out!</h3>
			<p>Don't forget to report all the bugs or just give feedback.</p>
		<?php require("../layout2.php");?>
	</body>
</html>

