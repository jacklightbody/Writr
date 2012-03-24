<?php
defined('WRITR_LOADED') or die("Access Denied.");
	
class AttributesTypeDateController extends AttributesController {
	public function getName(){
		return 'Date';
	}
	public function save($name,$post){
		//if we need to do any fancy logic to get the attribute into a string we do it here
		//since this is the text one we don't need to do anything.
		parent::save($name,$post[$name]);
	}
	public function formView($name,$value){
		load::helper('html');
		$html=New Html();
		$html->js('jqueryui.js',null,array('footer'=>0,'version'=>'1.8.18','handle'=>'jqueryui'));
		$html->css('jqueryui.css',null,array('footer'=>0,'version'=>'1.8.18','handle'=>'jqueryui'));
		$s=<<<EOD
		<script type="text/javascript>
		$("form").submit(function{
			$("#datepicker-$name").val($("#datepicker-$name").datepicker('getDate'));
		});</script>"
EOD;
		$html->addHeaderItem('<script type="text/javascript">$("#datepicker-$name").datepicker()</script>');
		$html->addHeaderItem($s);
	}
	public function form($name,$value){
		return '<input type="checkbox" id="datepicker-'.$name.'"name="'.$name.'" value="'.$value.'"/>';
	}
}