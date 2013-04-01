<?php
    defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour au panneaux</a><br/><br/>';
		echo "<fieldset><legend><strong>Ajouter un plan</strong></legend>";

$error = 0;
$msg= "";
$succes = 0;

if(isset($_POST['add'])){
$nom = $_POST['nom'];
$ram = $_POST['ram'];
$disque = $_POST['disque'];
$cpu = $_POST['cpu'];
$disque_info = $_POST['disque_info'];
$ram_info = $_POST['ram_info'];
$proc_info =$_POST['proc_info'];
$connexion = $_POST['connexion'];
$bp = $_POST['bp'];
$fraisinstall = $_POST['fraisinstall'];
$prix_install = $_POST['prix_install'];

if(!is_numeric($ram)){
	$error = 1;
	$msg .= "Ram doit être un nombre <br />";
}
if(!is_numeric($disque)){
	$error = 1;
	$msg .= "Disque doit être un nombre <br />";
}
if(!is_numeric($cpu)){
	$error = 1;
	$msg .= "CPU doit être un nombre <br />";
}



if($error == 0){
	if(!mysql_query("INSERT INTO plan (nom, ram, disque, nbr_cpu, dd_info, ram_info, proco_info, connexion_info, bp_info, frai_install, install_price) VALUES('$nom', '$ram', '$disque', '$cpu', '$disque_info', '$ram_info', '$proc_info', '$connexion', '$bp', '$fraisinstall', '$prix_install')")){
		$error = 1;
		$msg .= "Erreur : Problème au niveau de la requête SQL <br />";
	}
	else
	$succes = 1;
}


}

if($succes == 1){
				echo '<p><center><b>Plan Ajouter</b></center>
				<br />
				<br />
				<META http-equiv="Refresh" content="2; URL=index.php?page=admin/gestion_plan">
				</p>';
}
else{
if($error != 0)
echo "<center>$msg</center>";

?>

<script>
function confirmation(){
    choix = confirm("Êtes-vous sûr de vouloir supprimer ?");
    if (choix == true)
      {
      document.formulaire.submit();
      }
    else
      {
      return false;
      }
}

</script>

 <form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
	<table>
		<tr>
			<td>Nom</td>
			<td><input type="text" name="nom" value="<?if(isset($_POST['nom'])) echo $_POST['nom'];?>"></td>
		</tr>
		<tr>
			<td>Ram</td>
			<td><input type="text" name="ram" value="<?if(isset($_POST['ram'])) echo $_POST['ram'];?>"></td>
		</tr>
		<tr>
			<td>Disque</td>
			<td><input type="text" name="disque" value="<?if(isset($_POST['disque'])) echo $_POST['disque'];?>"></td>
		</tr>
		<tr>
			<td>Nombre CPU</td>
			<td><input type="text" name="cpu" value="<?if(isset($_POST['cpu'])) echo $_POST['cpu'];?>"></td>
		</tr>
		<tr>
			<td>Disque Dur Info</td>
			<td><input type="text" name="disque_info" value="<?if(isset($_POST['disque_info'])) echo $_POST['disque_info'];?>"></td>
		</tr>
		<tr>
			<td>Ram Info</td>
			<td><input type="text" name="ram_info" value="<?if(isset($_POST['ram_info'])) echo $_POST['ram_info'];?>"></td>
		</tr>
		<tr>
			<td>Processeur Info</td>
			<td><input type="text" name="proc_info" value="<?if(isset($_POST['proc_info'])) echo $_POST['proc_info'];?>"></td>
		</tr>
		<tr>
			<td>Connexion Info</td>
			<td><input type="text" name="connexion" value="<?if(isset($_POST['connexion'])) echo $_POST['connexion'];?>"></td>
		</tr>
		<tr>
			<td>Bande Passante Info</td>
			<td><input type="text" name="bp" value="<?if(isset($_POST['bp'])) echo $_POST['bp'];?>"></td>
		</tr>
		<tr>
			<td>Frais d'install</td>
			<td>
			<?
			if(isset($_POST['fraisinstall']) && $_POST['fraisinstall'] == "1"){
				echo '<input type="radio" name="fraisinstall" value="1" CHECKED/>Oui';
				echo '<input type="radio" name="fraisinstall" value="0" />Non';
			}
			else{
				echo '<input type="radio" name="fraisinstall" value="1" />Oui';
				echo '<input type="radio" name="fraisinstall" value="0" CHECKED/>Non';
			}
			?>
			</td>
		</tr>
		<tr>
			<td>Prix Frais Installation</td>
			<td><input type="text" name="prix_install" value="<?if(isset($_POST['prix_install'])) echo $_POST['prix_install'];?>"></td>
		</tr>
	</table>
<center><input type="submit" name="add" value="Ajouter" /></center>
</form>

<?
}

?>
