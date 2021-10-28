<?php
function getcountrylang($country){
	$country=strtolower($country);
	switch($country){
		case 'ar':
		case 'bo':
		case 'cl':
		case 'co':
		case 'cr':
		case 'do':
		case 'ec':
		case 'es':
		case 'gt':
		case 'hn':
		case 'mx':
		case 'ni':
		case 'pa':
		case 'pe':
		case 'pr':
		case 'py':
		case 'sv':
		case 'us':
		case 'uy':
		case 've':
			return 'es';
	}
	return $country;
}
?>