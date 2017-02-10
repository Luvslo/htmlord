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
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Foorum</title>
		<style>

			table, td, th {
				border: 1px solid bisque;
				padding: 5px;
			}
			table {
				border-spacing: 5px;
			}
			td {
				background-color: LightSalmon;
				color: black;
				padding: 5px;
				text-align: left;
			}
			th {
				background-color: LightSalmon;
				color: black;
				padding: 5px;
				text-align: right;
			}
	</style>
	</head>
	<body style="background-color:bisque;">
		
		<?php include_once("../analyticstracking.php") ?>
		<h1>Foorum</h1>
		<a href="data.php">Tagasi</a>
		<br>
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
	</body>
</html>
<?php 
	
	$html = "<table>";
	
	$html .= "<tr>";
	
		
		$IdOrder = "ASC";
		$arrow ="&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$IdOrder = "DESC";
			$arrow ="&uarr;";
		}
		
		$html .= "<th>
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
		
		$html .= "<th>
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
		
		$html .= "<th>
					<a href='?q=".$q."&sort=age&order=".$titleOrder."'>
						Pealkiri ".$arrow."
					</a>
				 </th>";
		
		
		foreach($post as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->username."</td>";
				$html .= "<td><a href='comments.php?id=".$p->id."'>".$p->title."</a></td>";
				$html .= "<td>".$p->created."</td>";
			$html .= "</tr>";	
		}
		
	$html .= "</table>";
	echo $html;
?>