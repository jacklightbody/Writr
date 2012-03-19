<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class AttributeController extends Controller{
	var $title='Attributes';
	public function view(){
		$attrs=Attribute::getAttributes();
		return array('attrs'=>$attrs);
	}
}