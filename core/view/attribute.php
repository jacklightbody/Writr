<?php 
defined('WRITR_LOADED') or die("Access Denied.");
?>
<script type="text/javascript" src="core/js/tablesorter.js"></script>
<script type="text/javascript" src="core/js/nicedit.js"></script>
<script type="text/javascript">$(document).ready(function() { $(".attribute-list").tablesorter(); } ); </script>
<script type="text/javascript">
  bkLib.onDomLoaded(function() {
  		new nicEditor().panelInstance('body');
});
  </script>
<?php
if(isset($_GET['error'])){
	if($_GET['error']==1){
		echo '<br/><div style="margin-left:140px;width:328px!important;"class="full alert-message error">Handle is already in use.</div>';
	}
}
if(isset($_GET['task'])){
	echo '<div id="container-thin">';
	if($_GET['task']=='new'){?>
		<form method="post" class="form-stacked" action="<?php echo Controller::submitForm('newUser');?>">
			<label for="name">Username</label>
			<input type="text" class="full" autofocus="autofocus" name="name" placeholder="username"/>
			<label for="email">Email</label>
			<input type="email" class="full" name="email" placeholder="email@email.com"/>
			<label for="path">Password</label>
			<input type="password" class="full" id="pass" name="pass" placeholder="password"/>
				<span class="help-block">
		<a href="javascript:void(0);" class="show-hide center" onclick="document.getElementById('pass').type='text';$('.show-hide').toggle();">Reveal Password</a>
		<a href="javascript:void(0);" class="show-hide center hide" onclick="document.getElementById('pass').type='password';$('.show-hide').toggle();">Hide Password</a>
		</span><br/>
			<input style="width:360px!important;" type="submit" class="full btn large primary" value="Add">
		</form>
	<?php }elseif($_GET['task']=='edit'){?>
			<form method="post" class="form-stacked" action="<?php echo Controller::submitForm('update');?>">
			<label for="name">Username</label>
			<input type="text" class="full" name="name" autofocus="autofocus" value='<?php echo $data['form']['name'];?>'/>
			<label for="email">Email</label>
			<input type="email" class="full" name="email" value="<?php echo $data['form']['email'];?>"/>
			<label for="path">Password</label>
			<input type="password" class="full" id="pass" name="pass" placeholder="password"/>
				<span class="help-block">
		Leave blank to keep the current password
		</span><br/>
		<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
			<input style="width:360px!important;" type="submit" class="full btn large primary" value="Save">
		</form>
	<?php }elseif($_GET['task']=='delete'){
		User::delete($_GET['id']);
		Header('location: ?path=user');
	}
	echo '</div>';
}else{
$users=$list;
?>
	<a href="?path=user&task=new" class="btn large primary">New User</a>
	<br/><br/>
	<table class="attribute-list bordered-table zebra-striped">
	<thead><th>Name</th><th>Handle</th><th>Type</th></thead>
	<?php foreach($attrs as $attr){ ?>
		<tr>
			<td><a href="?path=attribute&task=edit&id=<?php echo $attr['aID'];?>"><?php echo $attr['aName'];?></a></td>
			<td><a href="mailto:<?php echo $user['uEmail'];?>"><?php echo $user['uEmail'];?></a></td>
			<td style="width:140px;"><?php echo date('F j, Y', $user['uDateRegistered']);?></td>
			<td><a class="btn small" href="?path=user&task=edit&id=<?php echo $user['uID'];?>">Edit</a> 
			<?php if($user['uID']>1){ ?>
				<a class="btn small" href="?path=user&task=delete&id=<?php echo $user['uID'];?>">Delete</a>
			<?php }?>
			</td>
		</tr>
	<?php } ?>
	</table>
	<?php echo $data['pagination'];
}?>