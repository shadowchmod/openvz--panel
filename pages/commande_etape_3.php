<?


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
							
			$texte_bc .= '
			<tr class="light">
			<td>*</td>
			<td>Commande '.$req_plan_vps[0]['nom'].' - '.$sql_prix[0]['jour_texte'].' </td>
			<td style="text-align: center;">'.$sql_prix[0]['prix'].'€</td>
			<td style="text-align: center;">1</td>
			<td style="text-align: center;">'.$sql_prix[0]['prix'].'€</td>
			</tr>';
			$prix_tt += $sql_prix[0]['prix'];
			
			$var_frai_install =  $req_plan_vps[0]['frai_install'];
				if ( @$var_frai_install == "1")
				{
					$texte_bc .= '
			<tr class="light">
			<td>*</td>
			<td>Frai mise en service</td>
			<td style="text-align: center;">'.$req_plan_vps[0]['install_price'].'€</td>
			<td style="text-align: center;">1</td>
			<td style="text-align: center;">'.$req_plan_vps[0]['install_price'].'€</td>
			</tr>';
			$prix_tt += $req_plan_vps[0]['install_price'];
				}
			}
echo '<style>
h1 {
    font-size: 13px;
    color: #567eb9;
    border-bottom: 1px solid #567eb9;
}
</style>

<h1 qtlid="58734">Etape 3  - Récapitulatif de votre commande</h1>';

echo '
				<table cellpadding="3" cellspacing="1" class="displayOrder full" style="width: 100%; margin: 0; padding: 0;">
<tr class="title">
<th qtlid="33373">Domaine</th>
<th qtlid="33384">Description</th>
<th style="width: 70px;" qtlid="33395">Prix unitaire</th>
<th style="width: 30px;" qtlid="33406">Quantité</th>

<th style="width: 70px;" qtlid="33417">Prix</th>
</tr>


<tr><td colspan="5" style="border: none;" qtlid="33130"> </td></tr>


'.$texte_bc.'





</tr>

<tr class="light">


</tr>
<tr class="title">
<th style="text-align: left; font-size: 12px;" colspan="2" qtlid="33496">Prix Total</th>

<th class="title" style="text-align: center; font-size: 12px;">'.$prix_tt.'€</th>
</tr>
</table>

';

echo '<br/>
<h1 qtlid="58735">Finaliser votre commande :</h1><br/>';

	if ( @Session::$Client->Id !=NULL  )
	{
	echo "<center><strong>Voulez-vous finaliser votre commande avez l'utilisateur ". @Session::$Client->NikHandle." ?</center></strong>";
	echo '<center><a href="index.php?page=commande_etape_4&id='.$id_commande.'">Oui </a> - Non</center>';
	}

	}
?>