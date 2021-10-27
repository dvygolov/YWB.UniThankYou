<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'htmlinject.php';

$translator='deepl'; //deepl or libretranslate

$templates_dir='templates';
$templates_lang='en'; //You can change it to the language of your template's text
$cache_dir='cache';
if (!isset($pixel_sub))
    $pixel_sub='px'; //The GET/POST parameter that will have a Facebook's pixel ID as it's value
if (!isset($pixel_event))
{
    $pixel_event='Lead';
    if (isset($_REQUEST['pixelevent'])) $pixel_event=$_REQUEST['pixelevent'];
}
if (isset($_REQUEST[$pixel_sub]))
    $pixel_code='<img height="1" width="1" src="https://www.facebook.com/tr?id='.$_REQUEST[$pixel_sub].'&ev='.$pixel_event.'&noscript=1">';
if (!is_dir(__DIR__.'/'.$cache_dir)) mkdir(__DIR__.'/'.$cache_dir);

//setting thankyou page language
if (!isset($lang))
    $lang=strtolower(isset($_REQUEST['lang'])?$_REQUEST['lang']:(isset($_REQUEST['country'])?$_REQUEST['country']:'en'));

if (!isset($template))
    $template=isset($_REQUEST['template'])?$_REQUEST['template']:'random';
if (!is_dir(__DIR__.'/'.$templates_dir.'/'.$template)) $template='random';
//selecting a random template
if ($template==='random'){
    $directories = glob($templates_dir.'/*' , GLOB_ONLYDIR);
    $r=rand(0,count($directories)-1);
    $template=substr($directories[$r],strlen($templates_dir)+1);
}

$cached_thankyou_path=__DIR__.'/'.$cache_dir.'/'.$template.'/'.$lang.'.html';
if (!file_exists($cached_thankyou_path)){
    //we should get the text and translate it
    $text_path=__DIR__.'/'.$templates_dir.'/'.$template.'/text.txt';
    $text_content=file_get_contents($text_path);

	include 'translator.php';	
	$translation=array();    
    $translated_text=translate($text_content,$templates_lang,$lang,$translator);
	if ($translated_text==='error'||!isset($translated_text)){
        $cached_thankyou_path=__DIR__.'/'.$cache_dir.'/'.$template.'/en.html';
        $translation=explode("\n",$text_content);
    }
    else {
        $translation=explode("\n",$translated_text);
    }
    
    $template_path=__DIR__.'/'.$templates_dir.'/'.$template.'/t.html';
    $template_content=file_get_contents($template_path);
    for ($i=0;$i<count($translation);$i++){
        $template_content=str_replace('{T'.($i+1).'}',$translation[$i],$template_content);
    }
    if (!is_dir(__DIR__.'/'.$cache_dir.'/'.$template)) { // dir doesn't exist, make it
        mkdir(__DIR__.'/'.$cache_dir.'/'.$template);
    }
    file_put_contents($cached_thankyou_path,$template_content);
}

$thankyou=file_get_contents($cached_thankyou_path);
if (isset($pixel_code))
    $thankyou=insert_after_tag($thankyou,'<body',$pixel_code);
echo $thankyou;
return;
