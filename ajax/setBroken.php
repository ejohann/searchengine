<?php
	include("../config.php");

	if(isset($_POST["src"])){
		$query = $connection->prepare("UPDATE images SET broken = WHERE image_url = :image_url");
		$query->bindParam(":image_url", $_POST["src"]);
		$query->execute();
	  }
	 else{
	 	echo "No image in request";
	  }
?>