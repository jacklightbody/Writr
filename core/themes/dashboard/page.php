<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <?php echo $headerItems;?>
  <link rel="stylesheet" href="<?php echo $themePath;?>/theme.css"/>
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
              <a href="?path=writr&amp;task=new" onmouseover="$(this).parent('li').addClass('open')" onmouseout="$(this).parent('li').removeClass('open')" class="menu">Write</a>
              <ul onmouseover="$(this).parent('li').addClass('open')" onmouseout="$(this).parent('li').removeClass('open')" class="menu-dropdown">
              	<li><a href="?path=writr">Posts</a></li>
                <li><a href="?path=writr&amp;task=new">New Post</a></li>
              </ul>
            </li>
            <li class="menu">
              <a href="?path=manage" onmouseover="$(this).parent('li').addClass('open')" onmouseout="$(this).parent('li').removeClass('open')" class="menu">Manage</a>
              <ul onmouseover="$(this).parent('li').addClass('open')" onmouseout="$(this).parent('li').removeClass('open')" class="menu-dropdown">
                <?php foreach($elements as $el){ ?>
                    <li><a href="?path=<?php echo $el['file'];?>"><?php echo $el['name']; ?></a></li>
                <?php }?>
              </ul>
            </li>
          </ul><?php }?>
        </div>
      </div>
    </div>
  </div>
  <div id="container-wide">
<?php echo $pageContent; ?>
</div>
</body>
</html>