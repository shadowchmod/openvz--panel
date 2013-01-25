<?

mysql_connect("localhost", "", ""); // Connexion � MySQL		// user et votre mot de passe
mysql_select_db("panel"); // S�lection de la base coursphp		// votre base de donné
$time = time();
$req = mysql_query("SELECT * FROM vps ");

	while ($sql = mysql_fetch_array($req))

	{
	
	$date_expiration = $sql['expiration'];
	$id_vps =$sql['id'];
	$id_client = $sql['id_client'];
	$sql_etat = $sql['etat'];
		if ( $date_expiration <= $time   AND $sql_etat != "0"  ) 
		{
		echo $id_vps;
		echo "==>";
		echo $date_expiration;
		echo "<br />";
$sujet = '[VPS N°'.$id_vps.']SUSPENSION[CMD-web]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
          Madame, Monsieur,<br /><br /><br />


Votre serveur N°'.$id_vps.' est actuellement hébergé chez CMD-web.<br /><br />

Notre système de relance a détecté que votre compte est expiré et ceci
malgré les relances que vous avez reçues.<br /><br />

Votre serveur sera donc suspendu d\'ici quelques minutes.<br /><br />

Pour rouvrir le serveur, il vous suffit:<br /><br />

1) De vous rendre a l\'adresse :<br /><br />

http://panel.cmd-web.info<br /><br /><br />

2)De vous connectez est de choisir "Rennouveller mes services"<br /><br />

3) D\'effectuer le règlement par carte bancaire ou chèque bancaire à
l\'ordre de CMD-web.<br /><br />

La facture acquittée vous parviendra sous peu, signalant le renouvellement
de votre redevance pour la période choisie.<br /><br /><br />


IMPORTANT:<br />
==========<br /><br />
En cas de non réglement sous 5 jours le serveur sera DEFINITIVEMENT
arrêté et effacé.<br />

';
$time = time();
$msg = "Le VPS a etait suspendu par le robot pour date expirer";
mysql_query("INSERT INTO `cmdweb_panel`.`notes_vps` (
`id` ,
`id_vps` ,
`time` ,
`ip_crea` ,
`id_admin` ,
`texte` ,
`etat`
)
VALUES (
NULL , '".$id_vps."', '".$time ."', 'ROBOT', 'ROBOT', '".mysql_real_escape_string($msg)."', '1'
)");
mysql_query("UPDATE vps SET status='0' WHERE id='$id_vps' ")or die(mysql_error());
mysql_query("UPDATE vps SET etat='0' WHERE id='$id_vps' ")or die(mysql_error());
mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '". mysql_real_escape_string($sujet)."', '".$time."', '1', '1', '". mysql_real_escape_string($message)."'
)") or die(mysql_error());

		}

	}
?>
