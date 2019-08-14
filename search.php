<?php

	if(isset($_GET["term"])){
		echo $_GET["term"];
	}
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
							<button>Search</button>
						</div>
					</form>
				</div>
			</div>
		</div>	
	</div>
</body>
</html>