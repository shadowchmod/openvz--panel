<?
//    defined("INC") or die("403 restricted access");
 echo '<a href="index.php"> Retour aux panneaux</a><br/><br/>';
	if ( isset ( $_POST['invoice'] ) )
	{
	$invoice = $_POST['invoice'];
	$montant = $_POST['montant'];
	$id_transaction = $_POST['id_transaction'];
	$type_payement =  $_POST['type_payement'];
	$etat =  $_POST['etat'];
	
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
					'ADMIN',
					'".$invoice."',
					'".$id_transaction."',
					'".$type_payement."',
					'".$montant."',
					'".$etat."',
					'Administrateur',
					'".$time."'
					)") or die(mysql_error());
	
	echo '<center><strong>Paiement ajout&eacute; avec succes ! !</center></strong>';
	
	}
	echo '<fieldset><legend><strong>Assistant de cr&eacute;ation de facture - Etape 2 (Renouvellement VPS)</strong></legend>';

	echo '<form id="form1"  name="form1" method="POST" action="index.php?page=admin/add_payement">
						  <table>
						<tr>
							<td><span style="margin-left:100px;">Pour quelle facture ? : </td>
							<td><select name="invoice">';
							$reponse = mysql_query("SELECT * FROM invoice WHERE etat='1' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
							echo '<option value="'.$sql['id'].'">'.$sql['facture'].'</option>';	
								}
							echo '</select>
							</tr>
							
							<tr>
							<td><span style="margin-left:100px;">Quelle montant ?</td>
							<td><input type="text" name="montant"></td>
							</tr>
							
							<tr>
							<td><span style="margin-left:100px;">ID transaction</td>
							<td><input type="text" name="id_transaction"></td>
							</tr>
							
							<tr>
							<td><span style="margin-left:100px;">Type paiement</td>
							<td><input type="text" name="type_payement"></td>
							</tr>
				
							<tr>
							<td><span style="margin-left:100px;">Etat</td>
							<td><select name="etat">
							<option value="1">Paiement accept&eacute;</option>
							<option value="2">Paiement en attente de v&eacute;rification</option>
							<option value="3">Paiement frauduleux</option>
							<option value="4">Paiement annulé</option>
							<option value="5">Paiement &eacute;choué</option>
							<option value="6">Paiement rembours&eacute; (Pensez a mettre "-" devant le montant)</option>
							
							</select></td>
							</tr>
							
							<tr>
							<td><span style="margin-left:100px;">Action</td>
							<td><input type="submit" ></td>
							</tr>
						 </table>
						</form>	';

	echo '</fieldset>';

?>
