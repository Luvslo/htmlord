<?php 
class Forum {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function savePost($user_id, $title){

		$stmt = $this->connection->prepare("INSERT INTO user_posts (user_id, title) VALUES (?,?)");
		
		$stmt->bind_param("is", $user_id, $title);
		
		if ($stmt->execute()) {
			
			echo "Teema salvestamine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();

	}
	
	function getForumPosts($q, $sort, $order) {
		
		$allowedSort = ["id", "username", "title"];
		
		if(!in_array($sort, $allowedSort)){
			
			$sort = "id";
		}

		$orderBy = "ASC";
		
		if ($order == "DESC") {
			$orderBy = "DESC";
		}

		
		if ($q != "") {
			
			echo "Otsib: ".$q;

			$stmt = $this->connection->prepare("
				SELECT user_posts.id, user_sample.username, user_posts.title, user_posts.created
				FROM user_posts
				JOIN user_sample
				ON user_posts.user_id=user_sample.id
				WHERE user_posts.deleted IS NULL
				AND (user_posts.id LIKE ? OR user_sample.username LIKE ? OR user_posts.title LIKE ? OR user_posts.created LIKE ?)
				ORDER BY $sort $orderBy
			");
			$searchWord = "%".$q."%";
			$stmt->bind_param("ssss", $searchWord, $searchWord, $searchWord, $searchWord);
			
			
		} else {
			
			$stmt = $this->connection->prepare("
				SELECT user_posts.id, user_sample.username, user_posts.title, user_posts.created
				FROM user_posts
				JOIN user_sample
				ON user_posts.user_id=user_sample.id
				WHERE user_posts.deleted IS NULL
				ORDER BY $sort $orderBy
			");
		}
		
		echo $this->connection->error;
		
		$stmt->bind_result($id, $username, $title, $created);
		$stmt->execute();

		$result = array();

		while ($stmt->fetch()) {

			$Post = new StdClass();
			
			$Post->id = $id;
			$Post->username = $username;
			$Post->title = $title;
			$Post->created = $created;

			array_push($result, $Post);
		}
		
		$stmt->close();

		return $result;
	}
	
	function getSinglePost($post_id){

		$stmt = $this->connection->prepare("SELECT id, user_id, title, created FROM `user_posts` WHERE id=?");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $post_id);
		$stmt->bind_result($id, $user_id, $title, $created);
		$stmt->execute();

		$SPost = new Stdclass();

		if($stmt->fetch()){
			
			$SPost->id = $id;
			$SPost->user_id = $user_id;
			$SPost->title = $title;
			$SPost->created = $created;

		}else{

			exit();
		}
		
		$stmt->close();
		
		return $SPost;
	}
	
	function getComments($post_id){

		$stmt = $this->connection->prepare("
		SELECT user_comments.id, user_sample.username, user_comments.comment, user_comments.created 
		FROM user_comments
		JOIN user_sample
		ON user_comments.user_id=user_sample.id
		WHERE user_comments.post_id=? AND user_comments.deleted IS NULL
		");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $post_id);
		$stmt->bind_result($id, $user_id, $comment, $created);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$Com = new StdClass();
			$Com->id=$id;
			$Com->user_id=$user_id;
			$Com->comment=$comment;
			$Com->created=$created;

			array_push($result, $Com);
			
		}
		
		$stmt->close();
		
		return $result;
		
	}

	function saveComment ($user_id, $post_id, $comment) {

		$stmt = $this->connection->prepare("INSERT INTO user_comments (user_id, post_id, comment) VALUES (?, ?, ?)");
		
		echo $this->connection->error;
		
		$stmt->bind_param("iis", $user_id, $post_id, $comment);
		
		if($stmt->execute()) {
			echo "Kommenteerimine onnestus!";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();

	}
} 
?>