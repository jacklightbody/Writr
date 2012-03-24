<?php 
if(file_exists('config.php')){
	header("Location: index.php");
	exit;
}
ini_set("display_errors", 1);
error_reporting(E_ALL);
if(!empty($_POST)){
	foreach($_POST as $post){
		if(!$post||$post==""){
			$error=1;
		}
	}
	if(!isset($error)){
		$configuration = "<?php\n";
		$pass=md5($_POST['pass'].'html-writr');
		$configuration .= "define('SQL_SERVER', '" . addslashes($_POST['db_server']) . "');\n";
		$configuration .= "define('SQL_USER', '" . addslashes($_POST['db_user']) . "');\n";
		$configuration .= "define('SQL_PASS', '" . addslashes($_POST['db_pass']) . "');\n";
		$configuration .= "define('SQL_DB', '" . addslashes($_POST['db']) . "');\n";
		$configuration .= "define('REL_DIR', '" . addslashes(str_replace('install.php', '', __FILE__)) . "');\n";
		//create the config file
		file_put_contents('config.php', $configuration);
		require 'core/define.php';
		//create the tables we need
		$db=load::db();
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'users(uID integer AUTO_INCREMENT,uLogin varchar(255), uEmail varchar(255), uPass varchar(255),
uIsActive integer, uDateRegistered integer, PRIMARY KEY (uID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'posts(pID integer AUTO_INCREMENT,pName varchar(255), pPath varchar(500),pBody longtext, pTheme varchar(255),
pIsActive integer, pAuthorID integer, pDatePublished integer, UNIQUE (pPath),PRIMARY KEY (pID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'ip(ipID int AUTO_INCREMENT,ip varchar(255), uID integer,PRIMARY KEY (ipID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'config(cID int AUTO_INCREMENT,cKey varchar(255), cValue mediumtext,PRIMARY KEY (cID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'dashboardelements(eID int AUTO_INCREMENT,ext varchar(255), name varchar(255),file varchar(255),PRIMARY KEY (eID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'attributes(aID int AUTO_INCREMENT,atID int,aName varchar(255),aHandle varchar(255),PRIMARY KEY (aID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'attribute_values(aID int AUTO_INCREMENT,aValue mediumtext,aMisc mediumtext,PRIMARY KEY (aID))');
		$db->execute('CREATE TABLE '.WRITR_PREFIX.'attribute_types(atID int AUTO_INCREMENT,extHandle varchar(255) atHandle varchar,PRIMARY KEY (atID))');
		Config::save('site_name',$_POST['site_name']);
		Config::save('home_theme','default');
		Config::save('pagination',10);
		User::addSuper($_POST['user'],$_POST['pass'],$_POST['email']);
		User::authenticate($_POST['user'],$_POST['pass']);
		load::model('dashboard_elements');
		DashboardElements::registerElement('user','Users','core');
		DashboardElements::registerElement('general','Settings','core');
		DashboardElements::registerElement('attribute','Attributes','core');
		load::model('attribute');
		AttributeTypes::addType('select');
		AttributeTypes::addType('boolean');
		AttributeTypes::addType('date');
		AttributeTypes::addType('text');
		AttributeTypes::addType('textarea');
		header('Location: index.php');
		exit;
	}else{
		header('Location: install.php?error='.$error);
	}
}
if (version_compare(PHP_VERSION, '5.2.0', '>')) {
	$phpClass='success';
	$phpMessage='Success! Your php version is greater than 5.2.';
}else{ 
	$phpClass='error';
	$phpMessage='Uh Oh! Your php version is less than 5.2. Please upgrade it before continuing.';
	$class='error';
	$message='Not all required services available.';
}
if(function_exists('mysql_connect')){
	$msClass='success';
	$msMessage='Success! You have MySql enabled.';
	
}else{
	$msClass='error';
	$sMessage='Uh Oh! You don\'t have MySql configured correctly. Please enable it before continuing.';
	$class='error';
	$message='Not all required services available.';
}
if(!isset($class)){
	$class='success';
}
if(!isset($message)){
	$message='All required services available.';
}
?>
<html>
<head>
	<link rel="stylesheet" href="core/css/bootstrap.css">
	<link rel="stylesheet" href="core/css/core.css">
	<script type="text/javascript" src="core/js/jquery.js"></script>
	<script type="text/javascript" src="core/js/twipsy.js"></script>
	<script type="text/javascript" src="core/js/popover.js"></script>
	<script type="text/javascript"> $(function () {$("a[rel=popover]").popover();})</script>
	<title>Install | Writr</title>
</head>
<body class="install">
	<form method="post" class="form-stacked"action="install.php">
	<?php if(isset($_GET['error'])){
		if($_GET['error']==1){
			 echo '<br/><span class="alert-message error">Please fill out all fields.</span><br/><br/>';
		}

	}?>
	
		<h1 class="center heading">Writr</h1>
		<hr/>
		<h2 class="center heading">Required Items
		<a class="hide-show-tests pointer"onclick="$('#tests').fadeIn('fast');$('.hide-show-tests').toggle();">+</a>
		<a class="hide-show-tests pointer hide" onclick="$('#tests').fadeOut('fast');$('.hide-show-tests').toggle();">-</a>
		</h2><br/>
		<span class="alert-message hide-show-tests <?php echo $class;?>"><?php echo $message;?></span>
		<div id="tests" class="hide">
		<h3>Php Version
		<a class="php-hide pointer hide"onclick="$('#php-version').fadeIn('fast');$('.php-hide').toggle();">+</a></h3>
		<div id="php-version" class="alert-message <?php echo $phpClass;?>">
        	<a class="close" onclick="$('#php-version').fadeOut('slow');$('.php-hide').toggle();">&times;</a>
        	<p><?php echo $phpMessage;?></p>
      	</div>
      	<h3>MySql Connectivity
      	<a class="ms-hide pointer hide"onclick="$('.ms-hide').toggle();$('#ms-enabled').fadeIn('fast');">+</a></h3>
		<div id="ms-enabled" class="alert-message <?php echo $msClass;?>">
        	<a class="close" onclick="$('#ms-enabled').fadeOut('slow');$('.ms-hide').toggle();">&times;</a>
        	<p><?php echo $msMessage;?></p>
      	</div>
		</div>
		<hr/>
		<h2 class="center heading">Database Settings</h2>
		<label for="db_server">Server <a href="javascript:void(0)" class="pointer" rel="popover" title="Port"data-content="You can specify the port here, like localhost:3306">?</a></label>
		<input type="text" class="xlarge" name="db_server" placeholder="localhost"/>
        <label for="db">Name</label>
        <input class="xlarge" placeholder="writr" name="db"type="text" />
		<label for="db_user">Username</label>
		<input type="text" placeholder="username" class="xlarge" name="db_user"/>
		<label for="db_pass">Password</label>
		<input type="password" id="db-password" class="xlarge" placeholder="password" name="db_pass"/><br/><br/>
		<span class="help-block">
		<a href="javascript:void(0);" class="show-hide-db center" onclick="document.getElementById('db-password').type='text';$('.show-hide-db').toggle();">Reveal Password</a>
		<a href="javascript:void(0);" class="show-hide-db center hide" onclick="document.getElementById('db-password').type='password';$('.show-hide-db').toggle();">Hide Password</a>
		</span>
		<hr/>
		<h2 class="center heading">Writr Settings</h2>
		<label for="site_name">Site Name</label>
		<input type="text" class="xlarge" placeholder="My Awesome Site" name="site_name"/>
		<label for="email">Email Address</label>
		<input type="email" class="xlarge" placeholder="email@email.com" name="email"/>
		<label for="user">Username</label>
		<input type="text" class="xlarge" placeholder="username" name="user"/>
		<label for="pass">Password</label>
		<input type="password" id="user-password" placeholder="password" class="xlarge" name="pass"/><br/><br/>
		<span class="help-block">
		<a href="javascript:void(0);" class="show-hide center" onclick="document.getElementById('user-password').type='text';$('.show-hide').toggle();">Reveal Password</a>
		<a href="javascript:void(0);" class="show-hide center hide" onclick="document.getElementById('user-password').type='password';$('.show-hide').toggle();">Hide Password</a>
		</span>
		<hr/>
		<button type="submit" class="btn large full success">Install</button>
	</form>
</body>
</html>