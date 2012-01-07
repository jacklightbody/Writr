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
if(isset($_GET['path'])&&Post::isValidPath($_GET['path'])){
	$post=new Post();
	$headerItems='<script type="text/javascript">var disqus_developer = 1;var disqus_shortname = "'.config::get('disqus_username').'";var disqus_identifier = "'.$post->getID().'";</script>';
}elseif(!$_GET['path']){
	$headerItems= <<<EOD
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
	$p=New Pagination($posts, $_GET['postPage'],'index.php');
	$posts=$p->getList();
	$pagination=$p->generateLinks();
}else{
	$_GET['path']='page_not_found';
	$headerItems='<title> Page Not Found | '.Config::get('site_name').'</title>';
}
require(View::route());//include the theme file