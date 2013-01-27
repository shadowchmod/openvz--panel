<?php
// ligne 40 et 41 (serveur backup)

	defined("INC") or die("403 restricted access");
	
	echo '<a href="index.php">< Retour aux vps</a><br/>';
	
	if (Session::Ouverte() && Session::$Client!=NULL && isset($_GET['vps']) && VPS::IsClientVPS(Session::$Client->Id,$_GET['vps']))
	{
	$vpsinfo=VPS::GetVPS($_GET['vps']);
		$detail_vps_ip=VPS::GetIP($_GET['vps']);
		
		$dns=$detail_vps_ip['reverse_original'];
	echo '<br/><br/>
			<fieldset><legend><strong>FTP backup - '.strtoupper($dns).'</strong></legend>';

		if  ( @$_GET['action'] == "create" )
		{
			$id_client=@Session::$Client->Id;
	$i=0;
	$vps=$_GET['vps'];
	$reponse_ticket = mysql_query("SELECT * FROM vps WHERE id_client='$id_client' AND id='$vps' "); // Requête SQL
			while ($sql = mysql_fetch_array($reponse_ticket) )
								{
								$ip=$sql['id_ip'];
								$i++;
								}
						$sql_ip = DB:: SQLToArray("SELECT * FROM ip WHERE id='$ip' limit 1 ");
						$reverse = $sql_ip[0]['reverse_original'];
		$ii=0;
		$req_backup = mysql_query("SELECT * FROM compte_ftp WHERE user='$reverse' ");
		while ($sql_back = mysql_fetch_array($req_backup))
		{
		$ii++;
		}
			if ( $i!=1 OR $ii!=0 )
			{
			echo "Ce VPS ne vous appartien pas ou vous avez deja un compte FTP ";
			}
			else
			{
		$connection = ssh2_connect('', 22);										// ip , port (22)
				ssh2_auth_password($connection, '', '');						// user, password
		
				$stream = ssh2_shell($connection, "xterm");
						
				$nom = $dns;
								
				$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
		
				$pass = rand('100000','999999');
				$password = $pass;
				$nom = $dns;
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
									mysql -u ftp -p267988 -D ftp -e \"INSERT INTO users (name ,pass) VALUES ('$nom', ENCRYPT( '$pass' )) \" &&
									mysql -u root -p267988 -e \"CREATE USER '$nom'@'localhost' IDENTIFIED BY '$pass';GRANT USAGE ON *.* TO '$nom'@'localhost' IDENTIFIED BY '$pass' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;CREATE DATABASE IF NOT EXISTS $nom;GRANT ALL PRIVILEGES ON $nom.* TO '$nom'@'localhost' \"
		
				";
				$command.=" \n";
				fwrite($stream,$command);
				//Attend que la commande s'ex?cute et termine
				sleep(5);
				//R?cup?re le r?sultat
				$rep="";
				while($line = fgets($stream)){
						$rep.=$line;	
				}
				//Ferme la connection
				fclose($stream);
				echo '<center><strong>Compte FTP mis en place !</strong></center>';
				echo '<meta http-equiv="Refresh" content="1;URL=index.php?page=ftpbackup&vps='.$_GET['vps'].'">';
				
		}
		
		}
		elseif (VPS::HasFTPBackup($_GET['vps']))
		{
			$ftpinfo=VPS::GetFTPBackup($_GET['vps']);
			echo '
			<table width="100%" border="0">
              <tr>
                <td width="180"><strong>Voici vos acces FTP : </strong></td>
                <td >&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
				
                <td>
				
				<table>
				<tr>
				<td width="50%">Host : </rd><td>backup.your-domaine.fr</td>
				</tr>
				<tr>
				<td>Nom d\'utilisateur : </td><td>'.$ftpinfo['user'].'</td>
				</tr>
				<tr>
				<td>Mot de passe : </td><td>'.$ftpinfo['password'].'</td>
				</tr>
				<tr>
				<td>Espace disponible : </td><td>100Go</td>
				</tr>
				</table><br/>
					';
			/*echo '
					Espace disque utilis&eacute; : '.SizeToText(VPS::UsedSpaceFTPBackup($_GET['vps'])).'<br/>';*/
			echo '	
			</td>
              </tr>
            </table>';

		}else{		
			echo '
			<div id="ftpbackupzone">
				<br/>
				<center>
					<a href="index.php?page=ftpbackup&vps='.$_GET['vps'].'&action=create">
						<strong>Crée un compte FTP</storng>
					</a>
				</center>
				<br/>
			</div>';
			
			
		}
		
		echo '
        </fieldset><br/>';
	}else{
		Message("Mauvaise d'URL",ALERTE);
	}
?>
