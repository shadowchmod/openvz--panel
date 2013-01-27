<?

	defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$erreur = "";
	$id_client=@Session::$Client->Id;
	
	
	if ( isset ( $_POST['sujet']) )
	{
	
	$sujet =  mysql_real_escape_string($_POST['sujet']);
	$message =   nl2br(mysql_real_escape_string($_POST['message']));
	$urgence =  mysql_real_escape_string($_POST['urgence']);
	$service =  mysql_real_escape_string($_POST['service']);
	$secteur =  mysql_real_escape_string($_POST['secteur']);
	$facture = mysql_real_escape_string($_POST['facture']);
	$time = time();
	
	//On reupere le nik_handle 
	
		$reponse = mysql_query("SELECT * FROM client WHERE id='$id_client' limit 1 "); // Requête SQL
								while ($sql = mysql_fetch_array($reponse) )
								{
								$nik_handle = $sql['nikhandle'];
								}
	
		if ( $sujet == NULL ){
		$erreur .= "Le sujet est vide.<br />";}
		
		if ( $message > 30 ){
		$erreur .= "Le message doit comporté plus de 30 carateres<br />";}
		
		if ( $urgence == NULL AND preg_match("#[^0-9]#", $urgence) ){
		$erreur .= "Le champ urgent n'es pas correcte<br />";}
		
		if ( $service == NULL AND preg_match("#[^0-9]#", $service) ){
		$erreur .= "Le champ service n'es pas correcte<br />";}
		
		if ( $secteur == NULL AND preg_match("#[^0-9]#", $secteur) ){
		$erreur .= "Le champ secteur n'es pas correcte<br />";}
		
		if ( $facture == NULL AND preg_match("#[^0-9]#", $facture) ){
		$erreur .= "Le champ facture n'es pas correcte<br />";}
		
		if ( isset ( $_POST['tech'] ) && $_POST['tech'] != NULL )
		{
		$technitien = $_POST['tech'];
		}
		else
		{
		$technitien = NULL;
		}
		
		if ( $erreur == NULL )
		{
		
		
		 mysql_query("INSERT INTO ticket(
	id_client,
	sujet,
	date_creation,
	createur,
	service,
	facture,
	etat,
	secteur,
	urgence,
	technitien) 
	VALUES(
	'".$id_client."',
	'".$sujet."',
	'".$time."',
	'".$nik_handle."',
	'".$service."',
	'".$facture."',
	'5',
	'".$secteur."',
	'".$urgence."',
	'".$technitien."')");
	
	$reponse = mysql_query("SELECT * FROM ticket WHERE id_client='$id_client' AND date_creation='$time' AND sujet='$sujet' limit 1 "); // Requête SQL
								while ($sql = mysql_fetch_array($reponse) )
								{
								$id_ticket = $sql['id'];
								}
	
	mysql_query("INSERT INTO ticket_message(
	id_client,
	id_ticket,
	date,
	message,
	etat )
	VALUES (
	'".$id_client."',
	'".$id_ticket."',
	'".$time."',
	'".$message."',
	'1' )");
	
		echo "<strong><center>Le ticket a etait envoyer avez succes !</center></strong><br />";
		echo "<center><i>Vous serez avrtie par email l'orsque un de nos agent vous aura repondu</i></center>";
		echo '<meta http-equiv="Refresh" content="3;URL=index.php?page=ticket&id='.$id_ticket.'">';
		}
		else
		{
		echo "<strong><center>";
		echo $erreur;
		echo "</center><strong>";
		}
	
	
	}
	else
	{
			

				echo '<fieldset><legend><strong>Ouvrir une demande de support (ticket)</strong></legend>
					
					<form id="form1"  name="form1" method="post" action="index.php?page=create_ticket">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Sujet : </td>
							<td><input type="text" name="sujet"></td>
						</tr>
						
						<tr>
							<td><span style="margin-left:100px;"><strong>Secteur : </td>
							<td>
							<select name="secteur">
							';
									$reponse = mysql_query("SELECT * FROM ticket_secteur "); // Requête SQL
								while ($sql = mysql_fetch_array($reponse) )
								{
								echo '<option value="'.$sql['id'].'">'.$sql['name'].'</option>';
								}
							
				echo '</select></td>
						</tr>
						<tr>
							<td><span style="margin-left:100px;"><strong>Facture concerné : </td>
							<td><select name="facture">';
							
							$reponse_facture = mysql_query("SELECT * FROM invoice WHERE id_client='$id_client'"); // Requête SQL
								while ($sql_facture = mysql_fetch_array($reponse_facture) )
								{
								echo '<option value="'.$sql_facture['id'].'">Facture #'.$sql_facture['facture'].'</option>';
								}
						echo '	<option value="NULL">Aucune facture</option></select></td>
						</tr>
						<tr>
							<td><span style="margin-left:100px;"><strong>Service concerné : </td>
							<td><select name="service">';
							
							$reponse_service = mysql_query("SELECT * FROM vps WHERE id_client='$id_client'"); // Requête SQL
								while ($sql_service = mysql_fetch_array($reponse_service) )
								{
								$id_vps = $sql_service['id'];
								$id_ip = $sql_service['id_ip'];
								$id_plan = $sql_service['id_plan'];
								
										$reponse_ip = mysql_query("SELECT * FROM ip WHERE id='$id_ip'"); // Requête SQL
										while ($sql_îp = mysql_fetch_array($reponse_ip) )
										{
										$reverse = $sql_îp['reverse_original'];
										}
										
										$reponse_plan = mysql_query("SELECT * FROM plan WHERE id='$id_plan'"); // Requête SQL
										while ($sql_plan = mysql_fetch_array($reponse_plan) )
										{
										$nom_plan = $sql_plan['nom'];
										}
								
								echo '<option value="'.$id_vps.'">VPS N°'.$id_vps.' - '.$reverse.' - '.$nom_plan.'</option>';
								}
						echo '	<option value="NULL">Aucun service</option></select></td>
						</tr>
						<tr>
							<td><span style="margin-left:100px;"><strong>Urgence : </td>
							<td><select name="urgence">
							<option value="1">Basse</option>
							<option value="2">Moyenne</option>
							<option value="3">Haute</option>	
							<option value="4">Critique</option>				
							</select></td>
						</tr>
							</tr>
						';
						if ( isset ( $_GET['tech'] ) && $_GET['tech'] != NULL )
						{
						$technitien = mysql_real_escape_string(htmlspecialchars($_GET['tech']));
						$sql_user = DB:: SQLToArray("SELECT * FROM client WHERE id='$technitien' AND admin='1' LIMIT 1");
							
							if ( isset ($sql_user[0]['nom']) )
							{
							$user_nom = $sql_user[0]['nom'];
							$user_prenom = $sql_user[0]['prenom'];
							echo '<tr>
							<td><span style="margin-left:100px;"><strong>Technicien: </td>
							<td>
							<input type="hidden" name="tech" value="'.$technitien.'" />
							<input type="text" disabled="disabled" value="';
							echo ''.$user_nom.' '.$user_prenom.'';
							echo '"></td>';
							}
						
						}
							
						echo '</tr>
						<tr>
							<td><span style="margin-left:100px;"><strong>Message : </td>
							<td><textarea name="message" rows="10" cols="48">Bonjour,
							</textarea></td>
					
						
						<tr>
							<td><span style="margin-left:100px;"><strong></td>
							<td><input type="submit" value="Soumettre la demande"></td>
						</tr> 
						</table></span>
						  
						  
						 
						 
						 
			';
			}
	
?>

