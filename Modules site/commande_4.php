<?
$host='localhost';
$base='';			// base de donnée
$blogin='';			// login
$bpass='';			// mot de passe

//On prépare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);
	include ('pages/ctrl_login.php');
if ( isset ( $_GET['id'] ) AND $_GET['id'] != NULL )
{
$id_client =$idclient_verif;
$id_bc = $_GET['id'];
$time = time();


		$req_bc = DB:: SQLToArray("SELECT * FROM commande WHERE id='$id_bc' limit 1");
		$id_price = $req_bc[0]['id_prix'];
		$id_prix = $id_price;
	 
		if ( $req_bc[0]['cat_service'] == "VPS" )
		{
		
		$id_prix = $req_bc[0]['id_prix'];
		$id_plan = $req_bc[0]['id_service'];
		$plan = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_plan' limit 1");
		$nom_plan = $plan[0]['nom'];
$facture_denriere = "0900000";
			//On recupere le prix pour 1 mois par default :
			// $plan_vps
			
			
	$reponse_prix	= mysql_query("SELECT * FROM prix_service WHERE id='$id_prix' "); // Requête SQL
		 while ($sql_prix = mysql_fetch_array($reponse_prix) )
		{
		$facture_prix_id = $sql_prix['id'];
		$prix_du_service =  $sql_prix['prix'];
		$jour_time_addes =  $sql_prix['jour_time'];
		}
$sql_prix = DB:: SQLToArray("SELECT * FROM prix_service WHERE id='$id_price' limit 1");
		//On recupere le nuémro de la denrier facture pour en crée un superieur
		$reponsee = mysql_query("SELECT * FROM invoice ORDER BY facture ASC "); // Requête SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
		$lol = "ok";
		$facture_denriere = $sqll['facture'];
		}
	$facture_denriere = $facture_denriere+1;


mysql_query("INSERT INTO `invoice` ( `id` , `id_client` , `etat` , `date_creat` , `ip_crea` , `commentaire_admin` , `commentair_facture` , `texte` , `facture` ) 
VALUES (
NULL , '" . $id_client . "', '1', '". $time ."', 'local', '', '', '', '". $facture_denriere ."'
)");
	$reponse_coco	= mysql_query("SELECT * FROM invoice WHERE facture='$facture_denriere' "); // Requête SQL
		 while ($sql_coco = mysql_fetch_array($reponse_coco) )
		{
		$id_factre_id_id = $sql_coco['id'];
		}
		$nbr_day = $sql_prix[0]['jour_texte'];
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text` , `prix` ) 
VALUES (
NULL , '" . $id_plan . "', 'VPS', '".$facture_prix_id."', '".$jour_time_addes."', '1', '', '', '". $id_factre_id_id ."', 'ACHAT' , 'Commannde  ".$nom_plan." - ".$nbr_day."', '".$prix_du_service."'
)");
 




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

https://panel.your-domaine.info/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());
echo '
<style>
.erreur{
  color:#000000;
  font-size:12px;
  font-weight:bold;
  text-align:center;

}</style>
<center><img src="images/ajax-loader.gif"><br /><div class="erreur">Facture en cour de cr&eacute;ation ...</div></center>';
echo '<meta http-equiv="Refresh" content="01;URL=http://panel.your-domaine.info/index.php?page=invoice&id='.$facture_denriere.'">';

	}
	
	elseif ( $req_bc[0]['cat_service'] == "HOSTING" )
		{
		
		$id_prix = $req_bc[0]['id_prix'];
		$id_plan = $req_bc[0]['id_service'];
		$plan = DB:: SQLToArray("SELECT * FROM plan_hosting WHERE id='$id_plan' limit 1");
		$nom_plan = $plan[0]['nom'];
$facture_denriere = "0900000";
			//On recupere le prix pour 1 mois par default :
			// $plan_vps
			
			
	$reponse_prix	= mysql_query("SELECT * FROM prix_service WHERE id='$id_prix' "); // Requête SQL
		 while ($sql_prix = mysql_fetch_array($reponse_prix) )
		{
		$facture_prix_id = $sql_prix['id'];
		$prix_du_service =  $sql_prix['prix'];
		$jour_time_addes =  $sql_prix['jour_time'];
		}
$sql_prix = DB:: SQLToArray("SELECT * FROM prix_service WHERE id='$id_price' limit 1");
		//On recupere le nuémro de la denrier facture pour en crée un superieur
		$reponsee = mysql_query("SELECT * FROM invoice ORDER BY facture ASC "); // Requête SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
		$lol = "ok";
		$facture_denriere = $sqll['facture'];
		}
	$facture_denriere = $facture_denriere+1;


mysql_query("INSERT INTO `invoice` ( `id` , `id_client` , `etat` , `date_creat` , `ip_crea` , `commentaire_admin` , `commentair_facture` , `texte` , `facture` ) 
VALUES (
NULL , '" . $id_client . "', '1', '". $time ."', 'local', '', '', '', '". $facture_denriere ."'
)");
	$reponse_coco	= mysql_query("SELECT * FROM invoice WHERE facture='$facture_denriere' "); // Requête SQL
		 while ($sql_coco = mysql_fetch_array($reponse_coco) )
		{
		$id_factre_id_id = $sql_coco['id'];
		}
		$nbr_day = $sql_prix[0]['jour_texte'];
mysql_query("INSERT INTO `invoice_corp` ( `id` , `id_service` , `cat_service` , `id_prix` , `jour_add` , `etat` , `time_exec` , `return_exec` , `id_facture`, `type_action` , `text` , `prix` ) 
VALUES (
NULL , '" . $id_plan . "', 'HOSTING', '".$facture_prix_id."', '".$jour_time_addes."', '1', '', '', '". $id_factre_id_id ."', 'ACHAT' , 'Commannde  ".$nom_plan." - ".$nbr_day."', '".$prix_du_service."'
)");
 



 


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

https://panel.your-domaine.info/index.php?page=invoice&id='.$facture_denriere.'';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());
echo '
<style>
.erreur{
  color:#000000;
  font-size:12px;
  font-weight:bold;
  text-align:center;

}</style>
<center><img src="images/ajax-loader.gif"><br /><div class="erreur">Facture en cour de cr&eacute;ation ...</div></center>';
echo '<meta http-equiv="Refresh" content="01;URL=http://panel.your-domaine.info/index.php?page=invoice&id='.$facture_denriere.'">';

	}
	else
	{
	echo "Type de service n'es pas encore pris en charge";
	}
}
else
{

}
?>
