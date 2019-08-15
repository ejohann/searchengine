<?php 

	class SiteResultsProvider{

		private $connection;

		public function __construct($connection){
			$this->connection = $connection;
		  }

		public function getNumResults($term){
			$query = $this->connection->prepare("SELECT count(*) as total 
					FROM sites WHERE title LIKE :term 
					OR url LIKE :term 
					OR keywords LIKE :term 
					or description LIKE :term");
			$searchTerm = "%" .$term. "%";
			$query->bindParam(":term", $searchTerm);
			$query->execute();
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return $row["total"];
		  }   
	  }

?>