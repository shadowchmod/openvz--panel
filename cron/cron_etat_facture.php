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



$reponse = mysql_query("SELECT * FROM invoice WHERE etat='1' "); // Requête SQL
while ($sql = mysql_fetch_array($reponse) )
{
$id_client=$sql['id_client'];
$id_facture = $sql['id'];
$time=time();
// on initilaise la valirable du total des payement
$payement_total = "0";		
$init_price_verification = "0";
$payement_frauduleux = "0";
$prix_calcul = "0";

	$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$id_facture' AND etat='1' "); // Requête SQL
	while ($sql_corp = mysql_fetch_array($reponse_corp) )
	{
	$id_facture_prix = $sql_corp['id_prix'];
			
			
					
						$prix_calcul += $sql_corp['prix'];
						
						
						
	}
	
					$reponse_payement = mysql_query("SELECT * FROM payement WHERE id_facture='$id_facture' AND etat='1' "); // Requête SQL
					while ($sql_payement = mysql_fetch_array($reponse_payement) )
					{
					$payement_total += $sql_payement['montant'];
					}
			
			
					if ( $payement_total >= $prix_calcul)
					{
						$reponse_payement_verif = mysql_query("SELECT * FROM payement WHERE etat='3' "); // Requête SQL
						while ($sql__payement_verif = mysql_fetch_array($reponse_payement_verif) )
						{
						$payement_frauduleux += 1;
						}
								if ( $payement_frauduleux == 0 )
								{
								echo "facture payer en totalité !";
								mysql_query("UPDATE invoice SET etat='3' WHERE id='$id_facture'");
								$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$id_facture' AND etat='1' "); // Requête SQL
								while ($sql_corp = mysql_fetch_array($reponse_corp) )
									{
									$id_corp = $sql_corp['id']; 
								mysql_query("UPDATE invoice_corp SET etat='2' WHERE id='$id_corp'");
									}
								}
								else
								{
								mysql_query("UPDATE invoice SET etat='9' WHERE id='$id_facture'");
								
$sujet = 'Validation de la facture #'.$facture.'[votre entreprise]';
$message = '


<br /><br /><br />
Fait le '.date('d/m/y').' a '.date('H:i:s').' a Roubaix.
<br /><br /><br />
Bonjour,<br />
<br />
La facture N°'.$facture.' vient detre valider par un de nos administrateur. <br /><br />


Votre commande sera donc traiter dans un delai de 1H en moyenne.<br /><br />


Si votre facture nes pas marquer comme valider dans un delai de 24H merci de nous contactez.<br /><br />

';
$time = time();
mysql_query("INSERT INTO `email` ( `id` , `id_client` , `mail` , `sujet` , `time` , `prioriter` , `etat` , `text` ) 
VALUES (
NULL , '".$id_client."', '', '".$sujet."', '".$time."', '1', '1', '".$message."'
)") or die(mysql_error());
								$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$id_facture' AND etat='1' "); // Requête SQL
								while ($sql_corp = mysql_fetch_array($reponse_corp) )
									{
									$id_corp = $sql_corp['id']; 
								mysql_query("UPDATE invoice_corp SET etat='6' WHERE id='$id_corp'");
								
									}
								}
					
					}

					}
?>
