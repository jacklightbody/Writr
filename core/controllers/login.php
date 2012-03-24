<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class LoginController extends Controller{
	public function view(){
		return array("headerJs"=>array('core/js/modal.js'));
	}
	public function authenticate(){
		load::helper('text');
		if(!User::authenticate(Text::sanitize($_POST['login']),Text::sanitize($_POST['pass']))){
			return array("goto"=>'login&error=1');
		}
	}
	public function forgot(){
		$u=new User('',$_POST['email']);
		$admin=new User(1);
		$to=$_POST['email'];
        $subject= "Password Reset";
        load::helper('visitor');
		$ip=Visitor::getIP();
        $id=md5($u->getID().':'.$u->getLogin().':'.$ip);
        $base=str_replace('form_submit.php', '', $_SERVER["PHP_SELF"]);
        $message = "Hello, ".$u->getLogin()."\n You are receiving this message because you recently requested your password for ".config::get('site_name')." to be reset. If you did do this, click the link below to reset your password. You must go to this page from the same computer that you requested your password to be reset from.\n Thanks, ".$admin->getLogin()."\n\n http://".$_SERVER["SERVER_NAME"].$base.'dashboard.php?path=login&task=reset&name='.$u->getLogin().'&id='.$id;
        $headers = "From:".$admin->getEmail()."\r\n" .
                   "Reply-To:".$admin->getEmail(). "\r\n" .
                   "X-Mailer: PHP/".phpversion() ;
        $sent = mail($to, $subject, $message, $headers);
	}
	function generateUrl ($s) {
 		$from = explode (',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
  		$to = explode (',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
  		$s = preg_replace ('~[^\w\d]+~', '-', str_replace ($from, $to, trim ($s)));
  		return strtolower (preg_replace ('/^-/', '', preg_replace ('/-$/', '', $s)));
	}
	public function resetPass($u){
		$num=rand(10000, 100000000);
		User::update($u->getID(),$u->getLogin(),$num,$u->getEmail(),1);
		return $num;
	}
}