<?
$type = @$_GET['type'];


$sid = $_REQUEST["sid"];

	if ($sid == "1403583")
	{
	
	$facture = $_POST["test_id"];
	$key = $_POST["key"];
		if ( $_POST["total"] == $_REQUEST["total"] )
		{
		$transaction_id = $_POST["order_number"];
		
		
		$price = $_POST["total"] ;
		
					
					
				echo "<center><strong>Votre payement a bien etait valider, voici les details de la transaction : <br></center></strong>";
				
	
				$sql_vps = DB:: SQLToArray("SELECT * FROM invoice WHERE facture='$facture' limit 1 ");
							$facture_number = $sql_vps[0]['facture'];
	$ip = $_SERVER['REMOTE_ADDR'];
					$time = time();
					mysql_query("INSERT INTO payement(
					id_client,
					id_facture,
					id_transaction,
					id_type_payement,
					montant,
					etat,
					ip_client,
					date)
					VALUES (
					'',
					'".$facture_number."',
					'".$transaction_id."',
					'2CO',
					'".$price."',
					'1',
					'".$ip."',
					'".$time."'
					)") or die(mysql_error());
				
	echo '<table width="100%" border="0">
								<tr class="tableimpair">
								<td>Numéro de transation</td>
								<td>'.$transaction_id.'</td>
								</tr>
								
								
								<tr class="tableimpair">
								<td>Numéro de facture</td>
								<td>'.$facture.'</td>
								</tr>
								
								<tr class="tablepair">
								<td>Ip de payement</td>
								<td>'.$ip.'</td>
								</tr>
								
								<tr class="tableimpair">
								<td>Methode de payement</td>
								<td>Allopass</td>
								</tr>
								
								<tr class="tablepair">
								<td>Date et heur :</td>
								<td>'.date('d/m/Y - H:i:s').'</td>
								</tr>
								
								';
								
								
				
				echo '<br><center><a href="index.php?page=invoice&id='.$facture.'">Retournez sur la facture</a></center>';
		
		
		
		}
	
	}



?>