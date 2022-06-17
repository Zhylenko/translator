<?php 
	//	© Copyright 2021 by Vladislav Zhylenko
	namespace Classes;

	require_once 'TranslatorFactory.php';

	/*
		Main translator class
	*/

	interface iTranslator
	{
		public function __construct($from, $to);

		//Setters
		public function setSL($value);
		public function setTL($value);

		//Getters
		public function getSL();
		public function getTL();

		public function translate($string = '');
		public function splitString($string = '', $size);
	}

	class Translator extends TranslatorFactory implements iTranslator
	{

		private $sl, $tl;
		
		public function __construct($from, $to)
		{
			$this->setSL($from);
			$this->setTL($to);
		}

		/*
			Setters
		*/

		//Sets source language
		public function setSL($value)
		{
			$this->sl = $value;
			return $this;
		}

		//Sets target language
		public function setTL($value)
		{
			$this->tl = $value;
			return $this;
		}

		/*
			Getters
		*/

		public function getSL()
		{
			return $this->sl;
		}

		public function getTL()
		{
			return $this->tl;
		}


		public function translate($string = '')
		{
			parent::__construct($this->getSL(), $this->getTL(), $string);
			$answer = parent::translate();

			return $answer['translation'][0];
		}

		public function splitString($string = '', $size)
		{
			//Get sentences
			$pattern = "#.*?[.?!](?:\s|$)#uis";
			preg_match_all($pattern, $string, $matches);
			$sentences = $matches[0];
			unset($matches);

			if(count($sentences) == 0){
				return [$string];
			}

			//Split
			$result = [];
			$i = 0;
			$length = 0;
			foreach ($sentences as $key => $sentence) {
				if(($length + strlen($sentence)) > $size){
					$length = 0;
					$i++;
				}
				$result[$i][] = $sentence;
				$length += strlen($sentence);
			}

			return $result;
		}
	}
?>