<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class UserController extends Controller{
	public function view(){
		load::helper('pagination');
		$users=User::getAll();
		if(!isset($_GET['page'])){
			$_GET['page']=0;
		}
		$up = new Pagination($users,$_GET['page'],'dashboard.php?path=user','page');
		$list=$up->getList();
		$nav=$up->generateLinks();
		if($_GET['task']=='edit'){
			$u=New User($_GET['id']);
			return array("list"=>$list,"pagination"=>$nav,"form"=>array("name"=>$u->getLogin(),"email"=>$u->getEmail())); 
		}
		return array("list"=>$list,"pagination"=>$nav); 
	}
	public function newUser(){
		load::helper('text');
		$name=Text::sanitize($_POST['name']);
		$pass=Text::sanitize($_POST['pass']);
		$email=Text::sanitize($_POST['email']);
		if(!User::add($name,$pass,$email)){
			return array("goto"=>'user&task=new&error=1');
		}
	}
	public function update(){
		load::helper('text');
		$name=Text::sanitize($_POST['name']);
		$pass=Text::sanitize($_POST['pass']);
		$email=Text::sanitize($_POST['email']);
		if(!User::update($_POST['id'],$name,$email,1)){
			return array("goto"=>'user&task=edit&id='.$_POST['id'].'&error=1');
		}
		if(isset($pass)&&$pass!=''){
			User::updatePass($_POST['id'],$pass);
		}
	}
}
//<span class="alert-message error">Duplicate username or email.</span>