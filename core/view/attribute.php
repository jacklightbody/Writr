<?php 
defined('WRITR_LOADED') or die("Access Denied.");
?>
<?php
if(isset($_GET['error'])){
	if($_GET['error']==1){
		echo '<br/><div style="margin-left:140px;width:328px!important;"class="full alert-message error">Please fill out all data.</div>';
	}
}
if(isset($_GET['task'])){
	echo '<div id="container-thin">';
	if($_GET['task']=='new'){?>
		<form method="post" class="form-stacked" action="<?php echo Controller::submitForm('newAttribute');?>">
			<label for="name">Attribute Name</label>
			<input type="text" class="full" autofocus="autofocus" name="name" placeholder="Name"/>
			<label for="handle">Handle</label>
			<input type="text" class="full" name="handle" placeholder="attribute_handle"/>
			<label for="type">Type</label>
			<select name="type">
				<?php foreach($attrt as $attr){ 
					load::helper('attributes/types/'.$attr['atHandle'].'/controller',$attr['extHandle']);
					load::helper('text');
					$cname='AttributesType'.Text::camelcase($attr['atHandle']).'Controller';
					$name=$cname::getName();
					?>
				<option value="<?php echo $attr['atID'];?>"><?php echo $name;?></option>
				<?php } ?>
			</select><br/><br/>
			<input style="width:360px!important;" type="submit" class="full btn large primary" value="Add">
		</form>
	<?php }elseif($_GET['task']=='edit'){?>
			<form method="post" class="form-stacked" action="<?php echo Controller::submitForm('update');?>">
			<label for="name">Attribute Name</label>
			<input type="text" class="full" autofocus="autofocus" name="name" placeholder="Name"/>
			<label for="handle">Handle</label>
			<input type="text" class="full" name="handle" placeholder="attribute_handle"/>
			<label for="type">Type</label>
			<select name="type">
				<?php foreach($attrt as $attr){ 
					load::helper('attributes/types/'.$attr['atHandle'].'/controller',$attr['extHandle']);
					load::helper('text');
					$cname='AttributesType'.Text::camelcase($attr['atHandle']).'Controller';
					$name=$cname::getName();
					?>
				<option value="<?php echo $attr['atID'];?>"><?php echo $name;?></option>
				<?php } ?>
			</select><br/><br/>
			<input style="width:360px!important;" type="submit" class="full btn large primary" value="Save">
		</form>
	<?php }elseif($_GET['task']=='delete'){
		Attribute::delete($_GET['id']);
		Header('location: ?path=attribute');
	}
	echo '</div>';
}else{
?>
	<a href="?path=attribute&task=new" class="btn large primary">New Attribute</a>
	<br/><br/>
	<table class="attribute-list bordered-table zebra-striped">
	<thead><th>Name</th><th>Handle</th><th>Type</th><th>Options</th></thead>
	<?php foreach($attrs as $attr){ 
		load::model('attribute');
		$handle=AttributeTypes::getByID($attr['atID']);
		load::helper('attributes/types/'.$handle['atHandle'].'/controller',$attr['extHandle']);
		load::helper('text');
		$cname='AttributesType'.Text::camelcase($handle['atHandle']).'Controller';
		$name=$cname::getName();
					?>
		<tr>
			<td><a href="?path=attribute&task=edit&id=<?php echo $attr['aID'];?>"><?php echo $attr['aName'];?></a></td>
			<td style="width:140px;"><?php echo $attr['aHandle'];?></td>
			<td style="width:140px;"><?php echo $name; ?></td>
			<td><a class="btn small" href="?path=attribute&task=edit&id=<?php echo $attribute['uID'];?>">Edit</a> 
				<a class="btn small" href="?path=attribute&task=delete&id=<?php echo $attribute['uID'];?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
	</table>
	<?php echo $pagination;
}?>