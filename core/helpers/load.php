<?php 
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Load
    Loads packets of commonly used info and files from the correct location.
    About:
    - file		load.php
	- version	1.0
	- date		11/9/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Helper
*/
class Load {
   	/*
	 Function: db
	
	 Loads the adodb db abstraction layer
	
	Returns:
	
	A new instance of a database connection.
	*/
     public function db() {
     	Load::helper('3rdparty/adodb/adodb.inc');
     	Load::helper('3rdparty/adodb/adodb-exceptions.inc');
 		try { 
     	    $db = ADONewConnection('mysql');
 		    if(!$db){
 		    	die('Unsuccessful Connection');
 		    }
 		    $db->Connect(SQL_SERVER, SQL_USER, SQL_PASS, SQL_DB);
     	} catch (exception $e) { 
 		    var_dump($e); 
 		    adodb_backtrace($e->gettrace());
     	} 
     	return $db;
     }	
   	/*
	 Function: model
	
	Loads a site model in the correct location
	
	Parameters:
	
	   name - The name of the model you want to load
	   extHandle - An option handle of the extension to load the model from.
	   
	 See Also:
	
	   <helper>
	*/
     public function model($name,$extHandle=null){
     	$root=str_replace('core/helpers/load.php', '', __file__);
     	if(file_exists(''.DIR_MODELS.'/'.$name.'.php')){
     		require_once(''.DIR_MODELS.'/'.$name.'.php');
     	}elseif(isset($extHandle)&&file_exists('extensions/'.$extHandle.'/'.DIR_MODELS.'/'.$name)){
     		require_once('extensions/'.$extHandle.'/'.DIR_MODELS.'/'.$name);
     	}elseif(file_exists(''.DIR_CORE_MODELS.'/'.$name.'.php')){
     		require_once(''.DIR_CORE_MODELS.'/'.$name.'.php');
     	}
     }

   	/*
	 Function: helper
	
	Loads a site helper in the correct location
	
	Parameters:
	
	   name - The name of the helper you want to load
	   extHandle - An option handle of the extension to load the helper from.
	   
	 See Also:
	
	   <model>
	*/
     public function helper($name,$extHandle=null){
     	$root=str_replace('core/helpers/load.php', '', __file__);
     	if(file_exists(''.DIR_HELPERS.'/'.$name.'.php')){
     		require_once(''.DIR_HELPERS.'/'.$name.'.php');
     	}elseif(isset($extHandle)&&file_exists('extensions/'.$extHandle.'/'.DIR_HELPERS.'/'.$name)){
     		require_once('extensions/'.$extHandle.'/'.DIR_HELPERS.'/'.$name);
     	}elseif(file_exists(''.DIR_CORE_HELPERS.'/'.$name.'.php')){
     		require_once(''.DIR_CORE_HELPERS.'/'.$name.'.php');
     	}
     }
     /*
	 Function: Controller
	
	Loads a site controller in the correct location
	
	Parameters:
	
	   name - The name of the controller you want to load
	   extHandle - An option handle of the extension to load the controller from.
	   
	 See Also:
	
	   <model>
	*/
     public function controller($name,$extHandle=null){
     	if(file_exists('controllers/'.$name.'.php')){
     		require_once('controllers/'.$name.'.php');
     	}elseif(isset($extHandle)&&file_exists('extensions/'.$extHandle.'/controllers/'.$name)){
     		require_once('extensions/'.$extHandle.'/controllers/'.$name);
     	}elseif(file_exists('core/controllers/'.$name.'.php')){
     		require_once('core/controllers/'.$name.'.php');
     	}
     }
     /*
	 Function: Theme
	
	Loads a theme in the correct location
	
	Parameters:
	
	   handle - The folder name of the theme you want to load
	   template - The name of the post template to load
	   pid - The handle of a post
	    extHandle - An option handle of the extension to load the theme from.
	   
	 See Also:
	
	   <model>
	*/
     public function theme($handle,$template,$extHandle=null){
     	if(file_exists('themes/'.$handle.'/'.$template.'.php')){
     		return 'themes/'.$handle.'/'.$template.'.php';
     	}elseif(isset($extHandle)&&file_exists('extensions/'.$extHandle.'/themes/'.$handle.'/'.$template.'.php')){
     		return 'extensions/'.$extHandle.'/themes/'.$handle.'/'.$template.'.php';
     	}elseif(file_exists('core/themes/'.$handle.'/'.$template.'.php')){
     		return 'core/themes/'.$handle.'/'.$template.'.php';
     	}else{
     		return 'core/themes/'.$handle.'/default/'.$template.'.php';
     	}
     }
    public function oneOff($template,$extHandle=null){
    	$handle=Config::get('home_theme');
    	if(file_exists('view/'.$template.'.php')){
    		return 'view/'.$template.'.php';
    	}elseif(file_exists('core/view/'.$template.'.php')){
    		return 'core/view/'.$template.'.php';
	    }elseif(file_exists('themes/'.$handle.'/'.$template.'.php')){
     		return 'themes/'.$handle.'/'.$template.'.php';
     	}elseif(isset($extHandle)&&file_exists('extensions/'.$extHandle.'/themes/'.$handle.'/'.$template.'.php')){
     		return 'extensions/'.$extHandle.'/themes/'.$handle.'/'.$template.'.php';
     	}elseif(file_exists('core/themes/'.$handle.'/'.$template.'.php')){
     		return 'core/themes/'.$handle.'/'.$template.'.php';
     	}else{
     		return 'core/themes/'.$handle.'/default/'.$template.'.php';
     	}
    }
}