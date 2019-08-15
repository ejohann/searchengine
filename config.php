<?php 
	ob_start();

	try{
		$connection = new PDO("mysql:dbname=searchengine_db;host=localhost;port=3307", "root", "");
		$connection->setAttribite(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	  }
	 catch(PDOException $error){
	 	 echo "Connection failed: " . $error->getMessage();
	   }
?>