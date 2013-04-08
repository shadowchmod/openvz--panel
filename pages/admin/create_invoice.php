<?
//    defined("INC") or die("403 restricted access");
  echo '<a href="index.php"> Retour aux panneaux</a><br/><br/>';
 /*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Page develloppez par Sébastien ATTARD

http://attard-sebastien.fr

Contac Mail : sebjsp@gmail.com
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Chois du service  - Renouvellement VPS - Etape 2///////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ( isset ( $_POST['client'] ) AND $_POST['type'] == "1")
	{
	$id_client = $_POST['client'];
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 2 (Renouvellement VPS)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice&id='.$id_client.'&type='.$_POST['type'].'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Pour quelle service ? : </td>
							<td><select name="serice">';
							
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
								
					echo '<option value="'.$id_vps.'">'.$ip_reverse.' '.$nom_plan.'</option>';
								}
						echo '</select></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br></form></table></fieldset>';
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Choix plan - Commande dedier - Etape 2/////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ( isset ( $_POST['client'] ) AND $_POST['type'] == "2")
	{
	
	$id_client = $_POST['client'];
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 2 (Commande de dedier)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice&id='.$id_client.'&type='.$_POST['type'].'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Quelle type de serveur ? </td>
							<td><select name="serice">';
							$reponse = mysql_query("SELECT * FROM plan_dedicated  ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								
												
					echo '<option value="'.$sql['id'].'">'.$sql['nom_plan'].' REF#'.$sql['ref'] .'</option>';
								}
						echo '</select></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br></form></table></fieldset>';
	
	}
	
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Choix plan - Commande VPS - Etape 2/////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ( isset ( $_POST['client'] ) AND $_POST['type'] == "3")
	{
	
	$id_client = $_POST['client'];
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 2 (Commande de VPS)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice&id='.$id_client.'&type='.$_POST['type'].'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Quelle type de serveur ? </td>
							<td><select name="serice">';
							$reponse = mysql_query("SELECT * FROM plan  ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								
												
					echo '<option value="'.$sql['id'].'">'.$sql['nom'].'</option>';
								}
						echo '</select></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br></form></table></fieldset>';
	
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Choix Du temps - Commande VPS - Etape 3//////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		elseif( isset ( $_POST['serice'] ) AND $_GET['type'] == "3")
	{
	$id_service = $_POST['serice'];
	$id_client = $_GET['id'];
	
								
												
	
												
												
												
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 3 (Commande de VPS)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice&id='.$id_client.'&id_service='.$id_service.'&type='.$_GET['type'].'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Pour combien de temps ? : </td>
							<td><select name="prix">';
							
						$reponse = mysql_query("SELECT * FROM prix_service WHERE service_type='VPS' AND service_id='$id_service' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
															
					echo '<option value="'.$sql['id'].'">'.$sql['jour_nbr'].' Jour</option>';
								}
						echo '</select></td>
						</tr>
						
						<tr>
						<td><span style="margin-left:100px;"><strong>Ajouteer des frais ?</td>
						<td><select name="frais">
						<option value="1">Oui</option>
						<option value="0">Non</option>
						</select>
						</td>
						</tr>
						<tr>
						<td><span style="margin-left:100px;"><strong>Montant des frais : </td>
						<td><input type="text" name="montant_frai"></td>
						</tr>
						<tr>
						<td><span style="margin-left:100px;"><strong>Texte facture frai : </td>
						<td><input type="text" name="texte_frai"></td>
						</tr>
						<tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br></form></table></fieldset>';
	
	
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Choix Du temps - Commande dédié - Etape 3//////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		elseif( isset ( $_POST['serice'] ) AND $_GET['type'] == "2")
	{
	$id_service = $_POST['serice'];
	$id_client = $_GET['id'];
	
								
												
	
												
												
												
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 3 (Commande de dedier)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice&id='.$id_client.'&id_service='.$id_service.'&type='.$_GET['type'].'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Pour combien de temps ? : </td>
							<td><select name="prix">';
							
						$reponse = mysql_query("SELECT * FROM prix_service WHERE service_type='DEDICATED' AND service_id='$id_service' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
															
					echo '<option value="'.$sql['id'].'">'.$sql['jour_nbr'].' Jour</option>';
								}
						echo '</select></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br></form></table></fieldset>';
	
	
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Choix Du temps - Facture VPS - Etape 3/////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif( isset ( $_POST['serice'] ) AND $_GET['type'] == "1")
	{
	$id_service = $_POST['serice'];
	$id_client = $_GET['id'];
	
		$reponse = mysql_query("SELECT * FROM vps WHERE id='$id_service' LIMIT 1 ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$id_plan = $sql['id_plan'];
								}
												
	
												
												
												
	echo '<fieldset><legend><strong>Assistant de création de facture - Etape 3</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice&id='.$id_client.'&id_service='.$id_service.'&type='.$_GET['type'].'">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Pour combien de temps ? : </td>
							<td><select name="prix">';
							
						$reponse = mysql_query("SELECT * FROM prix_service WHERE service_type='VPS' AND service_id='$id_plan' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
															
					echo '<option value="'.$sql['id'].'">'.$sql['jour_nbr'].' Jour</option>';
								}
						echo '</select></td>
						</tr><tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
	echo '  <br></form></table></fieldset>';
	
	
	}
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Création de la facture - Commande VPS - Etape finale/////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ( isset ( $_GET['id_service'] )  AND $_GET['type'] == "3" )
	{
	$id_service = $_GET['id_service'];
	$id_client = $_GET['id'];
	$id_prix = $_POST['prix'];
													
								
									$sql_plan = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_service' LIMIT 1");
												$nom_plan = $sql_plan[0]['nom'];
							
		$reponse = mysql_query("SELECT * FROM prix_service WHERE id='$id_prix' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$nbr_jour = $sql['jour_time'];
								$jour_tecte = $sql['jour_texte'];
								$prix_prix = $sql['prix'];
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
		
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text`, `prix` ) 
VALUES (
NULL , '" . $id_service . "', 'VPS', '".$id_prix."', '".$nbr_jour."', '1', '', '', '". $id_factre_id_id ."', 'ACHAT' , 'Commande ".$nom_plan." -  ".$jour_tecte."', '".$prix_prix."'
)");
 

		if ( $_POST['frais'] == "1")
		{
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text`, `prix` ) 
VALUES (
NULL , '', 'FRAI', '', '', '1', '', '', '". $id_factre_id_id ."', 'FRAI' , '".$_POST['texte_frai']."', '".$_POST['montant_frai']."'
)");
		}
mysql_query("UPDATE vps SET facture_prolongation='". $facture_denriere ."' WHERE id='". $id_service ."'");

$sujet = 'Facture #'.$facture_denriere.'[CMD-web]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Une facture de renouvellement vient detre crée.<br />

Vous devez reglès cette facture dans un delail de 1 semain sans coi elle sera annulé<br />

Merci de vous rentre sur cette page afin de reglès la facture :<br />

https://178.32.40.40/panel/panel.cmd-web.info/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text`) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());

echo '<center><strong>La facture <a href="index.php?page=invoice&id='.$facture_denriere.'">#'.$facture_denriere.'</a> vient detre crée !';



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Création de la facture - Commande dedié - Etape finale/////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ( isset ( $_GET['id_service'] )  AND $_GET['type'] == "2" )
	{
	$id_service = $_GET['id_service'];
	$id_client = $_GET['id'];
	$id_prix = $_POST['prix'];
													
								
									$sql_plan = DB:: SQLToArray("SELECT * FROM plan_dedicated WHERE id='$id_service' LIMIT 1");
												$nom_plan = $sql_plan[0]['nom_plan'];
							
		$reponse = mysql_query("SELECT * FROM prix_service WHERE id='$id_prix' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$nbr_jour = $sql['jour_time'];
								$jour_tecte = $sql['jour_texte'];
								$prix_prix = $sql['prix'];
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
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text`, `prix` ) 
VALUES (
NULL , '" . $id_service . "', 'DEDICATED', '".$id_prix."', '".$nbr_jour."', '1', '', '', '". $id_factre_id_id ."', 'ACHAT' , 'Commande ".$nom_plan." -  ".$jour_tecte."', '".$prix_prix."'
)");
 



 
mysql_query("UPDATE vps SET facture_prolongation='". $facture_denriere ."' WHERE id='". $id_service ."'");

$sujet = 'Facture #'.$facture_denriere.'[CMD-web]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Une facture de renouvellement vient detre crée.<br />

Vous devez reglès cette facture dans un delail de 1 semain sans coi elle sera annulé<br />

Merci de vous rentre sur cette page afin de reglès la facture :<br />

https://panel.cmd-web.info/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());

echo '<center><strong>La facture <a href="index.php?page=invoice&id='.$facture_denriere.'">#'.$facture_denriere.'</a> vient detre crée !';



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	}
	
	
	
	
	
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Création de la facture - Renouvellement VPS - Etape finale/////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ( isset ( $_GET['id_service'] )  AND $_GET['type'] == "1" )
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
								$prix_prix = $sql['prix'];
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
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text`, `prix` ) 
VALUES (
NULL , '" . $id_service . "', 'VPS', '".$id_prix."', '".$nbr_jour."', '1', '', '', '". $id_factre_id_id ."', 'RRENEW' , 'Renouvellement ".$nom_plan." -  ".$jour_tecte."',  '".$prix_prix."'
)");
 



 
mysql_query("UPDATE vps SET facture_prolongation='". $facture_denriere ."' WHERE id='". $id_service ."'");

$sujet = 'Facture #'.$facture_denriere.'[Heberge-hd.fr]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Une facture de renouvellement vient detre crée.<br />

Vous devez reglès cette facture dans un delail de 1 semain sans coi elle sera annulé<br />

Merci de vous rentre sur cette page afin de reglès la facture :<br />

https://178.32.40.40/panel/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());

echo '<center><strong>La facture <a href="index.php?page=invoice&id='.$facture_denriere.'">#'.$facture_denriere.'</a> vient detre crée !';



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






	
	
	
	}
	else
	{
echo '<fieldset><legend><strong>Assistant de création de facture - Etape 1</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/create_invoice">
						  <table>
						<tr>
							<td><span style="margin-left:100px;"><strong>Pour quelle client ? : </td>
							<td><select name="client" >';
							
							$reponse_facture = mysql_query("SELECT * FROM client ORDER BY id ASC"); // Requête SQL
								while ($sql_facture = mysql_fetch_array($reponse_facture) )
								{
								echo '<option value="'.$sql_facture['id'].'">#'.$sql_facture['id'].' - '.$sql_facture['nom'].' '.$sql_facture['prenom'].'</option>';
								}
						echo '</select></td>
						</tr>
						<tr>
						<td><span style="margin-left:100px;"><strong>Pour quelle type de service ?</td>
							<td><select name="type" >
							<option value="1" >Renouvellement VPS</option>
							<option value="3" >Commande de VPS</option>
							<option value="2" >Commande de dédié</option>
							
							</select>
							</td>
						</tr>
						<tr>
						<td></td><td><input type="submit" value="Continuer ->"></td>
												</tr>';
					
echo '  <br></form></table></fieldset>';
}

?>
