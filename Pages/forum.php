<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST["post_title"])){
		$Forum->savePost($user_id, cleanInput($_POST["post_title"]));
		header("Location: forum.php");
	}
	
	if(isset($_GET["q"])){
		
		$q = $_GET["q"];
		
	}else{
		
		$q = "";
	}
	$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	if(isset($_GET["b"])){
		
		$b = $_GET["b"];
		
	}else{
		
		$b = "";
	}
	$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	 	if(isset($_GET["b"])){
		
		$q = $_GET["b"];
		
	}else{
		
		$b = "";
	}
	$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$post = $Forum->getForumPosts($q, $sort, $order);
	
	$html2 = "<table>";
	
	$html2 .= "<tr>";
	
		
		$IdOrder = "ASC";
		$arrow ="&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$IdOrder = "DESC";
			$arrow ="&uarr;";
		}
		
		$html2 .= "<th>
					<a href='?q=".$q."&sort=type&order=".$IdOrder."'>
						id ".$arrow."
					</a>
				 </th>";
				 
		$userOrder = "ASC";
		$arrow ="&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$userOrder = "DESC";
			$arrow ="&uarr;";
		}
		
		$html2 .= "<th>
					<a href='?q=".$q."&sort=name&order=".$userOrder."'>
						Autor ".$arrow."
					</a>
				 </th>";
				 
		$titleOrder = "ASC";
		$arrow ="&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$titleOrder = "DESC";
			$arrow ="&uarr;";
		}
		
		$html2 .= "<th>
					<a href='?q=".$q."&sort=age&order=".$titleOrder."'>
						Pealkiri ".$arrow."
					</a>
				 </th>";
		
		
		foreach($post as $p){
			$html2 .= "<tr>";
				$html2 .= "<td>".$p->id."</td>";
				$html2 .= "<td>".$p->username."</td>";
				$html2 .= "<td><a href='comments.php?id=".$p->id."'>".$p->title."</a></td>";
				$html2 .= "<td>".$p->created."</td>";
			$html2 .= "</tr>";	
		}
		
	$html2 .= "</table>";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Foorum</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php include_once("../analyticstracking.php") ?>
		<?php require("../layout1.php");?>
		<h1>Foorum</h1>
		<p>
			Kui on midagi oelda, siis vali sobiv teema voi tee uus ning realiseeri oma sonavabadus.<br><br>
			Uue teema tegemiseks sisesta siia teema pealkiri: 
		</p>
		<form method="POST">
			
			<input name="post_title" type="text"> 

			<input type="submit" value="Salvesta"><br><br>
		</form>
		<p>Olemasolevad teemad: </p>
		<form>

			<input type="search" name="q" value="<?=$q;?>">
			<input type="submit" value="Otsi">
	
		</form>
		<?php echo $html2;?>
		<?php require("../layout2.php");?>
	</body>
</html>