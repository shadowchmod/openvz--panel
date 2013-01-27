<?php
    defined("INC") or die("403 restricted access");
	
	if (isset($_GET["vps"]) &&($vps=VPS::GetVPS($_GET["vps"]))!=false)
	{
		echo '
			<a href="index.php">< Retour au panneau</a><br/><br/>';
		echo "
			<fieldset><legend><strong>VPS</strong></legend>";
			
			$vpsinfo=VPS::GetVPS($_GET["vps"]);
			ShowLightDetailVPS($_GET["vps"]);
			header("Status: 301 Moved Permanently");
			header("Location: index.php?page=admin/edit_vps&id=".$vpsinfo["id"]."");

			if ($vpsinfo["id_client"]==0)
			{
				echo "<center>Serveur libre</center>";
				echo "<center><a href=\"javascript:DeleteVPS();\">Supprimer le serveur. ATTENTION ! Aucune récupération possible.</a></center>";
				echo "
				<script language=\"JavaScript\" type=\"text/javascript\">
					function DeleteVPS(){
            if (confirm(\"Voulez vous vraiment supprimer ce VPS du serveur ?\")){
              window.location.replace(\"index.php?page=action&action=delete_vps&vps=".$vpsinfo["id"]."\");
            }
          }
				</script>";

			}else{
				$clientinfo=Client::GetClient($vpsinfo["id_client"]);
				$clientid=$clientinfo["id"];
				$clientnom=$clientinfo["nom"];
				$clientprenom=$clientinfo["prenom"];
				$vpsid=$_GET["vps"];
				$etat=$vpsinfo["etat"];
				echo "<center>Propriétaire : <a href=\"index.php?page=admin/detail_client&amp;client=$clientid\">$clientprenom $clientnom </a>&nbsp;<a href=\"javascript:UnlinkVPS($vpsid);\"><img src=\"images/bad.png\" alt=\"\" border=\"0\" /></a></center>";
				
				if($etat==1){
          echo "<center>Serveur Actif - <a href=\"javascript:BlockVPS($vpsid);\">Bloquer le serveur</a></center>";
				}else{
          echo "<center>Serveur Bloqué - <a href=\"javascript:DeblockVPS($vpsid);\">Réativer le serveur</a></center>";
				}
						
				
				
				echo "
				<script language=\"JavaScript\" type=\"text/javascript\">
				function UnlinkVPS(vpsid)
				{
					if (confirm(\"Voulez vous vraiment enlever ce VPS à ce client?\"))
					{
						window.location.replace(\"index.php?page=action&action=unlinkvps&vps=$vpsid\");
					}
				}
				function BlockVPS(vpsid)
				{
					if (confirm(\"Voulez vous bloquer ce VPS à ce client?\"))
					{
						window.location.replace(\"index.php?page=action&action=blockvps&vps=$vpsid\");
					}
				}
				function DeblockVPS(vpsid)
				{
					if (confirm(\"Voulez vous réactiver ce VPS à ce client?\"))
					{
						window.location.replace(\"index.php?page=action&action=deblockvps&vps=$vpsid\");
					}
				}
				</script>";
			}
			
		echo '<br />
			</fieldset>';
		
		
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>