<?php
	include("config.php");
	include("classes/SiteResultsProvider.php");

	$term = (isset($_GET["term"])) ? $_GET["term"] : exit("you must enter a search term");

	$type = (isset($_GET["type"])) ? $_GET["type"] : "site";  

	$page = (isset($_GET["page"])) ? $_GET["page"] : 1; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Engine</title>
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
				$resultsProvider = new SiteResultsProvider($connection);
				$totalResults = $resultsProvider->getNumResults($term);
				$pageItems = 20;
			
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
					$currentPage = 1;
					$pagesLeft = min($pagesToShow, $numPages);
					while($pagesLeft != 0){
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
</body>
</html>