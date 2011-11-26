<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class ManageController extends Controller{
	public function view(){
		load::model('dashboard_elements');
		return array("links"=>DashboardElements::getElements());
	}
}