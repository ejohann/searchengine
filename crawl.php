<?php 
	 include("classes/DomDocumentParser.php");

	 function createLink($src, $url){
	 	$scheme = parse_url($url)["scheme"]; //http
	 	$host = parse_url($url)["host"]; // www.sunsetcity.gd / link

	 	if(substr($src, 0, 2) =="//"){
	 		$src = $scheme . ":" . $src;
	 	  }
	 	else if(substr($src, 0, 1) =="/"){
	 		$src = $scheme . "://" . $src;
	 	  }

	 	//echo "SRC: $src<br/>";
	 	//echo "URL: $url<br/>";
	   }

	function followLinks($url){
		$parser = new DomDocumentParser($url);

		$linkList = $parser->getLinks();

		foreach ($linkList as $link) {
			$href = $link->getAttribute("href");

			if(strpos($href, "#") !== false){
				continue;
			  }
			else if(substr($href, 0, 12) == "javascript"){
				continue;
			 }

			createLink($href, $url); 
			echo $href . "<br/>";	
		  }
	  }


	$startUrl = "https://www.sunsetcity.gd";

	followLinks($startUrl);
?>