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
if(isset($_GET['path'])){
	$post=new Post();
	$headerItems='<script type="text/javascript">var disqus_developer = 1;var disqus_shortname = "'.config::get('disqus_username').'";var disqus_identifier = "'.$post->getID().'";</script>';
}else{
	$headerItems= <<<EOD
	<script type="text/javascript">var disqus_developer = 1;var disqus_shortname = "'.config::get('disqus_username').'";
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>
EOD;
	$posts=Post::getAllLivePosts();
}
require(View::route());//include the theme file