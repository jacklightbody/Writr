<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require 'core/define.php';
require 'core/helpers/controller.php';
require 'core/controllers/'.$_GET['file'].'.php';
load::helper('text');
$className=Text::camelcase($_GET['file']).'Controller';
$f=new $className();
$data=$f->$_GET['function']();
if(isset($data['goto'])){
	$_GET['origin']=$data['goto'];
}
if(!isset($_GET['origin'])){
	$_GET['origin']=$_GET['file'];
}
Header('Location: dashboard.php?path='.$_GET['origin']);