<?php 

	class ImageResultsProvider{

		private $connection;

		public function __construct($connection){
			$this->connection = $connection;
		  }

		public function getNumResults($term){
			$query = $this->connection->prepare("SELECT count(*) as total 
					FROM images 
					WHERE (title LIKE :term 
					OR alt LIKE :term) 
					AND broken = 0 ");
			$searchTerm = "%" .$term. "%";
			$query->bindParam(":term", $searchTerm);
			$query->execute();
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return $row["total"];
		  }  

		public function getResultsHtml($page, $pageSize, $term){

			// calculate limit for query
			$fromLimit = ($page - 1) * $pageSize;

			$query = $this->connection->prepare("SELECT * 
				FROM images 
				WHERE (title LIKE :term 
				OR alt LIKE :term) 
				AND broken = 0 
				ORDER BY clicks DESC 
				LIMIT :fromLimit, :pageSize");

			$searchTerm = "%" .$term. "%";
			$query->bindParam(":term", $searchTerm);
			$query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
			$query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
			$query->execute();

			$resultsHtml = "<div class='image-results'>";

			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$id = $row["id"];
				$image_url = $row["image_url"];
				$site_url = $row["site_url"];
				$title = $row["title"];
				$alt = $row["alt"];
				
				if($title){
					$displayText = $title;
				  }
				else if($alt){
					$displayText = $alt;
				  }
				else{
					$displayText = $image_url;
				  }

				$resultsHtml .= "<div class='grid-item'>
									<a class='result' href='$image_url' data-linkID='$id'>
										<img src='$image_url'>
									</a>
								</div>";
			  }

			$resultsHtml .= "</div>";

			return $resultsHtml;
		  }

	  }

?>