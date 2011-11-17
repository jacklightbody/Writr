<?php
defined('WRITR_LOADED') or die("Access Denied.");
if(isset($_GET['task'])&&$_GET['task']=='reset'){
	$u=new User('','',$_GET['name']);
	load::helper('visitor');
	$ip=Visitor::getIP();
    $id=md5($u->getID().':'.$u->getLogin().':'.$ip);
	if($_GET['id']==$id){
		load::controller('login');
		$new=LoginController::resetPass($u);
		$resetMessage='Your password has been reset. Your new password is '.$new;
		$resetClass='success';
	}else{
		$resetMessage='Incorrect identifier. You have to stay on the same computer for requesting a password reset and receiving it.';
		$resetClass='error';
	}
}
?>
<div id="container-thin">
<form method="post" class="form-stacked" action="form_submit.php?file=login&function=authenticate&origin=login">
	<?php if(isset($_GET['error'])){
	if($_GET['error']==1){
		echo '<br/><div style="width:250px;"class="alert-message error">Invalid username or password.</div>';
	}
}
if(isset($_GET['error'])){
	if($_GET['error']==2){
		echo '<br/><div style="width:250px;"class="alert-message error">Invalid email address.</div>';
	}
}
if(isset($_GET['message'])){
	if($_GET['message']==1){
		echo '<br/><div style="width:250px;"class="alert-message success">Instructions sent to the specified email.</div>';
	}
}
if(isset($resetMessage)){
	echo '<br/><div style="width:250px;"class="alert-message '.$resetClass.'">'.$resetMessage.'</div>';
}?>
	<h2>Login</h2>
    <label for="login">Username or Email</label>
    <input type="text" class="xlarge" name="login" placeholder="username"/>
    <label for="pass">Password</label>
    <input type="password" class="xlarge" name="pass" placeholder="password"/>
    <br/><br/><input type="submit" style="width: 280px;"class="btn large primary" value="Login">
</form>
<a data-controls-modal="forgot-pass" data-backdrop="true" style="margin-left:95px;"class="pointer center" data-keyboard="true">Forgot your password?</a>

<div id="forgot-pass" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <form method="post" action="form_submit.php?file=login&function=forgot&origin=login">
              <h3>Forgot your password?</h3>
            </div>
            <div class="modal-body">
            	<p>Just enter your email below to reset it.</p>
				<b>Email</b><br/>
				<input type="email" class="xlarge" name="email" placeholder="email@email.com"/>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn large left primary" value="Request">
              </form>
            </div>
          </div>

</div>