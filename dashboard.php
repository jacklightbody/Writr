<?php
if(!file_exists('config.php')){
	header("Location: install.php");
	exit;
}
require 'core/define.php';
if($_GET['task']=='logout'){
	User::logout();
	Header('location: index.php');
	exit;
}
if($_GET['path']!='login'&&(!isset($_COOKIE['writr'])||!User::isLoggedIn())){//if we aren't at the login page and the cookie isn't set correctly go to login
	Header('location:?path=login');
}
if($_GET['path']=='login'&&isset($_COOKIE['writr'])&&User::isLoggedIn()){
	Header('location:?path=writr');
}
if(!isset($_GET['path'])){
	$_GET['path']='writr';
}
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
Load::helper('view');
Load::helper('text');
Load::helper('controller');
$route=explode('/', View::route(1));
array_pop($route);//pop off the file
$themePath=implode('/', $route);
require_once 'core/controllers/'.$_GET['path'].'.php';
$controller=Text::camelcase($_GET['path']).'Controller';
$headerCss=array('core/css/bootstrap.css','core/css/core.css');
$headerJs=array('core/js/jquery.js');
$c=New $controller();
$data=$c->view();
if(is_array($data['headerCss'])){
	$headerCss=array_merge($headerCss, $data['headerCss']);
}
if(is_array($data['headerJs'])){
	$headerJs=array_merge($headerJs, $data['headerJs']);
}
$headerItems='';
foreach($headerCss as $css){
	$headerItems.='<link rel="stylesheet" href="'.$css.'"/>';
}
foreach($headerJs as $js){
	$headerItems.='<script type="text/javascript" src="'.$js.'"></script>';
}
ob_start();
require 'core/view/'.$_GET['path'].'.php';
$pageContent = ob_get_contents();
ob_end_clean();
require(View::route(1));
?>