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
		$Forum->saveComment($user_id, $post_id, $_POST['post_comment']);
		
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Foorum</title>
		<style>
			table {
				width:100%;
			}
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
				padding: 10px;
				text-align: left;
			}
			th {
				background-color: LightSalmon;
				color: black;
				padding: 10px;
				text-align: right;
			}
	</style>
	</head>
	<body style="background-color:bisque;">
	
	
		<h1>Foorum</h1>
		<a href="forum.php">Tagasi</a>
		<br>
		<h3><?php
				echo $post_title;
			?></h3>
		<p>Soovid midagi selle teema alla postitada?</p>
		<form method="POST">
			
			<label>Kommentaar: </label>
				<br>
				<textarea rows="5" cols="40" name="post_comment">
				
			
				</textarea> 
			<br>
			<input type="submit" value="Postita"><br><br>
			
		</form>
		<p>Senised postitused: </p>
	</body>
</html>
<?php
	$Com=$Forum->getComments ($post_id);

	
	$html="<table>";

		foreach($Com as $c) {

			$html .="<tr>";
				$html .="<th width='1%'>".$c->user_id.': '."</th>";
				$html .="<td>".$c->comment."</td>";
				$html .="<td width='15%'>".$c->created."</td>";
			$html .="</tr>";
		}
	$html .="</table>";
	echo $html;
?> 