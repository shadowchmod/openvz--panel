<?
	defined("INC") or die("403 restricted access");
	
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	
	$id_client =  @Session::$Client->Id;
	
	$i=0;
	$ii=0;
	$reponse_invoice = mysql_query("SELECT * FROM invoice WHERE id_client='$id_client' "); // Requête SQL
			while ($sql_invoice = mysql_fetch_array($reponse_invoice) )
			{
			$ii+=1;
			}
			
		if ( $ii == 0 )
		{
echo "<center><strong>Vous n'avez aucune facture en cours.</center></strong>";
		}
		else
		{
		
	$reponse_invoice = mysql_query("SELECT * FROM invoice WHERE id_client='$id_client' "); // Requête SQL
			echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Numéro de facture</td>
								<td>Date</td>
								<td>Etat</td>
								<td>Montant</td>
								
								</tr>';
			while ($sql_invoice = mysql_fetch_array($reponse_invoice) )
			{
			$id_fature = $sql_invoice['id'];
			$price = "0";
					$req_prix = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$id_fature'");
					while ( $sql_price = mysql_fetch_array($req_prix))
					{
					$price += $sql_price['prix'];
					}
			$i+=1;
						
					
							if ($i%2==0)
							{
								echo '
						<tr class="tableimpair">';
							}else{
								echo '
						<tr class="tablepair">';
							}
							
							switch ($sql_invoice['etat'])
							{	
			
							case "1";
							$etat_name = "En attente de paiement";
							break;
							
							case "2";
							$etat_name = "Facture traitée";
							break;
							
							case "3";
							$etat_name = "En attente de traitement";
							break;
							
							case "4";
							$etat_name = "Facture erronée";
							break;
							
							case "5";
							$etat_name = "Facture non-payée";
							break;
							
							case "6";
							$etat_name = "Facture annulée";
							break;
							
							case "7";
							$etat_name = "Facture annulée";
							break;
							
							case "8";
							$etat_name = "Facture frauduleuse";
							break;
							
							case "9";
							$etat_name = "Paiement en attente de vérification";
							break;
							
							}
							$date_time = $sql_invoice['date_creat'];
							$date_formater = date('d/m/Y', $date_time);
								echo '							
								<td><center><a href="index.php?page=invoice&id='.$sql_invoice['facture'].'">'.$sql_invoice['facture'].'</a></center></td>
								<td><center>'.$date_formater.'</center></td>
								<td><center>'.$etat_name.'</center></td>
	<td><center>'.$price.'&euro;</center></td>								</tr>';
			
			}
			
			}
		
	 
?>