<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class GeneralController extends Controller{
	public function save(){
		config::save('disqus_username',$_POST['disqus']);
		config::save('site_name',$_POST['site-name']);
	}
}