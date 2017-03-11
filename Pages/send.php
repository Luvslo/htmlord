<?php
	require("../function.php");
	
	$user_id=($_SESSION["userId"]);
	
	$back_button="";
	$receiver_username="";
	$receiver_username_error="";
	$title="";
	$title_error="";
	$content="";
	$content_error="";
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if(!isset($_GET["user_id"])){
		$back_button="postbox.php";
	}else{
		$back_button="user.php?user_id=".$_GET["user_id"];
		$Name=$User->getName($_GET["user_id"]);
		foreach($Name as $n){
			$receiver_username=$n->username;
		}
	}
	
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST["receiver_username"])){
		if(empty($_POST["receiver_username"])){
			$receiver_username_error="Please insert receivers username!";
		}else{
			$receiver_username=$_POST["receiver_username"];
		}
	}
	if(isset($_POST["title"])){
		if(empty($_POST["title"])){
			$title_error="Please insert a title to your message!";
		}else{
			$title=$_POST["title"];
		}
	}
	if(isset($_POST["content"])){
		if(empty($_POST["content"])){
			$content_error="Please write your message!";
		}else{
			$content=$_POST["content"];
		}
	}
	
	if ( isset($_POST["receiver_username"]) &&
		 isset($_POST["title"]) &&
		 isset($_POST["content"]) &&
		 empty($receiver_username_error) &&
		 empty($title_error) &&
		 empty($content_error) 
	   ) {

		$receiver_username=cleanInput($receiver_username);
		$title=cleanInput($title);
		$content=cleanInput($content);
		
		$UsId=$User->getUsId($receiver_username);
		$receiver_id = $UsId->id;
		
		$Message->save($user_id, $receiver_id, $title, $content);
		
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Diplomacy</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
		<h1>Send a message</h1>
		
		<form method="POST">
			
			<label>Receiver username</label>
			<br>
			<input name="receiver_username" type="text" value="<?=$receiver_username;?>"> <?php echo $receiver_username_error;?>
			<br><br>
			<label>Message title</label>
			<br>
			<input name="title" type="text"> <?php echo $title_error;?>
			<br><br>
			<label>Message content</label>
			<br>
			<textarea rows="15" cols="60" name="content"></textarea> 
			<br><br>
			<input type="submit" value="Send">
		
		</form>
		<?php require("../layout2.php");?>
	</body>
</html>