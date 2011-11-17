<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class WritrController extends Controller{
	public function newPost(){
		foreach($_POST as $post){
			if(!isset($post)||$post==""){
				$error=1;
				return array('goto'=>'writr&task=new&error=1');
			}
		}
		//load::model('post');
		Post::addPost($_POST['name'],$_POST['body'],$this->generateUrl($_POST['path']),$_POST['draft'],$_POST['theme']);
	}
	public function update(){
		foreach($_POST as $post){
			if(!isset($post)||$post==""){
				$error=1;
				return array('goto'=>'?path=writr&task=new','message'=>'Please fill out all fields');
			}
		}
		Post::updatePost($_POST['id'],$_POST['name'],$_POST['body'],$this->generateUrl($_POST['path']),$_POST['draft'],$_POST['theme']);
	}
	public function view(){
		$themes=array();
		$cthemes=array();
		$handle=opendir('themes');
		if($_GET['task']=='new'||$_GET['task']==edit){
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
			if($_GET['task']=='new'){
				return array("themes"=>$themes,"cthemes"=>$cthemes);
			}
		}if($_GET['task']=='edit'){
			$p=new Post($_GET['id']);
			return array("post"=>$p->getPostInfo(),"themes"=>$themes,"cthemes"=>$cthemes);
		}
	}
	function generateUrl ($s) {
 		$from = explode (',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
  		$to = explode (',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
  		$s = preg_replace ('~[^\w\d]+~', '-', str_replace ($from, $to, trim ($s)));
  		return strtolower (preg_replace ('/^-/', '', preg_replace ('/-$/', '', $s)));
	}
	
}