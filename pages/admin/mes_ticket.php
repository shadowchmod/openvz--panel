<?
defined("INC") or die("403 restricted access");

	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$id_client=@Session::$Client->Id;
	$i=0;
	echo '<fieldset><legend><strong>Mes demandes de soutien (Ticket)</strong></legend><br /><br />';
	echo '<center><a href="index.php?page=create_ticket" title="Ouvrir un ticket"><img  border="0"  src="images/khelpcenter-icone-9679-48.png" title="Ouvrir un ticket"><br /><strong>Ouvrir un ticket</strong></a></center><br /><br />';

	echo '<form action="index.php?page=admin/mes_ticket" method="POST" ><select name="etat">';
	
	if( isset($_POST['etat']) && $_POST['etat'] == 1)
		echo '<option value="1" SELECTED >Ouvert</option>';
	else
		echo '<option value="1">Ouvert</option>';

	if( isset($_POST['etat']) && $_POST['etat'] == 2)
		echo '<option value="2"SELECTED  >Attente de réponse client</option>';
	else
		echo '<option value="2">Attente de réponse client</option>';


	if( isset($_POST['etat']) && $_POST['etat'] == 3)
		echo '<option value="3" SELECTED >Fermé</option>';
	else
		echo '<option value="3">Fermé</option>';


	if( isset($_POST['etat']) && $_POST['etat'] == 4)
		echo '<option value="4" SELECTED>Réglé</option>';
	else
		echo '<option value="4" >Réglé</option>';


	if( isset($_POST['etat']) && $_POST['etat'] == 5)
		echo '<option value="5" SELECTED >Attente du Technicien</option>';
	else
		echo '<option value="5">Attente du Technicien</option>';

	echo '</select><input type="submit"></form>';
	
	if (isset($_POST['etat'])){
		$etat_df = $_POST['etat'];
		$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE etat='$etat_df' ORDER BY date_creation DESC "); // Requête SQL
	}
	else{
		$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE etat != '3' AND etat != '2' AND etat != '4' ORDER BY date_creation DESC "); // Requête SQL
	}
	
	$count = mysql_num_rows($reponse_ticket);

	if ( $count == 0 )
		echo "<center><strong>Aucun Ticket Support</center></strong>";
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
								
		//$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE etat='5'   "); // Requête SQL
		while ($sql_ticket = mysql_fetch_array($reponse_ticket)){
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
						$etat = "Attente Réponse Client";
					if ( $etat == 3 )
						$etat = "Fermé";
					if ( $etat == 4 )
						$etat = "Reglé";
					if ( $etat == 5 )
						$etat = "Attente Technicien";	
						
				$reponse_message = mysql_query("SELECT * FROM ticket_message WHERE id_ticket='$id_ticket'  ORDER BY id "); // Requête SQL
				while ($sql_message = mysql_fetch_array($reponse_message) ){
					$date_denrier_message = $sql_message['date'];
				}
			
				$reponse_secteur = mysql_query("SELECT * FROM ticket_secteur WHERE id='$id_secteur' limit 1 "); // Requête SQL
				while ($sql_secteur = mysql_fetch_array($reponse_secteur) ){
					$nom_secteur = $sql_secteur['name'];
				}

			if ($i%2==0)
				echo '<tr class="tableimpair">';
			else
				echo '<tr class="tablepair">';
				
			echo '<td><center><a href="index.php?page=admin/ticket&id='.$id_ticket.'" title="Voir le ticket" >#'.$id_ticket.'</a></center></td>';
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