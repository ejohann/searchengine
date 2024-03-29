<?php
	include("config.php");
	include("classes/SiteResultsProvider.php");
	include("classes/ImageResultsProvider.php");

	$term = (isset($_GET["term"])) ? $_GET["term"] : exit("you must enter a search term");

	$type = (isset($_GET["type"])) ? $_GET["type"] : "site";  

	$page = (isset($_GET["page"])) ? $_GET["page"] : 1; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Engine</title>
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/fancybox.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="wrapper">
		<div class="header">
			<div class="header-content">
				<div class="logo-container">
					<a href="./index.php"><img src="assets/images/search_engine_logo.png"></a>
				</div>
				<div class="search-container">
					<form action="search.php" method="GET">
						<div class="search-bar-container">
							<input type="hidden" name="type" value="<?php echo $type; ?>">
							<input type="text" name="term" class="search-box" value="<?php echo $term; ?>">
							<button class="search-button"><img src="assets/images/icons/search.png"></button>
						</div>
					</form>
				</div>
			</div>
			
			<div class="tab-container">
				<ul class="tab-list ">
					<li class="<?php echo $type == 'site' ? 'active' : ''; ?>"><a href='<?php echo "search.php?term=$term&type=site"; ?>'>Sites</a></li>
					<li class="<?php echo $type == 'image' ? 'active' : ''; ?>"><a href='<?php echo "search.php?term=$term&type=image"; ?>'>Images</a></li>
				</ul>
			</div>

		</div>

		<div class="main-result-section">
			<?php 
				
				if($type == "site"){
					$resultsProvider = new SiteResultsProvider($connection);
					$pageItems = 20;
			  	 }
				else{
					$resultsProvider = new ImageResultsProvider($connection);
					$pageItems = 30;
			  	 }	

				$totalResults = $resultsProvider->getNumResults($term);
				echo "<p class='results-count'>$totalResults results found.</p>";

				echo $resultsProvider->getResultsHtml($page, $pageItems, $term);
			?>
		</div>	

		<div class="pagination-container">
			<div class="page-buttons">

				<div class="page-number-container">
					<img src="assets/images/pageStart.png">				
				</div>

				<?php
					$pagesToShow = 10;
					$numPages = ceil($totalResults / $pageItems);
					$pagesLeft = min($pagesToShow, $numPages);
					$currentPage = $page - floor($pagesToShow / 2);

					if($currentPage < 1){
						$currentPage = 1;
			    	  }

			    	if($currentPage + $pagesLeft > $numPages + 1){
			    		$currentPage = ($numPages + 1) - $pagesLeft;
			    	}  

					while($pagesLeft != 0 && $currentPage <= $numPages){
						if($currentPage == $page){
							echo "<div class='page-number-container'> 
									<img src='assets/images/pageSelected.png'>
									<span class='page-number'>$currentPage</span>
								</div>";
						  }
						else{
							echo "<div class='page-number-container'> 
									<a href='search.php?term=$term&type=$type&page=$currentPage'>
										<img src='assets/images/page.png'>
										<span class='page-number'>$currentPage</span>
									</a>
								</div>";
						  }
						
						$currentPage++;
						$pagesLeft--;
					  }

				?>

				<div class="page-number-container">
					<img src="assets/images/pageEnd.png">				
				</div>

			</div>
		</div>

	</div>
	<script type="text/javascript" src="assets/js/fancybox.js"></script>
	<script type="text/javascript" src="assets/js/masonry.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>