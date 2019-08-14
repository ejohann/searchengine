<?php 

	class DomDocumentParser {

		public function __construct($url){
			$options = array(
				'http' => array(
					'method' => "GET",
					'header' => "User-Agent: searchEngineBot/0.1\n"
				 )
			  );
			$context = stream_context_create($options);
			
			$document = new DomDocument();
			$document->loadHTML(file_get_contents($url, false, $context));
		  }

	  }



?>