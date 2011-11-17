<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>

  <title></title>
  <?php echo $headerItems;?>
  <link rel="stylesheet" href="<?php echo $themePath;?>/theme.css"/>
	<script type="text/javascript" src="core/js/dropdown.js"></script>
</head>

<body>

  <div class="topbar-wrapper">
    <div id="topbar-example" class="topbar" data-dropdown="dropdown">
      <div class="topbar-inner">
        <div class="container">
          <h3><a href="index.php"><?php echo config::get('site_name');?></a></h3>
          <?php if($_GET['path']!='login'){?>
          <ul class="secondary-nav">
          	<li><a href="?task=logout">Logout &raquo;</a></li>
          </ul>
          <ul class="nav">
            <li class="menu">
              <a href="?path=writr" class="menu">Write</a>
              <ul class="menu-dropdown">
              	<li><a href="?path=writr">Posts</a></li>
                <li><a href="?path=writr&task=new">New Post</a></li>
              </ul>
            </li>
          </ul><?php }?>
        </div>
      </div>
    </div>
  </div>
<?php echo $pageContent; ?>
</body>
</html>