<?

	defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$id_client=@Session::$Client->Id;
	$i=0;
	echo '<fieldset><legend><strong>Mes demande de soutien (ticket)</strong></legend><br /><br />';
	echo '<center><a href="index.php?page=create_ticket" title="Ouvrir un ticket"><img  border="0"  src="images/khelpcenter-icone-9679-48.png" title="Ouvrir un ticket"><br /><strong>Ouvrir un ticket</strong></a></center><br /><br />';
	$count = "1";
	$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE id_client='$id_client'  "); // Requête SQL
			while ($sql_ticket = mysql_fetch_array($reponse_ticket) )
								{
								$count+=1;
								}
if ( $count == 1 )
{
echo "<center><strong>Vous n'avez aucune demande de soutien.</center></strong>";
}
else
{
	echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Numéro du ticket</td>
								<td>Date de création</td>
								<td>Objet</td>
								
								<td>Importance</td>
								<td>Etat</td>
								<td>Dernier reponsse</td>
								
								</tr>';
								
$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE id_client='$id_client'  "); // Requête SQL
			while ($sql_ticket = mysql_fetch_array($reponse_ticket) )
								{
								$id_ticket = $sql_ticket['id'];
								$date_de_creation = $sql_ticket['date_creation'];
								$sujet_ticket = $sql_ticket['sujet'];
								$id_secteur = $sql_ticket['secteur'];
								$importance = $sql_ticket['urgence'];
								$etat = $sql_ticket['etat'];
								
										
								
					if ( $importance == 1 )
						$importance = "Basse";
						
					if ( $importance == 2 )
						$importance = "Moyenne";
						
					if ( $importance == 3 )
						$importance = "Haute";
						
					if ( $importance == 4 )
						$importance = "Critique";
						
					if ( $etat == 1 )
						$etat = "Ouvert";
						
					if ( $etat == 2 )
						$importance = "En attente de votre reponsse";
						
					if ( $etat == 3 )
						$importance = "Fermer";
						
					if ( $etat == 4 )
						$etat = "Reglès";
						
							$reponse_message = mysql_query("SELECT * FROM ticket_message WHERE id_ticket='$id_ticket'  ORDER BY id "); // Requête SQL
			while ($sql_message = mysql_fetch_array($reponse_message) )
								{
								$date_denrier_message = $sql_message['date'];
								}
						
										$reponse_secteur = mysql_query("SELECT * FROM ticket_secteur WHERE id='$id_secteur' limit 1 "); // Requête SQL
											while ($sql_secteur = mysql_fetch_array($reponse_secteur) )
											{
											$nom_secteur = $sql_secteur['name'];
											}
								
								if ($i%2==0)
									{
									echo '
									<tr class="tableimpair">';
									}else{
									echo '
								<tr class="tablepair">';
									}
								echo '<td><center><a href="index.php?page=ticket&id='.$id_ticket.'" title="Voir le ticket" >#'.$id_ticket.'</a></center></td>';
								echo '<td><center>'.date('d/m/y', $date_de_creation).'</center></td>';
								echo '<td><center>'.$sujet_ticket.'</center></td>';
								echo '<td><center>'.$importance.'</center></td>';
								echo '<td><center>'.$etat.'</center></td>';
								echo '<td><center>'.date('d/m/y', $date_denrier_message).'</center></td>';
									
								echo '</tr>';
									
									
								}
								echo '</table>';
								}
								echo '</fieldset>';
								?>