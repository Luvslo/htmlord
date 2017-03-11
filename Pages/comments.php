<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	$post_id=($_GET["id"]);

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	if (!isset($_GET["id"])) {
		header("Location: data.php");
		exit();
	}
	
	$SPost=$Forum->getSinglePost ($post_id);
	$post_title=$SPost->title;

	if (isset($_POST['post_comment'])){
		$Forum->saveComment($user_id, $post_id, cleanInput($_POST['post_comment']));
		
	}
	
	$Com=$Forum->getComments ($post_id);

	
	$html2="<table>";

		foreach($Com as $c) {

			$html2 .="<tr>";
				$html2 .="<th width='1%'>".$c->user_id.': '."</th>";
				$html2 .="<td>".$c->comment."</td>";
				$html2 .="<td width='15%'>".$c->created."</td>";
			$html2 .="</tr>";
		}
	$html2 .="</table>";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Foorum</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
		<h1>Foorum</h1>
		<h3><?php echo $post_title;?></h3>
		<p>Soovid midagi selle teema alla postitada?</p>
		<form method="POST">
			
			<label>Kommentaar: </label>
				<br>
				<textarea rows="5" cols="40" name="post_comment"></textarea> 
			<br>
			<input type="submit" value="Postita"><br><br>
			
		</form>
		<p>Senised postitused: </p>
		<?php echo $html2;?>
		<?php require("../layout2.php");?>
	</body>
</html>