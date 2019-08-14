<?php 
	 include("classes/DomDocumentParser.php");

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

			echo $href . "<br/>";	
		  }
	  }


	$startUrl = "https://www.sunsetcity.gd";

	followLinks($startUrl);
?>