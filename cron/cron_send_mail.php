<?	
//remplacer  your-domaine par votre nom de domaine
// ligne 50 a 60
	include ('bdd.php');
mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp

$reponse = mysql_query("SELECT * FROM email WHERE etat='1' limit 10 "); // Requête SQL
while ($sql = mysql_fetch_array($reponse) )
{
$emaiil = NULL;
$email = NULL;
$id_client = NULL;
$message = $sql['text'];
$sujet = $sql['sujet'];
$id_client = $sql['id_client'];
$email = $sql['mail'];
$id = $sql['id'];

	if (preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#", $email) )
	{
	echo "1";
	$emaiil = $email;
	}
	elseif (preg_match("#[0-9]#", $id_client))
	{
	
			$reponse_client = mysql_query("SELECT * FROM client WHERE id='$id_client' limit 1 ")  or die(mysql_error());
				while ($sql_client = mysql_fetch_array($reponse_client) )
				{
				echo "2";
		$emaiil = $sql_client['email'];
		  mysql_query("UPDATE email SET mail='$emaiil' WHERE id='". $id_client ."'") or die(mysql_error());
				}
	}
	elseif ( $email !=  "01" && $id_client !=  "0" )
	{
	echo "3";
	$emaiil = $email;
	}
	else
	{
	echo "4";
	mysql_query("UPDATE email SET etat='3' WHERE id='". $id ."'") or die(mysql_error());
	}
	
	if ( $emaiil == NULL )
	{
	mysql_query("UPDATE email SET etat='3' WHERE id='". $id ."'") or die(mysql_error());
	}
     $headers ='From: "your-domaine"<support@heberge-hd.fr>'."\n"; 
     $headers .='Reply-To: support@your-domaine.fr'."\n"; 
     $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
     $headers .='Content-Transfer-Encoding: 8bit'; 

     $message ='<html><head><title>'.$sujet.'</title></head><body>'.$message.'<br /><br /><br /><br /><br />
	 
	 Cordialement,
	 <br /><br />
	 L\'equipe de your-domaine.<br />
	 Site : http://your-domaine.fr<br />
	 Forum : http://forum.your-domaine.fr<br />
	 Travaux : http://travaux.your-domaine.fr<br />
	 </body></html>'; 

     if(mail($emaiil, $sujet, $message, $headers)) 
     { 
	 echo "5";
          mysql_query("UPDATE email SET etat='2' WHERE id='". $id ."'") or die(mysql_error());
     } 
     else 
     { 
         mysql_query("UPDATE email SET etat='3' WHERE id='". $id ."'") or die(mysql_error());
     } 

}
?>
