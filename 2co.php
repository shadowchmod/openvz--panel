<?

mysql_connect("localhost", "", ""); // Connexion à MySQL
mysql_select_db(""); // Sélection de la base coursphp

// remplacer par votre site web   your-website

$type = @$_GET['type'];


$sid = @$_REQUEST["sid"];

	if ($sid == "1403583")
	{
	
	$facture = $_POST["test_id"];
	$key = $_POST["key"];
		if ( $_POST["total"] == $_REQUEST["total"] )
		{
		$transaction_id = $_POST["order_number"];
		
		
		$price = $_POST["total"] ;
		
					
					
				
	
				$sql_vps = mysql_query("SELECT * FROM invoice WHERE facture='$facture' limit 1 ");
				while ( $sql_bil = mysql_fetch_array($sql_vps ))
				{
				$facture_number = $sql_bil['id'];
				}
							
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
		
			echo '<img src="http://panel.your-website.info/images/logo_cmd_web.png" style="float:left;"><br /><br /><br /><br /> ';
							echo "<center><strong>Votre payement a bien etait valider, voici les details de la transaction : <br></center></strong><br /><br />";

							
			echo '<center><table width="50%" border="1">
								<tr >
								<td>Num&eacute;ro de transation</td>
								<td>'.$transaction_id.'</td>
								</tr>
								
								
								<tr >
								<td>Num&eacute;ro de facture</td>
								<td>'.$facture.'</td>
								</tr>
								
								<tr >
								<td>Ip de payement</td>
								<td>'.$ip.'</td>
								</tr>
								
								<tr >
								<td>Methode de payement</td>
								<td>2CO</td>
								</tr>
								
								<tr >
								<td>Date et heur :</td>
								<td>'.date('d/m/Y - H:i:s').'</td>
								</tr>
								</table></center><br /><br />
								';
								
												echo '<br><center><a href="http://panel.your-website.info/index.php?page=invoice&id='.$facture.'">Retournez sur la facture</a></center>';

								
								
				
		
		
		
		}
	
	}



?>
