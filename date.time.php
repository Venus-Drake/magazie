<header>
		<meta http-equiv="refresh" content="1">
</header>
<?php
	 date_default_timezone_set('Europe/Bucharest');
	 $date = date('d M Y', time());
	 $hour = date('h:i:s', time());
	 echo '<font size = 5><b>'.$date.'&nbsp&nbsp'.$hour;
?>