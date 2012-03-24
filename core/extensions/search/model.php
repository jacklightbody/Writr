<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class SearchExtensionModel{
	public function getString($search){
		$db=load::db();
		$name=$db->getAll('SELECT pBody FROM '.WRITR_PREFIX.'posts WHERE pName LIKE ?',array('%'.$search.'%'));
		$body=$db->getAll('SELECT pBody FROM '.WRITR_PREFIX.'posts WHERE pBody LIKE ?',array('%'.$search.'%'));
		return array_merge_recursive($name,$body);
	}
}