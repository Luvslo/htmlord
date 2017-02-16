<?php 
class Message {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function getUser ($user_id) {

		$stmt = $this->connection->prepare("
		SELECT user_messages.id, user_sample.username, user_messages.receiver_id, user_messages.title, user_messages.created, user_messages.seen 
		FROM user_messages 
		JOIN user_sample 
		ON user_messages.sender_id=user_sample.id 
		WHERE user_messages.receiver_id=? AND user_messages.receiver_deleted IS NULL
		");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($id, $username, $receiver_id, $title, $created, $seen);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$messages = new StdClass();
			$messages->id=$id;
			$messages->username=$username;
			$messages->receiver_id=$receiver_id;
			$messages->title=$title;
			$messages->created=$created;
			$messages->seen=$seen;
			
			array_push($result, $messages);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function getUserSent ($user_id) {

		$stmt = $this->connection->prepare("
		SELECT user_messages.id, user_messages.sender_id, user_sample.username, user_messages.title, user_messages.created, user_messages.seen 
		FROM user_messages 
		JOIN user_sample 
		ON user_messages.receiver_id=user_sample.id 
		WHERE user_messages.sender_id=? AND user_messages.sender_deleted IS NULL
		");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($id, $sender_id, $username, $title, $created, $seen);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$messagesSent = new StdClass();
			$messagesSent->id=$id;
			$messagesSent->sender_id=$sender_id;
			$messagesSent->username=$username;
			$messagesSent->title=$title;
			$messagesSent->created=$created;
			$messagesSent->seen=$seen;
			
			array_push($result, $messagesSent);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function getSingle($message_id){

		$stmt = $this->connection->prepare("
		SELECT user_messages.id, user_sample.username, user_messages.receiver_id, user_messages.title, user_messages.content
		FROM user_messages 
		JOIN user_sample 
		ON user_messages.sender_id=user_sample.id 
		WHERE user_messages.id=?
		");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $message_id);
		$stmt->bind_result($id, $username, $receiver_id, $title, $content);
		$stmt->execute();

		$message = new Stdclass();

		if($stmt->fetch()){
			$message->id = $id;
			$message->username = $username;
			$message->receiver_id = $receiver_id;
			$message->title = $title;
			$message->content = $content;
		}else{
			exit();
		}
		$stmt->close();
		
		return $message;
	}
	
	function getUnReadCount($user_id){

		$stmt = $this->connection->prepare("SELECT COUNT(*) FROM user_messages WHERE receiver_id=? AND seen IS NULL");
		
		echo $this->connection->error;
		
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($unread_count);
		$stmt->execute();

		$count = new Stdclass();

		if($stmt->fetch()){
			$count->unread_count = $unread_count;
		}else{
			exit();
		}
		$stmt->close();
		
		return $count;
	}
	
	function setSeen($message_id){

		$stmt = $this->connection->prepare("UPDATE user_messages SET seen=NOW(), created=created WHERE id=?");
		
		$stmt->bind_param("i", $message_id);
		
		if ($stmt->execute()) {
			
			echo "";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	/*
	function delet($action_id){

		$stmt = $this->connection->prepare("UPDATE user_actions SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		
		$stmt->bind_param("i", $action_id);
		
		if ($stmt->execute()) {
			
			echo "Tegevuse kustutamine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	*/
	function save($sender_id, $receiver_id, $title, $content){
		
		$stmt = $this->connection->prepare("INSERT INTO user_messages (sender_id, receiver_id, title, content) VALUES (?,?,?,?)");
		
		$stmt->bind_param("iiss", $sender_id, $receiver_id, $title, $content);
		
		if ($stmt->execute()) {
			
			echo "Kirja saatmine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
} 
?>