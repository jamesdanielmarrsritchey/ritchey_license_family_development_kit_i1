<?php
#Name:Ritchey Get Line By Prefix i1 v3
#Description:Get the content of a line in a file based on the start of the line. Returns line on success. Returns "FALSE" on failure.
#Notes:Optional arguments can be "NULL" to skip them in which case they will use default values.
#Arguments:'source' (required) is the file to read from. 'prefix' (required) is the prefix to search for. 'retain_line_ending' (optional) specifies whether to retain the line ending in the return. 'retain_prefix' (optional) specifies whether to retain the prefix string in the return. 'display_errors' (optional) indicates if errors should be displayed.
#Arguments (Script Friendly):source:file:required,prefix:string:required,retain_line_ending:bool:optional,retain_prefix:bool:optional,display_errors:bool:optional
#Content:
if (function_exists('ritchey_get_line_by_prefix_i1_v3') === FALSE){
function ritchey_get_line_by_prefix_i1_v3($source, $prefix, $retain_line_ending = NULL, $retain_prefix = NULL, $display_errors = NULL){
	$errors = array();
	if (@is_file($source) === FALSE){
		$errors[] = "source";
	}
	if (@isset($prefix) === TRUE){
		if ($prefix === ''){
			$errors[] = "prefix";
		}
	} else {
		$errors[] = "prefix";
	}
	if ($retain_line_ending === NULL){
		$retain_line_ending = TRUE;
	} else if ($retain_line_ending === TRUE){
		#Do Nothing
	} else if ($retain_line_ending === FALSE){
		#Do Nothing
	} else {
		$errors[] = "retain_line_ending";
	}
	if ($retain_prefix === NULL){
		$retain_prefix = TRUE;
	} else if ($retain_prefix === TRUE){
		#Do Nothing
	} else if ($retain_prefix === FALSE){
		#Do Nothing
	} else {
		$errors[] = "retain_prefix";
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
	##Task []
	if (@empty($errors) === TRUE){
		$handle = @fopen($source, 'r');
		$line = '';
		while (@feof($handle) !== TRUE AND @substr($line, 0, @strlen($prefix)) != $prefix) {
			$line = @fgets($handle);
		}
		@fclose($handle);
		###Determine if a match was found, or not.
		if (@substr($line, 0, @strlen($prefix)) != $prefix){
			$errors[] = "line - no line found with prefix";
			goto result;
		}
		###Determine if the prefix should be retained.
		if ($retain_prefix === FALSE){
			$line = @substr($line, @strlen($prefix));
		}
		###Determine if line ending should be retained.
		if ($retain_line_ending === FALSE){
			$line = @rtrim($line, "\n");
			$line = @rtrim($line, "\r");
		}
	}
	result:
	##Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('ritchey_get_line_by_prefix_i1_v3_format_error') === FALSE){
				function ritchey_get_line_by_prefix_i1_v3_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("ritchey_get_line_by_prefix_i1_v3_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	##Return
	if (@empty($errors) === TRUE){
		return $line;
	} else {
		return FALSE;
	}
}
}
?>