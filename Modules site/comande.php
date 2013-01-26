<?

mysql_connect("localhost", "", ""); // Connexion � MySQL	//  votre user, vote vode
mysql_select_db(""); // S�lection de la base coursphp 		//  nom de la base de donnée

$id_service = @$_GET['id'];
$cat_service = @$_GET['cd'];
$erreur=0;
$GLOBALS['local_var']['ERREUR'] = "";

if ( $cat_service != "VPS" )
{
	if ( $cat_service != "HOSTING")
	{
$erreur+=1;
$GLOBALS['local_var']['ERREUR'] .= "<div class=\"erreur\">Erreur : La categorie de service demander est introuvable</div><br />";

	}


}

  if (!preg_match("#^[0-9]$#",$id_service)){$erreur+=1;
	$GLOBALS['local_var']['ERREUR'] .=  '<div class="erreur">Erreur : Le param&egrave;tre est invalide</div><br />';

	}
$id_service_nbr =  strlen($id_service);
 		if ($id_service_nbr != "1" ){$erreur+=1;
		$GLOBALS['local_var']['ERREUR'] .=  '<div class="erreur">Erreur : Le service demande est inexistant</div><br />';
	
		
		}
if ( $cat_service == "HOSTING" AND $erreur ==0 )
{
$req_plan = mysql_query("SELECT * FROM plan_hosting WHERE id='$id_service' ");
		$i=0;
		while ($sql_plan = mysql_fetch_array($req_plan))
		  {
		  $i+=1;
		  }
			if ( $i != "1")
			{
			$GLOBALS['local_var']['ERREUR'] .=  '<div class="erreur">Erreur : Le service demande est introuvable</div><br />';
			
			$erreur+=1;
			
			
			}
			else
			{
			
		$facture_denriere = "0900000";
				//On recupere le nu�mro de la denrier facture pour en cr�e un superieur
		$reponsee = mysql_query("SELECT * FROM commande ORDER BY number_cmd  ASC "); // Requ�te SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
				$facture_denriere = $sqll['number_cmd'];
		}
	$facture_denriere = $facture_denriere+1;
$ip = $_SERVER['REMOTE_ADDR'];
		$req_plan = DB:: SQLToArray("SELECT * FROM plan_hosting WHERE id='$id_service' limit 1");
	mysql_query ("INSERT INTO `cmdweb_panel`.`commande` (
`id` ,
`id_client` ,
`number_cmd` ,
`id_service` ,
`cat_service` ,
`nbr_service` ,
`ip_client`
)
VALUES (
NULL , '', '".$facture_denriere."', '".$id_service."', '".$cat_service."', '1', '".$ip."'
)");
$GLOBALS['local_var']['V_CMD_NOM'] = $req_plan[0]['nom'];
$GLOBALS['local_var']['V_CMD_DD_INFO'] = $req_plan[0]['disque'];
$GLOBALS['local_var']['V_CMD_bandeb_INFO'] = $req_plan[0]['bandeb'];
$GLOBALS['local_var']['V_CMD_ftp_INFO'] = $req_plan[0]['ftp'];
$GLOBALS['local_var']['V_CMD_bdd_INFO'] = $req_plan[0]['bdd'];
$GLOBALS['local_var']['V_CMD_compte_mail_INFO'] = $req_plan[0]['compte_mail'];
$GLOBALS['local_var']['V_CMD_FACTURE_DIERE'] = $facture_denriere;



$_SESSION['BC'] = $facture_denriere;
$GLOBALS['local_var']['V_MON_PRIX']= 'Etape 1  - Commande du pack '.$req_plan[0]['nom'].' ';
	


	}

	
	
	
	}
elseif ( $cat_service == "VPS" AND $erreur ==0 )
{

		$req_plan = mysql_query("SELECT * FROM plan WHERE id='$id_service' ");
		$i=0;
		while ($sql_plan = mysql_fetch_array($req_plan))
		  {
		  $i+=1;
		  }
			if ( $i != "1")
			{
			$GLOBALS['local_var']['ERREUR'] .=  '<div class="erreur">Erreur : Le service demande est introuvable</div><br />';
			
			$erreur+=1;
			
			
			}
			else
			{
			
		
		$facture_denriere = "0900000";
				//On recupere le nu�mro de la denrier facture pour en cr�e un superieur
		$reponsee = mysql_query("SELECT * FROM commande ORDER BY number_cmd  ASC "); // Requ�te SQL
		 while ($sqll = mysql_fetch_array($reponsee) )
		{
				$facture_denriere = $sqll['number_cmd'];
		}
	$facture_denriere = $facture_denriere+1;
$ip = $_SERVER['REMOTE_ADDR'];
		$req_plan = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_service' limit 1");
	mysql_query ("INSERT INTO `cmdweb_panel`.`commande` (
`id` ,
`id_client` ,
`number_cmd` ,
`id_service` ,
`cat_service` ,
`nbr_service` ,
`ip_client`
)
VALUES (
NULL , '', '".$facture_denriere."', '".$id_service."', '".$cat_service."', '1', '".$ip."'
)");
$GLOBALS['local_var']['V_CMD_NOM'] = $req_plan[0]['nom'];
$GLOBALS['local_var']['V_CMD_DD_INFO'] = $req_plan[0]['dd_info'];
$GLOBALS['local_var']['V_CMD_RAM_INFO'] = $req_plan[0]['ram_info'];
$GLOBALS['local_var']['V_CMD_PROCO_INFO'] = $req_plan[0]['proco_info'];
$GLOBALS['local_var']['V_CMD_CONNEXION_INFO'] = $req_plan[0]['connexion_info'];
$GLOBALS['local_var']['V_CMD_BP_INFO'] = $req_plan[0]['bp_info'];
$GLOBALS['local_var']['V_CMD_FACTURE_DIERE'] = $facture_denriere;



$_SESSION['BC'] = $facture_denriere;
$GLOBALS['local_var']['V_MON_PRIX']= 'Etape 1  - Commande du '.$req_plan[0]['nom'].' ';
		}
		
		}
		
		if ( $erreur == 0 )
		{
			if ( $cat_service == "HOSTING" )
			{
		print_file("pages/services/commande_etape_1_hosting.html");
			}
			else
			{
		print_file("pages/services/commande_etape_1.html");
			}
			
		}else{
		$GLOBALS['local_var']['ERREUR_NBR'] = $erreur;
		print_file("pages/services/help.html");
		}
		
		
			

		


				

	
	
		
?>


