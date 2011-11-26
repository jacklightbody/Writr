<?php 
defined('WRITR_LOADED') or die("Access Denied.");
	
class User{
	public $user;
	public function __construct($uID='',$uEmail='',$uName=''){
		if($uID!=''){
			$this->getByID($uID);
		}
		if($uEmail!=''){
			$this->getByEmail($uEmail);
		}
		if($uName!=''){
			$this->getByName($uName);
		}
	}
	public function getAll(){
		$db=load::db();
		return $db->getAll('SELECT * FROM '.WRITR_PREFIX.'users');
	}
	public function getByID($uID){
		$db=load::db();
		$user=$db->getAll('SELECT * FROM '.WRITR_PREFIX.'users WHERE uID=?',array($uID));
		$this->user=$user[0];
	}
	public function getByName($uName){
		$db=load::db();
		$user=$db->getAll('SELECT * FROM '.WRITR_PREFIX.'users WHERE uLogin=?',array($uName));
		$this->user=$user[0];
	}
	public function getByEmail($uEmail){
		$db=load::db();
		$user=$db->getAll('SELECT * FROM '.WRITR_PREFIX.'users WHERE uEmail=?',array($uEmail));
		$this->user=$user[0];
	}
	public function checkUnique($uName,$uEmail,$uID=false){
		$db=load::db();
		$name=text::sanitize($uName);
		$email=text::sanitize($uEmail);
		if(isset($uID)){
			$n=$db->getOne('SELECT uID FROM '.WRITR_PREFIX.'users WHERE uLogin=? AND uID<>?',array($uName,$uID));
			$e=$db->getOne('SELECT uID FROM '.WRITR_PREFIX.'users WHERE uEmail=? AND uID<>?',array($uEmail,$uID));
		}else{
			$n=$db->getOne('SELECT uID FROM '.WRITR_PREFIX.'users WHERE uLogin=?',array($uName));
			$e=$db->getOne('SELECT uID FROM '.WRITR_PREFIX.'users WHERE uEmail=?',array($uEmail));
		}
		if(isset($n)||isset($e)){
			return false;
		}
		return true;
	}
	public function update($uID,$name,$email,$active){
		$name=text::sanitize($name);
		$email=text::sanitize($email);
		$db=load::db();
		if(self::checkUnique($name,$email,$uID)){
			$db->Execute('UPDATE '.WRITR_PREFIX.'users set uLogin=?,uEmail=?,uIsActive=? WHERE uID=?', array($name,$email,$active,$uID));
			return true;
		}else{
			return false;
		}
	}
	public function updatePass($pass,$uID){
		load::helper('text');
		$db=load::db();
		$pass=text::sanitize($pass);
		$pass=self::makePass($pass);
		$db->Execute('UPDATE '.WRITR_PREFIX.'users set uPass=? WHERE uID=?', array($pass,$uID));
	}
	public function add($name,$pass,$email){
		load::helper('text');
		$db=load::db();
		$name=text::sanitize($name);
		$pass=text::sanitize($pass);
		$email=text::sanitize($email);
		$pass=self::makePass($pass);
		if(self::checkUnique($name,$email)){
			$db->Execute('INSERT INTO '.WRITR_PREFIX.'users (uLogin,uEmail,uPass,uIsActive,uDateRegistered) VALUES (?,?,?,1,?)', array($name,$email,$pass,time()));
			return true;
		}else{
			return false;
		}
	}
	public function addSuper($name,$pass,$email){
		load::helper('text');
		$db=load::db();
		$name=text::sanitize($name);
		$pass=text::sanitize($pass);
		$email=text::sanitize($email);
		$pass=self::makePass($pass);
		$db->Execute('INSERT INTO '.WRITR_PREFIX.'users (uID,uLogin,uEmail,uPass,uIsActive) VALUES (1,?,?,?,1)', array($name,$email,$pass));	
	}
	public function makePass($pass){
		$password=md5($pass);
		return md5($pass.':'.$password);
	}
	public function generateCookie($uID){
		load::helper('visitor');
		$ip=Visitor::getIP();
		$u=md5($uID);
		$string=md5($ip.':'.$u);
		setcookie('writr',$string);
	}
	public function authenticate($uName,$uPass){
		load::helper('text');
		$uName=text::sanitize($uName);
		$uPass=text::sanitize($uPass);
		load::helper('visitor');
		$ip=Visitor::getIP();
		$ip=md5($ip);
		$pass=md5($uPass);
		$uPass=md5($uPass.':'.$pass);//use their own pass for them
		$db=load::db();
		if (filter_var($uName, FILTER_VALIDATE_EMAIL)) {//if the inputted name is an email then we query the uEmail column, otherwise we go with uLogin
			$u=$db->GetOne('SELECT uID FROM '.WRITR_PREFIX.'users WHERE uEmail=? and uPass=?', array($uName,$uPass));
		} else {
			$u=$db->GetOne('SELECT uID FROM '.WRITR_PREFIX.'users WHERE uLogin=? AND uPass=?', array($uName,$uPass));
		}
		if($u){
			self::generateCookie($u);
			$db->Execute('INSERT INTO '.WRITR_PREFIX.'ip (ip,uID) VALUES (?,?)', array($ip,$u));
			return true;
		}	
	}
	public function isLoggedIn(){
		load::helper('visitor');
		$ip=Visitor::getIP();
		$mip=md5($ip);
		$db=load::db();
		$u=$db->getOne('SELECT uID from '.WRITR_PREFIX.'ip WHERE ip=?', array($mip));
		$u=md5($u);
		$cookie=md5($ip.':'.$u);
		if(isset($_COOKIE['writr'])&&$_COOKIE['writr']==$cookie){
			return true;
		}
		return false;
	}
	public function getLoggedIn(){
		load::helper('visitor');
		$ip=Visitor::getIP();
		$mip=md5($ip);
		$db=load::db();
		$u=$db->getOne('SELECT uID from '.WRITR_PREFIX.'ip WHERE ip=?', array($mip));
		$uID=md5($u);
		$cookie=md5($ip.':'.$uID);
		if(isset($_COOKIE['writr'])&&$_COOKIE['writr']==$cookie){
			return $u;
		}
	}
	public function delete($id){
		if($id>1){
			$db=load::db();
			$db->execute('DELETE FROM '.WRITR_PREFIX.'users where uID=?',array($id));
		}
	}
	public function logout(){
		load::helper('visitor');
		$ip=Visitor::getIP();
		$mip=md5($ip);
		$uID=self::getLoggedIn();
		$db=load::db();
		$db->query('DELETE FROM '.WRITR_PREFIX.'ip WHERE ip=? and uID=?',array($mip,$uID));
		setcookie("writr", "", time()-3600);
	}
	public function getID(){ return $this->user['uID']; }
	public function getLogin(){ return $this->user['uLogin']; }
	public function getEmail(){ return $this->user['uEmail']; }
}