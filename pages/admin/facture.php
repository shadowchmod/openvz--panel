<?
	defined("INC") or die("403 restricted access");
	
	echo '<a href="index.php">< Retour aux panneaux</a><br/><br/>';
	
	$id_client =  @Session::$Client->Id;
	
	$i=0;
	$ii=0;
	$reponse_invoice = mysql_query("SELECT * FROM invoice  "); // Requête SQL
			while ($sql_invoice = mysql_fetch_array($reponse_invoice) )
			{
			$ii+=1;
			}
			
		if ( $ii == 0 )
		{
echo "<center><strong>Vous n'avez aucune facture en cour.</center></strong>";
		}
		else
		{
		
	$reponse_invoice = mysql_query("SELECT * FROM invoice  "); // Requête SQL
			echo '<table width="100%" border="0">
								<tr class="tabletitle">
								<td>Numéro de facture</td>
								<td>Client</td>
								<td>Date de création</td>
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
			$id_client_billing = $sql_invoice['id_client'];
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
							$etat_name = "En attente de payement";
							break;
							
							case "2";
							$etat_name = "Facture traité";
							break;
							
							case "3";
							$etat_name = "En attente de traitement";
							break;
							
							case "4";
							$etat_name = "Facture erroné";
							break;
							
							case "5";
							$etat_name = "Facture non payer";
							break;
							
							case "6";
							$etat_name = "Facture annuulé";
							break;
							
							case "7";
							$etat_name = "Facture annuulé";
							break;
							
							case "8";
							$etat_name = "Facture froduleuse";
							break;
							
							
							case "9";
							$etat_name = "Payement en attente de vérification";
							break;
							
							}
							$date_time = $sql_invoice['date_creat'];
							$date_formater = date('d/m/Y - H:i:s', $date_time);
							
							$reponse_client = mysql_query("SELECT * FROM client WHERE id='$id_client_billing' "); // Requête SQL
						while ($sql_client = mysql_fetch_array($reponse_client) )
						{
						$nom_client = $sql_client['nom'];
						$prenom_client = $sql_client['prenom'];
						}
								echo '							
								<td><center><a href="index.php?page=admin/invoice&id='.$sql_invoice['facture'].'">'.$sql_invoice['facture'].'</a></center></td>
								<td><center>'.$nom_client.' '.$prenom_client.'</center></td>
								<td><center>'.$date_formater.'</center></td>
								<td><center>'.$etat_name.'</center></td>
								<td><center>'.$price.'€</center></td>
								</tr>';
			
			}
			
			}
		
	 
?>
