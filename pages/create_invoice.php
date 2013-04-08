<?
	defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$id_client=@Session::$Client->Id;
/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Page develloppez par 

http://attard-sebastien.fr

Contac Mail : sebjsp@gmail.com
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Chois du service  - Renouvellement VPS - Etape 2///////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Choix Du temps - Facture VPS - Etape 3/////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if( isset ( $_POST['serice'] ) )
	{
	$id_service = $_POST['serice'];
	$id_client = $_GET['id'];
	
		$reponse = mysql_query("SELECT * FROM vps WHERE id='$id_service' LIMIT 1 ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$id_plan = $sql['id_plan'];
								}
												
	
												
												
												
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 3</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=create_invoice&id='.$id_client.'&id_service='.$id_service.'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Choix de la Durée : </strong></td>
							<td> <table width="100%" border="0">
	<tr class="tabletitle">
	  <td></td>
	  <td>Durée</td>
	  <td>Prix</td>
	
	  </tr>';
							
						$reponse = mysql_query("SELECT * FROM prix_service WHERE service_type='VPS' AND service_id='$id_plan' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
															
					
					echo '	<tr>
				
					<td><input type="radio" name="prix" value="'.$sql['id'].'"  /></td>
				<td><center>'.$sql['jour_texte'].'</center></td>
				<td><center>'.$sql['prix'].'</center></td>
							</tr>';
								}
						echo '</table></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br/></table></form></fieldset>';
	
	
	}
	
	
	
	
	

	
	
	
	
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Création de la facture - Renouvellement VPS - Etape finale/////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ( isset ( $_GET['id_service'] )  )
	{
	$id_service = $_GET['id_service'];
	$id_client = $_GET['id'];
	$id_prix = $_POST['prix'];
	
				$sql_ip = DB:: SQLToArray("SELECT * FROM vps WHERE id='$id_service' LIMIT 1");
												$ip_ip = $sql_ip[0]['id_plan'];
												
												
								
									$sql_plan = DB:: SQLToArray("SELECT * FROM plan WHERE id='$ip_ip' LIMIT 1");
												$nom_plan = $sql_plan[0]['nom'];
							
		$reponse = mysql_query("SELECT * FROM prix_service WHERE id='$id_prix' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$nbr_jour = $sql['jour_time'];
								$jour_tecte = $sql['jour_texte'];
								}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//On recupere le nuémro de la denrier facture pour en crée un superieur
		$reponsee = mysql_query("SELECT * FROM invoice ORDER BY facture ASC "); // Requête SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
		$lol = "ok";
		$facture_denriere = $sqll['facture'];
		}
	$facture_denriere = $facture_denriere+1;

	$timestampp = time();
mysql_query("INSERT INTO `invoice` ( `id` , `id_client` , `etat` , `date_creat` , `ip_crea` , `commentaire_admin` , `commentair_facture` , `texte` , `facture` ) 
VALUES (
NULL , '" . $id_client . "', '1', '". $timestampp ."', 'local', '', '', '', '". $facture_denriere ."'
)");
	$reponse_coco	= mysql_query("SELECT * FROM invoice WHERE facture='$facture_denriere' "); // Requête SQL
		 while ($sql_coco = mysql_fetch_array($reponse_coco) )
		{
		$id_factre_id_id = $sql_coco['id'];
		}
		
		$sql_prix = DB:: SQLToArray("SELECT * FROM prix_service WHERE id='$id_prix' LIMIT 1");
		$prix = $sql_prix[0]['prix'];
												
												
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text`, `prix` ) 
VALUES (
NULL , '" . $id_service . "', 'VPS', '".$id_prix."', '".$nbr_jour."', '1', '', '', '". $id_factre_id_id ."', 'RRENEW' , 'Renouvellement ".$nom_plan." -  ".$jour_tecte."', '".$prix."'
)");
 



 
mysql_query("UPDATE vps SET facture_prolongation='". $facture_denriere ."' WHERE id='". $id_service ."'");

$sujet = 'Facture #'.$facture_denriere.'[ENTREPRISE]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' à Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Une facture de renouvellement vient d\'être créée.<br />

Vous devez regler cette facture dans un délai d\'une semaine, sans quoi elle sera annulée<br />

Merci de vous rendre sur cette page afin de regler la facture :<br />

https://nom-de-domaine.info/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());

echo '<center><strong>La facture <a href="index.php?page=invoice&id='.$facture_denriere.'">#'.$facture_denriere.'</a> vient detre créée !</strong></center>';



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






	
	
	
	}
	else
	{

	$id_client = $id_client;
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 2 (Renouvellement VPS)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=create_invoice&id='.$id_client.'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Pour quel service ? : </strong></td>
							<td> <table width="100%" border="0">
      <tr class="tabletitle">
	  <td></td>
	  <td>Nom du service</td>
	  <td>Type de Service</td>
	  <td>Date d\'expiration</td>
	  
	  </tr>';
							
						$reponse = mysql_query("SELECT * FROM vps WHERE id_client='$id_client' ");
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
								
					echo ' <tr>
					
					  <td><input type="radio" name="serice" value="'.$sql['id'].'"  /></td>
	  <td><center>'.$ip_reverse.'</center></td>
	  <td><center>'.$nom_plan.'</center></td>
	  <td><center>'.date('d/m/y', $sql['expiration']).'</center></td>
					</tr>';
								}
						echo '</table></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br/></table></form></fieldset>';
	
}

?>

