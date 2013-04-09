<?php
// modifier ligne 70
//------------------------------------------------------------------------------------------------------
//-------------- Converti une valeur G M en Kilo -------------------------------------------------------
//------------------------------------------------------------------------------------------------------

function ToOctet($string){
  if(stripos($string,"G"))
    $mux=1048576;
  elseif(stripos($string,"M"))
    $mux=1024;
  elseif(stripos($string,"K"))
    $mux=1;
  else
    $mux=0;
  
  return intval($string)*$mux;
}

//------------------------------------------------------------------------------------------------------
//-------------- Converti une valeur M en Kilo ---------------------------------------------------------
//------------------------------------------------------------------------------------------------------

function MoToOctet($string){
  return intval($string)*1024;
}
//------------------------------------------------------------------------------------------------------
//-------------- Permet de voir l'état du serveur ------------------------------------------------------
//------------------------------------------------------------------------------------------------------

function info($IDVPS, $connection){

	//Commande à exécuter
	$command = 'vzctl exec '.$IDVPS.' free -o -m | awk \'/Mem/ {print $2 \" \" $3 \" \" $4}\' && vzctl exec '.$IDVPS.' df / -h | awk \'/simfs/ {print $2 " " $3 " " $5}\' && exit';
	$command =stripslashes($command);
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

	//Vérifie que la commande de restart est en cour
	//echo $rep.'<br>';
	$rep=str_replace("\n", " ", $rep);
	$string=explode(' ', $rep);
	if(count($string)>1){
    return array(
                'ram_total'     => $string[0],
                'ram_utilise'   => $string[1],
                'ram_restante'  => $string[2],
                'dd_total'      => $string[3],
                'dd_octect'     => $string[4],
                'dd_pourcent'   => $string[5]);
  }else{
    return false;
  }
}

//Code pour sauvegarder le transfert Réseau de chaque VPS
include ('bdd.php');
// Code d'origine

//$host='localhost';
//$base=''; 	// base 
//$blogin=''; 	// username
//$bpass='';	// votre code d'acces


//On prépare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);

//On récupère tous les vps
$sql_vps = "SELECT id,vmid,etat,id_server,status FROM vps WHERE status=1";
$req_vps = mysql_query($sql_vps) or die('Erreur SQL !<br>'.$$sql_vps.'<br>'.mysql_error());
//while($detail_vps = mysql_fetch_assoc($req_vps)){
while($detail_vps = mysql_fetch_assoc($req_vps)){
  //On récupère les info de connection en ssh au serveur
	$sql_vps_ssh = "SELECT id,host,login,password,port FROM serveur WHERE id=".$detail_vps['id_server'];
	$req_vps_ssh = mysql_query($sql_vps_ssh) or die('Erreur SQL !<br>'.$$sql_vps_ssh.'<br>'.mysql_error());
	$detail_vps_ssh = mysql_fetch_assoc($req_vps_ssh);
	
	//Créer la connection ssh
	$connection = ssh2_connect($detail_vps_ssh['host'],$detail_vps_ssh['port']);
	ssh2_auth_password($connection,$detail_vps_ssh['login'], $detail_vps_ssh['password']);

  //On récupère les transferts
  $rep=info($detail_vps['vmid'], $connection);
  
	//On ajoute l'etat du vps dans la base
	if($rep!=false){
    //On regarde si les données du vps existe déjà
    $sql_select="SELECT * FROM stats_mem_dd WHERE id_vps=".$detail_vps['id'];
    $result = mysql_query($sql_select);
    $num_rows = mysql_num_rows($result);
    
    if($num_rows>0){
      $sql_insert = "UPDATE stats_mem_dd 
                     SET ram_total='".MoToOctet($rep['ram_total'])."',
                         ram_use='".MoToOctet($rep['ram_utilise'])."',
                         disque_total='".ToOctet($rep['dd_total'])."',
                         disque_use='".ToOctet($rep['dd_octect'])."'
                     WHERE id_vps=".$detail_vps['id'];
                     
      $req_insert = mysql_query($sql_insert)or die('Erreur SQL !'.$sql_insert.'<br>'.mysql_error());
      //echo 'insert';
    }else{
    
      $sql_insert = "INSERT INTO stats_mem_dd (id,id_vps,ram_total,ram_use,disque_total,disque_use)
                    VALUES (
                    '',
                    '".$detail_vps['id']."',
                    '".MoToOctet($rep['ram_total'])."',
                    '".MoToOctet($rep['ram_utilise'])."',
                    '".ToOctet($rep['dd_total'])."',
                    '".ToOctet($rep['dd_octect'])."'
                   )";
      $req_insert = mysql_query($sql_insert)or die('Erreur SQL !'.$sql_insert.'<br>'.mysql_error());
      //echo 'create';
    }
	} 	
}

mysql_close($db_client);


?>
