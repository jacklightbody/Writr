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
ini_set("display_errors", 1);
error_reporting(E_ALL);
Load::helper('view');
Load::helper('text');
Load::helper('controller');
load::model('dashboard_elements');
$elements=DashboardElements::getElements();
$route=explode('/', View::route(1));
array_pop($route);//pop off the file
$themePath=implode('/', $route);
load::helper('html');
$html=New Html();
$html->css('bootstrap.css',null,array('footer'=>0,'version'=>'1.4','handle'=>'bootstrap'));
$html->css('core.css',null,array('footer'=>0,'version'=>'1','handle'=>'core'));
$html->js('jquery.js',null,array('footer'=>0,'version'=>'1.7','handle'=>'jquery'));
load::controller($_GET['path']);
load::model($_GET['path']);//automatically load the model for the controller if there is one.
$controller=Text::camelcase($_GET['path']).'Controller';
$c=New $controller();
$data=$c->view();
$headerItems=$html->outputHeaderlinks();
$footerItems=$html->outputFooterlinks();
$dashboardTitle='Dashboard';
if(isset($c->title)){
	$dashboardTitle=$c->title;
}
$headerItems.='<title>'.$dashboardTitle.' | '.config::get('site_name').'</title>';
ob_start();
if(isset($data)){
	extract($data);
}
require 'core/view/'.$_GET['path'].'.php';
$pageContent = ob_get_contents();
ob_end_clean();
require(View::route(1));
?>