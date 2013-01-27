<?
$id_bc = $_GET['id'];


if ( $_SESSION['BC'] !=  $id_bc )
{
echo "Erreur : Merci de recommencer votre commande";
$_SESSION['BC'] = NULL;

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
			}
		
echo '<style>
h1 {
    font-size: 13px;
    color: #567eb9;
    border-bottom: 1px solid #567eb9;
}
</style>

<h1 qtlid="58734">Etape 2  - Choix de la durrée de location du '.$req_plan_vps[0]['nom'].' </h1>';

echo '
						  <table>
				<table width="100%" border="0">
      <tr class="tabletitle">

	  <td>Durrée de location</td>
	  <td>Prix</td>
		  <td></td>
	  
	  </tr>';
							
						$reponse = mysql_query("SELECT * FROM prix_service WHERE service_type='$id_plan' AND service_id='$id_service' ");
								while ($sql = mysql_fetch_array($reponse) )
								{
															
					echo '
					
					<tr>
				
					<td><center>Louer pour '.$sql['jour_texte'].'</center></td>
					<td><center>'.$sql['prix'].'€</center></td>
						<td><center><a href="index.php?page=commande_etape_3&id='.$sql['id'].'">Choisir </a></center></td>
					</tr>';
								}
						echo '</table></td>
												</tr>';
					
	echo '  <br></form></fieldset>';
	}
?>