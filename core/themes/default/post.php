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
  <div id="inside">


     <h1><a href="index.php"><?php echo Config::get('site_name');?></a></h1><hr/>

<?php
if(User::isLoggedIn()){?>
<span class="edit-link"><a class="btn small" href="<?php echo $post->getEditLink();?>">Edit</a></span>
<?php }?>
<div>
<?php 
echo $post->getBody();
?>
<div id="disqus_thread"></div>
<script type="text/javascript">
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
</div>
</div>
</div>
</body>
</html>