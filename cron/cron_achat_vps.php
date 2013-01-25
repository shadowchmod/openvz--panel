<?
$erreur = "0";


/*-----------------------------------------------------------*/
/*----------------FAIT PAR [-------------]-------------------*/
/*----------Module de vérification des payement--------------*/
/*---------& et validation de la facture --------------------*/
/*-----------------Pour [-----]------------------------------*/
/*-----------------------------------------------------------*/

// voir ligne 42, 109, 116
 
	include ('bdd.php');
 mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp
//on reucpere la conf par defaut du site

$reponse = mysql_query("SELECT * FROM invoice WHERE etat='3'  ");
					while ($sql = mysql_fetch_array($reponse) )
					{

					$id_client =  $sql['id_client'];
					$id_facture = $sql['id'];
					
	$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE  id_facture='$id_facture' AND etat='2'  AND cat_service='VPS' AND type_action='ACHAT' ") or die(mysql_error());
						while ($sql_corp = mysql_fetch_array($reponse_corp) )
						{
						$text_corp = $sql_corp['text'];
						$ip_price = $sql_corp['id_prix'];
					$time_add = $sql_corp['jour_add'];					
						$id_sql_corp = $sql_corp['id'];
									
									//on recupere les ip dispo
									$req = mysql_query("SELECT * FROM ip WHERE dispo='1' limit 1 ") or die(mysql_error());
									while ($ip_dispo = mysql_fetch_array($req) )
									{
									$id_ip_dispo = $ip_dispo['id'];
									$reverse_ip_dispo = $ip_dispo['reverse_original'];
									$ip_du_vps_en_question = $ip_dispo['ip'];
									$vmid = str_replace('vps', '', $reverse_ip_dispo);
									$vmid = str_replace('.your-domaine.fr', '', $vmid);
								mysql_query("UPDATE ip SET dispo='0' WHERE id='$id_ip_dispo'");
								
									}
							$req_sql_price = mysql_query("SELECT * FROM prix_service WHERE id='$ip_price' ");
									while ( $sql_price = mysql_fetch_array($req_sql_price))
									{
									$id_plan = $sql_price['service_id'];
									
									
									}
									



$time = time();
$time_expire = $time + $time_add;

mysql_query("INSERT INTO `vps` ( `id` , `id_vps_whmcs` , `new` , `etat` , `status` , `id_client` , `vmid` , `id_ip` , `id_os` , `id_plan` , `id_server` , `TX_total` , `RX_total` , `TX_temp` , `RX_temp` , `deb_TX` , `deb_RX` , `expiration` , `creation` , `commentaire` , `facture_prolongation` , `facture` , `generate_invoice` )
VALUES (
NULL ,
 '',
 '1',
 '1',
 '1',
 '".$id_client."',
 '".$vmid."',
 '".$id_ip_dispo."',
 '',
 '".$id_plan."',
 '2',
 '0',
 '0',
 '0',
 '0',
 '',
 '',
 '".$time_expire."',
 '".$time."',
 '',
 'NULL',
 'NULL',
 '1'
)") or die(mysql_error());
		$message_vps_ajout = '
			
			
<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
<br />
Bonjour,<br /><br />

Nous somme heureux de vous informer qu&#145;un VPS vient d&#145;etre crée sur votre compte client :<br /><br />

Information sur le VPS : <br />

Reference : #'.$vmid.'<br />

Type de VPS : VPS0<br />

Ip du VPS : '.$ip_du_vps_en_question.'<br />

Reverse : '.$reverse_ip_dispo.'<br />

Lien de connexion : http://panel.your-domaine.info<br /><br />

<i>Votre serveur est pret a etre installer, une fois sur votre panel vous pourrez installer votre VPS sur l os de votre choix.</i><br />


';
	
						$sujet = 'Ajout d&#145;un VPS sur votre compte [votre entreprise]';
$time = time();

mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message_vps_ajout."'
)") or die(mysql_error());
		
		$text_corp = '#'.$reverse_ip_dispo.' - '.$text_corp.'';
							mysql_query("UPDATE invoice_corp SET etat='3', text='$text_corp' WHERE id='$id_sql_corp'");
							
		echo 'VPS cree => '.$vmid.'
		
		';				
							
							
							
							
						}
									
								
						
					}
					?>
