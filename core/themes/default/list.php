<?php load::helper('text');?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>

  <title></title>
  <link rel="stylesheet" href="<?php echo $themePath;?>/theme.css"/>
</head>

<body>

  <div id="container">


    <h1><a href="index.php"><?php echo Config::get('site_name');?></a></h1><hr/>


<div>
<?php foreach($posts as $post){
?>
<div class="clearfix">
	<div style="width:50px;clear:both;float:left;margin-right:20px;">
	<?php echo '<span class="date">'.date('j',$post['pDatePublished']).'</span> ';
	echo '<span class="month">'.date('M, Y',$post['pDatePublished']).'</span>';?>
	</div><div><a href="?path=<?php echo $post['pPath'];?>"><h2><?php echo $post['pName'];?></h2></a><p class="small-description"><?php echo Text::shortenTextWord($post['pBody'],300);?> <a href="?path=<?php echo $post['pPath'];?>">Read More &raquo;</a></p></div></div><hr/>
<?php }?>
</div>
</div>
</body>
</html>