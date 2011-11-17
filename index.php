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
$posts=Post::getAllLivePosts();
$headerItems='<link rel="stylesheet" href=""/>';
require(View::route());//include the theme file