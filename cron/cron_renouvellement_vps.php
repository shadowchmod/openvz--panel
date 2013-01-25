<?
$erreur = "0";


/*-----------------------------------------------------------*/
/*----------------FAIT PAR ------------------*/
/*----------Module de vérification des payement--------------*/
/*---------& et validation de la facture --------------------*/
/*-----------------Pour ------------------------------*/
/*-----------------------------------------------------------*/


	
 
	include ('bdd.php');
mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp

//on reucpere la conf par defaut du site
$time=time();
$reponse = mysql_query("SELECT * FROM invoice WHERE etat='3'  ") or die(mysql_error());
					while ($sql = mysql_fetch_array($reponse) )
					{
					$id_facture = $sql['id'];
						$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE  id_facture='$id_facture' AND etat='2'  AND cat_service='VPS' AND type_action='RRENEW' ") or die(mysql_error());
						while ($sql_corp = mysql_fetch_array($reponse_corp) )
						{
						$id_sql_corp = $sql_corp['id'];
									
									$jour_a_ajouter = $sql_corp['jour_add'];
									$id_service =  $sql_corp['id_service'];
									
										$reponse_vps = mysql_query("SELECT * FROM vps WHERE id='$id_service'  "); // Requête SQL
										while ($sql_vps = mysql_fetch_array($reponse_vps) )
										{
									$jour_a_ajouter += $sql_vps['expiration'];
									$avant_expiration = $sql_vps['expiration'];
										}
							mysql_query("UPDATE invoice_corp SET etat='3' WHERE id='$id_sql_corp'");
							mysql_query("UPDATE vps SET expiration='$jour_a_ajouter' WHERE id='$id_service'");
							mysql_query("UPDATE vps SET facture_prolongation='' WHERE id='$id_service'");
		$texte = 'Modification date expiration '.date('d/m/Y', $avant_expiration).' => '.date('d/m/Y', $jour_a_ajouter).' By ROBOT';
							mysql_query("INSERT INTO `action_vps` ( `id` , `id_vps` , `time` , `texte` )
VALUES (
NULL , '".$time."', 'TIME', 'TEXTE'
);");
						}
									
								
						
					}
					?>
