<?php
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Text
    Functions useful for working with text
    - file		text.php
	- version	1.0
	- date		9/29/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Html Writr
	- type		Helper
*/
	
class Text {
	/*
	  Function: sanitize
		Sanitizes a string
		
	  Parameters:
	  
	  	text- the string you want sanitized
	  	allowed- the allowed tags in the string
	  	
	  Returns:
	  
	  	the cleaned string
	  	
	*/
     public function sanitize($text, $allowed="") {
     	if ($text == null) {
			return "";
		}
     	$text=strip_tags($text, $allowed);
     	return $text;
     }
    /*
	  Function: camelcase
	  
		Converts a string like test_string to TestString
		
	  Parameters:
	  
	  	string- the string you want camelcased
	  	
	  Returns:
	  
	  	the camelcased string
	  	
	  See Also:
	  
	  	<uncamelcase>
	*/
     public function camelcase($string) {
		$string = ucwords(str_replace(array('_', '-', '/'), ' ', $string));
		$string = str_replace(' ', '', $string);
		return $string;		
	}
	   /*
	  Function: uncamelcase
	  
		Converts a string like TestString to test_string 
		
	  Parameters:
	  
	  	string- the string you want uncamelcased
	  	
	  Returns:
	  
	  	the uncamelcased string
	  	
	  See Also:
	  
	  	<camelcase>
	  	
	*/
     public function uncamelcase($string) {
		$name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_name));	
	}
	
	public function shortText($text, $chars=255, $tail='…') {
		if (intval($chars)==0) $chars=255;
		$text=strip_tags($text,'<a>');
		if (function_exists('mb_substr') && function_exists('mb_strlen')) {
			if (mb_strlen($text, WRITR_CHARSET) > $chars) { 
				$text = mb_substr($text, 0, $chars, WRITR_CHARSET) . $tail;
			}
		} else {
			if (strlen($text) > $chars) { 
				$text = substr($text, 0, $chars) . $tail;
			}
		}
		return $text;			
	}

    public function shortenTextWord($text, $chars=255, $tail='…') {
		if (intval($chars)==0) $chars=255;
		$text=strip_tags($text,'<a>');
		if (function_exists('mb_substr')) {
			if (mb_strlen($text, WRITR_CHARSET) > $chars) { 
				$text=preg_replace('/\s+?(\S+)?$/', '', mb_substr($text, 0, $chars + 1, WRITR_CHARSET)) . $tail;
			}
		} else {
			if (strlen($text) > $chars) { 
				$text = preg_replace('/\s+?(\S+)?$/', '', substr($text, 0, $chars + 1)) . $tail;
			}
		}
		return $text;		
	}
	public function fallback($var1,$var2){
		if(isset($var1)&&$var1!=''){
			return $var1;
		}
		return $var2;
	}
}