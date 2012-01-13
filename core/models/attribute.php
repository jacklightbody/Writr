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
		$results= $db->getAll("SELECT atID,aValue FROM ".WRITR_PREFIX."atrributes WHERE pID=?",array($pID));
		$array=array();
		foreach($results as $arr){
			$handle= $db->getAll("SELECT atHandle FROM ".WRITR_PREFIX."atrribute_types WHERE atID=?",array($arr['atID']));
			$array[][$handle]=$arr['aValue'];
		}
		return $array;
	}
}