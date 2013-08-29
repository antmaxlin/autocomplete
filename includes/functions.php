<?php
function escape_data($data) {
	//Address Magic Quotes.
	if (ini_get('magic_quotes_gpc')) {
		$data = stripslashes($data);
	}
	//Check for mysql_real_escape_string() support.
	if (function_exists('mysql_real_escape_string')) {
		$data = mysql_escape_string(trim($data));
	}
	//Return the escaped value.
	return $data;
} //End of function.

function nl2br2($content) {
	$content = stripslashes(str_replace("\\r\\n", "<br>", $content));
	return $content;
}

function truncate_text($string, $limit, $break=".", $pad="...") { 
	// return with no change if string is shorter than $limit  
	if(strlen($string) <= $limit) return $string; 
	// is $break present between $limit and the end of the string?
	if ($limit > 50) {
		if(false !== ($breakpoint = strpos($string, $break, $limit))) { 
			if($breakpoint < strlen($string) - 1) { 
				$string = substr($string, 0, $breakpoint) . $pad; 
				return $string;
			}
		}
	} else {
		$pad='';
	}
	$string = substr($string, 0, $limit);
	$last = strrpos($string, ' ');
	if ($last != 0) $string = substr($string, 0, $last);
	return $string.$pad; 
}

function url_in($content) {
	$content = str_replace("&","!@100", $content);
	$content = str_replace("/","!@110", $content);
	$content = str_replace("'","!@120", $content);
	$content = str_replace("#","!@130", $content);
	$content = str_replace("+","!@140", $content);
	$content = str_replace(".","!@150", $content);
	$content = str_replace("\\","!@160", $content);
 	$content = urlencode($content);
	return $content;
}
 
function url_out($content) {
	$content = str_replace("!@100","&", $content);
	$content = str_replace("!@110","/", $content);
	$content = str_replace("!@120","'", $content);
	$content = str_replace("!@130","#", $content);
	$content = str_replace("!@140","+", $content);
	$content = str_replace("!@150",".", $content);
	$content = str_replace("!@160","\\", $content);
 	$content = urldecode($content);
	$content = str_replace("\\","", $content);
	return $content;
}

?>