<?php
	defined("INC") or die("403 restricted access");
	
	echo '<a href="index.php">< Retour aux vps</a><br/>';
	
	if (Session::Ouverte() && Session::$Client!=NULL && isset($_GET['vps']) && VPS::IsClientVPS(Session::$Client->Id,$_GET['vps']))
	{
	$vpsinfo=VPS::GetVPS($_GET['vps']);
		$detail_vps_ip=VPS::GetIP($_GET['vps']);
		
		$dns=$detail_vps_ip['reverse_original'];
	echo '<br/><br/>
			<fieldset><legend><strong>VNC console - '.strtoupper($dns).'</strong></legend>';
			
		
		
		
		
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>
