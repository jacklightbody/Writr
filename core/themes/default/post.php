<?php 
$post=New Post();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <?php echo $headerItems;?>
  <link rel="stylesheet" href="<?php echo $themePath;?>/theme.css"/>
</head>

<body>

  <div id="container">


     <h1><a href="index.php"><?php echo Config::get('site_name');?></a></h1><hr/>

<?php
if(User::isLoggedIn()){?>
<span class="edit-link"><a class="btn small" href="<?php echo $post->getEditLink();?>">Edit</a></span>
<?php }?>
<div>
<?php 
echo $post->getBody();
?>
</div>
</div>
</body>
</html>