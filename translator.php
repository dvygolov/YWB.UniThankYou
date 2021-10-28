<?php
	define("DEEPL_KEY","YOUR_API_KEY");
    include 'requestfunc.php';
	function translate($text_content,$templates_lang,$lang,$translator){
		if ($translator==='libretranslate'){
			$translateAddress='https://libretranslate.de/translate';
			$params = array("q"=>$text_content,"source"=>$templates_lang,"target"=>$lang,"format"=>"text");
			$json= json_decode(post($translateAddress,$params));
			if (isset($json->error)) //this language is not supported so we show an english version
				return 'error';
			else
				return $json->translatedText;
		}
		else if ($translator==='deepl'){
			$address_start=strpos(DEEPL_KEY,":fx")!==-1?"api-free":"api";
			$translateAddress='https://'.$address_start.'.deepl.com/v2/translate?auth_key='.DEEPL_KEY;
			$params = array("auth_key"=>DEEPL_KEY,"text"=>$text_content,"source_lang"=>strtoupper($templates_lang),"target_lang"=>strtoupper($lang));
			$res= post($translateAddress,$params);
			$json=json_decode($res);
			if (!isset($json))
				return 'error';
			else
				return $json->translations[0]->text;
		}
	}
?>