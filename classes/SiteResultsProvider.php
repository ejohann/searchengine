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
				$id = $row["id"];
				$url = $row["url"];
				$title = $row["title"];
				$description = $row["description"];
				$resultsHtml .= "<div class='result-container'>
									<h3 class='title'><a class='result' href='$url'>$title</a></h3>
									<span class='url'>$url</span>
									<span class='description'>$description</span>
								</div>";
			  }

			$resultsHtml .= "</div>";

			return $resultsHtml;
		  }

	  }

?>