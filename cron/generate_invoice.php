<?php
// modifier 98, 113  your-domaine
 
	include ('bdd.php');
 mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp
//on reucpere la conf par defaut du site
 $timestamp = time();
  $timestampp = time();
 $timestamp = $timestamp + 604800;
// On fait une boucle pour lister tout ce que contient la table :
$reponse = mysql_query("SELECT * FROM vps WHERE generate_invoice='1' "); // Requête SQL
while ($sql = mysql_fetch_array($reponse) )
{
		if ( $sql['expiration'] != NULL AND $sql['facture_prolongation'] == NULL AND $sql['generate_invoice'] == 1)
		{
			if ( $timestamp > $sql['expiration'] )
			{
			$plan_vps = $sql['id_plan'];
		
			$reponse_plan	= mysql_query("SELECT * FROM plan WHERE id='$plan_vps' "); // Requête SQL
			while ($sql_plan = mysql_fetch_array($reponse_plan) )
			{
			$nom_plan = $sql_plan['nom'];
			}
				echo $sql['id'];
				echo "<br>";
				echo date('d/m/Y', $sql['expiration']);

				echo "<br>";
							
							echo "On genera une facture - ";
							echo date('d/m/Y',$timestamp );
							
			$id_client = $sql['id_client'];		
			$id_service = $sql['id'];	
			$facture_denriere = "0900000";
			//On recupere le prix pour 1 mois par default :
			// $plan_vps
				$reponse_prix	= mysql_query("SELECT * FROM prix_service WHERE service_type='vps' && service_id='$plan_vps' && jour_time='2678400'"); // Requête SQL
		 while ($sql_prix = mysql_fetch_array($reponse_prix) )
		{
		$facture_prix_id = $sql_prix['id'];
		$prix_du_service =  $sql_prix['prix'];
		
		}

		//On recupere le nuémro de la denrier facture pour en crée un superieur
		$reponsee = mysql_query("SELECT * FROM invoice ORDER BY facture ASC "); // Requête SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
		$lol = "ok";
		$facture_denriere = $sqll['facture'];
		}
	$facture_denriere = $facture_denriere+1;

/*
mysql_query("INSERT INTO invoice VALUES(
'',
'" . $id_client . "',
'".$facture_prix_id."',
'" . $id_service . "',
'vps',
'2592000',
'1',
'1',
'RRENEW',
'',
'". $timestampp ."',
'',
'',
'',
'',
'". $facture ."'
 )") or die(mysql_error());			
*/

mysql_query("INSERT INTO `invoice` ( `id` , `id_client` , `etat` , `date_creat` , `ip_crea` , `commentaire_admin` , `commentair_facture` , `texte` , `facture` ) 
VALUES (
NULL , '" . $id_client . "', '1', '". $timestampp ."', 'local', '', '', '', '". $facture_denriere ."'
)");
	$reponse_coco	= mysql_query("SELECT * FROM invoice WHERE facture='$facture_denriere' "); // Requête SQL
		 while ($sql_coco = mysql_fetch_array($reponse_coco) )
		{
		$id_factre_id_id = $sql_coco['id'];
		}
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text` , `prix` ) 
VALUES (
NULL , '" . $id_service . "', 'VPS', '".$facture_prix_id."', '2592000', '1', '', '', '". $id_factre_id_id ."', 'RRENEW' , 'Renouvellement ".$nom_plan." -  1 Mois', '".$prix_du_service."'
)");
 



 
mysql_query("UPDATE vps SET facture_prolongation='". $facture_denriere ."' WHERE id='". $id_service ."'");

$sujet = 'Facture #'.$facture_denriere.'[your-domaine]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
Une facture de renouvellement vient detre crée.<br />

Vous devez reglès cette facture dans un delail de 1 semain sans coi elle sera annulé<br />

Merci de vous rentre sur cette page afin de reglès la facture :<br />

https://your-domaine.fr/panel/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());

		}
		}
		
}
 
mysql_close(); // Déconnexion de MySQL
?>

