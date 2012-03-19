<?php 
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Attribute
    Deals with attrbute values
    About:
    - file		attribute.php
	- version	1.0
	- date		11/9/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Model
*/
class Attribute {
	public function getAllAttributeValues($pID){
		$db=load::db();
		$results= $db->getAll("SELECT atID,aValue FROM ".WRITR_PREFIX."attributes WHERE pID=?",array($pID));
		$array=array();
		foreach($results as $arr){
			$handle= $db->getAll("SELECT atHandle FROM ".WRITR_PREFIX."attribute_types WHERE atID=?",array($arr['atID']));
			$array[][$handle]=$arr['aValue'];
		}
		return $array;
	}
	public function getAttributes(){
		$db=load::db();
		return $db->getAll("SELECT * FROM ".WRITR_PREFIX."attributes INNER JOIN attribute_types ON attributes.atID=attribute_types.atID");
	}
	public function getPageAttributes(){
		$db=load::db();
		return $db->getAll("SELECT * FROM ".WRITR_PREFIX."attributes INNER JOIN attribute_types ON attributes.atID=attribute_types.atID INNER JOIN attribute_values ON attributes.aID=attribute_values.aID");
	}
	public function add(){
		
	}
}