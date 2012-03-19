<?php 
defined('WRITR_LOADED') or die("Access Denied.");
?>
			<form method="post" class="form-stacked" action="<?php echo Controller::submitForm('save');?>">
			<label for="site-name">Site Name</label>
			<input type="text" class="full" autofocus="autofocus" name="site-name" value="<?php echo config::get('site_name');?>"/>
			<label for="disqus">Disqus Username</label>
			<input type="text" class="full" name="disqus" value="<?php echo config::get('disqus_username');?>"/>
			<label for="disqus">Items per Page</label>
			<input type="text" class="full" name="pagination" value="<?php echo config::get('pagination');?>"/>
			<label for="theme">Home Page Theme</label>
			<select name="theme">
				<?php foreach($themes as $theme){ 
					$check='';
					if(config::get('home_theme')==$theme){
						$check='selected';
					}?>
				<option value="<?php echo $theme;?>"<?php echo $check;?>><?php echo file_get_contents('themes/'.$theme.'/info.txt');?></option>
				<?php } ?>
				<?php foreach($cthemes as $theme){ 
					$check='';
					if(config::get('home_theme')==$theme){
						$check='selected';
					}?>
				<option value="<?php echo $theme;?>" <?php echo $check;?>><?php echo file_get_contents('core/themes/'.$theme.'/info.txt');?></option>
				<?php } ?>
			</select><br/><br/>
			<input type="submit" class="btn primary" value="Save">
		</form>
