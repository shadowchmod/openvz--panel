<?


defined("INC") or die("403 restricted access");
	echo '<a href="index.php">< Retour aux vps</a><br/><br/>';
	$id_client=@Session::$Client->Id;
	if ( isset ( $_GET['id'] ) )
	{
	$id_facture = $_GET['id'];
	}
	$type=$_GET['type'];
	$error_msg = "";
	$erreur = "";
	if ( $type == "allopass" )
	{
		if ( isset ( $_GET['action'] ) )
			{
			
				if ( $_GET['action'] == "send" )
				{
						$id_facture = $_SESSION['id_facture'];
						$_SESSION['id_facture'] = NULL;
						
						
						$datas = $_GET['DATAS'];
						
						
						

					  $RECALL = $_GET["RECALL"];
					  if( trim($RECALL) == "" )
					  {
						
						header( "Location: erreur.html" );
						exit(1);
					  }
					 $code1 = "170550";
					 $code3 = "2258711";
					  $RECALL = urlencode( $RECALL );
						if ( $datas == 780026)
						{
						  $prix_add = "1,00";
						  $AUTH = urlencode( "". $code1."/".$datas."/". $code3."" );
						}
						elseif ( $datas == 780039)
						{
							$prix_add = "2,00";
						  $AUTH = urlencode( "". $code1."/".$datas."/". $code3."" );
						}
						elseif ( $datas == 780040)
						{
							$prix_add = "3,00";
						  $AUTH = urlencode( "". $code1."/".$datas."/". $code3."" );
						}
						elseif ( $datas == 780042)
						{
							$prix_add = "4,00";
						  $AUTH = urlencode( "". $code1."/".$datas."/". $code3."" );
						}
						elseif ( $datas == 780043)
						{
							$prix_add = "5,00";
						  $AUTH = urlencode( "". $code1."/".$datas."/". $code3."" );
						}
						else 
						{
						echo "<center><strong>Erreur : Tentative de modification d'url</center></strong>";
						exit();
						}
					

					   $r = @file( "http://payment.allopass.com/api/checkcode.apu?code=$RECALL&auth=$AUTH" );

					  if( substr( $r[0],0,2 ) != "OK" ) 
					  {
						header( "Location: erreur.html" );
						exit(1);
					  }
					 
					  setCookie( "CODE_OK", "1", 0, "/", ".your-domaine.info", false );
					$id_transaction = $RECALL;		
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
					'".$id_client."',
					'".$id_facture."',
					'".$id_transaction."',
					'Allopass',
					'".$prix_add."',
					'1',
					'".$ip."',
					'".$time."'
					)") or die(mysql_error());
					
				echo "<center><strong>Votre payement a bien etait valider, voici les details de la transaction : <br></center></strong>";
				
	
				$sql_vps = DB:: SQLToArray("SELECT * FROM invoice WHERE id='$id_facture' limit 1 ");
			
			$facture_number = $sql_vps[0]['facture'];
				
	echo '<table width="100%" border="0">
								<tr class="tableimpair">
								<td>Numéro de transation</td>
								<td>'.md5($RECALL).'</td>
								</tr>
								
								<tr class="tablepair">
								<td>Code utilisé : </td>
								<td>'.$RECALL.'</td>
								</tr>
								
								<tr class="tableimpair">
								<td>Numéro de facture</td>
								<td>'.$facture_number.'</td>
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
								
								
				
				echo '<br><center><a href="index.php?page=invoice&id='.$facture_number.'">Retournez sur la facture</a></center>';
				}
				elseif ( $_GET['action'] == "erreur" )
				{
				}
			
			}
			else
			{
			$reponse = mysql_query("SELECT * FROM invoice WHERE facture='$id_facture'"); // Requête SQL
				while ($sql = mysql_fetch_array($reponse) )
				{
					//On vérifie les etat :
					$facture_id_id = $sql['id'];
					$facture_etat = $sql['etat'];
					
					
				if ( $facture_etat == 4 )
				{
				$error_msg .= "<br /><strong>Erreur : </strong>Une erreur a etait détecté dans cette facture, merci de contacter le support";
				$erreur += 1;
				}
				elseif ( $facture_etat == 6 )
				{
				$error_msg .= "<br /><strong>Erreur : </strong> Vous avez annulé cette facture, pour la réactiver merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 7 )
				{
				$error_msg .= "<br /><strong>Erreur : </strong>Cette facture etait annulé par un Administrateur, pour la réactiver merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 8 )
				{
				$error_msg .= "<br /><strong>Erreur : </strong>Cette facture a etait classer comme froduleuse, pour la réactiver merci de nous contactez<br />";
				$erreur += 1;
				}
				elseif ( $facture_etat == 9 )
				{
				$error_msg .= "<br /><strong>Erreur : </strong>Cette facture a etait payer mais le payement est toujour en attente de véirification<br />";
				$erreur += 1;
				}
				
				$init_price_verification = "0,00";
				$prix_vps = "0";
	$reponse_corp = mysql_query("SELECT * FROM invoice_corp WHERE id_facture='$facture_id_id'  "); // Requête SQL
	while ($sql_corp = mysql_fetch_array($reponse_corp) )
		{
		$facture_id_prix = $sql_corp['prix'];
				
						$prix_vps +=   $sql_corp['prix'];
				
						
		}			
				$payement_payer_ok = "0,00";
				$reponse_payement = mysql_query("SELECT * FROM payement WHERE id_facture='$facture_id_id' "); // Requête SQL
				while ($sql_payement = mysql_fetch_array($reponse_payement) )
				{
				//On liste les payement
					if ( $sql_payement['etat'] == 1)
					{
					$payement_payer_ok += $sql_payement['montant'];
					}
				}
				$payement_reste = $prix_vps - $payement_payer_ok;
				if ( $payement_reste <= "0" )
						{
						$error_msg .= "<br /><strong>Erreur : </strong>Cette facture a deja etait payers.<br />";
							$erreur += 	1;
						}
					if ( $erreur != 0 )
					{
					echo '<center><strong>Il y a '.$erreur.' erreur ! <br />'.$error_msg.'</center></strong>';
					}
					else
					{
						$_SESSION['id_facture'] = $facture_id_id;
						$nbr_arrondi = round($payement_reste);
						
						
						
							echo '<center><strong>Il reste '.$payement_reste.' a payer ce jour</center></strong>';
						
							echo '<fieldset><legend><strong>Etape 1 - Choisisez votre pays</strong></legend>';
						if ($nbr_arrondi == 1)
						{
						  $prix_add = "1";
						 $code_auth = "780026";
						}
						elseif ( $nbr_arrondi == 2)
						{
							$prix_add = "2";
						   $code_auth = "780039";
						}
						elseif ($nbr_arrondi == 3)
						{
							$prix_add = "3";
						  $code_auth = "780040";
						}
						elseif ($nbr_arrondi == 4)
						{
							$prix_add = "4";
						 $code_auth = "780042";
						}
						elseif ($nbr_arrondi <= 5)
						{
							$prix_add = "5";
						 $code_auth = "780043";
						}
						else
						{
							$prix_add = "5";
						 $code_auth = "780043";
						}
					?>
					<center>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=fr','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_fr.gif" width="35" height="29" alt="FR" title="FR" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=zz','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_zz.gif" width="35" height="29" alt="ZZ" title="ZZ" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=be','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_be.gif" width="35" height="29" alt="BE" title="BE" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ch','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ch.gif" width="35" height="29" alt="CH" title="CH" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=lu','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_lu.gif" width="35" height="29" alt="LU" title="LU" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=de','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_de.gif" width="35" height="29" alt="DE" title="DE" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=uk','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_uk.gif" width="35" height="29" alt="UK" title="UK" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ca','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ca.gif" width="35" height="29" alt="CA" title="CA" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=au','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_au.gif" width="35" height="29" alt="AU" title="AU" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=nl','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_nl.gif" width="35" height="29" alt="NL" title="NL" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=es','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_es.gif" width="35" height="29" alt="ES" title="ES" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=at','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_at.gif" width="35" height="29" alt="AT" title="AT" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=it','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_it.gif" width="35" height="29" alt="IT" title="IT" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=pt','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_pt.gif" width="35" height="29" alt="PT" title="PT" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=us','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_us.gif" width="35" height="29" alt="US" title="US" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=se','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_se.gif" width="35" height="29" alt="SE" title="SE" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=no','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_no.gif" width="35" height="29" alt="NO" title="NO" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=dk','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_dk.gif" width="35" height="29" alt="DK" title="DK" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=fi','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_fi.gif" width="35" height="29" alt="FI" title="FI" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=gr','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_gr.gif" width="35" height="29" alt="GR" title="GR" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=il','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_il.gif" width="35" height="29" alt="IL" title="IL" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=cz','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_cz.gif" width="35" height="29" alt="CZ" title="CZ" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=pl','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_pl.gif" width="35" height="29" alt="PL" title="PL" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=lt','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_lt.gif" width="35" height="29" alt="LT" title="LT" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ru','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ru.gif" width="35" height="29" alt="RU" title="RU" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ee','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ee.gif" width="35" height="29" alt="EE" title="EE" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ro','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ro.gif" width="35" height="29" alt="RO" title="RO" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=pe','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_pe.gif" width="35" height="29" alt="PE" title="PE" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=lv','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_lv.gif" width="35" height="29" alt="LV" title="LV" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=sk','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_sk.gif" width="35" height="29" alt="SK" title="SK" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=bg','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_bg.gif" width="35" height="29" alt="BG" title="BG" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=hu','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_hu.gif" width="35" height="29" alt="HU" title="HU" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=kz','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_kz.gif" width="35" height="29" alt="KZ" title="KZ" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ec','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ec.gif" width="35" height="29" alt="EC" title="EC" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=ve','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_ve.gif" width="35" height="29" alt="VE" title="VE" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=mx','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_mx.gif" width="35" height="29" alt="MX" title="MX" /></a>
  <a href="javascript:;" onclick="javascript:window.open('http://payment.allopass.com/acte/scripts/popup/access.apu?ids=170550&amp;idd=469813&amp;lang=fr&amp;country=co','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=340');"><img border="0" src="http://payment.allopass.com/imgweb/common/flag_co.gif" width="35" height="29" alt="CO" title="CO" /></a>
						</center><? echo '</fieldset><br><br>';	
						echo '<fieldset><legend><strong>Etape 2 - Obtention des codes</strong></legend>';
						echo 'Composez le numéro inscrit sur la fiche de votre pays, puis attendez la declaration du codes.<br /><br />';
						if ( $prix_add != 1 )
						{
						$prix_addd = $prix_add - 1;
						echo 'Une foi le premier code obtenus vous devriez renouveler '.$prix_addd.' fois votre apelle.<br /><br />';
						echo 'Quand vous aurez obtenus vos '.$prix_add.' code obtenus merci de les inserez dans les champs prévue a cette effet puis de cliquez sur le bouton valider.<br />';
						}
						else
						{
						echo 'Une fois votre code obtenus merci de l\'inserez dans le champ prévue a cette effet puis de clique sur le bouton valider.<br />';
						}
						echo '<strong><center><br /><br />ATTENTION : Penssez a bien noté vos code, il vous seront demander en cas de probleme</strong></center>';
						 echo '</fieldset>';
				// On arrondi le prix
					
						echo '<br /><br /><fieldset><legend><strong>Etape 3 - Validation des codes</strong></legend>';
				
				
					
					
				
					echo '
					
					<form action ="http://payment.allopass.com/acte/access.apu" method="post"><center>';
					if ( $nbr_arrondi >= 1 )
					  echo '<input type="text" size="8" maxlength="10" value="Code1" name="code[]" onfocus="if(this.value==\'Code1\') this.value=\'\'"  />';
					if ( $nbr_arrondi >= 2 )
					  echo '<input type="text" size="8" maxlength="10" value="Code2" name="code[]" onfocus="if(this.value==\'Code2\') this.value=\'\'"  />';
					if ( $nbr_arrondi >= 3 )
					  echo '<input type="text" size="8" maxlength="10" value="Code3" name="code[]" onfocus="if(this.value==\'Code3\') this.value=\'\'"  />';
					if ( $nbr_arrondi >= 4 )
					  echo '<input type="text" size="8" maxlength="10" value="Code4" name="code[]" onfocus="if(this.value==\'Code4\') this.value=\'\'"  />';
					if ( $nbr_arrondi >= 5 )
					  echo '<input type="text" size="8" maxlength="10" value="Code5" name="code[]" onfocus="if(this.value==\'Code5\') this.value=\'\'"  />';

					echo '<input type="hidden" name="ids" value="170550" />
					<input type="hidden" name="data" value="'.$code_auth.'" />
					<input type="hidden" name="idd" value="'.$code_auth.'" />
					<input type="hidden" name="lang" value="fr" />
					<input type="hidden" name="recall" value="1" />
				
					<br><input type="submit" value="  Valider  " />

				  </form>
				  
					';
					 echo '</center></fieldset>';
					}
			}
		}
	}


?>
