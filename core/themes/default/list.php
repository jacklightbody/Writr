<?php load::helper('text');?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>

  <title>Home | <?php echo Config::get('site_name');?></title>
    <?php echo $headerItems;?>
  <link rel="stylesheet" href="<?php echo $themePath;?>/theme.css"/>
</head>

<body>

  <div id="container">
<div id="inside">

    <h1><a href="index.php"><?php echo Config::get('site_name');?></a></h1><hr/>


<div>
<?php
if(count($posts)==0){
  echo 'Nothing here yet. You can add posts from the <a href="dashboard.php">dashboard</a>.';
} 
foreach($posts as $post){
?>
<div class="clearfix">
	<div style="width:50px;clear:both;float:left;margin-right:20px;">
	</div><div><a href="?path=<?php echo $post['pPath'];?>"><h2 style="margin-bottom:-10px;"><?php echo $post['pName'];?></a></h2> 
	<p style="font-size:10px;"> posted by <?php $u=new User($post['pAuthorID']);echo $u->getLogin();?> on <?php echo date('M j,Y',$post['pDatePublished']);?>. <a href="?path=<?php echo $post['pPath'];?>#disqus_thread" data-disqus-identifier="<?php echo $post['pID'];?>">Comments</a></p>
	<p class="small-description"><?php echo Text::shortenTextWord($post['pBody'],300);?> <a href="?path=<?php echo $post['pPath'];?>">Read More &raquo;</a></p></div></div><hr/>
<?php }?>
</div>
<?php echo $pagination;?>
</div>
</div>
</body>
</html>