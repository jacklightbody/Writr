<?php 
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Config
    Deals with saving config information
    About:
    - file		config.php
	- version	1.0
	- date		11/9/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Model
*/
class Config {
	/*
	 Function: save
	
	Saves a config value
	
	Parameters:
	
	handle- the key to store the data under
	data- the info to save
	
	See Also:
	
	   <get>
	   <clear>
	*/
	public function save($handle,$data){
		$db=load::db();
		$v=self::get($handle);
		if($v){
			$db->query('UPDATE '.WRITR_PREFIX.'config set cValue=? WHERE cKey=?', array($data,$handle));
		}else{
			$db->query('INSERT INTO '.WRITR_PREFIX.'config (cValue,cKey) VALUES (?,?)', array($data,$handle));
		}
	}
	/*
	 Function: save
	
	Gets the data stored under a key
	
	Parameters:
	
	handle- the key to grab the data under
	
	See Also:
	
	   <save>
	   <clear>
	*/
	public function get($handle){
		$db=load::db();
		return $db->getOne('SELECT '.WRITR_PREFIX.'cValue FROM config WHERE cKey=?', array($handle));
	}
	/*
	 Function: clear
	
	Deletes the data stored under a key
	
	Parameters:
	
	handle- the key to delete the data under
	
	See Also:
	
	   <save>
	   <get>
	*/
	public function clear($handle){
		$db=load::db();
		$db->query('DELETE FROM '.WRITR_PREFIX.'config WHERE cKey=?', array($handle));
	}
}