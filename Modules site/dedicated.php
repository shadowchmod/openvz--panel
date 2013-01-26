<?php
	defined("INC") or die("403 restricted access");
	
	$supportedhost = array("prenium500g","dedil","duobestof","duostorage","duomax","quadmax","quadlarge","quadssd");
	if (!isset($_GET['host']) || !in_array($_GET['host'],$supportedhost))
		$GLOBALS['local_var']['V_OFFER']="services/".$supportedhost[0];
	else{
		$GLOBALS['local_var']['V_OFFER']="services/".$_GET['host'];
	}
	$lol = "poutpout";
	print_file("pages/include/dedicated.html");
					 
?>