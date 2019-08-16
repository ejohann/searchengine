<?php 
	include("../config.php");

	if(isset($_POST["linkID"])){
		$query = $connection->prepare("UPDATE sites SET clicks = clicks + 1 WHERE id = :id");
		$query->bindParam(":id", $_POST["linkID"]);
		$query->execute();

	 }
	else{
		echo "No linked passed";
	}
?>