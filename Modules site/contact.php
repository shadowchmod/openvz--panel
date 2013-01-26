<?php
$erreur="0";
 mysql_connect("localhost", "", ""); // Connexion à MySQL // login // mot de passe
mysql_select_db(""); // Sélection de la base coursphp
	defined("INC") or die("403 restricted access");

$ip = $_SERVER['REMOTE_ADDR'];
$time=time();
	if ( isset ( $_POST['message'] ) AND  isset ( $_POST['subject'] ) AND isset ( $_POST['email'] ))
	{
	$message = $_POST['message'];
	$sujet = $_POST['subject'];
	$mail = $_POST['email'];
	 if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$mail)){$erreur+=1;
		$erreur_msg .= "Adresse email incorrect <br />";}
		
		$info_message =  strlen($message);
 		if ($info_message < "10" ){$erreur+=1;
		$erreur_msg .= "Le champ nom doit comporter plus de 3000 caract&egrave;res<br />";
		}
		
		if ( $info_message >= "3000" ){$erreur+=1;
		$erreur_msg .= "Le champ nom ne doit comporter plus de 3000 caract&egrave;res<br />";}
		
		if ( $erreur != "0" )
		{
		$GLOBALS['local_var']['V_CONTACT_ERREUR'] = $erreur_msg;
		}
		else
		{
		$sujet = mysql_real_escape_string('Demande de soutien[your-domaine]');
$messagee = mysql_real_escape_string('


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />Mauvais 
Bonjour,<br />
<br />
Votre demande de soutien vient d\'etre prise en compte.<br /><br />

Une reponse vous sera envoyer sur votre adresse email.



');
	mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '', '".$mail."', '".$sujet."', '".$time."', '1', '1', '".$messagee."'
)") or die(mysql_error());
		$sujet1 = mysql_real_escape_string('Nouvelle demande de soutien[your-domaine]');
$message1 = mysql_real_escape_string('


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
<br />
Nouveaux message du formulair de contact :<br /><br /><br />
<br /><br />
Sujet : '.$sujet.'<br /><br />
Email : '.$mail.'<br /><br />
Date : '.date('d/m/y').'<br /><br />
Heur : '.date('H:i:s').'<br /><br />
Ip : '.$ip.'<br /><br />
Message : <br />'.$message.'<br /><br />



');
mysql_query("INSERT INTO `email` ( `id` ,  `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL ,  'your-domaine-email@gmail.com', '".$sujet1."', '".$time."', '1', '1', '".$message1."'
)") or die(mysql_error());
	

mysql_query("INSERT INTO `email` ( `id` ,  `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL ,  'support@your-domaine.info', '".$sujet1."', '".$time."', '1', '1', '".$message1."'
)") or die(mysql_error());
	
	}
	}
	
	
	print_file("pages/include/contact.html");
?>
