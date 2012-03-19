<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class GeneralController extends Controller{
	var $title='Settings';
	public function save(){
		config::save('disqus_username',$_POST['disqus']);
		config::save('site_name',$_POST['site-name']);
		config::save('pagination',$_POST['pagination']);
		config::save('home_theme',$_POST['theme']);
	}
	public function view(){
		$handle=opendir('themes');
		$cthemes=array();
		$themes=array();
		if($handle) {
			while(($file = readdir($handle)) !== false) {
				if (substr($file, 0, 1) != '.' && is_dir('themes/'.$file)) {
					array_push($themes, $file);
				}
			}
		}
		$handle=opendir('core/themes');
		if($handle) {
			while(($file = readdir($handle)) !== false) {
				if (substr($file, 0, 1) != '.' && is_dir('core/themes/'.$file)&&$file!=='dashboard') {
					array_push($cthemes, $file);
				}
			}
		}
		return array("themes"=>$themes,"cthemes"=>$cthemes);
	}
}