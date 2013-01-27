<?

$id_vps = $_GET['id'];

if ( isset (  $_GET['id'] ) )
{
$id_vps = $_GET['id'];

	if ( isset ( $_GET['action'] )  )
	{
	
		if ($_GET['action'] == "addday"  )
		{
		$type_add = $_POST['type_ajout'];
		$nbr_jour = $_POST['nbr_day_add'];
		$envoi_mail = $_POST['mail'];
			
	$sql_vps = DB:: SQLToArray("SELECT * FROM vps WHERE id='$id_vps' limit 1 ");
			
			$date_expiration = $sql_vps[0]['expiration'];
			$date_creation =  $sql_vps[0]['creation'];
			$id_plann = $sql_vps[0]['id_plan'];
			$id_client =  $sql_vps[0]['id_client'];
			$note_admis = $sql_vps[0]['commentaire'];

					
			
	$expp_day = date('d', $date_expiration);			
	$exp_d = $nbr_jour + $expp_day ;
	$exp_m = date('m', $date_expiration);
	$exp_y = date('y', $date_expiration);
	$exp_h = date('h', $date_expiration);
	$exp_i = date('i', $date_expiration);
	$exp_s = date('s', $date_expiration);
	
			$timestamp_expir = mktime($exp_h, $exp_i, $exp_s, $exp_m, $exp_d, $exp_y);
			$timestamp_expir_avant = mktime($exp_h, $exp_i, $exp_s, $exp_m, $expp_day, $exp_y);

			if ( $type_add == "1" AND $envoi_mail == "1" )
			{
			
$sujet = '[VPS N°'.$id_vps.']Geste commerciale [Heberge-HD]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Suite a votre demande, un geste commercial vient d\'etre effectué.

La date d\'expiration a changée :

Ancienne date : '.$timestamp_expir_avant.'

Nouvelle date : '.$timestamp_expir.'

ATTENTION : Si votre VPS est actuellement suspendu, merci de patienter 1H avant sa réactivation.


Merci de votre fidélité.
';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());
			}
			
			if ( $type_add == "2" AND $envoi_mail == "1" )
			{
			$sujet = '[VPS N°'.$id_vps.']Prolongation [Heberge-HD]';
			$message = '

<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Un de nos conseiller vient de prolonger votre VPS.

La date d\'expiration a changé :

Ancienne date : '.$timestamp_expir_avant.'

Nouvelle date : '.$timestamp_expir.'

ATTENTION : Si votre VPS est actuellement suspendu, merci de patienter 1H avant sa réactivation.


Merci de votre fidélité.';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());
			}
			
	
	
		
		}
		if ($_GET['action'] == "edit"  )
		{
		
	$ginvoice = $_POST['ginvoice'];
	$plan = $_POST['plan'];
	$facture_prolongation = $_POST['facture_prolongation'];
	$client = $_POST['client'];
	$commetair_admin = $_POST['commentair_admin'];
	
	
	$exp_d = $_POST['exp_d'];
	$exp_m = $_POST['exp_m'];
	$exp_y = $_POST['exp_y'];
	$exp_h = $_POST['exp_h'];
	$exp_i = $_POST['exp_i'];
	$exp_s = "00";
	
	$crea_d = $_POST['crea_d'];
	$crea_m = $_POST['crea_m'];
	$crea_y = $_POST['crea_y'];
	$crea_h = $_POST['crea_h'];
	$crea_i = $_POST['crea_i'];
	$crea_s = "00";
	

	$timestamp_crea = mktime($crea_h, $crea_i, $crea_s, $crea_m, $crea_d, $crea_y);
	$timestamp_expir = mktime($exp_h, $exp_i, $exp_s, $exp_m, $exp_d, $exp_y);
	
	
	
	
mysql_query("UPDATE vps SET facture_prolongation='$facture_prolongation', generate_invoice='".$ginvoice."', id_client='".$client."', id_plan='".$plan."', expiration='".$timestamp_expir."', creation='".$timestamp_crea."',  commentaire='".$commetair_admin."' WHERE id='". $id_vps ."'");
	echo '<center><strong>Modifications enregistrées !</strong></center>';

echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=admin/edit_vps&id='.$id_vps.'">';
	}
	}
	
	
	echo '
			<br/><br/>';
		echo "
			<fieldset><legend><strong>Informations VPS</strong></legend>";
			
			$vpsinfo=VPS::GetVPS($_GET["id"]);
			ShowLightDetailVPS($_GET["id"]);

			if ($vpsinfo["id_client"]==0)
			{
				echo "<center>Serveur libre</center>";
				echo "<center><a href=\"javascript:DeleteVPS();\">Supprimer le serveur. ATTENTION ! Aucune récupération possible.</a></center>";
				echo "
				<script language=\"JavaScript\" type=\"text/javascript\">
					function DeleteVPS(){
            if (confirm(\"Voulez vous vraiment supprimer ce VPS ?\")){
              window.location.replace(\"index.php?page=action&action=delete_vps&vps=".$vpsinfo["id"]."\");
            }
          }
				</script>";

			}else{
				$clientinfo=Client::GetClient($vpsinfo["id_client"]);
				$clientid=$clientinfo["id"];
				$clientnom=$clientinfo["nom"];
				$clientprenom=$clientinfo["prenom"];
				$vpsid=$_GET["id"];
				$etat=$vpsinfo["etat"];
				echo "<br /><center><table><tr><td><u>Propriétaire</u> : </td><td><a href=\"index.php?page=admin/detail_client&amp;client=$clientid\">".ucfirst(strtolower($clientprenom))." ".strtoupper($clientnom)." </a></td><td style=\"padding-left:5px;\"><a href=\"javascript:UnlinkVPS($vpsid);\"><img src=\"images/bad.png\" alt=\"Retirer le VPS au client\" title=\"Retirer le VPS au client\" border=\"0\" width=\"15\" height=\"15\" /></a></td></tr></table></center>";
				
				if($etat==1){
          echo "<center><b>Serveur Actif</b> - <a href=\"javascript:BlockVPS($vpsid);\">Bloquer le serveur</a></center>";
				}else{
          echo "<center><b>Serveur Bloqué</b> - <a href=\"javascript:DeblockVPS($vpsid);\">Réativer le serveur</a></center>";
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
			
	$sql_vps = DB:: SQLToArray("SELECT * FROM vps WHERE id='$id_vps' limit 1 ");
			$id_vps = $sql_vps[0]['id'];
			$date_expiration = $sql_vps[0]['expiration'];
			$date_creation =  $sql_vps[0]['creation'];
			$id_plann = $sql_vps[0]['id_plan'];
			$id_client =  $sql_vps[0]['id_client'];
			$note_admis = $sql_vps[0]['commentaire'];

	echo '<fieldset><legend><strong>Modification d\'un VPS</strong></legend>';
	echo '<table border="0"><form action="index.php?page=admin/edit_vps&id='.$id_vps.'&action=edit" method="POST">
	<tr>
	<td><b>Plan : </b></td>
	<td><select name="plan"> ';
		$reponse_ticket = mysql_query("SELECT * FROM plan   "); // Requête SQL
			while ($sql_ticket = mysql_fetch_array($reponse_ticket) )
								{
			echo '<option value="'.$sql_ticket['id'].'" ';
			if ( $sql_ticket['id'] == $id_plann )
			{
			echo 'selected="selected"';
			}
			echo '>'.$sql_ticket['nom'].'</option>'; 
								}
			

	echo '</select></td>
	</tr>
  <tr>
	<td><b>Date de Création : </b></td>
	<td>

	<input type="text" name="crea_d" maxlength="2" value="'.date('d', $date_creation).'" size="2"> -
	<input type="text" name="crea_m" maxlength="2" value="'.date('m', $date_creation).'" size="2"> -
	<input type="text" name="crea_y" maxlength="4" value="'.date('Y', $date_creation).'" size="4"> à 
	<input type="text" name="crea_h" maxlength="2" value="'.date('H', $date_creation).'" size="2"> :
	<input type="text" name="crea_i" maxlength="2" value="'.date('i', $date_creation).'" size="2">
</td>
	</tr>
	<tr>
	<td><b>Date d\'expiration : </b></td>
	<td>
	<input type="text" name="exp_d" maxlength="2" value="'.date('d', $date_expiration).'" size="2"> - 
	<input type="text" name="exp_m" maxlength="2" value="'.date('m', $date_expiration).'" size="2"> - 
	<input type="text" name="exp_y" maxlength="4" value="'.date('Y', $date_expiration).'" size="4"> à 
	<input type="text" name="exp_h" maxlength="2" value="'.date('H', $date_expiration).'" size="2"> : 
	<input type="text" name="exp_i" maxlength="2" value="'.date('i', $date_expiration).'" size="2">
	
	</td>
	</tr>
	<tr>
	<td>Propriétaire : </td>
	<td><select name="client">';
			
			
			
	$reponse_client = mysql_query("SELECT * FROM client ORDER BY nom"); // Requête SQL
			while ($sql_client = mysql_fetch_array($reponse_client) )
								{
			echo '<option value="'.$sql_client['id'].'" ';
			if ( $sql_client['id'] == $id_client )
			{
			echo 'selected="selected"';
			}
			echo '>#'.$sql_client['id'].' - '.strtoupper($sql_client['nom']).' '.ucfirst(strtolower($sql_client['prenom'])).'</option>'; 
								}
								$genere = "0";
echo '</select>	</td>
	</tr>
		<tr>
	<td>Commentaire (Visible par le client) : </td>
	<td><textarea name="commentair_admin" cols="50">'.$note_admis.'</textarea></td>
	</tr>
	<tr>
	<td>Facture en cours : </td>
	<td><input type="text" name="facture_prolongation" value="'.$sql_vps[0]['facture_prolongation'].'"></td>
	</tr>
	<tr>
	<td>Génération automatique des factures :</td>
	<td><input type="radio" name="ginvoice" value="1"';
	if ( $sql_vps[0]['generate_invoice'] == 1 )
	{
	echo 'checked="checked" ';
	}
	
	echo '/> Oui
<input type="radio" name="ginvoice" value="0" ';

	if ( $sql_vps[0]['generate_invoice'] == 0 OR $sql_vps[0]['generate_invoice'] == NULL )
	{
	echo 'checked="checked" ';
	}


echo '/> Non</td>
	</tr>
	</table><br />
	<center><input type="submit" value="Valider les changements"></center>

<style>
h1 {
    font-size: 13px;
    color: #567eb9;
    border-bottom: 1px solid #567eb9;
}
</style>	
	</form>';
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////DEBUT NOTES ADMIN///////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
	echo '<h1 qtlid="58734">Notes sur le VPS</h1>
	



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
mysql_query("	INSERT INTO `panel`.`notes_vps` 
(`id`, `id_vps`, `time`, `ip_crea`, `id_admin`, `texte`, `etat`) VALUES
(NULL,
 '".$id_vps."',
 '".$time."',
 '".$ip."',
 '".$nom." ".$prenom."',
 '".$texte."',
 '1');
			");	
			echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=admin/edit_vps&id='.$id_vps.'">';
	}
	$i=0;
echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Crée le </td>
								<td>Crée par</td>
								<td>Texte</td>
								
											
								</tr>';
						$req_notes = mysql_query("SELECT * FROM  notes_vps WHERE id_vps='$id_vps'");
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
<form action="index.php?page=admin/edit_vps&id='.$id_vps.'&add_notes=1" method="POST">
<td><center><input type="submit"></center></td>
								<td></td>
								<td><center><textarea name="texte" rows="1" cols="45"></textarea></center></form></td>';

echo '</table>';		
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////FIN NOTES ADMIN////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

						
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////Debut des ticket///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

echo '<h1 qtlid="58734">Ticket en rapport avec le VPS </h1>	<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Numéro du ticket</td>
								<td>Date de création</td>
								<td>Objet</td>
								
								<td>Importance</td>
								<td>Etat</td>
								<td>Dernier reponsse</td>
								
								</tr>';
								
$reponse_ticket = mysql_query("SELECT * FROM ticket WHERE cat_service='VPS' AND service='$id_vps'  "); // Requête SQL
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
////////////////////////////////////////////////////////////////////////////////////////
///////////////////////Fin des ticket///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
echo'
	
<h1 qtlid="58734">Facture du VPS </h1>
	<br><center>
	<table border="0">
	<tr class="tabletitle">
	<td>#</td>
	<td>Date</td>
	<td>Date payement</td>
	<td>Montant</td>
	</tr>	
	';
	$i=0;
$req_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_service='$id_vps' AND cat_service='VPS' ");
while ( $sql_corp = mysql_fetch_array($req_corp))
{
	$id_corp = $sql_corp['id_facture'];
	$req_facture = mysql_query("SELECT * FROM invoice WHERE id='$id_corp ' ");

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
	<td>'.date('d/m/Y', $sql_invoice['date_creat']).'</td>
	<td>Date payement</td>
		<td><center>'.$price.'&euro;</center></td>
	</tr>';
			}
			}
	echo '</table></center>'; 
	
	echo '</fieldset>';
	echo '<fieldset><legend><strong>Ajout de X jour</strong></legend>';
	echo '<table border="0"><form action="index.php?page=admin/edit_vps&id='.$id_vps.'&action=addday" method="POST">
	<tr>
	<td>Nombre de jour a ajouter : </td>
	<td><input type="text" size="2" name="nbr_day_add"></td>
	</tr>
	
	<tr>
	<td>Type d\'ajout: </td>
	<td><select name="type_ajout">
	<option value="1">Gestion Commercial</option>
	<option value="2">Prolongation aide paiement</option>
	<option value="3">Autre</option>
	</select>
	
	</td>
	</tr>
	
	<tr>
	<td>Envoyer une notification par mail ? </td>
	<td><input type="radio" name="mail" value="1"/> Oui
<input type="radio" name="mail" value="0" > Non</td>
	</tr>
	
	
	';
		echo '</table></fieldset>';
	
	
		
		
	
}

?>

