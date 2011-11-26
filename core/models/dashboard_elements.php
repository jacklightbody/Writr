<?php
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: dashboard elements
    Used to register dashboard elements to include them on the dashboard.
    About:
    - file		elements.php
	- version	1.0
	- date		11/10/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Helper
*/
	
class DashboardElements {
	/*
	 Function: getElements
	
	gets all the registered elements
	
	Returns:
	
		elements- an array of all registered elements	
		
	See Also:
	
	   <registerElement>
	*/
	public function getElements(){
		$db=load::db();
		return $db->getAll("SELECT * FROM dashboardelements");
	}
	/*
	 Function: registerElement
	
	Adds an element to the system
	
	Parameters:
	
	   file - file that contains the element
	   function - the function that you want to call in the file
	   ext - the extension this is related with. Used for uninstalling.
	
	See Also:
	
	   <uninstallExtElement>
	*/
    public static function registerElement($file,$name,$ext){
    	$db=load::db();
    	//add the element to the array
    	$db->query("INSERT INTO dashboardelements (ext,name,file) VALUES (?,?,?)",array($ext,$name,$file));
    }
    /*
	 Function: uninstallExtElement
	
	removes all the elements from an extension 
	
	Parameters:
		element- the name of the element you want to uninstall
	    ext - The name of the extension you want to uninstall elements for
	
	See Also:
	
	   <registerElement>
	*/
    public static function uninstallExtElement($ext){
    	//remove the element
    	$db->query("DELETE FROM dashboardelements WHERE ext=?",array($ext));
    }
    public function get($file){
    	$db=load::db();
    	//get the element
    	return $db->getAll("SELECT * FROM dashboardelements WHERE file=?",array($file));
    }
}