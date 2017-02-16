<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	if (!isset($_GET["message_id"])) {
		header("Location: postbox.php");
	}
	$message=$Message->getSingle($_GET["message_id"]);
	$receiver_id=$message->receiver_id;
	$sender=$message->username;
	$title=$message->title;
	$content=$message->content;
	
	$UsId = $User->getUsId($sender);
	$sender_id = $UsId->id;
	
	if($receiver_id != $user_id or $sender_id != $user_id){
		header("Location: postbox.php");
		exit();
	}
	$Message->setSeen($_GET["message_id"]);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Message</title>
	</head>
	<body style="background-color:bisque;">
		<a href="postbox.php">Back</a><br>
		<a href="send.php?user_id=<?php echo $sender_id;?>">Reply</a><br>
		<h1><?php echo $title;?></h1>
		<p>By <?php echo $sender;?></p>
		<pre><?php echo $content;?></pre>
	</body>
</html>

