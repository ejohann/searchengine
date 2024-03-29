<?php 
	include("config.php");
	include("classes/DomDocumentParser.php");

	$alreadyCrawled = array();
	$crawling = array();
	$alreadyFoundImages = array();

	function insertLink($url, $title, $description, $keywords){
		global $connection;

		$insert_query = $connection->prepare("INSERT INTO sites(url, title, description, keywords) 
			VALUES(:url, :title, :description, :keywords) ");

		$insert_query->bindParam(":url", $url);
		$insert_query->bindParam(":title", $title);
		$insert_query->bindParam(":description", $description);
		$insert_query->bindParam(":keywords", $keywords);
		$insert_query->execute();

		return $insert_query->rowCount() != 0;
	  }


	function insertImage($url, $src, $alt, $image_title){
		global $connection;

		$insert_image_query = $connection->prepare("INSERT INTO images(site_url, image_url, alt, title) 
			VALUES(:site_url, :image_url, :alt, :title) ");

		$insert_image_query->bindParam(":site_url", $url);
		$insert_image_query->bindParam(":image_url", $src);
		$insert_image_query->bindParam(":alt", $alt);
		$insert_image_query->bindParam(":title", $image_title);
		$insert_image_query->execute();

		return $insert_image_query->rowCount() != 0;
	  }


	 function linkExists($url){
		global $connection;

		$select_query = $connection->prepare("SELECT * FROM sites WHERE url = :url");

		$select_query->bindParam(":url", $url);

		$select_query->execute();

		return $select_query->rowCount() != 0;
	  }

	function createLink($src, $url){
	 	$scheme = parse_url($url)["scheme"]; //http
	 	$host = parse_url($url)["host"]; // www.sunsetcity.gd / link

	 	// convert relative links to absolute links
	 	if(substr($src, 0, 2) == "//"){
	 		$src = $scheme . ":" . $src;
	 	  }
	 	else if(substr($src, 0, 1) == "/"){
	 		$src = $scheme . "://" . $src;
	 	  }
	 	else if(substr($src, 0, 2) == "./"){
	 		$src = $scheme . "://" . $host .dirname(parse_url($url)["path"]) . substr($src, 1);
	 	  }
	 	else if(substr($src, 0, 3) == "../"){
	 		$src = $scheme . "://" . $host . "/" . $src;
	 	  }
	 	else if(substr($src, 0, 5) !== "https"  && substr($src, 0, 4) !== "http"){
	 		$src = $scheme . "://" . $host . "/" . $src;
	 	  }

	 	 return $src;
	   }


	 function getDetails($url){
	 	global $alreadyFoundImages;
	 	$parser = new DomDocumentParser($url);
	 	$titleArray = $parser->getTitleTags();
	 	if(sizeof($titleArray) == 0 || $titleArray->item(0) == NULL){
	 		return;
	 	 }
	 	
	 	$title = $titleArray->item(0)->nodeValue; // get first item in array
	 	$title = str_replace("\n", "", $title); // replace newline

	 	if($title == ""){
	 			return;
	 	  }

	 	 $description =  "";
	 	 $keywords = "";

	 	 $metasArray = $parser->getMetaTags();

	 	foreach($metasArray as $meta){
	 	 	if($meta->getAttribute("name") == "description"){
	 	 			$description = $meta->getAttribute("content");
	 	 	    }

	 	 	 if($meta->getAttribute("name") == "keywords"){
	 	 		$keywords = $meta->getAttribute("content");
	 	 	  }
	 	  }

	 	 
	 	$description = str_replace("\n", "", $description); // replace newline
	 	$keywords = str_replace("\n", "", $keywords); // replace newline

	 	// check if link already exists in db
	 	if(linkExists($url)){
	 		echo "$url already exists<br/>";
	 	   }
	 	  // insert into db
	 	 else if(insertLink($url, $title, $description, $keywords)){
	 	 	 echo "SUCCESS:  $url<br/>";
	 	   }
	 	 else{
	 	 	echo "ERROR: Failed to insert $url<br/>";
	 	   }
	 	
	 	// images
	 	 $imageArray = $parser->getImages();  
	 	 foreach($imageArray as $image){
	 	 		$src = $image->getAttribute("src");
	 	 		$alt = $image->getAttribute("alt");
	 	 		$image_title = $image->getAttribute("title");

	 	 		// if image doesn't have title or alt - continue
	 	 		if(!$title && !$alt){
	 	 			continue;
	 	 		  }

	 	 		$src = createLink($src, $url);

	 	 		if(!in_array($src, $alreadyFoundImages)){
	 	 			$alreadyFoundImages[] = $src;

	 	 			//insert images
	 	 			if(insertImage($url, $src, $alt, $image_title)){
	 	 				echo "SUCCESS: $src<br/>";
	 	 			  }
	 	 		  }

	 	   }

	 	// echo "URL: $url, Title: $title, Description: $description, Keywords: $keywords<br>";
	      
	 }



	function followLinks($url){
		global $alreadyCrawled;
		global $crawling;

		$parser = new DomDocumentParser($url);

		$linkList = $parser->getLinks();

		foreach ($linkList as $link) {
			$href = $link->getAttribute("href");

			 // links to be ignored
			if(!$href){
				continue;
			  }
			else if(strpos($href, "#") !== false){
				continue;
			  }
			else if(substr($href, 0, 12) == "javascript"){
				continue;
			 }

			$href = createLink($href, $url); 

			if(!in_array($href, $alreadyCrawled)){
				$alreadyCrawled[] = $href;
				$crawling[] = $href;

				//insert $href
				 
				getDetails($href);
				 
				
			 }

			//echo $href . "<br/>";


		  }

		  // remove item from array
		 array_shift($crawling); 

		 foreach($crawling as $site){
		 	 followLinks($site);
		   }
	  }

	if(isset($_POST['url'])){
		$startUrl  = $_POST['url'];
		followLinks($startUrl);
  	  }
	else {
		echo "<form method='POST'>
			<input type='text' placeholder='Enter a url' name='url'>
			<input type='submit' value='Crawl'>
		</form>";
	  }
?>