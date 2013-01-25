<?php

//------------------------------------------------------------------------------------------------------
//-------------- Permet de voir l'état du serveur ------------------------------------------------------
//------------------------------------------------------------------------------------------------------
function status_vps($IDVPS, $connection){

	//Commande à exécuter
	$command = "vzctl status $IDVPS && exit";
	
	//Lance la connection et exécute la commande
	$stream = ssh2_exec($connection, $command);

	//Attend que la commande s'exécute et termine
	stream_set_blocking($stream, true);
	
	//Récupère le résultat
	$rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}

	//Ferme la connection
	fclose($stream);

	//Récupèrer que la consigne et la réponse
	//$resultat=explode('root@ns4:~# ', $rep);

	//Vérifie que la commande de restart est en cour
	$run=stripos($rep,"running");
	$down=stripos($rep,"down");

	if($run){
		return true;
	}
	if($down){
		return false;
	}
	
}

//Code pour sauvegarder le transfert Réseau de chaque VPS
include ('bdd.php');

//On prépare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);

//On récupère tous les vps
$sql_vps = "SELECT id,vmid,etat,id_server,status FROM vps";
$req_vps = mysql_query($sql_vps) or die('Erreur SQL !<br>'.$$sql_vps.'<br>'.mysql_error());
while($detail_vps = mysql_fetch_assoc($req_vps)){
  //On récupère les info de connection en ssh au serveur
	$sql_vps_ssh = "SELECT id,host,login,password,port FROM serveur WHERE id=".$detail_vps['id_server'];
	$req_vps_ssh = mysql_query($sql_vps_ssh) or die('Erreur SQL !<br>'.$$sql_vps_ssh.'<br>'.mysql_error());
	$detail_vps_ssh = mysql_fetch_assoc($req_vps_ssh);
	
	//Créer la connection ssh
	$connection = ssh2_connect($detail_vps_ssh['host'],$detail_vps_ssh['port']);
	ssh2_auth_password($connection,$detail_vps_ssh['login'], $detail_vps_ssh['password']);

  //On récupère les transferts
  $rep=status_vps($detail_vps['vmid'], $connection);
  
	//On ajoute l'etat du vps dans la base
	if($rep){
    $sql_insert = "UPDATE vps SET status='1' WHERE id='".$detail_vps['id']."'";
	}else{
    $sql_insert = "UPDATE vps SET status='0' WHERE id='".$detail_vps['id']."'";
	}
 
  //On stocke les valeurs dans la base
	
	$req_insert = mysql_query($sql_insert) or die('Erreur SQL !'.$sql_insert.'<br>'.mysql_error());  
	
}


mysql_close($db_client);
?>

