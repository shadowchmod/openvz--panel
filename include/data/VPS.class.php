<?php
// ajouter le nom de votre base de donnée  mysql
$nom_de_la_base_de_donnee = 'hd_panel';

class VPS
{
	public static function GetVPS($id)
	{
		$vpsarray=DB::SqlToArray("SELECT * FROM vps WHERE `id`='$id'");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	public static function GetVPSFull($id)
	{
		$vpsarray=DB::SqlToArray("SELECT `vps`.`id`, `vps`.`etat`, `ip`.`ip`, `ip`.`reverse_original`, `os`.`nom_os`, `plan`.`nom`
								FROM `vps` 
								LEFT OUTER JOIN `ip`
									ON `vps`.`id_ip` = `ip`.`id`
								LEFT OUTER JOIN `os`
									ON `vps`.`id_os` = `os`.`id`
								LEFT OUTER JOIN `plan`
									ON `vps`.`id_plan` = `plan`.`id`
								WHERE `vps`.`id`='$id'
								LIMIT 1");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	/**
	* Retourne la liste des clients
	*/
	public static function GetVPSList($page=1,$parPage=20,$sortid=0)
	{
		switch ($sortid)
		{
		case 0:
			$sort="`vps`.`id`";
			break;
		case 1:
			$sort="`ip`.`ip`";
			break;
		case 2:
			$sort="`ip`.`reverse_original`";
			break;
		case 3:
			$sort="`os`.`nom_os`";
			break;
		case 4:
			$sort="`plan`.`nom`";
			break;
		case 5:
			$sort="`vps`.`status`";
			break;
		case 6:
			$sort="`vps`.`etat`";
			break;	
		}

		$start=($page-1)*$parPage;
		$vpsarray=DB::SqlToArray("SELECT `vps`.`id`, `vps`.`etat`, `vps`.`status` , `ip`.`ip`, `ip`.`reverse_original`, `os`.`nom_os`, `plan`.`nom`
			FROM `vps` 
			LEFT OUTER JOIN `ip`
				ON `vps`.`id_ip` = `ip`.`id`
			LEFT OUTER JOIN `os`
				ON `vps`.`id_os` = `os`.`id`
			LEFT OUTER JOIN `plan`
				ON `vps`.`id_plan` = `plan`.`id`
			ORDER BY $sort ASC LIMIT $start , $parPage");
		
		return $vpsarray;
	}
	
	public static function GetVPSCount()
	{
		return DB::SqlCount("SELECT * FROM `vps`");
	}
	
	public static function GetFreeVPS()
	{
		return DB::SqlToArray("SELECT * FROM `vps` WHERE `id_client`=0");
	}	
	
	public static function VPSFromClient($id)
	{
		$id=ProtectSQL($id);
		$vpsarray=DB::SqlToArray("SELECT * FROM `vps` WHERE `id_client`='$id'");		
		return $vpsarray;
	}
	
	public static function GetIP($id)
	{
		$vpsinfo=VPS::GetVPS($id);
		$ipid=$vpsinfo["id_ip"];
		$vpsarray=DB::SqlToArray("SELECT * FROM ip WHERE `id`='$ipid'");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	public static function GetPlan($id)
	{
		$vpsinfo=VPS::GetVPS($id);
		$planid=$vpsinfo["id_plan"];
		$vpsarray=DB::SqlToArray("SELECT * FROM plan WHERE `id`='$planid'");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	public static function GetOS($id)
	{
		$vpsinfo=VPS::GetVPS($id);
		$osid=$vpsinfo["id_os"];
		$vpsarray=DB::SqlToArray("SELECT * FROM os WHERE `id`='$osid'");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	public static function GetServer($id)
	{
		$vpsinfo=VPS::GetVPS($id);
		$serverid=$vpsinfo["id_server"];
		$vpsarray=DB::SqlToArray("SELECT * FROM serveur WHERE `id`='$serverid'");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	public static function IsClientVPS($clientid, $vpsid)
	{
		$clientid=ProtectSQL($clientid);
		$vpsid=ProtectSQL($vpsid);
		if (DB::SqlCount("SELECT * FROM vps WHERE `id`='$vpsid' && `id_client`='$clientid'")==1)
			return true;
		else
			return false;
	}
	
	public static function HasFTPBackup($id)
	{
		$id=ProtectSQL($id);
		$vpsinfo=VPS::GetVPS($id);		
		$ipinfo=VPS::GetIP($id);
		$dns=$ipinfo['reverse_original'];
		if (DB::SqlCount("SELECT * FROM compte_ftp WHERE `user`='$dns'")==1)
			return true;
		else
			return false;
	}
	
	public static function GetFTPBackup($id)
	{
		$id=ProtectSQL($id);
		$vpsinfo=VPS::GetVPS($id);		
		$ipinfo=VPS::GetIP($id);
		$dns=$ipinfo['reverse_original'];
		$vpsarray=DB::SqlToArray("SELECT * FROM compte_ftp WHERE `user`='$dns'");
		if (count($vpsarray)==1)
			return $vpsarray[0];
	}
	
	public static function CreateVPS($planid,$serverid,$ipid,$vmid)
	{
		$planid=ProtectSQL($planid);
		$serverid=ProtectSQL($serverid);
		$ipid=ProtectSQL($ipid);
		$vmid=ProtectSQL($vmid);
		$requete = "INSERT INTO `$nom_de_la_base_de_donnee`.`vps` (`id`, `new`, `etat`, `status`, `id_client`, `vmid`, `id_ip`, `id_os`, `id_plan`, `id_server`, `TX_total`, `RX_total`, `TX_temp`, `RX_temp`) 
				VALUES (NULL, '1', '1', '0', '', '$vmid', '$ipid', '', '$planid', '$serverid', '0', '0', '0', '0')";
				
		if (DB::Sql($requete))
		{
			$id=DB::GetInsertId();
			return $id; // retourne l'id du VPS
		}else{
			return false;
		}
	}

//--------------------------------requette myslq pour ajouter un serveur proxmox
//requette mysql
// id - login - password - ip - host - nom - etat - port        
	public static function Serveur_Root($login,$password,$ip,$host,$nom,$etat,$port)
        {
		//protectionSQL
                $login=ProtectSQL($login);
                $password=ProtectSQL($password);
                $ip=ProtectSQL($ip);
                $host=ProtectSQL($host);
		$nom=ProtectSQL($nom);
		$etat=ProtectSQL($etat);
		$port=ProtectSQL($port);

                $requete = "INSERT INTO `$nom_de_la_base_de_donnee`.`serveur` (`id`, `login`, `password`, `ip`, `host`, `nom`, `etat`, `port`)
                                VALUES (NULL, '$login', '$password', $ip', $host'', 'nom', '$etat', '$port')";
                                
                if (DB::Sql($requete))
                {
                        $id=DB::GetInsertId();
                        return $id; // retourne l'id serveur vps
                }else{
                        return false;
                }
        }
//-------------------------------------------

	public static function LinkVPSToClient($vpsid,$clientid)
	{
		$requete = "UPDATE `$nom_de_la_base_de_donnee`.`vps` SET `id_client` = '$clientid' WHERE `vps`.`id` ='$vpsid' LIMIT 1";
		if (DB::Sql($requete))
		{
			return true;
		}else{
			return false;
		}
	}
	
	public static function BlockVPSToClient($vpsid)
	{
		$requete = "UPDATE `$nom_de_la_base_de_donnee`.`vps` SET `etat` = 0 WHERE `vps`.`id` ='$vpsid' LIMIT 1";
		if (DB::Sql($requete))
		{
			return true;
		}else{
			return false;
		}
	}
	
	public static function DeblockVPSToClient($vpsid)
	{
		$requete = "UPDATE `$nom_de_la_base_de_donnee`.`vps` SET `etat` = 1 WHERE `vps`.`id` ='$vpsid' LIMIT 1";
		if (DB::Sql($requete))
		{
			return true;
		}else{
			return false;
		}
	}
	
	public static function Reboot($id)
	{
		$id=ProtectSQL($id);
		if (Session::Ouverte() && VPS::IsClientVPS(Session::$Client->Id,$id))
		{
			$vpsinfo=VPS::GetVPS($id);
			$serverinfo=VPS::GetServer($id);
			//Cr�er la connection ssh
			$res=false;
			passer_message_info("Erreur de red�marrage (server ssh error)",ALERTE);
			//sleep(2); // � enlever
			$connection = ssh2_connect($serverinfo['host'],$serverinfo['port']);
			ssh2_auth_password($connection,$serverinfo['login'], $serverinfo['password']);
			effacer_message_info();
			$res=restart_vps($vpsinfo["vmid"],$connection);			
			if($res)
			{
				DB::Sql("INSERT INTO reboot (id,id_vps,date,heure,id_client)VALUES ('','$id', '".date('Y/m/d')."','".date('G:i:s')."','".Session::$Client->Id."')");
				DB::Sql("UPDATE vps SET status=2 WHERE id=$id");
				passer_message_info("VPS red�marrer",OK);
				return true;
			}else{
				passer_message_info("Erreur de red�marrage",ALERTE);
				return false;
//				passer_message_info($serverinfo['host']." - ".$serverinfo['port'],ALERTE);
//				passer_message_info($serverinfo['login']." - ".$serverinfo['password'],ALERTE);
//				passer_message_info($id." - ".$connection,ALERTE);
			}			
		}else{
			passer_message_info("Vous ne poss�dez pas des droits requis pour controler ce VPS",ALERTE);
			return false;
		}
	}
	
	public Static function ReInstall($id,$osid,$passroot)
	{
		$id=ProtectSQL($id);
		//$osid=ProtectSQL($osid);
		$passroot=ProtectSQL($passroot);		
		if (Session::Ouverte() && VPS::IsClientVPS(Session::$Client->Id,$id))
		{
			$vpsinfo=VPS::GetVPS($id);
			$ipinfo=VPS::GetIP($id);			
			$serverinfo=VPS::GetServer($id);
			$planinfo=VPS::GetPlan($id);
			$osinfo=OS::GetOS($osid);
			//$mess=$vpsinfo['id'].' '.$vpsinfo['id_plan'].' '.$vpsinfo['id_server'].' '.$vpsinfo['vmid'].' '.$serverinfo['host'].' '.$serverinfo['port'].' '.$serverinfo['login'].' '.$serverinfo['password'].' '.$osid.' '.$osinfo['fichier'];
			//mail("aure.loiseaux@laposte.net","prop",$mess);
			passer_message_info("Erreur d'installation (server ssh error)",ALERTE);	
			//sleep(2); // � enlever
			$connection = ssh2_connect($serverinfo['host'],$serverinfo['port']);
			ssh2_auth_password($connection,$serverinfo['login'], $serverinfo['password']);			
			//$connection=0;
			if($vpsinfo['new']==0)
			{
				$res=reinstall_vps($vpsinfo['vmid'], $connection, $osinfo['fichier'], $ipinfo['reverse_original'], $planinfo['disque'], $ipinfo['ip'], $planinfo['ram'], $planinfo['ram'], $planinfo['nbr_cpu'], $passroot);
			}else{
				$res=install_new_vps($vpsinfo['vmid'], $connection, $osinfo['fichier'], $ipinfo['reverse_original'], $planinfo['disque'], $ipinfo['ip'], $planinfo['ram'], $planinfo['ram'], $planinfo['nbr_cpu'], $passroot);
			}
			effacer_message_info();			
			if($res)
			{
				//Insert dans la table reinstallation
				DB::Sql("INSERT INTO reinstallation (id,id_vps,id_os,date,heure,id_client)VALUES ('','$id', '$osid','".date('Y/m/d')."','".date('G:i:s')."','".$vpsinfo['id_client']."')");

				//Insert dans la table vps le nouveau OS
				DB::Sql("UPDATE vps SET id_os='$osid', new=0 WHERE id=$id");
				//Envoi du mail
				mail_reinstal(Session::$Client->Email,
							  Session::$Client->Nom,
							  Session::$Client->Prenom,
							  $osinfo['nom_os'],
							  $ipinfo['ip'],
							  $ipinfo['reverse_original'],
							  $passroot);
				
				if($vpsinfo['new']==0){
					passer_message_info("Reinstallation  reussi !",OK);
				}else{
					passer_message_info("Installation  reussi !",OK);
				}
			}else{
				passer_message_info("Erreur !",ALERTE);
			}
		}else{
			passer_message_info("Vous ne poss�dez pas des droits requis pour controler ce VPS",ALERTE);
		}
	}
	
	public static function UsedSpaceFTPBackup($id)
	{
		$id=ProtectSQL($id);
		if (Session::Ouverte() && VPS::IsClientVPS(Session::$Client->Id,$id))
		{
			$vpsinfo=VPS::GetVPS($id);
			$ipinfo=VPS::GetIP($id);			
			$dns=$ipinfo['reverse_original'];
			
			if ($dns)
			{
				$command = "du /home/$dns | tail -n1 | cut -f1";
	
				$connection = ssh2_connect(VPS_ACCESS_HOST, 22);
				ssh2_auth_password($connection, VPS_ACCESS_USER, VPS_ACCESS_PASS);
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
				return $rep;
			}
		}
		return 0;
	}
	
	public static function CreateFTPBackup($id)
	{
		$id=ProtectSQL($id);
		if (Session::Ouverte() && VPS::IsClientVPS(Session::$Client->Id,$id))
		{
			$vpsinfo=VPS::GetVPS($id);
			$ipinfo=VPS::GetIP($id);			
			$dns=$ipinfo['reverse_original'];
			
			passer_message_info("Erreur d'installation (server ssh error)",ALERTE);	
			
			//sleep(2); // � enlever
			if ($dns)
			{			
				$connection = ssh2_connect('ks305836.kimsufi.com', 22); //
				ssh2_auth_password($connection, 'root', '74123');  //
		
				$stream = ssh2_shell($connection, "xterm"); 
						
				$nom = $dns;
								
				$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
		
				$pass = rand('100000','999999');
				$password = $pass;
				$nom = $detail_vps_ip['reverse_original'];
				mysql_query("INSERT INTO compte_ftp VALUES('', '".$nom."', '".$password."', '')");
				$command = "mkdir /home/$nom &&
									chown -R www-data.www-data /home/$nom &&
									chmod -R 700 /home/$nom && 
									echo \"anon_world_readable_only=NO\" > /etc/vsftpd/$nom &&
									echo \"local_root=/home/$nom\" >> /etc/vsftpd/$nom &&
									echo \"write_enable=YES\" >> /etc/vsftpd/$nom &&
									echo \"anon_upload_enable=YES\" >> /etc/vsftpd/$nom &&
									echo \"anon_mkdir_write_enable=YES\" >> /etc/vsftpd/$nom &&
									echo \"anon_other_write_enable=YES\" >> /etc/vsftpd/$nom &&
									echo \"hide_file=(none)\" >> /etc/vsftpd/$nom &&
									echo \"force_dot_files=YES\" >> /etc/vsftpd/$nom &&
									mysql -u ftp -p267988 -D compte_ftp -e \"INSERT INTO users (name ,pass) VALUES ('$nom', ENCRYPT( '$pass' )) \" &&
									mysql -u root -p267988 -e \"CREATE USER '$nom'@'localhost' IDENTIFIED BY '$pass';GRANT USAGE ON *.* TO '$nom'@'localhost' IDENTIFIED BY '$pass' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;CREATE DATABASE IF NOT EXISTS $nom;GRANT ALL PRIVILEGES ON $nom.* TO '$nom'@'localhost' \"
		
				";
				$command.=" \n";
				fwrite($stream,$command);
				//Attend que la commande s'ex�cute et termine
				sleep(5);
				//R�cup�re le r�sultat
				$rep="";
				while($line = fgets($stream)){
						$rep.=$line;	
				}
				//Ferme la connection
				fclose($stream);
				
				effacer_message_info();	
				passer_message_info("FTP creer",OK);
				return true;
			}else{
				effacer_message_info();	
				passer_message_info("Erreur lors de la creation du FTP",ALERTE);
				return true;
			}
		}else{
			passer_message_info("Vous ne possedez pas des droits requis pour controler ce VPS",ALERTE);
			return false;
		}
	}
	public static function ModifRoot($id,$passroot)
	{
		$id=ProtectSQL($id);
		if (Session::Ouverte() && VPS::IsClientVPS(Session::$Client->Id,$id))
		{
			$vpsinfo=VPS::GetVPS($id);
			$serverinfo=VPS::GetServer($id);
			//Cr�er la connection ssh
			$res=false;
			passer_message_info("Erreur de redemarrage (server ssh error)",ALERTE);
			$connection = ssh2_connect($serverinfo['host'],$serverinfo['port']);
			ssh2_auth_password($connection,$serverinfo['login'], $serverinfo['password']);
			effacer_message_info();
			$res=modif_root($vpsinfo["vmid"],$connection,$passroot);			
			if($res)
			{
				passer_message_info("Mot de pass root modifie",OK);
				return true;
			}else{
				passer_message_info("Erreur lors du changement du mot de passe",ALERTE);
				return false;
			}			
		}else{
			passer_message_info("Vous ne possedez pas des droits requis pour controler ce VPS",ALERTE);
			return false;
		}
	}

		public static function DeleteVPS($vpsid)
	{
    $vpsinfo=VPS::GetVPS($vpsid);
		$serverinfo=VPS::GetServer($vpsid);
		
		//Créer la connection ssh
		$connection = ssh2_connect($serverinfo['host'],$serverinfo['port']);
		ssh2_auth_password($connection,$serverinfo['login'], $serverinfo['password']);
		effacer_message_info();
		$res=destroy_vps($vpsinfo["vmid"],$connection);			
		if($res==false){
      passer_message_info("Erreur de suppression du VPS sur la machine",ALERTE);}
    //Suppression OK
    $requete_vps = "DELETE FROM vps WHERE id='$vpsid' LIMIT 1";
    $requete_ip = "UPDATE ip SET dispo=1 WHERE id='".$vpsinfo['id_ip']."' LIMIT 1";
    if (DB::Sql($requete_vps) && DB::Sql($requete_ip)){
      passer_message_info("VPS supprimé avec succès !",OK);
      return true;
    }else{
      passer_message_info("Erreur de supression vps dans SQL !",ALERTE);
      return false;
    }
  }

}

?>
