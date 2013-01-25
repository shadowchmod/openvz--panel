<?php
//Temps limite du script
//set_time_limit();//en seconde


//Fait la puissance d'un nombre
function puissance($x,$y){ 
  $resultat=1;
  for ($i=0;$i<$y;$i++)
   $resultat *= $x;
  return $resultat;
}

//Convertit un grand nombre int venant d'un string
function stringToINT($string){
  $nb_chiffre=strlen($string);
  $i=0;
  $nb=0;
  while($i<=$nb_chiffre){
    $nb_cut=substr($string, -5);
    $string=substr($string,0, -5);
    //echo "<br>Cut : $nb_cut String : $string";
    $nb+=puissance(10,$i)*intval($nb_cut);
    //echo ' NB='.$nb;
    $i+=5;
  }
  return $nb;
}

//Récupère le traffic
function traffic_vps($IDVPS, $connection){

		//Commande à exécuter
	$command = "vzctl exec $IDVPS netstat -e -i | awk '/^venet0 /,/^$/' && sleep 1 && vzctl exec $IDVPS netstat -e -i | awk '/^venet0 /,/^$/' && exit";
	
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

	//Cherche TX
	$cherche=explode('TX bytes:',$rep);
	$start_TX=explode(' (',$cherche[1]);
	$stop_TX=explode(' (',$cherche[2]);
	$diff_TX=(intval(substr($stop_TX[0], -9))-intval(substr($start_TX[0], -9)))/1024;
	if($diff_TX>=1024){
    $diff_TX/=1024;
    $deb_TX=number_format($diff_TX, 2, ',', ' ').' Mo/s';
  }else{
    $deb_TX=number_format($diff_TX, 2, ',', ' ').' ko/s';
  }
	
	//Cherche RX
	
	$cherche=explode('RX bytes:',$rep);
	$start_RX=explode(' (',$cherche[1]);
	$stop_RX=explode(' (',$cherche[2]);
	$diff_RX=(intval($stop_RX[0])-intval($start_RX[0]))/1024;
	if($diff_RX>=1024){
    $diff_RX/=1024;
    $deb_RX=number_format($diff_RX, 2, ',', ' ').' Mo/s';
  }else{
    $deb_RX=number_format($diff_RX, 2, ',', ' ').' ko/s';
  }
  
  //Retourne les résultats en tableau
  
  $send = array(
                  "TX" => stringToINT($start_TX[0]),
                  "RX" => stringToINT($start_RX[0]),
                  "TX_deb" =>$deb_TX,
                  "RX_deb" =>$deb_RX
               );
               
  
  return $send;
  
}

//Code pour sauvegarder le transfert Réseau de chaque VPS

include ('bdd.php');

//On prépare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);

//On récupère tous les vps
$sql_vps = "SELECT id,vmid,etat,id_server,TX_total,RX_total,TX_temp,RX_temp FROM vps WHERE etat=1";
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
  $rep=traffic_vps($detail_vps['vmid'], $connection);
  //echo '<br>';
  //print_r($rep);
	//On ajoute dans le total si nouvelle session
	if(($detail_vps['RX_temp']>$rep['RX'])||($detail_vps['TX_temp']>$rep['TX'])){
    //On stocke ajoute les tmp ds total
    $sql_insert = "UPDATE vps SET RX_total='".($detail_vps['RX_temp']+$detail_vps['RX_total'])."' , TX_total='".($detail_vps['TX_temp']+$detail_vps['TX_total'])."' WHERE id='".$detail_vps['id']."'";
    $req_insert = mysql_query($sql_insert) or die('Erreur SQL !'.$sql_insert.'<br>'.mysql_error());  
	}
 
  //On stocke les valeurs dans la base
	$sql_insert = "UPDATE vps SET TX_temp='".$rep['TX']."' , RX_temp='".$rep['RX']."', deb_TX='".$rep['TX_deb']."', deb_RX='".$rep['RX_deb']."' WHERE id='".$detail_vps['id']."'";
	$req_insert = mysql_query($sql_insert) or die('Erreur SQL !'.$sql_insert.'<br>'.mysql_error());  
	
}


mysql_close($db_client);

?>
