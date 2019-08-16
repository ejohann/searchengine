<?php 
	include("../config.php");

	if(isset($_POST["imageUrl"])){
		$query = $connection->prepare("UPDATE images SET clicks = clicks + 1 WHERE image_url = :image_url");
		$query->bindParam(":image_url", $_POST["imageUrl"]);
		$query->execute();

	 }
	else{
		echo "No linked passed";
	}
?>