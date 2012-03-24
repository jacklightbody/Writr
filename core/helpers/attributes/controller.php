<?php
defined('WRITR_LOADED') or die("Access Denied.");
	
class AttributesController {
	public function save($handle,$data,$misc){
		load::model('attribute');
		AttributeValues::Save($handle,$data,$misc);
	}
}