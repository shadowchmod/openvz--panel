<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::Ouverte() && Session::$Client!=NULL)
	{						
		echo '
			Bonjour '.ucfirst(strtolower(@Session::$Client->Prenom)).' '.strtoupper(@Session::$Client->Nom).' : ';
		
		echo '
		<center>
		
		<a href="index.php?page=facture" title="Mes factures" ><img src="facture-facture-icone-9075-48.png" title="facture"></a>
		<br />
		Mes factures
		</center>';
		echo" Voici vos RPS :";
		echo '
			<br/><br/>';
		
		$vpsarray = VPS::VPSFromClient(Session::$Client->Id);
		foreach($vpsarray as $vps)
		{
			if ($vps['new']==1)
			{
				ShowNewVPS($vps);
			}
		}
		
		foreach($vpsarray as $vps)
		{
			if ($vps['etat']==1)
			{
				ShowDetailVPS($vps);
			}
		}
	}
?>