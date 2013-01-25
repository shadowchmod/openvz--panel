<?
 								// voir ligne 32, 33, 34, 54
	include ('bdd.php');
 mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp
echo '
		--------------------------------------------------------------
		|  VPS  |       IP        | ETAT IP |   PING  |ETAT VPS |ETAT DISQUE |
';
$req_ip = mysql_query("SELECT * FROM ip WHERE dispo='0'  ");
	while ( $sql = mysql_fetch_array($req_ip))
	{
	
	$i=0;
	$id_ip = $sql['id'];
	$ip = $sql['ip'];
	$reverse_ip_dispo = $sql['reverse_original'];
			$req_vps = mysql_query("SELECT * FROM vps WHERE id_ip='$id_ip' ");
			while ($sql_ip = mysql_fetch_array($req_vps))
			{
				if ( $sql_ip['id_ip'] == $id_ip )
				{
				$id_vps = $sql_ip['id'];
				$i=1;
				}
			
			}
	if ( $i = 1 )
	{
	
						$vmid = str_replace('vps', '', $reverse_ip_dispo);
		$vmid = str_replace('.your-domaine.fr', '', $vmid); 	//remplacer your domaine
$connection = ssh2_connect('your-ip-nom-domaine', 22);			//modificaton de host
ssh2_auth_password($connection, '', '');			//modification de l'username et votre mot de passe 

$stream = ssh2_exec($connection, 'vzctl status '.$vmid.'');
	stream_set_blocking($stream, true);
  
 

  $rep="";
	while($line = fgets($stream)){
		$rep.=$line;	
	}
	

$temp = explode(" ",$rep);





							$connect = TRUE; // Autoriser ou non la connexion
				$port = 22; // Port du serveur
				
				


				if (! $sock = @fsockopen($ip, $port, $num, $error, 5))
				{
 echo '		------------------------------------------------------------------
		|  '.$id_vps.'  |  '.$sql['ip'].'  |   OK    |  ERREUR |  '.$temp[2].'|  '.$temp[3].' | '.$temp[4].' ';


				}else{
				// Si il est en ligne
 echo '		------------------------------------------------------------
		|  '.$id_vps.'  |  '.$sql['ip'].'  |   OK    |    ok   |  '.$temp[2].'  |   '.$temp[3].'  | '.$temp[4].' ';


				
}
					

	
	}		
	else
	{
	echo 'IP ERROR
	';
	}

	
	
	
	
	
	}


echo '			------------------------------------------';
?>
