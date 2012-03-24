<?php
defined('WRITR_LOADED') or die("Access Denied.");
	
class AttributesTypeTextController extends AttributesController {
	public function getName(){
		return 'Text Field';
	}
	public function save($name,$post){
		//if we need to do any fancy logic to get the attribute into a string we do it here
		//since this is the text one we don't need to do anything.
		parent::save($name,$post[$name]);
	}
	public function form($name,$value){
		return '<input type="text" name="'.$name.'" value="'.$value.'"/>';
	}
}