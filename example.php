<?php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_license_family_development_kit_i1_v3.php';
$return = ritchey_license_family_development_kit_i1_v3('txt', TRUE);
if (is_string($return) === TRUE){
	print_r($return) . PHP_EOL;
} else if ($return === TRUE) {
	echo "TRUE" . PHP_EOL;
} else {
	echo "FALSE" . PHP_EOL;
}
?>