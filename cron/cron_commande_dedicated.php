<?
$erreur = "0";


/*-----------------------------------------------------------*/
/*----------------FAIT PAR ATTARD ------------------*/
/*----------Module de vérification des payement--------------*/
/*---------& et validation de la facture --------------------*/
/*-----------------Pour ------------------------------*/
/*-----------------------------------------------------------*/


 
	include ('bdd.php');
mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp
//on reucpere la conf par defaut du site

$reponse = mysql_query("SELECT * FROM invoice WHERE etat='3'  ") or die(mysql_error());
					while ($sql = mysql_fetch_array($reponse) )
					{
					$id_facture = $sql['id'];
						$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE  id_facture='$id_facture' AND etat='2'  AND cat_service='DEDICATED' AND type_action='ACHAT' ") or die(mysql_error());
						while ($sql_corp = mysql_fetch_array($reponse_corp) )
						{		
						$ip_prix = $sql_corp['id_prix'];
						$id_sql_corp = $sql_corp['id'];
						$text_invoice_corp =  $sql_corp['texte'];
						$id_client = $sql['id_client'];
						
						
				$sql_price =  mysql_query("SELECT * FROM prix_service WHERE id='$ip_prix' limit 1 ");
				while ($sqll_price = mysql_fetch_array($sql_price) )
						{
						
				$jour_prix = $sqll_price['jour_texte'];
				$id_plan = $sqll_price['service_id'];
				}
				
				
				$sql_plan =  mysql_query("SELECT * FROM plan_dedicated WHERE id='$id_plan' limit 1 ");
					while ($sqll_plan = mysql_fetch_array($sql_plan) )
					{
				$nom_plan = $sqll_plan['nom_plan'];
				}
									$id_service =  $sql_corp['id_service'];
									
						$texte = ''.$text_invoice_corp.' ('.$jour_prix.') pour  le client  '.$id_client.' ';
						$time = time();
						mysql_query("INSERT INTO `tache_admin` ( `id` , `date` , `for` , `texte` , `sujet` , `etat` )
VALUES (
NULL , '".$time."', '1', '".$texte."', 'Comande de dédié', '1'
)");
							mysql_query("UPDATE invoice_corp SET etat='3' WHERE id='$id_sql_corp'");
						}
									
								
						
					}
					?>
