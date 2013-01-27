<?	
 mysql_connect("localhost", "", ""); // Connexion à MySQL //user and password
mysql_select_db(""); // Sélection de la base coursphp

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
     $headers ='From: "Heberge-hd"<support@your-domaine.fr>'."\n"; 
     $headers .='Reply-To: support@your-domaine.fr'."\n"; 
     $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
     $headers .='Content-Transfer-Encoding: 8bit'; 

     $message ='<html><head><title>'.$sujet.'</title></head><body>'.$message.'<br /><br /><br /><br /><br />
	 
	 Cordialement,
	 <br /><br />
	 L\'equipes de your-domaine.<br />
	 Site : http://your-domaine.fr<br />
	 Forum : http://your-domaine.fr<br />
	 Etat des serveurs http://your-domaine.fr<br />
	 Travaux : http://your-domaine.fr<br />
	 </body></html>'; 

     if(mail($emaiil, $sujet, $message, $headers)) 
     { 
	 echo "5";
         // mysql_query("UPDATE email SET etat='2' WHERE id='". $id ."'") or die(mysql_error());
     } 
     else 
     { 
         mysql_query("UPDATE email SET etat='3' WHERE id='". $id ."'") or die(mysql_error());
     } 

}
?>
