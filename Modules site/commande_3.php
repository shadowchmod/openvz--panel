<?

$host='localhost';
$base='';		// base de donnée
$blogin='';		// login
$bpass='';		// mot de passe

//On pr�pare la connection mysql
$db_client = mysql_connect($host,$blogin,$bpass);
mysql_select_db($base,$db_client);
if ( isset ( $_GET['action'] ) )
{
 	if ( $_GET['action'] )
	{
	$_SESSION['login'] =  NULL;
	$_SESSION['password'] = NULL;
	$_SESSION['client']  = NULL;
	}
}
if ( 1 != 1 )
{
echo "Erreur : Merci de recommencer votre commande";
$_SESSION['BC'] = NULL;

}
else
{
						$id_bc = $_SESSION['BC'];
						if ( isset ( $_SESSION['BC'] ) AND $_SESSION['BC'] !=NULL )
						{
						$id_bc = $_SESSION['BC'];
						}
						else
						{
							if ( isset ( $_GET['BC'] ) )
							{
							
								if ( $_GET['BC'] != NULL )
								{
								$id_bc = $_GET['BC'];
								}
							}
						}
$prix_tt = "";
		//On recupere les parametre du BC
		$req_bc = DB:: SQLToArray("SELECT * FROM commande WHERE number_cmd='$id_bc' limit 1");
		$id_commande = $req_bc[0]['id'];
			if ( $req_bc[0]['id_prix'] == NULL )
			{
			$id_price = $_GET['id'];
			
			mysql_query("UPDATE commande SET id_prix='$id_price' WHERE id='$id_commande' ");
			}
			else
			{
			$id_price = $req_bc[0]['id_prix'];
			}
		//On recupere les parametre du service
		$texte_bc ="";
			//si VPS
			if ( $req_bc[0]['cat_service'] == "VPS" )
			{
			$id_plan = $req_bc[0]['cat_service'];
			$id_service = $req_bc[0]['id_service'];
			$req_plan_vps = DB:: SQLToArray("SELECT * FROM plan WHERE id='$id_service' limit 1");
			
			//recherche du prix 
			$sql_prix = DB:: SQLToArray("SELECT * FROM prix_service WHERE id='$id_price' limit 1");
			$style = 'class="celinter" ';		
			$texte_bc .= '
			<tr			'.$style.' >
			<td >*</td>
			<td >Commande '.$req_plan_vps[0]['nom'].' - '.$sql_prix[0]['jour_texte'].' </td>
			<td >'.$sql_prix[0]['prix'].'&euro;</td>
			<td >1</td>
			<td >'.$sql_prix[0]['prix'].'&euro;</td>
			</tr>';
			$prix_tt += $sql_prix[0]['prix'];
			
			$var_frai_install =  $req_plan_vps[0]['frai_install'];
				if ( @$var_frai_install == "1")
				{
					$texte_bc .= '
			<tr 	'.$style.'>
			<td>*</td>
			<td>Frai mise en service</td>
			<td >'.$req_plan_vps[0]['install_price'].'&euro;</td>
			<td >1</td>
			<td >'.$req_plan_vps[0]['install_price'].'&euro;</td>
			</tr>';
			$prix_tt += $req_plan_vps[0]['install_price'];
				}
			}
			
			elseif ( $req_bc[0]['cat_service'] == "HOSTING" )
			{
			$id_plan = $req_bc[0]['cat_service'];
			$id_service = $req_bc[0]['id_service'];
			$req_plan_vps = DB:: SQLToArray("SELECT * FROM plan_hosting WHERE id='$id_service' limit 1");
			
			//recherche du prix 
			$sql_prix = DB:: SQLToArray("SELECT * FROM prix_service WHERE id='$id_price' limit 1");
			$style = 'class="celinter" ';		
			$texte_bc .= '
			<tr			'.$style.' >
			<td >*</td>
			<td >Commande '.$req_plan_vps[0]['nom'].' - '.$sql_prix[0]['jour_texte'].' </td>
			<td >'.$sql_prix[0]['prix'].'&euro;</td>
			<td >1</td>
			<td >'.$sql_prix[0]['prix'].'&euro;</td>
			</tr>';
			$prix_tt += $sql_prix[0]['prix'];
			
			$var_frai_install =  $req_plan_vps[0]['frai_install'];
				if ( @$var_frai_install == "1")
				{
					$texte_bc .= '
			<tr 	'.$style.'>
			<td>*</td>
			<td>Frai mise en service</td>
			<td >'.$req_plan_vps[0]['install_price'].'&euro;</td>
			<td >1</td>
			<td >'.$req_plan_vps[0]['install_price'].'&euro;</td>
			</tr>';
			$prix_tt += $req_plan_vps[0]['install_price'];
				}
			}
			$GLOBALS['local_var']['V_CMD_TEXTE_BC'] = $texte_bc;
			$GLOBALS['local_var']['V_CMD_TITRE'] = 'Etape 3  - R&eacute;capitulatif de votre commande';
			$GLOBALS['local_var']['PRIX_TT'] = $prix_tt;
						
						
						include ('pages/ctrl_login.php');
					if ( $etat_connxion == "1")
					{
						$GLOBALS['local_var']['LOGIN'] =  '<div class="erreur">
				Vous etes connectes en tant que '.$nikhandle .', vous-vous utilisez ce compte ?<br />
				<a  class="erreur" href="index.php?lang=fr&page=commande_4&id='.$id_commande.'">Oui</a> / <a  class="erreur" href="index.php?lang=fr&page=commande_3&action=deco" >Non </a></div>';
					}
					else{
		$GLOBALS['local_var']['LOGIN'] =  '				<div class="erreur"><a  class="erreur" href="index.php?lang=fr&page=enregistrement&req=commande_3">Vous etes un nouveaux client </a><br />
<a  class="erreur" href="index.php?lang=fr&page=conexion&refer=commande_3">Connectez-vous</a></div>';

						}
						print_file("pages/services/commande_3.html");
	
			//affichage du texte

	}
?>
