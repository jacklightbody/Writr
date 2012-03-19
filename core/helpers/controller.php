<?php
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Controller
    A class that dashboard controllers extend
    - file		controller.php
	- version	1.0
	- date		10/1//2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Helper
*/
	
class Controller {
    /*
	 Function: view
	A function that can be extended to set variables for the view page.
	
	*/
	public function view() {			
	}
	public function submitForm($functionName){
		$action='form_submit.php?file='.$_GET['path'].'&function='.$functionName;
		return $action;
	}
}