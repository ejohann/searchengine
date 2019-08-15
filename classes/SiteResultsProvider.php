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

		public function getResultsHtml($page, $pageSize, $term){
				$query = $this->connection->prepare("SELECT * 
					FROM sites WHERE title LIKE :term 
					OR url LIKE :term 
					OR keywords LIKE :term 
					or description LIKE :term 
					ORDER BY clicks DESC
					");
			$searchTerm = "%" .$term. "%";
			$query->bindParam(":term", $searchTerm);
			$query->execute();

			$resultsHtml = "<div class='siteResults'>";

			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$title = $row["title"];
				echo "$title<br/>";
			  }

			$resultsHtml .= "</div>";
		  }

	  }

?>