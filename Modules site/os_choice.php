<?php
	defined("INC") or die("403 restricted access");
	
	if (isset($_GET['os']) && file_exists("pages/include/os/".$_GET['os'].".html"))
	{
		$GLOBALS['local_var']['V_OS_INFO'] = get_print_file("pages/include/os/".$_GET['os'].".html");
		if (file_exists("images/os/".$_GET['os'].".png"))
		{
			$GLOBALS['local_var']['V_OS_LOGO'] = $_GET['os'];
		}else{
			$GLOBALS['local_var']['V_OS_LOGO'] = "cmd-web";
		}
	}else{
		$GLOBALS['local_var']['V_OS_INFO'] = get_print_file("pages/include/os/index.html");
		$GLOBALS['local_var']['V_OS_LOGO'] = "cmd-web";
	}
	
	print_file("pages/include/os_choice.html");					 
?>
