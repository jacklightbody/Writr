<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class ManageController extends Controller{
	var $title='Dashboard Pages';
	public function view(){
		load::model('dashboard_elements');
		return array("links"=>DashboardElements::getElements());
	}
}