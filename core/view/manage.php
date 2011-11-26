
	<ul>
	<?php
	foreach($data['links'] as $link){?>
		<li><a href="?path=manage&sub=<?php echo $link['file'];?>"><?php echo $link['name'];?></a></li>
	<?php }?>
	</ul>