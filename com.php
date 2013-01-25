<?php

$connection = ssh2_connect('', 22);			// votre serveur 
ssh2_auth_password($connection, '', '');	// user -  votre code d'acces


$stream = ssh2_exec($connection, 'vzctl restart 5200');
stream_set_blocking($stream, true);
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}
	//Ferme la connection
	fclose($stream);

	$ok=stripos($rep,"Container start in progress");
if($ok!=false)
  echo 'Ok';
else
  echo 'Probleme';

?>
