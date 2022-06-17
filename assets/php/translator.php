<?php 
	//	© Copyright 2021 by Vladislav Zhylenko
	spl_autoload_register();
	
	use Classes\Translator;

//=========================
	if(empty($_POST)){
		header("HTTP/1.1 403 Forbidden");
		exit;
	}

	//Get data
	$string = $_POST['text'];
	$sl = 'rus';
	$tl = 'eng';

	$translator = new Translator($sl, $tl);
	//Splitting string to override char's limit
	$blocks = $translator->splitString($string, 2000);
	unset($string);

	//Translating blocks
	$translatedText;
	foreach ($blocks as $key => $sentences) {
		$string = (count($blocks) > 1)? implode(' ', $sentences): $sentences;
		$translatedText[] = $translator->translate($string);
	}
	//Combine translated blocks into one string
	$translatedText = implode(' ', $translatedText);
	
	//Show response
	echo($translatedText);
?>

<form method="post">
	<textarea name="text" id="" cols="30" rows="10"></textarea>
	<input type="submit">
</form>