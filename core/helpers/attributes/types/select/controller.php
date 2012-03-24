<?php
defined('WRITR_LOADED') or die("Access Denied.");
	
class AttributesTypeSelectController extends AttributesController {
	public function getName(){
		return 'Select';
	}
	public function save($name,$post){
		//if we need to do any fancy logic to get the attribute into a string we do it here
		//since this is the text one we don't need to do anything.
		parent::save($name,$post[$name]);
	}
	public function form($name,$value){
		$possible=Config::get('possible');
		$f='<select name="'.$name.'">';
		$possible=explode(',', $possible);
		foreach($possible as $poss){
			$sel='';
			if($value==$post){
				$sel='selected';
			}
			$f.='<option value="'.$poss.'" '.$sel.'>'.$poss.'</option>' ;
		}
		$f.='</select>';
	}
}