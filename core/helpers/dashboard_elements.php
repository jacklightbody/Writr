<?php
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: elements
    Allows registering and executing elements for use by third party extensions
    About:
    - file		elements.php
	- version	1.0
	- date		11/10/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Helper
*/
	
class DashboardElements {
	public static $elements = array();
	/*
	 Function: getElements
	
	gets all the registered elements
	
	Returns:
	
		elements- an array of all registered elements	
		
	See Also:
	
	   <fire>
	*/
	public function getElements(){
		return self::$elements;
	}
	/*
	 Function: registerElement
	
	Adds an element to the system
	
	Parameters:
	
	   element - The name of the element you want to extend
	   file - file that contains the element
	   function - the function that you want to call in the file
	   pkg - the extension this is related with. Used for uninstalling.
	   type - the type of the function that you want to call. 0 if you just want to get the data, 1 if you want to edit it.
	
	See Also:
	
	   <fire>
	   <uninstallExtelement>
	*/
    public static function registerElement($element,$file,$function,$ext, $type=0){
    	//add the element to the array
    	if($ext){
    		self::$elements[$element][$ext]['function'] = $function;
    		self::$elements[$element][$ext]['location'] = $file;
    		self::$elements[$element][$ext]['type'] = $file;
    	}else{
    		self::$elements[$element][]['function'] = $function;
    		self::$elements[$element][]['location'] = $file;
    		self::$elements[$element][]['type'] = $file;
    	}
    }
    /*
	 Function: uninstallExtelement
	
	Adds an element to the system
	
	Parameters:
		element- the name of the element you want to uninstall
	    ext - The name of the extension you want to uninstall elements for
	
	See Also:
	
	   <fire>
	   <registerelement>
	*/
    public static function uninstallExtelement($element,$ext){
    	//remove the element
    	unset(self::$elements[$element][$ext]);
    }
    /** 
    * Does both methods, in the correct order
    */
   	/*
	 Function: fire
	
	Queries all registered elements to get their data. Pass an array of elements that you want modified into this.
	
	Parameters:
	
	   element - The name of the element you want to extend
	   args - an array of the data you want to pass on to extensions
	   
	Returns:
	
      The output of the elements
      
	See Also:
	
	   <fireelement>
	   <fireelementEdit>
	*/
    public function fire($element, $args=array()){
    	if($content!=""){
    		$data=self::fireelementEdit($element,$args);
    	}
    	self::fireelement($element, $args);
    	return $data;	
    }
   	/*
	 Function: fireelement
	
	fires an element when you want elements to use the data but not modify it
	
	Parameters:
	
	   element - The name of the element you want to extend
	   args - an array of the data you want to pass on to extensions
	
	See Also:
	
	   <fire>
	   <fireelementEdit>
	*/
    public function fireelement($element, $args = array()){
        if(isset(self::$elements[$element])){
            foreach(self::$elements[$element] as $ev){
            	if($ev['type']==0){
            		//only do the ones that don't return data
            		include $ev['location'];
            		$function=$ev['function'];
                	call_user_func_array($function, $args);
                }
            }
        }
    }
    /*
	 Function: fireelementEdit
	
	Fires the element and recieves the modified information. 
	Put the content you want modified as the first value in args
	
	Building an element? You need to return an array of the modified args in the same format and order as you get it.
	
	Parameters:
	
	   element - The name of the element you want to extend
	   args - an array of the data you want to pass on to extensions
	   
	Returns:
	
      The output of the elements
      
	See Also:
	
	   <fire>
	   <fireelementEdit>
	*/
    public function fireelementEdit($element, $args = array()){
    	$elementReturn=false;
    	$i=0;
        if(isset(self::$elements[$element])){
            foreach(self::$elements[$element] as $ev){
            	if($ev['type']==1){//only do the ones that return data
            		include $ev['location'];
            		$function=$ev['function'];
            		//if theres a return on this we'll capture that data.
                	$args=call_user_func_array($function, $args);
                	$i++;
                }
            }
        }
        return $args;
        // return the modified data. Yipee!
    }
}