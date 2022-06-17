<?php 
	//	© Copyright 2021 by Vladislav Zhylenko
	namespace Classes;

	require_once 'Parser.php';

	/*
		Translator helper
	*/

	interface iTranslatorFactory
	{
		//Parse settings
		public function __construct($sl, $tl, $value = '');
	}

	class TranslatorFactory
	{
		private $url = '', $headers = [], $data;

		//Parse settings
		public function __construct($sl, $tl, $value = ''){
			$this->url = "https://api.reverso.net/translate/v1/translation";
			$this->headers = [
			   "Connection: keep-alive",
			   "Pragma: no-cache",
			   "Cache-Control: no-cache",
			   "Accept: application/json, text/javascript, */*; q=0.01",
			   "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1",
			   "Content-Type: application/json; charset=UTF-8",
			   "Origin: https://www.reverso.net",
			   "Sec-Fetch-Site: same-site",
			   "Sec-Fetch-Mode: cors",
			   "Sec-Fetch-Dest: empty",
			   "Referer: https://www.reverso.net/translationresults.aspx?lang=RU&sourcetext=%D0%AF%20%D1%85%D0%BE%D1%87%D1%83%20%D0%BF%D0%BE%D0%BA%D1%83%D1%88%D0%B0%D1%82%D1%8C%20%D1%81%D1%8B%D1%80%D0%BE%D0%BA",
			   "Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7",
			];
			$this->data = [
				"input" => $value,
				"from" => $sl,
				"to" => $tl,
				"format" => "text",
				"options" => [
					"origin" => "reversodesktop",
					"sentenceSplitter" => false,
					"contextResults" => true,
					"languageDetection" => false,
				]
			];
		}

		//Parse
		protected function translate()
		{
			$url = $this->url;
			$headers = $this->headers;
			$data = json_encode($this->data);

			$parser = new Parser($url);
			$parser->setHeaders($headers);
			$parser->setFields($data);

			return json_decode($parser->getPage(), 1);
		}
	}
?>