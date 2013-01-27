<?php
	defined("INC") or die("403 restricted access");
	$id_client=@Session::$Client->Id;
	if (Session::Ouverte() && Session::$Client!=NULL)
	{			
		echo '
			Bonjour '.ucfirst(strtolower(@Session::$Client->Prenom)).' '.strtoupper(@Session::$Client->Nom).' : ';

/* echo '<br /><br /><center><table border="0"><tr>
<td><img src="images/avertissement-icone-9768-64.png" width="32" height="32"></td>
<td><strong><center>Vous pouvez d�s � pr�sent r�-installer vos VPS.<br />(Ticket support pour r�cuprer vos donn�es par FTP)</center></strong></td>
<td><img src="images/avertissement-icone-9768-64.png" width="32" height="32"></td>
</tr></table></center><br /><br />';	*/

		echo '
		<center>
		<table border="0">
		<tr>
		<th  WIDTH="33%">
		<a href="index.php?page=facture" title="Mes factures" ><img border="0" src="images/facture-facture-icone-9075-48.png" title="facture" width="38" height="38">
		<br />
		<strong>Mes factures</strong></a>
		</th>
		<th  WIDTH="33%">
		<a href="index.php?page=mes_ticket" title="Mes demande de soutien" ><img  border="0" src="images/khelpcenter-icone-6008-48.png" title="facture" width="38" height="38">
		<br />
		<strong>Mes demande de soutien</strong></a>
		</th>
		<th  WIDTH="33%">
		<a href="index.php?page=edit_profil" title="Mes factures" ><img  border="0" src="images/modifier-profil-details-utilisateur-icone-9329-48.png" title="facture" width="38" height="38">
		<br />
		<strong>Editer mon profil</strong>
		</a>
		</tr>
		
		<tr>
		<td></td>
		
		<td width="33%" align="center">
		<center><br><a href="index.php?page=create_invoice"></center>
		        	<img src="images/dossier-manille-nouvelles-icone-9149-64.png" width="38" height="38" border="0" /><br />
   	 <strong>Renouveller un services</strong></a>
	  </td>
		</tr>
		<tr>
		<th  WIDTH="33%"></th>
		<th  WIDTH="33%"></th>
		<th  WIDTH="33%"></th>
		<th  WIDTH="33%">
		
		<center><br><a href="http://travaux.your-domaine.fr" target="_blank"></center>
		        	<img src="images/1262637228_network-error.png" width="38" height="38" border="0" /><br />
   	 <strong>Maintenance en cours</strong></a>
		
		</th>
		</tr>
		</table>
		</center>';
		
		
		$count="1";
		$reponse = mysql_query("SELECT * FROM vps WHERE id_client='$id_client' && etat='1'");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$count+=1;
								$id_server = $sql['id_server'];
									$req_maintenan = mysql_query("SELECT * FROM maintenance WHERE server='$id_server' ");
										$i=0;
										while ($sql_maintenance = mysql_fetch_array($req_maintenan))
										{
										$i+=1;
										}
										
										
								}
		
						$req_maintenan = mysql_query("SELECT * FROM maintenance WHERE server='$id_server' ");
										
										while ($sql_maintenance = mysql_fetch_array($req_maintenan))
										{
					echo '<br /><br /><br /><br /><strong>Une maintenance est en cour :</strong><br /><br />';
					echo '<fieldset><legend><strong>'.$sql_maintenance['sujet'].'</strong></legend>';
					echo '<center><table border="0"';
						echo '<TR>';
					
							echo '<TD><strong>Type : </strong>'.$sql_maintenance['type'].' </TD>';
							echo '<TD><span style="margin-left:100px;"><strong>Importance :</strong> '.$sql_maintenance['sujet'].' </TD>';
						echo '</TR>';
						echo '<TR>';
					
							echo '<TD><strong>Ouvert le  :</strong> '.date('d/m/y H:i:s',$sql_maintenance['date_open']).' </TD>';
							echo '<TD><span style="margin-left:100px;"><strong>Temp estim&eacute; : </strong> '.$sql_maintenance['temp_prevue'].'</TD>';
						echo '</TR>';
						echo '<TR>';
					
							echo '<TD><strong>Avancement : </strong> '.$sql_maintenance['avancement'].'%</TD>';
							echo '<TD><span style="margin-left:100px;"><strong> Technitien :</strong> ';
							$tech = $sql_maintenance['technitien'];
							$sql_user = DB:: SQLToArray("SELECT * FROM client WHERE id='$tech' LIMIT 1");
							$user_nom = $sql_user[0]['nom'];
							$user_prenom = $sql_user[0]['prenom'];
							echo ''.$user_nom.' '.$user_prenom.'';
							
							echo '</TR>';
					echo '</table></center>
					<br /><br /><i>
					<center>'.$sql_maintenance['description'].'
					</i><br /><br />
					<strong><a href="index.php?page=details_maintenance&id='.$sql_maintenance['id'].'" >Detail de la maintenance</a></center>';
					echo '</fieldset><br /><br /><br /><br />';
										}
		}
		echo" Voici vos service :";
		if ( $count == 1 )
		{
		echo "<center><strong>Vous n'avez aucun service. </strong></center>";
		}
		else
		{
		echo '
			<br/><br/>';
			echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Num&eacute;ro du Service</td>
								<td>Type de service</td>
								<td>Domaine</td>
								<td>Plan</td>								
								
								<td>Etat</td>
								
								
								</tr>';
		$i=0;						
		
		
		
		$reponse = mysql_query("SELECT * FROM vps WHERE id_client='$id_client' && etat='1'");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$id_vps = $sql['id'];
								$os_vps = $sql['id_os'];
								if ($os_vps==0||$os_vps==13)
								{
								$name_os = "Inconnu";
								}
								else
								{
									$sql_os = DB:: SQLToArray("SELECT * FROM os WHERE id='$os_vps' LIMIT 1");
												$name_os = $sql_os[0]['nom_os'];
								}
								$id_ip = $sql['id_ip'];
									$sql_ip = DB:: SQLToArray("SELECT * FROM ip WHERE id='$id_ip' LIMIT 1");
												$ip_ip = $sql_ip[0]['ip'];
												$ip_reverse = $sql_ip[0]['reverse_original'];
												
								$id_plan = $sql['id_plan'];
									$sql_plan = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_plan' LIMIT 1");
												$nom_plan = $sql_plan[0]['nom'];
								$id_etat = $sql['etat'];
								
								if ( $id_etat == 1 )
								$id_etat = "Actif";

								if ( $id_etat == 2)
								$id_etat = "Suspendu";
								
								$i++;
								if ($i%2==0)
									{
									echo '
									<tr class="tableimpair">';
									}else{
									echo '
								<tr class="tablepair">';
									}
									
echo '<td><center><a href="index.php?page=vps_detail&vps='.$id_vps.'" title="">#'.$id_vps.'</a></center></td>';
echo '<td><center>VPS</center></td>';
echo '<td><center>'.$ip_reverse.'</center></td>';
echo '<td><center>'.$nom_plan.'</center></td>';

echo '<td><center>'.$id_etat.'</center></td>';
echo '</tr>';
								}
							

	$req_hosting = mysql_query ("SELECT * FROM hosting WHERE id_client='$id_client' ");
		while ($sql_hosting = mysql_fetch_array($req_hosting))
		{
								if ( $sql_hosting['etat'] == 1 )
								$id_etat = "Actif";

								if ( $sql_hosting['etat'] == 2)
								$id_etat = "Suspendu";
								
								$i++;
								if ($i%2==0)
									{
									echo '
									<tr class="tableimpair">';
									}else{
									echo '
								<tr class="tablepair">';
									}
									
echo '<td><center><a href="index.php?page=vps_detail&vps='.$sql_hosting['id'].'" title="">#'.$sql_hosting['id'].'</a></center></td>';
echo '<td><center>H&eacute;bergement web</center></td>';
echo '<td><center>'.$sql_hosting['domaine'].'</center></td>';
echo '<td><center>'.$sql_hosting['id_plan'].'</center></td>';

echo '<td><center>'.$id_etat.'</center></td>';
echo '</tr>';
		
		}


						echo '</table><br /><br /><br />';
		}
		
	
?>
