<?php
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//-------- Auteur :                                                             ------------------------
//-------- Email :                                                              ------------------------
//-------- Année : 2009                                                         ------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------------
//-------------- Permet de lancer le redémarrage du serveur --------------------------------------------
//------------------------------------------------------------------------------------------------------
function restart_vps($IDVPS, $connection)
{
	//passer_message_info("Start restart");
	//passer_message_info("");
	//Lance la connection et lance un terminal
		
	//Commande � ex�cuter
	$command = "vzctl restart ".$IDVPS;
	
	//Lance la connection et ex�cute la commande
	$stream = ssh2_exec($connection, $command);

	//Attend que la commande s'ex�cute et termine
	stream_set_blocking($stream, true);
	
	//R�cup�re le r�sultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}

	//Ferme la connection
	fclose($stream);
	
	//R�cup�rer que la consigne et la r�ponse
	//$resultat=explode('root@ns4:~# ', $rep);
	
	//V�rifie que la commande de restart est en cour
	$ok=stripos($rep,"Container start in progress");

	//passer_message_info("Finish restart");
	if($ok)
	{
		return true;
	}else{
		return false;
	}
	
}



//------------------------------------------------------------------------------------------------------
//-------------- Permet de voir l'�tat du serveur ------------------------------------------------------
//------------------------------------------------------------------------------------------------------
function status_vps($IDVPS, $connection){

	//Commande � ex�cuter
	$command = "vzctl status ".$IDVPS;
	
	//Lance la connection et ex�cute la commande
	$stream = ssh2_exec($connection, $command);

	//Attend que la commande s'ex�cute et termine
	stream_set_blocking($stream, true);
	
	//R�cup�re le r�sultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}

	//Ferme la connection
	fclose($stream);

	//R�cup�rer que la consigne et la r�ponse
	$resultat=explode('root@ks305836:~# ', $rep);

	//V�rifie que la commande de restart est en cour
	$run=stripos($resultat[1],"running");
	$down=stripos($resultat[1],"down");

	if($run){
		return true;
	}
	if($down){
		return false;
	}
	
}


//------------------------------------------------------------------------------------------------------
//-------------- Permet de stopper le serveur --------------------------------------------
//------------------------------------------------------------------------------------------------------

function stop_destroy_vps($IDVPS, $connection){
  
  $command_stop = 'vzctl stop '.$IDVPS.' && vzctl destroy '.$IDVPS;
  //On arr�te le serveur
	$stream = ssh2_exec($connection, $command_stop);
	
	//On lance la commande d'install
 
  stream_set_blocking($stream, true);
  
  //R�cup�re le r�sultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}
		$time=time();
	$message = mysql_real_escape_string('Le '.date('d/m/y - H:i:s').' le VPS '.$hostname.' ('.$IDVPS.') est passer en erreur lors de sont arrete et de sa suppresion.
		Voici le message : '.$rep.'

		Commande : 
		'.$command_stop.'');
	$IDVPS = mysql_real_escape_string($IDVPS);
	$time = mysql_real_escape_string($time);
	mysql_query("INSERT INTO `warning` ( `id` , `id_client` , `ip` , `message` , `page` , `time` , `type`, `TYPE_W`)
VALUES (
NULL , '".$IDVPS."', 'IP', '".$message."', '', '".$time."', 'W_ERREUR_DELL_DETROY_VPS', 'VPS'
)");
	//Ferme la connection
	fclose($stream);
  
}

//------------------------------------------------------------------------------------------------------
//-------------- Permet de lancer de reinstaller le serveur --------------------------------------------
//------------------------------------------------------------------------------------------------------

function reinstall_vps($IDVPS, $connection, $OS, $hostname, $disque, $ip, $swap, $memoire, $cpu, $passroot){
	//On suprrime et r�installe le serveur--------------------------------------------------------------------------------
	
	// Pour old version : Commande � ex�cuter
	//$command='/usr/bin/pvectl vzcreate '.$IDVPS.' --disk '.$disque.' --ostemplate '.$OS.'  --hostname '.$hostname.'  --nameserver 127.0.0.1 --nameserver 213.186.33.99 --searchdomain ovh.net --onboot no --ipset '.$ip.' --swap '.$swap.' --mem '.$memoire.' --cpus '.$cpu.' && vzctl restart '.$IDVPS.' && vzctl set '.$IDVPS.' --userpasswd root:'.$passroot;
	// pour proxmox 2.X
	$command='/usr/bin/pvectl create -vmid '.$IDVPS.' -ostemplate '.$OS.' -disk '.$disque.' -hostname '.$hostname.' -nameserver 213.186.33.99 -searchdomain ovh.net -onboot 1 -ip_address '.$ip.' -swap '.$swap.' -memory '.$memoire.' -cpus '.$cpu.' -password '.$passroot;
//	$command='echo "$IDVPS $connection $OS $disque $hostname $ip $swap $memoire $cpu $passroot" > /root/txt.txt';
	$mes='$IDVPS $OS $disque $hostname $ip $swap $memoire $cpu $passroot ';	
	mail("ashemta01@gmail.com","fonction_vps reinstall", $mes);
	
	//On arr�te le serveur
	stop_destroy_vps($IDVPS, $connection);
	
	//On lance la commande d'install
  $stream = ssh2_exec($connection, $command );
  stream_set_blocking($stream, true);
	
	//R�cup�re le r�sultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
		$repp.=$line;
	}
	//Ferme la connection
	fclose($stream);

	if($stream!=false){
		return true;
	}else{
	

	$ok=stripos($rep,"Container start in progress");
	$time=time();
	$message = mysql_real_escape_string('Le '.date('d/m/y - H:i:s').' le VPS '.$hostname.' ('.$IDVPS.') est passer en erreur lors de sa réinstallation.
		Voici le message : '.$rep.'

		Commande : 
		'.$command_stop.'');
	$IDVPS = mysql_real_escape_string($IDVPS);
	$time = mysql_real_escape_string($time);
	mysql_query("INSERT INTO `warning` ( `id` , `id_client` , `ip` , `message` , `page` , `time` , `type`, `TYPE_W`)
VALUES (
NULL , '".$IDVPS."', 'IP', '".$message."', '', '".$time."', 'W_ERREUR_SETUP_VPS', 'VPS'
)");

		return false;
	}
	
}


//------------------------------------------------------------------------------------------------------
//-------------- Permet d'installer un nouveau serveur -------------------------------------------------
//------------------------------------------------------------------------------------------------------

function install_new_vps($IDVPS, $connection, $OS, $hostname, $disque, $ip, $swap, $memoire, $cpu, $passroot)
{
	//On suprrime et r�installe le serveur--------------------------------------------------------------------------------
	
	//Commande � ex�cuter
	//$command = '/usr/bin/pvectl vzcreate '.$IDVPS.' --disk '.$disque.' --ostemplate '.$OS.'  --hostname '.$hostname.'  --nameserver 127.0.0.1 --nameserver 213.186.33.99 --searchdomain ovh.net --onboot no --ipset '.$ip.' --swap '.$swap.' --mem '.$memoire.' --cpus '.$cpu.' && vzctl restart '.$IDVPS.' && vzctl set '.$IDVPS.' --userpasswd root:'.$passroot;
	$command = '/usr/bin/pvectl create -vmid '.$IDVPS.' -ostemplate '.$OS.' -disk '.$disque.' -hostname '.$hostname.'  -nameserver 13.186.33.99 -searchdomain ovh.net -onboot 1 -ip_address '.$ip.' -swap '.$swap.' -memory '.$memoire.' -cpus '.$cpu;
	
  //On lance la commande
  $stream = ssh2_exec($connection, $command);
  stream_set_blocking($stream, true);
  
	//R�cup�re le r�sultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}
	//Ferme la connection
	fclose($stream);

	
	if($stream!=false){
		return true;
	}else{$ok=stripos($rep,"Container start in progress");
	$time=time();
	$message = mysql_real_escape_string('Le '.date('d/m/y - H:i:s').' le VPS '.$hostname.' ('.$IDVPS.') est passer en erreur lors de sa réinstallation.
		Voici le message : '.$rep.'

		Commande : 
		'.$command_stop.'');
	$IDVPS = mysql_real_escape_string($IDVPS);
	$time = mysql_real_escape_string($time);
	mysql_query("INSERT INTO `warning` ( `id` , `id_client` , `ip` , `message` , `page` , `time` , `type`, `TYPE_W`)
VALUES (
NULL , '".$IDVPS."', 'IP', '".$message."', '', '".$time."', 'W_ERREUR_SETUP_VPS', 'VPS'
)");
		return false;
	}
	
}


//------------------------------------------------------------------------------------------------------
//-------------- Envoie mail reinstallation ------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
function mail_reinstal($mail,$nom,$prenom,$os,$ip,$dns,$passroot){

    $headers ='From: "Heberge-hd"<support@your-domaine.fr>'."\n";
    $headers .='Reply-To: support@your-domaine.fr'."\n";
    $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
    $headers .='Content-Transfer-Encoding: 8bit';

    $message ='<html><head><title>Voici vos identifiant SSH :</title></head><body>
	Bonjour, '.ucfirst(strtolower($prenom)).' '.strtoupper($nom).'<br/>
	La réinstallation de votre RPS est maintenant terminée, voici les informations d\'accés :<br/>
	<br/><br/>
	Login : root <br/>
	Password : '.$passroot.' <br/>
	IP : '.$ip.' <br/>
	DNS : '.$dns.' <br/>
	OS : '.$os.' <br/>
	<br/>
	Pour plus d\'information merci de contacter le support.<br/>
	Cordialement,<br/>
	L\'equipes de your-domaine.<br/>
	Site web : http://your-domaine.fr<br/>
	Forum : http://forum.your-domaine.fr<br/>
	Travaux : http://travaux.your-domaine.fr<br/>
	Contact email : support@your-domaine.fr
	
	
	</body></html>';

    mail($mail, 'Réinstallation de votre RPS [http://forum.your-domaine.fr<br/>]', $message, $headers);
	

}

//modif_root($vpsinfo["vmid"],$connection,$passroot);			
//------------------------------------------------------------------------------------------------------
//-------------- Permet de changer le pass ROOT du serveur ---------------------------------------------
//------------------------------------------------------------------------------------------------------

function modif_root($IDVPS, $connection, $passroot){
	
	//Commande � ex�cuter
	$command='vzctl set '.$IDVPS.' --userpasswd root:'.$passroot;
		
	//On lance la commande d'install
  $stream = ssh2_exec($connection, $command);
  stream_set_blocking($stream, true);
	
	//R�cup�re le r�sultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}
	//Ferme la connection
	fclose($stream);

	if($stream!=false){
		return true;
	}else{
		
	$ok=stripos($rep,"ok");
	$time=time();
	$message = mysql_real_escape_string('Le '.date('d/m/y - H:i:s').' le VPS '.$hostname.' ('.$IDVPS.') est passer en erreur lors du chnagement de passwors root
		Voici le message : '.$rep.'

		Commande : 
		'.$command_stop.'');
	$IDVPS = mysql_real_escape_string($IDVPS);
	$time = mysql_real_escape_string($time);
	mysql_query("INSERT INTO `warning` ( `id` , `id_client` , `ip` , `message` , `page` , `time` , `type`, `TYPE_W`)
VALUES (
NULL , '".$IDVPS."', 'IP', '".$message."', '', '".$time."', 'W_ERREUR_UPDATE_PASSWORD_VPS', 'VPS'
)");
		return false;
	}
	
}

//------------------------------------------------------------------------------------------------------
//-------------- Permet de supprimer le serveur --------------------------------------------
//------------------------------------------------------------------------------------------------------

function destroy_vps($IDVPS, $connection){
  
  $command_stop = '#!/bin/bash
                   if vzctl destroy '.$IDVPS.'
                   then echo ok
                   else 
                      if vzctl stop '.$IDVPS.' && vzctl destroy '.$IDVPS.'
                      then echo ok
                      else 
                      echo non
                      fi
                   fi
                   ';

  //On arrête le serveur
	ssh2_exec($connection, $command_stop);
	
	//On lance la commande d'install
  $stream = ssh2_exec($connection, $command_stop);
  stream_set_blocking($stream, true);
  
  //Récupère le résultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}
	
	//Ferme la connection
	fclose($stream);

	if($stream!=false){
		return true;
	}else{
		
	$ok=stripos($rep,"ok");
	$time=time();
	$message = mysql_real_escape_string('Le '.date('d/m/y - H:i:s').' le VPS '.$hostname.' ('.$IDVPS.') est passer en erreur lors de sa suppression.
		Voici le message : '.$rep.'

		Commande : 
		'.$command_stop.'');
	$IDVPS = mysql_real_escape_string($IDVPS);
	$time = mysql_real_escape_string($time);
	mysql_query("INSERT INTO `warning` ( `id` , `id_client` , `ip` , `message` , `page` , `time` , `type`, `TYPE_W`)
VALUES (
NULL , '".$IDVPS."', 'IP', '".$message."', '', '".$time."', 'W_ERREUR_DELL_VPS', 'VPS'
)");
		return false;
	}
}
?>

