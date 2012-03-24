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
	public function add($atID,$aName,$aHandle){
		$db=load::db();
		$db->query('INSERT INTO '.WRITR_PREFIX.'attributes (atID,aName,aHandle) VALUES (?,?,?)',array($atID,$aName,$aHandle));
	}
	public function deleteByID($aID){
		$db=load::db();
		$db->query("DELETE FROM ".WRITR_PREFIX."attributes WHERE aID=?",array($aID));
	}
	public function deleteByTypeID($atID){
		$db=load::db();
		$db->query("DELETE FROM ".WRITR_PREFIX."attributes WHERE atID=?",array($atID));
	}
}
class AttributeTypes{
	public function getAllTypes(){
		$db=load::db();
		return $db->getAll('SELECT * FROM '.WRITR_PREFIX.'attribute_types');
	}
	public function addType($atHandle,$ext='core'){
		if(is_object($ext)){
			$extID=$ext->getHandle();
		}else{
			$extID=$ext;
		}
		$db=load::db();
		$db->query("INSERT INTO ".WRITR_PREFIX."attribute_types (atHandle,extHandle) VALUES (?,?)",array($atHandle,$extID));
	}
	public function getByID($atID){
		$db=load::db();
		$info= $db->getAll('SELECT * FROM '.WRITR_PREFIX.'attribute_types WHERE atID=?',array($atID));
		return $info[0];
	}
	public function deleteByExtension($extHandle){
		$db=load::db();
		$atID=$db->getOne('SELECT atID FROM '.WRITR_PREFIX.'attribute_types WHERE extHandle=?',array($extHandle));
		Attribute::deleteByTypeID($atID);
		$db->query("DELETE FROM ".WRITR_PREFIX."attribute_types WHERE extHandle=?",array($extHandle));
	}
	public function deleteByID($atID){
		$db=load::db();
		$db->query("DELETE FROM ".WRITR_PREFIX."attribute_types WHERE atID=?",array($atID));
	}
}
Class AttributeValues(){
	
}