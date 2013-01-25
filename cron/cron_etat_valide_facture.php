<?
/*-----------------------------------------------------------*/
/*----------------FAIT PAR ------------------*/
/*----------Module de motdification de statu de facture------*/
/*-----------------Pour ------------------------------*/
/*-----------------------------------------------------------*/
/*
Ce script récupere tout les facture qui on un etat en attene de traitement
Regarde si les different element sont traiter si il sont traiter elle valide la facture.
*/

 
	include ('bdd.php');
mysql_connect($host, $blogin, $bpass); // Connexion à MySQL
mysql_select_db($base); // Sélection de la base coursphp



$req = mysql_query("SELECT * FROM invoice WHERE etat='3' ");

	while ( $var = mysql_fetch_array($req))
	{
	
		$id_facture = $var['id'];
	echo ''.$id_facture.'/'.$var['facture'].'==>';
		$i=0;
		$j=0;
		
		$inc = mysql_query("SELECT * FROM invoice_corp WHERE  id_facture='$id_facture'");
		
		while ( $var_corp = mysql_fetch_array($inc))
		{
		$i+=1;
		
			if ( $var_corp['etat'] == "3" )
			{
		$j+=1;
			}
			
		
		}
	if ( $i == $j )
	{
	echo "Facture Valider
	
	
	";
	mysql_query("UPDATE invoice SET etat='2' WHERE id='$id_facture'");
	}
	else
	{
	echo "Facture Non valider
	
	";
	}
	
	}

?>
