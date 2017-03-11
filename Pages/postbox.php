<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$messages=$Message->getUser($user_id);
	$messagesSent=$Message->getUserSent($user_id);
	
	$html2="<table>";
		$html2 .="<tr>";
			$html2 .="<th>Sender</th>";
			$html2 .="<th>Message title</th>";
			$html2 .="<th>Created</th>";
			$html2 .="<th>Read</th>";
		$html2 .="</tr>";

		foreach($messages as $m) {
			$html2 .="<tr>";
				$html2 .="<td>".$m->username."</td>";
				$html2 .="<td><a href='message.php?message_id=".$m->id."'>".$m->title."</td>";
				$html2 .="<td>".$m->created."</td>";
				$html2 .="<td>".$m->seen."</td>";
			$html2 .="</tr>";
		}	
	$html2 .="</table>";
	
	$html3="<table>";
		$html3 .="<tr>";
			$html3 .="<th>Receiver</th>";
			$html3 .="<th>Message title</th>";
			$html3 .="<th>Created</th>";
			$html3 .="<th>Read</th>";
		$html3 .="</tr>";

		foreach($messagesSent as $ms) {
			$html3 .="<tr>";
				$html3 .="<td>".$ms->username."</td>";
				$html3 .="<td><a href='messagesent.php?message_id=".$ms->id."'>".$ms->title."</td>";
				$html3 .="<td>".$ms->created."</td>";
				$html3 .="<td>".$ms->seen."</td>";
			$html3 .="</tr>";
		}	
	$html3 .="</table>";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Postbox</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
		<h1>Your postbox</h1>
		<a href="send.php">Send a message</a>
		<br>
		<p>
			Manage and send messages<br>
			You received: 
			<?php echo $html2;?>
		</p>
		<p>You sent: 
			<?php echo $html3;?>
		</p>
		<?php require("../layout2.php");?>
	</body>
</html>