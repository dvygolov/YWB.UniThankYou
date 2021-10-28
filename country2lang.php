<?php
function getcountrylang($country){
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
	}
	return $country;
}
?>