<?php 

	class DomDocumentParser {

		private $document;

		public function __construct($url){
			$options = array(
				'http' => array(
					'method' => "GET",
					'header' => "User-Agent: searchEngineBot/0.1\n"
				 )
			  );
			$context = stream_context_create($options);
			
			$this->document = new DomDocument();
			@$this->document->loadHTML(file_get_contents($url, false, $context));
		  }

		public function getLinks(){
			return $this->document->getElementsByTagName("a");
		  }  

		public function getTitleTags(){
			return $this->document->getElementsByTagName("title");
		  } 

		public function getMetaTags(){
			return $this->document->getElementsByTagName("meta");
		  } 

	  }



?>