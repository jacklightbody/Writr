<?php
if(!file_exists('config.php')){
	header("Location: install.php");
	exit;
}
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
require 'core/define.php';
Load::helper('view');
$route=explode('/', View::route());
array_pop($route);//get the path to the theme.
$themePath=implode('/', $route);
//$footerItems=config::get('footer_items'); 
//$headerItems=config::get('header_items');
//TODO integrate attributes
$headerItems='';
$footerItems='';
if(isset($_GET['path'])&&Post::isValidPath($_GET['path'])){
	$post=new Post();
	$headerItems.='<script type="text/javascript">var disqus_developer = 1;var disqus_shortname = "'.config::get('disqus_username').'";var disqus_identifier = "'.$post->getID().'";</script>';
	$headerItems.='<title>'.$post->getName().' | '.Config::get('site_name').'</title>';
}elseif(!isset($_GET['path'])){
	$headerItems.= <<<EOD
	<title>Home | Config::get('site_name')</title><script type="text/javascript">var disqus_developer = 1;var disqus_shortname = "'.config::get('disqus_username').'";
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>
EOD;
	load::helper('pagination');
	$posts=Post::getAllLivePosts();
	if(isset($posts)){
		$postPage=0;
		if(isset($_GET['postPage'])){
			$postPage=$_GET['postPage'];
		}
		$p=New Pagination($posts, $postPage,'index.php','postPage');
		$posts=$p->getList();
		$pagination=$p->generateLinks();
	}

}else{
	$_GET['path']='page_not_found';
	$headerItems.='<title> Page Not Found | '.Config::get('site_name').'</title>';
}
load::helper('html');
$html=New Html();
$headerItems.=$html->outputHeaderlinks();
$footerItems.=$html->outputFooterlinks();
require(View::route());//include the theme file