<?php
	defined("INC") or die("403 restricted access");
	
	$supportedhost = array("ftp250","ftp500","ftp1000","sesswin","vpnssl");
	if (!isset($_GET['host']) || !in_array($_GET['host'],$supportedhost))
		$GLOBALS['local_var']['V_OFFER']="services/".$supportedhost[0];
	else{
		$GLOBALS['local_var']['V_OFFER']="services/".$_GET['host'];
	}
	
	print_file("pages/include/otherservices.html");
					 
?>
