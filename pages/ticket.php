<?


	defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$id_client=@Session::$Client->Id;
	$id_ticket = $_GET['id'];
	
	$reponse = mysql_query("SELECT * FROM ticket WHERE id='$id_ticket' limit 1 "); // Requête SQL
			while ($sql = mysql_fetch_array($reponse) )
								{
							$id_client_ticket = $sql['id_client'];
							$sujet =  $sql['sujet'];
							$importance =  $sql['urgence'];
							$service =  $sql['service'];
							$facture =  $sql['facture'];
							$createur =  $sql['createur'];
							$secteur = $sql['secteur'];
							$date_crea = $sql['date_creation'];
							$etat = $sql['etat'];
							
								}
				if ( $id_client_ticket == $id_client OR $id_client == 1 )
				{
					if ( isset ( $_GET['REQ'] ) )
					{
							if ( $_GET['REQ'] == "close" )
							{
							mysql_query("UPDATE ticket SET etat='3' WHERE id='". $id_ticket ."'");
							echo "<strong><center>Votre ticket vient d'etre fermer.</center></strong>";
							echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=ticket&id='.$id_ticket.'">';

							}
					}
					if ( isset ( $_POST['message'] ) )
					{
					$message_add = mysql_real_escape_string($_POST['message']);
					$time = time();
					
					mysql_query("INSERT INTO ticket_message(
					id_client,
					id_ticket,
					date,
					message,
					etat )
					VALUES (
					'".$id_client_ticket."',
					'".$id_ticket."',
					'".$time."',
					'".$message_add."',
					'1' )");
					mysql_query("UPDATE ticket SET etat='5' WHERE id='". $id_ticket ."'");
					echo "<strong><center>Votre message a bien etait ajouté</center></strong>";
						echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=ticket&id='.$id_ticket.'">';
					
					}
					
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
						$etat = "Attente de votre réponse";
						
					if ( $etat == 3 )
						$etat = "Fermé";
						
					if ( $etat == 4 )
						$etat = "Reglé";
						
					if ( $etat == 5 )
						$etat = "Attente technicien";
						
							$reponse_secteur = mysql_query("SELECT * FROM ticket_secteur WHERE id='$secteur' limit 1 "); // Requête SQL
			while ($sql_secteur = mysql_fetch_array($reponse_secteur) )
								{
								$nom_secteur = $sql_secteur['name'];
								}
								
								$reponse_message = mysql_query("SELECT * FROM ticket_message WHERE id_ticket='$id_ticket'  ORDER BY id "); // Requête SQL
			while ($sql_message = mysql_fetch_array($reponse_message) )
								{
								$date_denrier_message = $sql_message['date'];
								}
						
					echo '<fieldset><legend><strong>Ticket #'.$id_ticket.' - Ouvert par <a href="index.php?page=admin/detail_client&client='.$id_client_ticket.'">'.$createur.'</a></strong></legend>';
					echo '<center><table border="0"';
						echo '<TR>';
					
							echo '<TD><strong>Sujet :</strong> '.$sujet.'</TD>';
							echo '<TD><span style="margin-left:100px;"><strong>Importance :</strong>  '.$importance.'</TD>';
						echo '</TR>';
						echo '<TR>';
					$date_formater = date('d/m/Y', $date_crea);
							echo '<TD><strong>Ouvert le  :</strong> '.$date_formater.' </TD>';
							echo '<TD><span style="margin-left:100px;"><strong>Derniere reponse le :</strong> '.date('d/m/Y', $date_denrier_message).'</TD>';
						echo '</TR>';
						echo '<TR>';
					
							echo '<TD><strong>Secteur :</strong> '.$nom_secteur.'</TD>';
							echo '<TD><span style="margin-left:100px;"><strong> Etat :</strong> '.$etat.' ';
							if ( $etat != "Fermé" )
							{
							echo '<a href="index.php?page=ticket&id='.$id_ticket.'&REQ=close">[fermer]</a>';
							}
							echo '</TD>';
						echo '</TR>';
					echo '</table></center>';
					echo '</fieldset>';
					
					// -----
					$i=0;
					echo '<table border="0">';
					$reponse_message = mysql_query("SELECT * FROM ticket_message WHERE id_ticket='$id_ticket' AND etat='1' ORDER BY id "); // Requête SQL
			while ($sql_message = mysql_fetch_array($reponse_message) )
								{
								$i+=1;
							$id_client_send = $sql_message['id_client'];
							$message_postage =  $sql_message['message'];
							$date_postage =  $sql_message['date'];
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
						<tr class="tableimpair" valign="top">';
							}else{
								echo '
						<tr class="tablepair" valign="top">';
							}
							echo '<td width="300px" style="padding-top:10px;"><strong>Envoyé par <a href="index.php?page=admin/detail_client&client='.$id_client_ticket.'">'.$nom_client.' '.$prenom_client.'</strong></a>';
							if ( $admin_q == 1 AND $id_client_send != 1)
							echo "<br /><center><i>(<b>Administrateur</b>)</i></center>";
							echo '</strong><br /><i>Le : '.date('d/m/Y', $date_postage).' a '.date('H:i:s', $date_postage).'</i></td>';
							echo '<td width="500px" valign="top"><br />'.nl2br($message_postage).'<br /><br /><br /></td>';
							
													
							echo'</tr>';
				
								}
								echo '</table>';
					// -----
					if ( $etat != "Fermé" )
							{
							
					echo '<table> <tr> <td width="300">Repondre : </td>
					<form action="index.php?page=ticket&id='.$id_ticket.'" method="post">
					<td><textarea name="message" rows="5" cols="50"></textarea><br /></td><br>
					
					</tr>
					<tr>
					<td></td>
					<td><input type="submit" value="Envoyer votre reponsse"> </td>					
					</form></table>';
					}
					}
					
					else
					{
		


					$message_waring = "Client  Affichage d\'un ticket";
					$msg_warning = "Tentative d\'acces a un ticket qui ne lui appartien pas.";
					echo "<center><strong>Accès refuser : Ce ticket ne vous apartien pas !</center></strong>";
					$conf_adresse_ip = $_SERVER['REMOTE_ADDR'];
					$time = time();
					 mysql_query("INSERT INTO `warning` ( `id` , `id_client` , `ip` , `message` , `page` , `time` , `type` ) 
					VALUES ('NULL', '".$id_client."', '".$conf_adresse_ip."', '".$msg_warning."', '".$message_waring."', '".$time."', 'ACCES_DENY' )")  or die(mysql_error());
					}
	
	
?>