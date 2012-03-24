<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class WritrController extends Controller{
	var $title='Writr';
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
		load::helper('html');
		$html=New Html();
		$html->js('tablesorter.js',null,array('footer'=>0,'version'=>'2.0.5','handle'=>'tablesorter'));
		$html->js('nicedit.js',null,array('footer'=>0,'version'=>'.09r3','handle'=>'nicedit'));
		$script=<<<EOD
		<script type="text/javascript">
		$(document).ready(function() { 
			$(".post-list").tablesorter(); 
		});  
		bkLib.onDomLoaded(function() {
			new nicEditor().panelInstance("body");
		});
		var variable=0;
		function generateTitle(title){
			return title.replace(' ','-');
		}
		</script>
EOD;
		$html->addHeaderItem($script);
		$themes=array();
		$cthemes=array();
		$handle=opendir('themes');
		load::helper('pagination');
		$posts=Post::getAllPosts();
		if(!isset($_GET['page'])){
			$_GET['page']=0;
		}
		$up = new Pagination($posts,$_GET['page'],'dashboard.php?path=writr','page');
		$list=$up->getList();
		$nav=$up->generateLinks();
		if(isset($_GET['task'])&&($_GET['task']=='new'||$_GET['task']=='edit')){
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
		}
		if(isset($_GET['task'])&&$_GET['task']=='new'){
				return array("themes"=>$themes,"cthemes"=>$cthemes);
			}
		if(isset($_GET['task'])&&$_GET['task']=='edit'){
			$p=new Post($_GET['id']);
			return array("post"=>$p->getPostInfo(),"themes"=>$themes,"cthemes"=>$cthemes);
		}else{
			return array("list"=>$list,"pagination"=>$nav);
		}
	}
	function generateUrl ($s) {
 		$from = explode (',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
  		$to = explode (',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
  		$s = preg_replace ('~[^\w\d]+~', '-', str_replace ($from, $to, trim ($s)));
  		return strtolower (preg_replace ('/^-/', '', preg_replace ('/-$/', '', $s)));
	}
	
}