<?php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_get_content_from_value_tag_i1_v1.php';
$return = ritchey_get_content_from_value_tag_i1_v1("{$location}/temporary/example.txt", 2, TRUE, TRUE);
if ($return == TRUE){
	print_r($return);
	echo PHP_EOL;
} else {
	echo "FALSE";
}
?>