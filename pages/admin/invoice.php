<?
   defined("INC") or die("403 restricted access");
	
	
	$erreur = "";
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';

	
 $invoice = $_GET['id'];

 
if ( isset ( $_GET['action'] ) )
{
	if ( $_GET['action'] == "edit" )
	{
	$id_corp = $_GET['id_copr'];
	$texte = $_POST['texte'];
	$prix = $_POST['prix'];
	$etat = $_POST['etat'];
	$cat_service = $_POST['cat_service'];
	$facture_day = $_POST['facture_day'];
	$type_servie = $_POST['type_servie'];
	mysql_query("UPDATE invoice_corp SET text='$texte', etat='$etat', prix='$prix', cat_service='$cat_service', jour_add='$facture_day', type_action='$type_servie'  WHERE id='$id_corp'");
	}


}
$reponse = mysql_query("SELECT * FROM invoice WHERE facture='$invoice'"); // Requête SQL
// on initisalise quelques variable 
$suplemet_payer = "0,00";
 $prix_tt = "00,00";
 $ligne_service ="";
while ($sql = mysql_fetch_array($reponse) )
{
$id_client_facture = $sql['id_client'];
$facture_id_id =  $sql['id'];
//On recupere les info client
			$reponse = mysql_query("SELECT * FROM client WHERE id='$id_client_facture'"); // Requête SQL
			while ($sql_client = mysql_fetch_array($reponse) )
			{
			$client_id = $sql_client['id'];
			$client_nom = $sql_client['nom'];
			$client_prenom = $sql_client['prenom'];
			$client_adresse = $sql_client['adresse'];
			$client_ville = $sql_client['ville'];
			$client_cp = $sql_client['cp'];
			$client_pays = $sql_client['pays'];
			$client_nikhandle = $sql_client['nikhandle'];
			}
//On recupere les ellement de la facture
			
			
		
		
		
			$facture_etat = $sql['etat'];
		
		
			$facture_date_crea = $sql['date_creat'];
		
			$facture_commentair = $sql['commentair_facture'];
			
			$facture_id_number = $sql['facture'];
			

			//On vérifie l'etat de la facture
			
				/* Liste des etats possible !
				1 --> Facture non payer
				2 --> Facture payer et traité
				3 --> Facture payer et non-traité
				4 --> Facture erroné 
				5 --> Facture payer partielement
				6 --> Facture annulé par le Client
				7 --> Facture annulé par un admin
				8 --> Facture froduleuse
				9 --> Payement douteux/Attente de vérifcation de payement
				*/
			
				if ( $facture_etat == 4 )
				{
				$error_msg .= "<strong>Erreur : </strong>Une erreur a etait détecté dans cette facture, merci de contacter le support";
				$erreur += 1;
				}
				elseif ( $facture_etat == 6 )
				{
				$error_msg .= "<strong>Erreur : </strong> Vous avez annulé cette facture, pour la réactiver merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 7 )
				{
				$error_msg .= "<strong>Erreur : </strong>Cette facture etait annulé par un Administrateur, pour la réactiver merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 8 )
				{
				$error_msg .= "<strong>Erreur : </strong>Cette facture a etait classer comme froduleuse, pour la réactiver merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 9 )
				{
				$error_msg .= "<strong>Erreur : </strong>Cette facture a etait payer mais le payement est toujour en attente de véirification<br />";
				//$erreur += 1;
				}
				
				
		$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$facture_id_id' "); // Requête SQL
		while ($sql_corp = mysql_fetch_array($reponse_corp) )
		{
		$facture_id_corp = $sql_corp['id'];
		$facture_type_service = $sql_corp['type_action'];
		$facture_cat_service = $sql_corp['cat_service'];
		$id_service = $sql_corp['id_service'];
		$facture_jour = $sql_corp['jour_add'];
		$facture_id_prix =  $sql_corp['id_prix'];
		$facture_prix  =  $sql_corp['prix'];
		$texte_facture = $sql_corp['text'];
		$facture_etat2 = $sql_corp['etat'];
				//On recupere le type de facture 
					if ( $facture_type_service == "RRENEW" )
					{
					$indicate_type_facture = "Renouvellement";
					}
					elseif ( $facture_type_service == "ACHAT" )
					{
					$indicate_type_facture = "Location";
					}
					
				//On récupere le domaine && date d'expiration && prix
					if ( $facture_cat_service == "vps" )
					{
							//connexion a la table VPS pour recupere la fiche VPS
							$reponse_domaine = mysql_query("SELECT * FROM vps WHERE id='$id_service' "); // Requête SQL
							while ($sql_domaine = mysql_fetch_array($reponse_domaine) )
							{
							// On recupere l'id de l'ip
							$id_domaine_ip_vps = $sql_domaine['id_ip'];
							
							//on recupere la date d'expiration
							$expiration_avant_payement = $sql_domaine['expiration'];
							
							//on recupere l'id du plan 
							$id_plan_prix = $sql_domaine['id_plan'];
							
								//On se connecte a la BDD des Ip pour recupéré le ndd 
									$reponse_domaine_ip = mysql_query("SELECT * FROM ip WHERE id='$id_domaine_ip_vps'"); // Requête SQL
									while ($sql_domaine_ip = mysql_fetch_array($reponse_domaine_ip) )
									{
									$domaine_finale_vps = $sql_domaine_ip['reverse_original'];
									}
							}
					//On calcul la date après renouvellement
							$expiration_apres_payement = $expiration_avant_payement + $facture_jour;
					}
				
				//on cherche le prix 
								
						
						
					
						
						$prix_tt += $facture_prix;
						
						
						
						
						
						
			switch ($facture_etat2)
			{
			case "1":
			$message_etat2 ="Payement en attente";
			break;
			case "2":
			$message_etat2 ="En attente d'execution";
			break;
			case "3":
			$message_etat2 ="Facture traiter";
			break;
			case "4":
			$message_etat2 ="Erreur l'ors du traitement";
			break;
			case "5":
			$message_etat2 ="Annulé";
			break;
			case "6":
			$message_etat2 ="Payement en cour de véirifcation";
			break;
			}
		$ligne_service .= '<form action="index.php?page=admin/invoice&id='.$invoice.'&action=edit&id_copr='.$facture_id_corp.'" method="POST">
				<tr>
<td><input type="text" name="texte" size="40" value="'.$texte_facture.'"></td>
<td><select name="etat">
';

$ligne_service .=  '<option '; if ( $facture_etat2 == "1") { $ligne_service .=  ' selected="selected" '; } $ligne_service .=  'value="1">Payement en attente</option>';
$ligne_service .=  '<option '; if ( $facture_etat2 == "2") { $ligne_service .=  ' selected="selected" '; } $ligne_service .=  'value="2">En attente d\'execution</option>';
$ligne_service .=  '<option '; if ( $facture_etat2 == "3") { $ligne_service .=  ' selected="selected" '; } $ligne_service .=  'value="3">Facture traiter</option>';
$ligne_service .=  '<option '; if ( $facture_etat2 == "4") { $ligne_service .=  ' selected="selected" '; } $ligne_service .=  'value="4">Erreur l\'ors du traitement</option>';
$ligne_service .=  '<option '; if ( $facture_etat2 == "5") { $ligne_service .=  ' selected="selected" '; } $ligne_service .=  'value="5">Annulé</option>';
$ligne_service .=  '<option '; if ( $facture_etat2 == "6") { $ligne_service .=  ' selected="selected" '; } $ligne_service .=  'value="6">Payement en cour de véirifcation</option>';
$ligne_service .=  '
</select></td>
<td><input type="text" name="cat_service" size="5" value="'.$facture_cat_service.'"></td>
<td><input type="text" name="facture_day" size="10" value="'.$facture_jour.'"></td>
<td><input type="text" name="type_servie" size="2" value="'.$facture_type_service.'"></td>

<td>'.$facture_prix.'€</td>
<td><input type="text" size="3" name="prix" value="'.$facture_prix.'"></td>
<td><input type="submit" ></td>
</tr>

</form>'; 
		}
	
				
//On recupere les payement
			
			/*
			1 = Payement axcepter
			2 = Payement en attente de vérification
			3 = Payement froduleux
			4 = Payement annulé
			5 = Payement échoué
			6 = Payement renboursé
			*/
			// on initialise la varble du montant payé
			$payement_payer_refund = "0,00";
			$payement_payer_ok = "0,00";
			$reponse_payement = mysql_query("SELECT * FROM payement WHERE id_facture='$facture_id_id' "); // Requête SQL
			
			while ($sql_payement = mysql_fetch_array($reponse_payement) )
			{
			//On liste les payement
					if ( $sql_payement['etat'] == 1)
					{
					$payement_payer_ok += $sql_payement['montant'];
					}
					
					if ( $sql_payement['etat'] == 6)
					{
					$payement_payer_refund += $sql_payement['montant'];
					}
			}
			$facture_payer = 0;
			//On calcul le reste a peyr
			$payement_payer_reste = $prix_tt - $payement_payer_ok;
			$payement_payer_reste = $payement_payer_reste - $payement_payer_refund;
			
		
		
			
			//On récupere l'etat 2 --> $facture_etat2
			/* Etat possible 
			1 -> En attente de payement
			2 -> Payer en attente d'execution
			3 -> Facture traité
			4 -> Erreur l'ors du traitement
			5 -> Annulé
			*/
			
			//On génére le titre de la facture 
			
			// on propose les payement disponible
				// si la facture a deja etait payer en totalité on ne propose pas les moyen de payement			
				 if ( $facture_payer != 1 )
				 {
				$bouton_allopass = '
				<a  border="0" href="index.php?page=payement&type=allopass&id='.$invoice.'" ><img border="0" src="images/allopass.gif" ></a>
				
				';
				$bouton_paypal = "
				
<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
<input type=\"hidden\" name=\"business\" value=\"maxoff@mixfeever.com\">
<input type=\"hidden\" name=\"lc\" value=\"FR\">
<input type=\"hidden\" name=\"item_name\" value=\"Facture du service #$invoice \">
<input type=\"hidden\" name=\"item_number\" value=\"".$facture_id_number."\">
<input type=\"hidden\" name=\"amount\" value=\"".$payement_payer_reste."\">
<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">
<input type=\"hidden\" name=\"button_subtype\" value=\"services\">
<input type=\"hidden\" name=\"no_note\" value=\"1\">
<input type=\"hidden\" name=\"no_shipping\" value=\"2\">
<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted\">
<input type=\"image\" src=\"https://www.paypal.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !\">
<img alt=\" border=\"0\" src=\"https://www.paypal.com/fr_FR/i/scr/pixel.gif\" width=\"1\" height=\"1\">
</form>
";
				$bouton_cheque = "";
				$bouton_virement = "";
				}
//On affiche les paramettre de la facture

/* rapelle des parametre client 
			$client_nom 
			$client_prenom 
			$client_adresse
			$client_ville 
			$client_cp
			$client_pays 
			$client_nikhandle
*/

	
if ( $erreur != 0 )
{
echo "Il y a <strong>".$erreur."</strong> erreur detecté ! ";
echo "<br>";
echo $error_msg;
echo "<br>";
echo "Merci de contactez notre support.";
exit;
}

?>





<center>
<table border="1">
<tr>
<td WIDTH=400><strong>
<?=strtoupper($client_nom); ?> <?=$client_prenom;?><br />
<?=$client_adresse;?><br />
<?=$client_cp;?> - <?=$client_ville;?> <br />
<?=strtoupper($client_pays);?><br />
<center><strong><a href="index.php?page=admin/detail_client&client=<?=$client_id;?>">Fiche client</a></center></strong>
</strong></td>

<td WIDTH=415>
Heberge-hd.fr<br />
Jean-Baptiste PETRE
14 rue Oscar Roty<br />
75015 - PARIS 15eme<br />
SIREN : : 518 975 750<br />
</td>
</tr>

</table>
<table border="0">
<tr>
<td WIDTH=400>Description</td>
<td WIDTH=150>Etat</td>
<td WIDTH=100>Service</td>
<td WIDTH=100>Jour</td>
<td WIDTH=100>Action</td>
<td WIDTH=100>Prix unitair</td>
<td WIDTH=100>Prix Total</td>
<td WIDTH=100>Valider</td>
</tr>

<?=$ligne_service;?>

</table>

<table border="1">
<tr><td  WIDTH=700>Montant Total</td><td  WIDTH=100><?=$prix_tt;?>€</td></tr>
<tr><td  WIDTH=700>Montant Payer</td><td  WIDTH=100> <?=$payement_payer_ok;?>€</td></tr>
<tr><td  WIDTH=700>Reste a payer</td><td  WIDTH=100><?=$payement_payer_reste;?>€</td></tr>
<tr><td  WIDTH=700>Payer en plus</td><td  WIDTH=100> <?=$suplemet_payer;?>€</td></tr>

</table><? if ( $payement_payer_reste != 0 )
{
echo '<br><strong>Payement :</strong><br />
<br>';



echo $bouton_allopass;

echo '<br /><i>Le moyen de payement paypal a etait suspendu temporairement, pour payer via paypal merci de faire une demande par ticket.</i><br />';
}

echo '<br /><br /><strong><center>Payement envoyer : </center></strong><br />';

echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Numéro de transaction</td>
								<td>Date</td>
								<td>Type</td>
								<td>Ip</td>
								<td>Etat</td>
								<td>Montant</td>
								
								
								</tr>';
			$i=0;
			$p=0;
	$reponse_payement = mysql_query("SELECT * FROM payement WHERE id_facture='$facture_id_id' "); // Requête SQL
	while ($sql_payement = mysql_fetch_array($reponse_payement) )
						{
						$p+=1;
						
									if ($i%2==0)
									{
									echo '
									<tr class="tableimpair">';
									}else{
									echo '
								<tr class="tablepair">';
									}
									echo '<td><center>';
							
							echo ''.$sql_payement['id_transaction'].'</center></td>';
							
								echo '<td><center>'.date('d/m/y - H:i:s', $sql_payement['date']).'</center></td>
								<td><center>'.$sql_payement['id_type_payement'].'</center></td>
								<td><center>'.$sql_payement['ip_client'].'</center></td>';
								if ( $sql_payement['etat'] == 1 )
								$sql_payement['etat'] = "Payement valider";
								echo '<td><center>'.$sql_payement['etat'].'</center></td>
								<td><center>'.$sql_payement['montant'].'€</center></td>
								</tr>';
								
									
						}
						if ( $p == "0" )
						{
						echo '<tr><td><strong><center>Aucun payement n\'a etait envoyer.</strong></center></td></tr>';
						}
						echo '</table>';
}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////DEBUT NOTES ADMIN///////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
	echo '<style>
h1 {
    font-size: 13px;
    color: #567eb9;
    border-bottom: 1px solid #567eb9;
}
</style><h1 qtlid="58734">Notes de la facture</h1>
	



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
mysql_query("	INSERT INTO `panel`.`notes_facture` 
(`id`, `id_facture`, `time`, `ip_crea`, `id_admin`, `texte`, `etat`) VALUES
(NULL,
 '".$invoice."',
 '".$time."',
 '".$ip."',
 '".$nom." ".$prenom."',
 '".$texte."',
 '1');
			");	
			echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=admin/invoice&id='.$invoice.'">';
	}
	$i=0;
echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Crée le </td>
								<td>Crée par</td>
								<td>Texte</td>
								
											
								</tr>';
						$req_notes = mysql_query("SELECT * FROM  notes_facture WHERE id_facture='$invoice'");
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
<form action="index.php?page=admin/invoice&id='.$invoice.'&add_notes=1" method="POST">
<td><center><input type="submit"></center></td>
								<td></td>
								<td><center><textarea name="texte" rows="1" cols="45"></textarea></center></form></td>';

echo '</table>';		
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////FIN NOTES ADMIN////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

?>
