<?
$id_maintenance = $_GET['id'];

	$req_maintenan = mysql_query("SELECT * FROM maintenance WHERE id='$id_maintenance' ");
										
										while ($sql_maintenance = mysql_fetch_array($req_maintenan))
										{
					
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
					</center>';
					echo '</fieldset>';
					$i=0;
						echo '<table border="0">';
					$reponse_message = mysql_query("SELECT * FROM maintenance_message WHERE id_maintenance='$id_maintenance' ORDER BY id "); // Requête SQL
			while ($sql_message = mysql_fetch_array($reponse_message) )
								{
								$i+=1;
							$id_client_send = $sql_message['id_tech'];
							$message_postage =  $sql_message['message'];
							$date_postage =  $sql_message['time'];
										$reponse_client = mysql_query("SELECT * FROM client WHERE id='$id_client_send' limit 1 "); // Requête SQL
										while ($sql_client = mysql_fetch_array($reponse_client) )
										{
										$nom_client = $sql_client['nom'];
										$prenom_client = $sql_client['prenom'];
										$admin_q =  $sql_client['admin'];
										}
							
							if ($i%2==0)
							{
								
								echo '
						<tr class="tableimpair">';
							}else{
								echo '
						<tr class="tablepair">';
							}
							echo '<td width="300px" ><strong>Envoyer par '.$nom_client.' '.$prenom_client.'';
							if ( $admin_q == 1 AND $id_client_send != 1)
							echo "<br /><center><i>(Administarteur)</i></center>";
							echo '</strong><br /><i>Le : '.date('d/m/Y', $date_postage).' a '.date('H:i:s', $date_postage).'</i></td>';
							echo '<td width="500px"><br /><br /><br />'.nl2br($message_postage).'<br /><br /><br /></td>';
							echo'</tr>';
				
								}
								echo '</table>';
					}

?>