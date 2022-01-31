<?php
function get_country_lang($country){
	$country=strtolower($country);
	switch($country){
		case 'ar':
		case 'bo':
		case 'cl':
		case 'co':
		case 'ec':
		case 'gt':
		case 'hn':
		case 'mx':
		case 'pe':
			return 'es';
        case 'nz':
        case 'ph':
        case 'us':
			return 'en';
        case 'si':
			return 'sl';
	}
	return $country;
}
?>