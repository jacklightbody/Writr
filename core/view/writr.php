<?php 
defined('WRITR_LOADED') or die("Access Denied.");
?>
<script type="text/javascript" src="core/js/tablesorter.js"></script>
<script type="text/javascript" src="core/js/nicedit.js"></script>
<script type="text/javascript">$(document).ready(function() { $(".post-list").tablesorter(); } ); </script>
<script type="text/javascript">
  bkLib.onDomLoaded(function() {
  		new nicEditor().panelInstance('body');
});
var variable=0;
function generateTitle(title){
	return title.replace(' ','-');
}
  </script>
<?php
if(isset($_GET['error'])){
	if($_GET['error']==1){
		echo '<br/><div style="margin-left:145px;width:328px!important;"class="full alert-message error">Please fill out all fields.</div>';
	}
}
if(isset($_GET['task'])){
	echo '<div id="container-thin">';
	if($_GET['task']=='new'){?>
		<form method="post" class="form-stacked" action="<?php echo Controller::submitForm('newPost');?>">
			<label for="name">Name</label>
			<input type="text" class="full" autofocus="autofocus" id="pageName" onkeyup="if(variable==0){$('#pagePath').val(generateTitle($(this).val()))}"name="name" placeholder="post"/>
			<label for="path">Path</label>
			<input type="text" class="full" name="path" id="pagePath" onclick="variable=1" placeholder="path"/>
			<label for="theme">Theme</label>
			<select name="theme">
				<?php foreach($themes as $theme){ ?>
				<option value="<?php echo $theme;?>"><?php echo file_get_contents('themes/'.$theme.'/info.txt');?></option>
				<?php } ?>
				<?php foreach($cthemes as $theme){ ?>
				<option value="<?php echo $theme;?>"><?php echo file_get_contents('core/themes/'.$theme.'/info.txt');?></option>
				<?php } ?>
			</select>
			<label for="draft">Draft</label>
			<input type="radio" name="draft" value="0"> Yes
			<input type="radio" name="draft" checked="checked" value="1"> No
			<label for="body">Content</label>
			<textarea style="width:350px!important;"class="full" rows="5"name="body" id="body"></textarea><br/>
			<input style="width:350px!important;" type="submit" class="full btn large primary" value="Add">
		</form>
	<?php }elseif($_GET['task']=='edit'){?>
			<form method="post" class="form-stacked"autofocus="autofocus" action="<?php echo Controller::submitForm('update');?>">
			<label for="name">Name</label>
			<input type="text" class="full" value="<?php echo $data['post']['pName'];?>"name="name" placeholder="post"/>
			<label for="path">Path</label>
			<input type="text" class="full" value="<?php echo $data['post']['pPath'];?>" name="path" placeholder="path"/>
			<label for="theme">Theme</label>
			<select name="theme">
				<?php foreach($themes as $theme){ ?>
				<option <?php if($data['post']['pTheme']==$theme){echo 'selected="selected"';}?>value="<?php echo $theme;?>"><?php echo file_get_contents('themes/'.$theme.'/info.txt');?></option>
				<?php } ?>
				<?php foreach($cthemes as $theme){ ?>
				<option <?php if($data['post']['pTheme']==$theme){echo 'selected="selected"';}?> value="<?php echo $theme;?>"><?php echo file_get_contents('core/themes/'.$theme.'/info.txt');?></option>
				<?php } ?>
			</select>
			<label for="draft">Draft</label>
			<input type="radio" name="draft" <?php if($data['post']['pIsActive']==0){echo 'checked="checked"';}?> value="0"> Yes
			<input type="radio" name="draft" <?php if($data['post']['pIsActive']==1){echo 'checked="checked"';}?>value="1"> No
			<label for="body">Content</label>
			<textarea class="full" rows="5"name="body" id="body"><?php echo $data['post']['pBody'];?></textarea><br/>
			<input type="submit" class="full btn large primary" value="Add">
			<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
		</form>
	<?php }elseif($_GET['task']=='delete'){
		load::controller('writr');
		Post::delete($_GET['id']);
		Header('location: ?path=writr');
	}elseif($_GET['task']=='publish'){
		load::controller('writr');
		Post::publish($_GET['id']);
		Header('location: ?path=writr');
	}elseif($_GET['task']=='unpublish'){
		load::controller('writr');
		Post::unpublish($_GET['id']);
		Header('location: ?path=writr');
	}
	echo '</div>';
}else{
	$posts=$data['list'];?>
	<a href="?path=writr&task=new" class="btn large primary">New Post</a>
	<br/><br/>
	<table class="post-list bordered-table zebra-striped">
	<thead><th>Name</th><th>Author</th><th>Date Posted</th><th>Options</th></thead>
	<?php foreach($posts as $post){ ?>
		<tr>
			<td><a href="index.php?path=<?php echo $post['pPath'];?>"><?php echo $post['pName'];?></a></td>
			<td><?php  $u=new User($post['pAuthorID']);echo $u->getLogin();?></td>
			<td style="width:140px;"><?php echo date('F j, Y', $post['pDatePublished']);?></td>
			<td style="width:175px;"><a class="btn small" href="?path=writr&task=edit&id=<?php echo $post['pID'];?>">Edit</a> <a class="btn small" href="?path=writr&task=delete&id=<?php echo $post['pID'];?>">Delete</a> 
			<?php if($post['pIsActive']==0){?>
				<a class="btn small" href="?path=writr&task=publish&id=<?php echo $post['pID'];?>">Publish</a>
			<?php }else{?>
				<a class="btn small" href="?path=writr&task=unpublish&id=<?php echo $post['pID'];?>">Unpublish</a>
			<?php }?>
			</td>
		</tr>
	<?php } ?>
	</table><?php
	echo $data['pagination'];
}?>