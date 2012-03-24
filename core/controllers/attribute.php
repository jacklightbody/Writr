<?php
defined('WRITR_LOADED') or die("Access Denied.");
Class AttributeController extends Controller{
	var $title='Attributes';
	public function view(){
		load::helper('html');
		$html=New Html();
		$html->js('tablesorter.js',null,array('footer'=>0,'version'=>'2.0.5','handle'=>'tablesorter'));
		$script=<<<EOD
		<script type="text/javascript">
		$(document).ready(function() { 
			$(".attribute-list").tablesorter(); 
		});  
		</script>
EOD;
		if(isset($_GET['task'])){
			if($_GET['task']=='edit'){
				$attrs=AttributeTypes::getAllTypes();
				return array('attrt'=>$attrs);
			}
			if($_GET['task']=='new'){
				$attrs=AttributeTypes::getAllTypes();
				return array('attrt'=>$attrs);
			}
		}else{
			$attrs=Attribute::getAttributes();
			if(!isset($_GET['page'])){
				$_GET['page']=0;
			}
			load::helper('pagination');
			$up = new Pagination($attrs,$_GET['page'],'dashboard.php?path=attribute','page');
			$list=$up->getList();
			$nav=$up->generateLinks();
			return array('attrs'=>$attrs,'pagination'=>$nav);
		}
	}
	public function newAttribute(){
		load::model('attribute');
		if(isset($_POST['type'])&&isset($_POST['name'])&&isset($_POST['handle'])){
			Attribute::add($_POST['type'],$_POST['name'],$_POST['handle']);
		}else{
			return array("goto"=>"?action=attribute&error=1");
		}
	}
}