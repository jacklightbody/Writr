<?php
defined('WRITR_LOADED') or die("Access Denied.");
	
class AttributesTypeBooleanController extends AttributesController {
	public function getName(){
		return 'Boolean';
	}
	public function save($name,$post){
		//if we need to do any fancy logic to get the attribute into a string we do it here
		//since this is the text one we don't need to do anything.
		parent::save($name,$post[$name]);
	}
	public function form($name,$value){
		return '<input type="checkbox" name="'.$name.'" value="'.$value.'"/>';
	}
}