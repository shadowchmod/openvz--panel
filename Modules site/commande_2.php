<?
$id_bc = @$_GET['id'];

$host='localhost';
$base='';			// base de donnée
$blogin='';			// login
$bpass='';			// mot de passe
$erreur = "0";
$GLOBALS['local_var']['ERREUR'] = "";
//On pr�pare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);
if ( $_SESSION['BC'] !=  $id_bc )
{
$GLOBALS['local_var']['ERREUR'] .= "<div class=\"erreur\">Erreur : Merci de recommencer votre commande</div><br />";
$_SESSION['BC'] = NULL;
$erreur+=1;
}
else
{
		//On recupere les parametre du BC
		$req_bc = DB:: SQLToArray("SELECT * FROM commande WHERE number_cmd='$id_bc' limit 1");
		
		//On recupere les parametre du service
		
			//si VPS
			if ( $req_bc[0]['cat_service'] == "VPS" )
			{
			$id_plan = $req_bc[0]['cat_service'];
			$id_service = $req_bc[0]['id_service'];
			$req_plan_vps = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_service' limit 1");
			$GLOBALS['local_var']['V_CMD_TITRE'] = 'Etape 2  - Durr&eacute;e de location du '.$req_plan_vps[0]['nom'].'';

			}
			elseif ( $req_bc[0]['cat_service'] == "HOSTING" )
			{
			$id_plan = $req_bc[0]['cat_service'];
			$id_service = $req_bc[0]['id_service'];
			$req_plan_vps = DB:: SQLToArray("SELECT * FROM plan_hosting WHERE id='$id_service' limit 1");
			$GLOBALS['local_var']['V_CMD_TITRE'] = 'Etape 2  - Durr&eacute;e de location du	'.$req_plan_vps[0]['nom'].'';

			}
			else
			{
			$GLOBALS['local_var']['ERREUR'] .= "<div class=\"erreur\">Erreur : Type de service inconnue</div><br />";
			
			$erreur+=1;
			}



$bouc_ecmd = '';
							$i=0;
						$reponse = mysql_query("SELECT * FROM prix_service WHERE service_type='$id_plan' AND service_id='$id_service' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
								$i+=1;
															
			$bouc_ecmd .=  '
					
					<tr>
				
					<td class="cell_offre_detail_pair1"><center><br />Louer pour '.$sql['jour_texte'].'</center><br></td>
					<td class="cell_offre_detail_pair2"><center>'.$sql['prix'].'&#128;</center></td>
					<td width="100px" class="cell_offre_detail_pair1" >
<div align="center"><a  class="linkcheck" title="Choisir" href="index.php?lang=fr&page=commande_3&id='.$sql['id'].'" border="0" ><img src="images/001_46.png" border="0"></a></div>
</td>
					</tr>';
								}
								if ( $i == 0 )
								{
			$GLOBALS['local_var']['ERREUR'] .= "<div class=\"erreur\">Erreur : Liste de prix introuvable</div><br />";
		
			$erreur+=1;								
								}

			
		
$GLOBALS['local_var']['V_CMD_CONTENUE_BOUCLE'] = $bouc_ecmd;	

	if ( $erreur == 0 )
		{
		print_file("pages/services/commande_2.html");
		}else{
		$GLOBALS['local_var']['ERREUR_NBR'] = $erreur;
		print_file("pages/services/help.html");
		}
		
			

	}
	
	?>
