<?php
include ('bdd.php');
//-----------------------------------------------------------------------------------
//--------------- Fonction pour eteindre un VPS -------------------------------------
//-----------------------------------------------------------------------------------
function stop_vps($IDVPS, $connection){

	//Commande � ex�cuter
	$command = "vzctl stop $IDVPS && exit";
	
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
}

//Code de connection MYSQL
include ('bdd.php'); //rajouter by ASHEMTA

//On pr�pare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);

//On r�cup�re tous les vps
$sql_vps = "SELECT id,vmid,etat,id_server FROM vps WHERE etat=0";
$req_vps = mysql_query($sql_vps) or die('Erreur SQL !<br>'.$$sql_vps.'<br>'.mysql_error());
while($detail_vps = mysql_fetch_assoc($req_vps)){
  //On r�cup�re les info de connection en ssh au serveur
	$sql_vps_ssh = "SELECT id,host,login,password,port FROM serveur WHERE id=".$detail_vps['id_server'];
	$req_vps_ssh = mysql_query($sql_vps_ssh) or die('Erreur SQL !<br>'.$$sql_vps_ssh.'<br>'.mysql_error());
	$detail_vps_ssh = mysql_fetch_assoc($req_vps_ssh);
	
	//Cr�er la connection ssh
	$connection = ssh2_connect($detail_vps_ssh['host'],$detail_vps_ssh['port']);
	ssh2_auth_password($connection,$detail_vps_ssh['login'], $detail_vps_ssh['password']);

  //On r�cup�re les transferts
  stop_vps($detail_vps['vmid'], $connection);
  }

mysql_close($db_client);

?>
