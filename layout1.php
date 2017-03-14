<?php
	$count=$Message->getUnReadCount ($user_id);
	$unread_count=$count->unread_count;
	$res=$Resources->getUser ($_SESSION["userId"]);
?>

<div class="flex-container">

<header>
	<div>
		<table>
			<tr>
				<td colspan="4" style="font-size: 2em; font-weight: bold; text-align: left; padding: 10px; text-decoration: underline;" valign="bottom"><a href="news.php" style="color: white;">HTMLord</a></td>
				<td colspan="4"></td>
			</tr>
			<tr>
				<td colspan="8"></td>
			</tr>
			<?php require("resources_table.php"); echo $html;?>
		</table>
	</div>
</header>

<nav class="nav">
<ul>
  <li><a href="postbox.php">Postbox (<?php echo $unread_count;?> unread)</a></li>
  <li><a href="data.php">Your actions</a></li><br>
  <li><a href="woodcutting.php">Woodcutters huts</a></li>
  <li><a href="farming.php">Farms</a></li>
  <li><a href="trading.php">Market</a></li>
  <li><a href="stonemining.php">Quarry</a></li>
  <li><a href="ironmining.php">Iron mines</a></li>
  <li><a href="people.php">Houses</a></li>
  <li><a href="war.php">War office</a></li><br>
  <li><a href="leaderboard.php">Leaderboard</a></li>
  <li><a href="forum.php">Forum</a></li><br>
  <li><a href="?logout=1">Log out</a></li>
</ul>
</nav>

<article class="article">