<?php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_get_line_by_prefix_i1_v3.php';
$return = ritchey_get_line_by_prefix_i1_v3("{$location}/ritchey_get_line_by_prefix_i1_v3.php", '#Arguments (Script Friendly):', FALSE, FALSE, TRUE);
if ($return == TRUE){
	print_r($return);
	echo "\n";
} else {
	echo "FALSE";
}
?>