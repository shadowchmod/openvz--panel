<?
	
	$erreur = "";
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';

 $invoice = $_GET['id'];
$reponse = mysql_query("SELECT * FROM invoice WHERE facture='$invoice'"); // Requ�te SQL
// on initisalise quelques variable 
$suplemet_payer = "0,00";
 $prix_tt = "00,00";
 $ligne_service ="";
while ($sql = mysql_fetch_array($reponse) )
{
$id_client_facture = $sql['id_client'];
$facture_id_id =  $sql['id'];
//On recupere les info client
			$reponse = mysql_query("SELECT * FROM client WHERE id='$id_client_facture'"); // Requ�te SQL
			while ($sql_client = mysql_fetch_array($reponse) )
			{
			$client_nom = $sql_client['nom'];
			$client_prenom = $sql_client['prenom'];
			$client_adresse = $sql_client['adresse'];
			$client_ville = $sql_client['ville'];
			$client_cp = $sql_client['cp'];
			$client_pays = $sql_client['pays'];
			$client_nikhandle = $sql_client['nikhandle'];
			$client_email = $sql_client['email'];
			$client_tel_fixe = $sql_client['tel_fixe'];
			
			}
//On recupere les ellement de la facture
			
			
		
		
		
			$facture_etat = $sql['etat'];
		
		
			$facture_date_crea = $sql['date_creat'];
		
			$facture_commentair = $sql['commentair_facture'];
			
			$facture_id_number = $sql['facture'];
			

			//On v�rifie l'etat de la facture
			
				/* Liste des etats possible !
				1 --> Facture non payer
				2 --> Facture payer et trait�
				3 --> Facture payer et non-trait�
				4 --> Facture erron� 
				5 --> Facture payer partielement
				6 --> Facture annul� par le Client
				7 --> Facture annul� par un admin
				8 --> Facture froduleuse
				9 --> Payement douteux/Attente de v�rifcation de payement
				*/
			
				if ( $facture_etat == 4 )
				{
				$error_msg .= "<strong>Erreur : </strong>Une erreur a etait d�tect� dans cette facture, merci de contacter le support";
				$erreur += 1;
				}
				elseif ( $facture_etat == 6 )
				{
				$error_msg .= "<strong>Erreur : </strong> Vous avez annul� cette facture, pour la r�activer merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 7 )
				{
				$error_msg .= "<strong>Erreur : </strong>Cette facture etait annul� par un Administrateur, pour la r�activer merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 8 )
				{
				$error_msg .= "<strong>Erreur : </strong>Cette facture a etait classer comme froduleuse, pour la r�activer merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 9 )
				{
				$error_msg .= "<strong>Erreur : </strong>Cette facture a etait payer mais le payement est toujour en attente de v�irification<br />";
				//$erreur += 1;
				}
				
				
		$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$facture_id_id' "); // Requ�te SQL
		while ($sql_corp = mysql_fetch_array($reponse_corp) )
		{
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
					
				//On r�cupere le domaine && date d'expiration && prix
					if ( $facture_cat_service == "vps" )
					{
							//connexion a la table VPS pour recupere la fiche VPS
							$reponse_domaine = mysql_query("SELECT * FROM vps WHERE id='$id_service' "); // Requ�te SQL
							while ($sql_domaine = mysql_fetch_array($reponse_domaine) )
							{
							// On recupere l'id de l'ip
							$id_domaine_ip_vps = $sql_domaine['id_ip'];
							
							//on recupere la date d'expiration
							$expiration_avant_payement = $sql_domaine['expiration'];
							
							//on recupere l'id du plan 
							$id_plan_prix = $sql_domaine['id_plan'];
							
								//On se connecte a la BDD des Ip pour recup�r� le ndd 
									$reponse_domaine_ip = mysql_query("SELECT * FROM ip WHERE id='$id_domaine_ip_vps'"); // Requ�te SQL
									while ($sql_domaine_ip = mysql_fetch_array($reponse_domaine_ip) )
									{
									$domaine_finale_vps = $sql_domaine_ip['reverse_original'];
									}
							}
					//On calcul la date apr�s renouvellement
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
			$message_etat2 ="Annul&eacute;";
			break;
			case "6":
			$message_etat2 ="Payement en cour de v&eacute;irifcation";
			break;
			}

		$ligne_service .= '
				<tr>
<td>'.$texte_facture.'</td>
<td>'.$message_etat2.'</td>
<td><center>1</td>
<td><center>'.$facture_prix.'&euro;</center></td>
<td><center>'.$facture_prix.'&euro;</center></td>
</tr>'; 
		}
	
				
//On recupere les payement
			
			/*
			1 = Payement axcepter
			2 = Payement en attente de v�rification
			3 = Payement froduleux
			4 = Payement annul�
			5 = Payement �chou�
			6 = Payement renbours�
			*/
			// on initialise la varble du montant pay�
			$payement_payer_refund = "0,00";
			$payement_payer_ok = "0,00";
			$reponse_payement = mysql_query("SELECT * FROM payement WHERE id_facture='$facture_id_id' "); // Requ�te SQL
			
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
			
		
		
			
			//On r�cupere l'etat 2 --> $facture_etat2
			/* Etat possible 
			1 -> En attente de payement
			2 -> Payer en attente d'execution
			3 -> Facture trait�
			4 -> Erreur l'ors du traitement
			5 -> Annul�
			*/
			
			//On g�n�re le titre de la facture 
			
			// on propose les payement disponible
				// si la facture a deja etait payer en totalit� on ne propose pas les moyen de payement			
				 if ( $facture_payer != 1 )
				 {
				$bouton_allopass = '
				<a  border="0" href="index.php?page=payement&type=allopass&id='.$invoice.'" ><img src="images/allopass.gif" border="0"></a>
				
				';
				
		$bouton_2co = '<form action="https://www.2checkout.com/checkout/purchase" method="post">
	<p>
		<input type="hidden" name="sid" value="1403583"/>
		<input type="hidden" name="cart_order_id" value="Facture #'.$facture_id_number.'"/>
		<input type="hidden" name="total" value="'.$payement_payer_reste.'"/>
		<input type="hidden" name="c_name_1" value="Facture #'.$facture_id_number.'"/>
		<input type="hidden" name="c_description_1" value="Payement de la facture #'.$facture_id_number.'/>
		<input type="hidden" name="c_price_1" value="'.$payement_payer_reste.'"/>
		<input type="hidden" name="fixed" value="Y"/>
				<input type="hidden" name="TEST_ID" value="'.$facture_id_number.'"/>
				

	<input type="hidden" name="card_holder_name" value="'.strtoupper($client_nom).''.$client_prenom.'"/>
			<input type="hidden" name="ship_name" value="'.strtoupper($client_nom).''.$client_prenom.'"/>

		<input type="hidden" name="street_address" value="'.$client_adresse.'"/>
		<input type="hidden" name="city" value="'.$client_ville.'"/>
		<input type="hidden" name="state" value="None"/>
		<input type="hidden" name="zip" value="'.$client_cp.'"/>
		<input type="hidden" name="country" value="FR"/>
		<input type="hidden" name="email" value="'.$client_email.'"/>
		<input type="hidden" name="phone" value="'.$client_tel_fixe.'"/>
		<input type="hidden" name="ship_steet_address" value="'.$client_adresse.'"/>
		<input type="hidden" name="ship_city" value="'.$client_ville.'"/>
		<input type="hidden" name="ship_state" value="None"/>
		<input type="hidden" name="ship_zip" value="'.$client_cp.'"/>
		<input type="hidden" name="ship_country" value="FR"/>
		<input type="hidden" name="id_type" value="1"/>
		<input type="hidden" name="c_tangible_1" value="N"/>
		<input type="hidden" name="lang" value="fr"/>
		<input type="hidden" name="return_url" value="http://panel.cmd-web.info/2co.php"/>
		<input type="hidden" name="skip_landing" value="1"/>
		<input type="hidden" name="x_receipt_link_url" value="http://panel.cmd-web.info/2co.php"/>
		<i
		<input type="image" src="https://www.2checkout.com/images/2cocc05.gif" value="Purchase"/>
	</p>
</form>';
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
<input type=\"image\" src=\"https://www.paypal.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - la solution de paiement en ligne la plus simple et la plus s�curis�e !\">
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
echo "Il y a <strong>".$erreur."</strong> erreur detect� ! ";
echo "<br>";
echo $error_msg;
echo "<br>";
echo "Merci de contactez notre support.";
exit;
}

?>





<center>
<table style="border-color:#1E9DFF;border-width:1;border-style:solid">
<tr>
<td WIDTH=450><strong>
<?=strtoupper($client_nom); ?> <?=$client_prenom;?><br />
<?=$client_adresse;?><br />
<?=$client_cp;?> - <?=$client_ville;?> <br />
<?=strtoupper($client_pays);?>
</strong></td>

<td WIDTH=350>
Association Entreprise<br />
0 rue de votre entreprise<br />
CODE POSTAL - VILLE 
</td>
</tr>

</table>
<table style="border-color:#1E9DFF;border-width:1;border-style:solid">
<tr>
<td WIDTH=400><strong>Description</strong></td>
<td WIDTH=150><strong>Etat</strong></td>
<td WIDTH=50><strong>Quantit&eacute;</strong></td>
<td WIDTH=100><strong>Prix unitair</strong></td>
<td WIDTH=100><strong>Prix Total</strong></td>
</tr>

<?=$ligne_service;?>

</table>

<table style="border-color:#1E9DFF;border-width:1;border-style:solid">
<tr><td  WIDTH=700>Montant Total</td><td  WIDTH=100><?=$prix_tt;?>&euro;</td></tr>
<tr><td  WIDTH=700>Montant Payer</td><td  WIDTH=100> <?=$payement_payer_ok;?>&euro;</td></tr>
<tr><td  WIDTH=700>Reste a payer</td><td  WIDTH=100><?=$payement_payer_reste;?>&euro;</td></tr>
<tr><td  WIDTH=700>Payer en plus</td><td  WIDTH=100> <?=$suplemet_payer;?>&euro;</td></tr>

</table><? if ( $payement_payer_reste != 0 )
{
echo '<br><strong>Payement :</strong><br />
<br>';


echo '<table border="0">

<tr>
<td width="200" ><center>'.$bouton_allopass.'</center></td>
<td width="250" ><center>'.$bouton_2co.'</center></td>

</tr>

<tr>
<td width="200" ><strong><center>Payez par allopass</strong></center></td>
<td width="200" ><strong><center>Payer par CB</strong></center></td>

</tr>

</table>';

echo '<br /><br /><br /><i>Le moyen de payement paypal a etait suspendu temporairement, pour payer via paypal merci de faire une demande par ticket.</i><br />';
}

echo '<br /><br /><strong><center>Payement envoyer : </center></strong><br />';

echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Num&eacute;ro de transaction</td>
								<td>Date</td>
								<td>Type</td>
								<td>Ip</td>
								<td>Etat</td>
								<td>Montant</td>
								
								
								</tr>';
			$i=0;
			$p=0;
	$reponse_payement = mysql_query("SELECT * FROM payement WHERE id_facture='$facture_id_id' "); // Requ�te SQL
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
							if ( $sql_payement['id_type_payement'] == "Allopass")
							echo ''.md5($sql_payement['id_transaction']).'</center></td>';
							else
							echo ''.$sql_payement['id_transaction'].'</center></td>';
							
								echo '<td><center>'.date('d/m/y - H:i:s', $sql_payement['date']).'</center></td>
								<td><center>'.$sql_payement['id_type_payement'].'</center></td>
								<td><center>'.$sql_payement['ip_client'].'</center></td>';
								if ( $sql_payement['etat'] == 1 )
								$sql_payement['etat'] = "Payement valider";
								echo '<td><center>'.$sql_payement['etat'].'</center></td>
								<td><center>'.$sql_payement['montant'].'&euro;</center></td>
								</tr>';
								
									
						}
						if ( $p == "0" )
						{
						echo '<tr><td><strong><center>Aucun payement n\'a etait envoyer.</strong></center></td></tr>';
						}
						echo '</table>';
}


?>
