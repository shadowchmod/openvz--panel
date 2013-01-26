<?
						
$host='localhost';
$base='';									// base  (modifier la ligne 204, 157)
$blogin='';									// login
$bpass='';									// mot de passe
	$GLOBALS['local_var']['status'] = "";
	$GLOBALS['local_var']['pays'] ="";
	$GLOBALS['local_var']['nom'] = "";
	$GLOBALS['local_var']['prenom'] ="";
	$GLOBALS['local_var']['adresse'] ="";
	$GLOBALS['local_var']['codezip'] ="";
	$GLOBALS['local_var']['ville'] = "";
	$GLOBALS['local_var']['tel_fixe'] = "";
	$GLOBALS['local_var']['tel_mobile'] ="";
	$GLOBALS['local_var']['mail'] ="";
	$GLOBALS['local_var']['mailconf'] ="";
	$GLOBALS['local_var']['connuecmd'] ="";
	if ( isset ( $_GET['req'] ) )
	{
	$GLOBALS['local_var']['V_CMD_RED'] = $_GET['req'];
	}
	else
	{
	$GLOBALS['local_var']['V_CMD_RED'] = "index.php";
	}

//On pr�pare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);
	$var_register = "0";					

$GLOBALS['local_var']['V_CMD_ERREUR'] = "";

	if ( isset ( $_GET['send'] ) AND $_GET['send'] == "send" )
	{
	$erreur = 0;
	$erreur_msg = "";
		

$info_status = mysql_real_escape_string($_POST['status']);
$GLOBALS['local_var']['status'] = $_POST['status'];
$info_pays = mysql_real_escape_string($_POST['pays']);
$GLOBALS['local_var']['pays'] = $_POST['pays'];
$info_nom = mysql_real_escape_string($_POST['nom']);
$GLOBALS['local_var']['nom'] = $_POST['nom'];
$info_prenom = mysql_real_escape_string($_POST['prenom']);
$GLOBALS['local_var']['prenom'] = $_POST['prenom'];
$info_adresse = mysql_real_escape_string($_POST['adresse']);
$GLOBALS['local_var']['adresse'] = $_POST['adresse'];
$info_codezip = mysql_real_escape_string($_POST['codezip']);
$GLOBALS['local_var']['codezip'] = $_POST['codezip'];
$info_ville = htmlspecialchars(mysql_real_escape_string($_POST['ville']));
$GLOBALS['local_var']['ville'] = $_POST['ville'];
$info_tel_fixe = mysql_real_escape_string($_POST['tel_fixe']);
$GLOBALS['local_var']['tel_fixe'] = $_POST['tel_fixe'];
$info_tel_mobile = mysql_real_escape_string($_POST['tel_mobile']);
$GLOBALS['local_var']['tel_mobile'] = $_POST['tel_mobile'];
$info_mail = mysql_real_escape_string($_POST['mail']);
$GLOBALS['local_var']['mail'] = $_POST['mail'];
$info_mailconf = mysql_real_escape_string($_POST['mailconf']);
$GLOBALS['local_var']['mailconf'] = $_POST['mailconf'];
$info_password_info = mysql_real_escape_string($_POST['pass']);
$info_password = md5(mysql_real_escape_string($_POST['pass']));
$info_verifpassword = md5(mysql_real_escape_string($_POST['verifpassword']));
$info_connuecmd =mysql_real_escape_string($_POST['connuecmd']);
$GLOBALS['local_var']['connuecmd'] = $_POST['connuecmd'];
				
				$i=0;
				$sql_client = mysql_query("SELECT * FROM client WHERE email='$info_mail' ");
				while ( $sql_client_resulat = mysql_fetch_array($sql_client))
				{
					if ( $sql_client_resulat['email'] == $info_mail ) 
					{
					$i++;
					}
				}
		if ( $i != 0 ){$erreur+=1;
		$erreur_msg .= "Cette adresse email existe d&eacute;ja<br />";}
				
		  if (!preg_match("#^[0-9]$#",$info_status)){$erreur+=1;
		$erreur_msg .= "La status et incorrect <br />";}
		
		if ( $info_password != $info_verifpassword) {  $erreur+=1;
		$erreur_msg .= "Les deux mot de passe sont different<br />";
		
		}
		
		 if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$info_mail)){$erreur+=1;
		$erreur_msg .= "Adresse email incorrect <br />";}
		
		$info_nom_nbr =  strlen($info_nom);
 		if ($info_nom_nbr < "3" ){$erreur+=1;
		$erreur_msg .= "Le champ nom doit comporter plus de 3 caract&egrave;res<br />";
		}
		
		if ( $info_nom_nbr >= "20" ){$erreur+=1;
		$erreur_msg .= "Le champ nom ne doit comporter plus de 20 caract&egrave;res<br />";}
		
		$info_prenom_nbr = strlen($info_prenom);
		if ( $info_prenom_nbr <= "3" ){$erreur+=1;
		$erreur_msg .= "Le champ prenom doit comporter plus de 3 caract&egrave;res<br />";}
		
		if ( $info_prenom_nbr >= "20" ){$erreur+=1;
		$erreur_msg .= "Le champ prenom doit comporter moins de 20 caract&egrave;res<br />";}
		
		$info_ville_nbr = strlen($info_ville);
		if ( $info_ville_nbr <= "3" ){$erreur+=1;
		$erreur_msg .= "Le champ ville doit comporter plus de 3 caract&egrave;res<br />";}
		
		if ( $info_ville_nbr >= "30" ){$erreur+=1;
		$erreur_msg .= "Le champ ville doit comporter moins de 30 caract&egrave;res<br />";}
		
		$info_adresse_nbr = strlen($info_adresse);
		if ($info_adresse_nbr <= "6"	){$erreur+=1;
		$erreur_msg .= "Le champ adresse doit comporter au plus de 6 caract&egrave;res<br />";}
		
		if ( $info_adresse_nbr >= "30" ){$erreur+=1;
		$erreur_msg .= "Le champ adresse doit comporter moins de 30 caract&egrave;res<br />";}
		
		$info_codezip_nbr = strlen($info_codezip);
		if ($info_codezip_nbr != 5 ){$erreur+=1;
		$erreur_msg .= "Le champ code postal doit comporter 5 caract&egrave;res <br />";}
		

		if (!is_numeric($info_codezip)){$erreur+=1;
		$erreur_msg .= "Le champ code postal doit &ecirc;tre un nombre <br />";}

		//On cr�e le nik-hanlde 
		$name_client_count = strlen($info_nom);
		$name_client_count = $name_client_count - 1;
		$nom_format = substr($info_nom, 0, -$name_client_count);   
		// on recupere la premiere lettre du prenom
		$surname_client_count = strlen($info_prenom);
		$surname_client_count = $surname_client_count - 1;
		$prenom_format = substr($info_prenom, 0, -$surname_client_count);   
		// On les asseble et passe en MAJ
		$name_and_prenom = ''.$nom_format.''.$prenom_format.'';
		$name_and_prenom = strtoupper($name_and_prenom); 
		//on genere un nombre de 4-5 chiffre
		$nombre_genere = rand(1000,99999);
		//On cr�e le nik-handle 
		$nik_finale = ''.$name_and_prenom.''.$nombre_genere.'-CMD';
		
		


		if ( $erreur != "0" )
		{
		$GLOBALS['local_var']['V_CMD_ERREUR'] = "Il  y a ".$erreur." erreur : <br /> ".$erreur_msg."";
		
		}
		else
		{
		$ip = $_SERVER['REMOTE_ADDR'];
		$GLOBALS['local_var']['V_CMD_ERREUR'] = "";
	mysql_query("INSERT INTO `your-base-de-donnee`.`client` (
`id` ,
`nom` ,
`prenom` ,
`email` ,
`tel_fixe` ,
`tel_mobile` ,
`password` ,
`nikhandle` ,
`etat` ,
`ville` ,
`cp` ,
`adresse` ,
`pays` ,
`credit` ,
`langue` ,
`ip_register` ,
`status`
)
VALUES (
NULL , '".$info_nom."', '".$info_prenom."', '".$info_mail."', '".$info_tel_fixe."', '".$info_tel_mobile."', '".$info_password."', '".$nik_finale."', '1', '".$info_ville."', '".$info_codezip."', '".$info_adresse."', '".$info_pays."', '0', 'FR', '".$ip."', '".$info_status."'
)") or die(mysql_error());

			$headers ='From: "your-domaine"<support@your-domaine.info>'."\n";
			$headers .='Reply-To: support@your-domaine.info'."\n";
			$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
			$headers .='Content-Transfer-Encoding: 8bit';
			
			$message = mysql_real_escape_string("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Vos identifiants [your-domaine]</title>
</head>

<body>
<p>Bienvenue chez your-domaine.</p>
<p>Vos identifiants sont :</p>
<blockquote>
	<p>Nik-handle : <strong>$nik_finale<br />
	</strong>Mot de passe : <strong>$info_password_info</strong></p>
</blockquote>
</body>
</html>");
			$time=time();

$sujet = mysql_real_escape_string('Vos identifiants [your-domaine]');
mysql_query("INSERT INTO `your-base-de-donnee`.`email` (
`id` ,
`id_client` ,
`mail` ,
`sujet` ,
`time` ,
`prioriter` ,
`etat` ,
`text`
)
VALUES (
NULL , '', '".mysql_real_escape_string($info_mail)."', '".$sujet."', '".$time."', '1', '1', '".$message."'
)");	
$var_register = "1";

		}
		}
					if ( $var_register == "0" )
					{
					$GLOBALS['local_var']['V_CMD_TITRE'] = "Inscription";
					print_file("pages/services/register.html");
					}
					elseif ($var_register == "1" )
					{
					$GLOBALS['local_var']['V_CMD_TITRE'] = "Fin de l'inscription";
					
					$pagee = $_POST['RED'];
					if ( preg_match("#commande_3#", $pagee )  ) 
					{
	$GLOBALS['local_var']['V_CMD_INDICATION'] = "Vos identifiant vous on etait envoyer par mot de passe, une foi rediriger sur la page de commande cliquez sur \"Connectez-vous\" afin de de vous connectez avec vos nouveaux identifiant. ";
					}else{ $GLOBALS['local_var']['V_CMD_INDICATION'] = "";}
	echo '	<meta http-equiv="Refresh" content="10;URL=index.php?lang=fr&page='.$_POST['RED'].'">';
					print_file("pages/services/register_finish.html");		
							
					}
?>
