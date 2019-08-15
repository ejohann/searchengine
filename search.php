<?php
	include("config.php");
	$term = (isset($_GET["term"])) ? $_GET["term"] : exit("you must enter a search term");

	$type = (isset($_GET["type"])) ? $_GET["type"] : "site";  
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
							<input type="text" name="term" class="search-box">
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
	</div>
</body>
</html>