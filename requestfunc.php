<?php

function get_request_headers(){
    $headers=array();
    $headers[]="Content-Type: application/x-www-form-urlencoded";
    return $headers;
}

function post($url,$parameters){
    $curl = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTPHEADER => get_request_headers()
			);
    $optArray[CURLOPT_POST]=1;
    $optArray[CURLOPT_POSTFIELDS]=http_build_query($parameters);
    $optArray[CURLOPT_FOLLOWLOCATION]=true;
    curl_setopt_array($curl, $optArray);
    $json = curl_exec($curl);
    $info = curl_getinfo($curl);
    $error= curl_error($curl);
    curl_close($curl);
    return $json;
}

?>