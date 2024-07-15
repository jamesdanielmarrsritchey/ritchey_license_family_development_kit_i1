<?php
//Name: Ritchey License Family Development Kit
//Description: Generate license texts using configuration files. On success returns "TRUE". Returns "FALSE" on failure.
//Notes: Optional arguments can be "NULL" to skip them in which case they will use default values.
//Dependencies: 
//Arguments: 'filetype' (optional) indicates the type of file to create. Valid filetypes are: 'txt'. 'display_errors' (optional) indicates if errors should be displayed.
//Arguments (Script Friendly):filetype:string:optional,display_errors:bool:optional
//Content:
//<value>
if (function_exists('ritchey_license_family_development_kit_i1_v3') === FALSE){
function ritchey_license_family_development_kit_i1_v3($filetype = NULL, $display_errors = NULL){
	# Check Variables
	$errors = array();
	$location = realpath(dirname(__FILE__));
	if ($filetype === NULL){
		$filetype = 'txt';
	} else if ($filetype === 'txt'){
		#Do Nothing
	} else if ($filetype === 'markdown'){
		$errors[] = "filetype (markdown not presently supported)";
	} else {
		$errors[] = "filetype";
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
	# Task
	if (@empty($errors) === TRUE){
		$return = array();
		## Load all the texts into an array
		$location = realpath(dirname(__FILE__));
		require_once $location . '/dependencies/ritchey_list_files_i1_v1/ritchey_list_files_i1_v1.php';
		$list = ritchey_list_files_i1_v1("{$location}/databases/default", TRUE);
		//var_dump($list);
		$texts = array();
		foreach ($list as $item){
			$item_name = basename($item, ".txt");
			$item_value = file_get_contents($item);
			$texts[$item_name] = $item_value;
		}
		unset($item);
		//var_dump($texts);
		## For each configuration file, generate a file comprised of the appropriate text pieces
		$location = realpath(dirname(__FILE__));
		require_once $location . '/dependencies/ritchey_get_line_by_prefix_i1_v3/ritchey_get_line_by_prefix_i1_v3.php';
		$list = ritchey_list_files_i1_v1("{$location}/configuration_files", TRUE);
		//var_dump($list);
		foreach ($list as $item){
			$location = realpath(dirname(__FILE__));
			require_once $location . '/dependencies/ritchey_list_files_i1_v1/ritchey_list_files_i1_v1.php';
			$item_name = ritchey_get_line_by_prefix_i1_v3($item, 'Name: ', FALSE, FALSE, TRUE);
			//var_dump($item_name);
			$item_version = ritchey_get_line_by_prefix_i1_v3($item, 'Version: ', FALSE, FALSE, TRUE);
			//var_dump($item_version);
			//$item_filename = str_replace('-', '', str_replace(' ', '_', strtolower($item_name))) . '_v' . $item_version . '.txt';
			$item_filename = $item_name . ' v' . $item_version . '.txt';
			//var_dump($item_filename);
			$location = realpath(dirname(__FILE__));
			require_once $location . '/dependencies/ritchey_get_content_from_value_tag_i1_v1/ritchey_get_content_from_value_tag_i1_v1.php';
			$item_value = ritchey_get_content_from_value_tag_i1_v1($item, 1, TRUE, TRUE);
			//var_dump($item_value);
			$item_value = explode(PHP_EOL, $item_value);
			//var_dump($item_value);
			$spacing = PHP_EOL . PHP_EOL;
			$compiled_text = array();
			$compiled_text[] = $item_name . " v{$item_version}";
			$compiled_text[] = $spacing;
			$m = 1;
			foreach ($item_value as &$item_2){
				if (substr($item_2, 0, 9) === 'Statement'){
					// Do nothing
				} else if (substr($item_2, 0, 9) === 'Expansion'){
					// Do nothing
				} else if (substr($item_2, 0, 14) === 'List Expansion'){
					$compiled_text[$m] = PHP_EOL;
				}
				$compiled_text[] = $texts[$item_2];
				$compiled_text[] = $spacing;
				$m = $m + 2;
			}
			unset($item_2);
			$compiled_text = rtrim(implode($compiled_text));
			//var_dump($compiled_text);
			file_put_contents("{$location}/live/Plain-Text/{$item_filename}", $compiled_text);
		}
		unset($item);
	}
	result:
	# Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('ritchey_license_family_development_kit_i1_v3_format_error') === FALSE){
				function ritchey_license_family_development_kit_i1_v3_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("ritchey_license_family_development_kit_i1_v3_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	# Return
	if (@empty($errors) === TRUE){
		if (@empty($result) === TRUE){
			return TRUE;
		} else {
			return $result;
		}
	} else {
		return FALSE;
	}
}
}
//</value>
?>