<?php
	defined("INC") or die("403 restricted access");
	
	$supportedhost = array(	"start1g","start10g",
							"pro20g","pro50g",
							"start1gs","start10gs",
							"pro20gs","pro50gs",
							"rev50","rev100","rev200");
	if (!isset($_GET['host']) || !in_array($_GET['host'],$supportedhost))
		$GLOBALS['local_var']['V_OFFER']="services/".$supportedhost[0];
	else{
		$GLOBALS['local_var']['V_OFFER']="services/".$_GET['host'];
	}
	
	print_file("pages/include/hosting.html");
					 
?>