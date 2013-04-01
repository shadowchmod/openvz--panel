<?php
    defined("INC") or die("403 restricted access");
	
	if (isset($_GET["client"]) &&
		($client=Client::GetClient($_GET["client"]))!=false)
	{
		echo '
			<a href="index.php">< Retour au panneaux</a><br/><br/>';
		echo "
			<fieldset><legend><strong>Profil client</strong></legend>";
			$clientid=$client["id"];
			$clientnik=$client["nikhandle"];
			$clientnom=$client["nom"];
			$clientprenom=$client["prenom"];
			$clienttelfixe=$client["tel_fixe"];
			$clienttelmobile=$client["tel_mobile"];
			$clientmail=$client["email"];
			$clientetat=$client["etat"];
			$clientville=$client["ville"];
			$clientadresse=$client["adresse"];
			$clientcp=$client["cp"];
			$clientpays=$client["pays"];
?>
				<table border="\&quot;0\&quot;" align="center" >
					<tr>
						<th> 
							<center>
								<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=edit_client">
									<input type="hidden" value="<?php echo $_GET["client"];?>" name="id"/>
									<table width="100%" border="0">
										<tr>
											<td>
												<font color="#FF0000">*</font><strong>Nik-handle :</strong>
											</td>
											<td>
												<input name="nik" type="text" id="nik" value="<?php echo $clientnik?>" size="50" />
											</td>
										</tr>
										<tr>
											<td>
												<strong>Nom</strong>
											</td>
											<td>
												<input name="nom" type="text" id="nom" value="<?php echo $clientnom?>" size="50" maxlength="30"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Prénom</strong>
											</td>
											<td>
												<input name="prenom" type="text" id="prenom" value="<?php echo $clientprenom?>" size="50" maxlength="30"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Ville</strong>
											</td>
											<td>
												<input name="prenom" type="text" id="ville" value="<?php echo $clientville?>" size="50" maxlength="30"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Code Postal</strong>
											</td>
											<td>
												<input name="prenom" type="text" id="cp" value="<?php echo $clientcp?>" size="50" maxlength="30"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Adresse</strong>
											</td>
											<td>
												<input name="prenom" type="text" id="adresse" value="<?php echo $clientadresse?>" size="50" maxlength="300"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Pays</strong>
											</td>
											<td>
												<input name="prenom" type="text" id="pays" value="<?php echo $clientpays?>" size="50" maxlength="30"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Téléphone fixe</strong>
											</td>
											<td>
												<input name="telfixe" type="text" id="telfixe" value="<?php echo $clienttelfixe?>" size="50" maxlength="14"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Téléphone mobile</strong>
											</td>
											<td>
												<input name="telmobile" type="text" id="telmobile" value="<?php echo $clienttelmobile?>" size="50" maxlength="14"/>
											</td>
										</tr>
										<tr>
											<td>
												<font color="#FF0000">*</font><strong>Adresse e-mail :</strong>
											</td>
											<td>
												<input name="mail" type="text" id="mail" value="<?php echo $clientmail?>" size="50" maxlength="50"/>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Bloqué :</strong>
											</td>
											<td>
												<input name="blocked" type="checkbox" id="blocked" <?php if ($clientetat==0) echo "CHECKED";?>"/>
											</td>
										</tr>
									</table>
									<p>
										<label>
											<input type="submit" name="Modifier" id="Modifier" value="Modifier" />
										</label>
									</p>
								</form>
							</center>
						</th>
					</tr>
				</table>
				<center>
					<a href="index.php?page=action&amp;action=resetpassword&amp;client=<?php echo $_GET["client"];?>">Regénérer le mot de passe</a>
				</center>
			</fieldset>
<?php
		echo '
			<br/><fieldset><legend><strong>VPS</strong></legend>';
			
		echo "
				<form method=\"post\" action=\"index.php?page=action&amp;action=linkvps\">
				<input type=\"hidden\" name=\"clientid\" id=\"clientid\" value=\"$clientid\" />
				Ajouter VPS : <select name=\"vpsid\" id=\"vpsid\">";

		$freevps = VPS::GetFreeVPS();
		foreach($freevps as $free)
		{
			$vpsname;
			$vpsid=$free["id"];
			$planinfo=VPS::GetPlan($vpsid);
			$ipinfo=VPS::GetIP($vpsid);
			$vpsplan=$planinfo["nom"];
			$vpsip=$ipinfo["ip"];
			$vpsdns=$ipinfo["reverse_original"];
			echo "<option value=\"$vpsid\">$vpsid - $vpsplan - $vpsip - $vpsdns</option>";
		}
		echo "</select><input type=\"submit\" value=\"Ajouter\" /></form>";
?>
				<br/><br/>
				<table width="100%" border="0">
					<tr class="tabletitle">
						<td>Id</a></td>
						<td>IP</a></td>
						<td>DNS</a></td>
						<td>OS</a></td>
						<td>Plan</a></td>
						<td>Etat</a></td>
					</tr>
<?php
  		$listevps = VPS::VPSFromClient($client["id"]);
		$i=0;
		foreach ($listevps as $vps)
		{
			$vps=VPS::GetVPSFull($vps["id"]);
			$vpsid=$vps["id"];
			$vpsip=$vps["ip"];
			$vpsdns=$vps["reverse_original"];
			$vpsos=$vps["nom_os"];
			$vpsplan=$vps["nom"];
			$vpsetat=$vps["etat"];
			if ($vpsetat==1)
				$vpsetat="vert";
			else
				$vpsetat="rouge";
				
			if ($i%2==0)
			{
				echo '
					<tr class="tableimpair">';
			}else{
				echo '
					<tr class="tablepair">';
			}
			
			$link="index.php?page=admin/detail_vps&amp;vps=$vpsid";
			echo "
						<td><a href=\"$link\" class=\"linkblack\">$vpsid</a></td>
						<td><a href=\"$link\" class=\"linkblack\">$vpsip</a></td>
						<td><a href=\"$link\" class=\"linkblack\">$vpsdns</a></td>
						<td><a href=\"$link\" class=\"linkblack\">$vpsos</a></td>
						<td><a href=\"$link\" class=\"linkblack\">$vpsplan</a></td>	
						<td align=\"center\"><a href=\"$link\" class=\"linkblack\"><img src=\"images/feux_$vpsetat.png\" border=\"0\" /></a></td>
						
					 </tr>";
			$i++;
		}
		echo "
				</table><br/>";
		
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////Debut des Facture//////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
echo'
	
<h1 qtlid="58734">Facture du Client </h1>
	<br><center>
	<table border="0">
	<tr class="tabletitle" align="center">
	<td><b>#ID</b></td>
	<td><b>Date Création</b></td>
	<td><b>Date Paiement</b></td>
	<td><b>Montant</b></td>
	<td><b>Status</b></td>
	</tr>	
	';
	$i=0;


	$req_facture = mysql_query("SELECT DISTINCT invoice.id, invoice.etat, invoice.date_creat, invoice.facture FROM invoice LEFT JOIN payement on payement.id_facture = invoice.id WHERE invoice.id_client='$clientid'  ");

			while ($sql_invoice = mysql_fetch_array($req_facture))
			{
			$id_fature = $sql_invoice['id'];
			$price = "0";
					$req_prix = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$id_fature'");
					while ( $sql_price = mysql_fetch_array($req_prix))
					{
					$price += $sql_price['prix'];
					}
				
								if ($i%2==0)
									{
									echo '
									<tr class="tableimpair">';
									}else{
									echo '
								<tr class="tablepair">';
									}
			echo '
			

	<td><a href="index.php?page=admin/invoice&id='.$sql_invoice['facture'].'">'.$sql_invoice['facture'].'</a></td>
	<td>'.date('d/m/Y', $sql_invoice['date_creat']).'</td>';
	if(!empty($sql_invoice['date']) && $sql_invoice['date'] != 0)
	echo '<td>'.date('d/m/Y', $sql_invoice['date']).'</td>';
	else
	echo '<td align="center"> - </td>';
	echo '<td><center>'.$price.'&euro;</center></td>';
	if($sql_invoice['etat'] == 1)
		$etat = "Non Payé";
	if($sql_invoice['etat'] == 2)
		$etat = "Payé";
	if($sql_invoice['etat'] == 3)
		$etat = "<b>Annulé</b>";
	
	echo '<td><center>'.$etat.'</center></td>';
	echo '</tr>';
			
			}
	echo '</table></center>'; 
////////////////////////////////////////////////////////////////////////////////////////
/////////////////Fin des facture ///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////		

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////Debut des ticket///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

echo '<h1 qtlid="58734">Ticket en rapport avec le client </h1>	<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Numéro du ticket</td>
								<td>Date de création</td>
								<td>Objet</td>
								
								<td>Importance</td>
								<td>Etat</td>
								<td>Dernier reponsse</td>
								
								</tr>';
								
$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE id_client='$clientid'  "); // Requête SQL
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
						$i=0;
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
////////////////////////////////////////////////////////////////////////////////////////
///////////////////////Fin des ticket///////////////////////////////////////////////////		
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////DEBUT NOTES ADMIN///////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
	echo '<style>
h1 {
    font-size: 13px;
    color: #567eb9;
    border-bottom: 1px solid #567eb9;
}
</style><h1 qtlid="58734">Notes du client</h1>
	



';
	if ( @isset ( $_GET['add_notes'] ) )
	{
	$id_client=@Session::$Client->Id;
		$req_plan = DB:: SQLToArray("SELECT * FROM client WHERE id='$id_client' ") or die(mysql_error());
	$nom =$req_plan[0]['nom'];
	$prenom = $req_plan[0]['prenom'];
$texte = $_POST['texte'];
$time=time();
$ip=$_SERVER['REMOTE_ADDR'];
mysql_query("	INSERT INTO `panel`.`notes_client` 
(`id`, `id_client`, `time`, `ip_crea`, `id_admin`, `texte`, `etat`) VALUES
(NULL,
 '".$clientid."',
 '".$time."',
 '".$ip."',
 '".$nom." ".$prenom."',
 '".$texte."',
 '1');
			");	
			echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=admin/detail_client&client='.$clientid.'">';
	}
	$i=0;
echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Crée le </td>
								<td>Crée par</td>
								<td>Texte</td>
								
											
								</tr>';
						$req_notes = mysql_query("SELECT * FROM  notes_client WHERE id_client='$clientid'");
						while ($sql_notes = mysql_fetch_array($req_notes))
						{
						if ($i%2==0){ echo '<tr class="tableimpair">'; }else { echo '<tr class="tablepair">'; }
								echo '<td><center>'.date('d/m/Y H:i:s', $sql_notes['time']).' </center></td>
								<td><center>'.$sql_notes['id_admin'].'</center></td>
								<td><center>'.$sql_notes['texte'].'</center></td>';
									
								echo '</tr>';
						}
		if ($i%2==0){echo '<tr class="tableimpair">';}else{echo '<tr class="tablepair">';}	
echo '
<form action="index.php?page=admin/detail_client&client='.$clientid.'&add_notes=1" method="POST">
<td><center><input type="submit"></center></td>
								<td></td>
								<td><center><textarea name="texte" rows="1" cols="45"></textarea></center></form></td>';

echo '</table>';		
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////FIN NOTES ADMIN////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

		



	echo '
			</fieldset>';
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>
