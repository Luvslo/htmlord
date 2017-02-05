<?php

	require("../function.php");

	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}

	$loginEmail="";
	$loginEmailError="";
	$loginPasswordError="";
	
	
	if (isset($_POST["loginPassword"])){
		
		if (empty($_POST["loginPassword"])){
			
			$loginPasswordError="Sisestage siia oma parool, et sisse logida!";
			
				} else {
			
				if (strlen($_POST["loginPassword"]) <8) {
					$loginPasswordError="Parool peab olema vahemalt 8 tahemarki pikk";
				}
			
		}
	}
	if (isset($_POST["loginEmail"])){
				
		if (empty($_POST["loginEmail"])){
					
			$loginEmailError="Sisestage siia oma e-post, et sisse logida!";
		
			} else {
			$loginEmail=$_POST["loginEmail"];	
		}
	}
	
	$error = "";
	
	if( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])){
	
		$error = $User->login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));
	}
?>



<!DOCTYPE html>
<html>

	

	<head>
		<title>Logi sisse</title>
	</head>
	<body style="background-color:bisque;">
			
		<h1>Logi sisse!</h1>
		<a href="index.php">Avaleht</a>
		<br>
		<a href="registration.php">Loo kasutaja!</a>
		<br><br>
		<form method="POST">
		
			<p style ="color:red;"><?=$error;?></p>
			
			<input name="loginEmail" type="email" placeholder="E-post" value="<?=$loginEmail;?>"> <?php echo $loginEmailError;?>
			
			<br><br>
			
			<input name="loginPassword" type="password" placeholder="Parool"> <?php echo $loginPasswordError;?>
			
			<br> <br>
			
			<input type="submit" value="Logi sisse">
			
		
		</form>
	</body>
</html>
