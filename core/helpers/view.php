<?php defined('WRITR_LOADED') or die("Access Denied.");
/**
*	@file		view.php
*	@version	1.0
*	@date		9/15/2011
*	@author		Jack Lightbody <jack.lightbody@gmail.com>
*	@type		helper
*	@info		
*		-- Renders a page
*/
	
class View {
	
	public function route($dashboard=null){
		if(isset($dashboard)){
			return load::theme('dashboard','page');
		}else{
			if(isset($_GET['path'])){//if theres a post we're loading
				if($_GET['path']=='page_not_found'){
					return load::oneOff('page_not_found');
				}else{
					load::model('post');
					$post=New Post($_GET['path']);
					return load::theme($post->getTheme(),'post');	
				}
			}else{//homepage!
				return load::theme(Config::get('home_theme'),'list');
			}
		}
	}
}