<?
defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$id_client=@Session::$Client->Id;
	$id_vps = $_GET['vps'];
	
	$vpsarray = VPS::VPSFromClient(Session::$Client->Id);
		foreach($vpsarray as $vps)
		{
			if ($vps['new']==1 && $vps['id']==$id_vps )
			{
				ShowNewVPS($vps);
			}
		}
		
foreach($vpsarray as $vps)
		{
			if ($vps['etat']==1 && $vps['id']==$id_vps)
			{
				ShowDetailVPS($vps);
			}
		}

?>