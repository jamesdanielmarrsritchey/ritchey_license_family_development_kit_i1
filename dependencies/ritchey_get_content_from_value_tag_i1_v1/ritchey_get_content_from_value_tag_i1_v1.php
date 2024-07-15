<?php
#Name:Ritchey Get Content From Value Tag i1 v1
#Description:Get the contents of lines in a file between value tages ("<value></value>"). Returns content on success. Returns "FALSE" on failure.
#Notes:Optional arguments can be "NULL" to skip them in which case they will use default values. This function does not support nested value tags; it will close using the first closing tag it finds.
#Arguments:'source' (required) is the file to read from. 'instance' (optional) is a number representing which instance of value tags the content should be extracted from since there could be more than one in a file (e.g., "1" would extract from the first instance). 'remove_extra_line_breaks' (optional) will remove the line break at the start of the content, and end of the content, if present. 'display_errors' (optional) indicates if errors should be displayed.
#Arguments (Script Friendly):source:file:required,prefix:string:required,postfix:string:required,retain_prefix_and_postfix:bool:optional,display_errors:bool:optional
#Content:
#<value>
if (function_exists('ritchey_get_content_from_value_tag_i1_v1') === FALSE){
function ritchey_get_content_from_value_tag_i1_v1($source, $instance = NULL, $remove_extra_line_breaks = NULL, $display_errors = NULL){
	$errors = array();
	if (@is_file($source) === FALSE){
		$errors[] = "source";
	}
	if ($instance === NULL){
		$instance = 1;
	} else if (is_int($instance) === TRUE){
		#Do Nothing
	} else {
		$errors[] = "instance";
	}
	if ($remove_extra_line_breaks === NULL){
		$remove_extra_line_breaks = FALSE;
	} else if ($remove_extra_line_breaks === TRUE){
		#Do Nothing
	} else if ($remove_extra_line_breaks === FALSE){
		#Do Nothing
	} else {
		$errors[] = "remove_extra_line_breaks";
	}
	if ($display_errors === NULL){
		$display_errors = FALSE;
	} else if ($display_errors === TRUE){
		#Do Nothing
	} else if ($display_errors === FALSE){
		#Do Nothing
	} else {
		$errors[] = "display_errors";
	}
	##Task
	if (@empty($errors) === TRUE){
		$handle = @fopen($source, 'r');
		$current_line = NULL;
		$result = array();
		$switch1 = FALSE;
		$value_start = FALSE;
		$value_end = FALSE;
		$current_instance = 0;
		$check1 = FALSE; //This is used to ensure that only the instance value starting tag is trimmed, and not any nested value starting tags.
		while (@feof($handle) !== TRUE AND $switch1 !== TRUE) {
			###Get line from file
			$current_line = @fgets($handle);
			###Check if value tag is present, and update the instance record
			if ($value_start === FALSE) {
				if (is_int(strpos($current_line, '<value>')) === TRUE){
					$current_instance++;
					$value_start_position = strpos($current_line, '<value>');
				}
			}
			###Check if this is the instance being sought
			if ($current_instance === $instance){
				$value_start = TRUE;
			}
			###If the value tag instance has been found, start capturing data
			if($value_start === TRUE) {
				if ($check1 === FALSE){
					$value_start_position = $value_start_position + 7;
					if (strlen($current_line) <= $value_start_position) {
						$value_start_position = 0;
					}
					$current_line = substr($current_line, $value_start_position);
					$check1 = TRUE;
				} else {
					//Do nothing.
				}
				if (is_int(strpos($current_line, '</value>')) === TRUE){
					$current_line = strrev($current_line);
					$value_end_position = strpos($current_line, '>eulav/<');
					$value_end_position = $value_end_position + 8;
					if (strlen($current_line) < $value_end_position) {
						$value_end_position = 0;
					}
					$current_line = substr($current_line, $value_end_position);
					$current_line = strrev($current_line);
					$value_end = TRUE;
				}
				$result[] = $current_line;
			}
			if ($value_end === TRUE){
				$switch1 = TRUE;
			}
		}
		@fclose($handle);
		###Convert result to string
		$result = @implode('', $result);
		###Remove extra line breaks
		if ($remove_extra_line_breaks === TRUE){
			if(substr($result, 0, 1) === PHP_EOL) {
				$result = substr($result, 1);
			}
			if(substr(strrev($result), 0, 1) === PHP_EOL) {
				$result = strrev(substr(strrev($result), 1));
			}
		}
	}
	result:
	##Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('ritchey_get_content_from_value_tag_i1_v1_format_error') === FALSE){
				function ritchey_get_content_from_value_tag_i1_v1_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("ritchey_get_content_from_value_tag_i1_v1_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	##Return
	if (@empty($errors) === TRUE){
		return $result;
	} else {
		return FALSE;
	}
}
}
#</value>
?>