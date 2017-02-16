<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$messages=$Message->getUser($user_id);
	$messagesSent=$Message->getUserSent($user_id);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Postbox</title>
	</head>
	<body style="background-color:bisque;">
	<?php require("../styles.php"); ?>
	
		<h1>Your postbox</h1>
		<a href="data.php">Back</a><br>
		<a href="send.php">Send</a>
		<br>
		<p>
			Manage and send messages<br>
			You received:
		</p>
	</body>
</html>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Sender</th>";
			$html .="<th>Message title</th>";
			$html .="<th>Created</th>";
			$html .="<th>Read</th>";
		$html .="</tr>";

		foreach($messages as $m) {
			$html .="<tr>";
				$html .="<td>".$m->username."</td>";
				$html .="<td><a href='message.php?message_id=".$m->id."'>".$m->title."</td>";
				$html .="<td>".$m->created."</td>";
				$html .="<td>".$m->seen."</td>";
			$html .="</tr>";
		}	
	$html .="</table>";
	echo $html;
?> 
<p>You sent: </p>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Receiver</th>";
			$html .="<th>Message title</th>";
			$html .="<th>Created</th>";
			$html .="<th>Read</th>";
		$html .="</tr>";

		foreach($messagesSent as $ms) {
			$html .="<tr>";
				$html .="<td>".$ms->username."</td>";
				$html .="<td><a href='messagesent.php?message_id=".$ms->id."'>".$ms->title."</td>";
				$html .="<td>".$ms->created."</td>";
				$html .="<td>".$ms->seen."</td>";
			$html .="</tr>";
		}	
	$html .="</table>";
	echo $html;
?>
