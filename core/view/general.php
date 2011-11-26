<?php 
defined('WRITR_LOADED') or die("Access Denied.");
?>
			<form method="post" class="form-stacked" action="form_submit.php?file=general&function=save&origin=general">
			<label for="site-name">Site Name</label>
			<input type="text" class="full" name="site-name" value="<?php echo config::get('site_name');?>"/>
			<label for="disqus">Disqus Username</label>
			<input type="text" class="full" name="disqus" value="<?php echo config::get('disqus_username');?>"/><br/><br/>
			<input type="submit" class="btn primary" value="Save">
		</form>
