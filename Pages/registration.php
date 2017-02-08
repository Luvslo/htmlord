<?php

	require("../function.php");

	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}

	$signupUsernameError="";
	$username="";
	$signupUsername="";
	$signupEmailError="";
	$signupPasswordError="";
	$signupPassword2Error="";
	$signupEmail ="";

	if (isset($_POST["signupPassword"])){
		
		if (empty($_POST["signupPassword"])){
			
			$signupPasswordError="See vali on kohustuslik!";
			
		} else {
			
			if (strlen($_POST["signupPassword"]) <8) {
					$signupPasswordError="Parool peab olema vahemalt 8 tahemarki pikk";
			}
		}
	}
	
	if (isset($_POST["signupPassword2"])){
		
		if (empty($_POST["signupPassword2"])){
			
			$signupPasswordError="See vali on kohustuslik!";
			
		} else {
			
			if (($_POST["signupPassword"])!=($_POST["signupPassword2"]) ){
				$signupPassword2Error="Paroolid ei klapi!";
			}
		}
	}
	
	if (isset($_POST["signupEmail"])){
				
		if (empty($_POST["signupEmail"])){
					
			$signupEmailError="See vali on kohustuslik!";
			
		} else {
			$signupEmail =$_POST["signupEmail"];
			
		
	
		}
	}
	
	if (isset($_POST["signupUsername"])){
				
		if (empty($_POST["signupUsername"])){
					
			$signupUsernameError="See vali on kohustuslik!";
			
		} else {
			$signupUsername=$_POST["signupUsername"];
		}
	}

	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&
		 isset($_POST["signupUsername"]) &&
		 empty($signupUsernameError) &&
		 empty($signupPassword2Error) &&
		 empty($signupEmailError) &&
		 empty($signupPasswordError) 
	   ) {
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		
		$signupEmail=cleanInput($signupEmail);
		$signupUsername=cleanInput($signupUsername);
		$password=cleanInput($password);
		
		
		$User->signUp($signupEmail, $signupUsername, $password);
		$us = getUser($signupUsername);
		$user_id = $us->id;
		$Resources->signUp($user_id);
		$Modifiers->signUp($user_id);
		$Combat->signUp($user_id);
		$Levels->signUp($user_id);
		
	}
?>



<!DOCTYPE html>
<html>
	<head>
		<title>Loo kasutaja</title>
	</head>
		<body style="background-color:bisque;">

			<h1>Loo kasutaja!</h1>
			<a href="index.php">Avaleht</a>
			<br>
			<a href="login.php">Logi sisse!</a>
			<br><br>
			<form method="POST">
			
				<label>Kasutajanimi</label>
				<br>
				<input name="signupUsername" type="username" value="<?=$signupUsername;?>"> <?php echo $signupUsernameError;?>
				<br><br>
			
				<label>E-post</label>
				<br>
				<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError;?>
				<br><br>
				
				<label>Parool</label>
				<br>
				<input name="signupPassword" type="password"> <?php echo $signupPasswordError;?>
				<br> <br>
				
				<label>Parool uuesti</label>
				<br>
				<input name="signupPassword2" type="password"> <?php echo $signupPassword2Error;?>
				<br> <br>

				
				<input type="submit" value="Loo kasutaja">

			</form>

	</body>
</html>
