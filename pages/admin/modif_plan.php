<?php
    defined("INC") or die("403 restricted access");
	
		echo '
			<a href="index.php">< Retour au panneau</a><br/><br/>';
		echo "<fieldset><legend><strong>Modification d'un plan</strong></legend>";

if(isset($_GET['id'])){
$requete = "SELECT id FROM plan WHERE id = '".$_GET['id']."'";
$query = mysql_query($requete);
}
$error = 0;
$msg= "";

if(isset($_GET['id']) && is_numeric($_GET['id']) && (mysql_num_rows($query) == 1)){
$id = $_GET['id'];
// Mise à jour du formulaire
if(isset($_POST['maj'])){

$nom = $_POST['nom'];
$ram = $_POST['ram'];
$disque = $_POST['disque'];
$cpu =  $_POST['cpu'];
$disque_info = $_POST['disque_info'];
$ram_info = $_POST['ram_info'];
$proc_info = $_POST['proc_info'];
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
if(!mysql_query("UPDATE plan SET nom='$nom', ram='$ram', disque='$disque', nbr_cpu='$cpu', dd_info='$disque_info', ram_info='$ram_info', proco_info='$proc_info', connexion_info='$connexion', bp_info='$bp', frai_install='$fraisinstall', install_price='$prix_install' WHERE id='$id' "))
	$error = 1;
	$msg .= "Erreur : Problème au niveau de la requête SQL <br />";
}
}

$result = mysql_query("SELECT nom, ram, disque, nbr_cpu, dd_info, ram_info, proco_info, connexion_info, bp_info, frai_install, install_price, id FROM plan WHERE id = '$id'");
$row = mysql_fetch_row($result);
$nom = $row[0];
$ram = $row[1];
$disque = $row[2];
$cpu = $row[3];
$disque_info = $row[4];
$ram_info = $row[5];
$proc_info = $row[6];
$connexion = $row[7];
$bp = $row[8];
$fraisinstall = $row[9];
$prix_install = $row[10];
$id = $row[11];

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
			<td><input type="text" name="nom" value="<?=$nom?>"></td>
		</tr>
		<tr>
			<td>Ram</td>
			<td><input type="text" name="ram" value="<?=$ram?>"></td>
		</tr>
		<tr>
			<td>Disque</td>
			<td><input type="text" name="disque" value="<?=$disque?>"></td>
		</tr>
		<tr>
			<td>Nombre CPU</td>
			<td><input type="text" name="cpu" value="<?=$cpu?>"></td>
		</tr>
		<tr>
			<td>Disque Dur Info</td>
			<td><input type="text" name="disque_info" value="<?=$disque_info?>"></td>
		</tr>
		<tr>
			<td>Ram Info</td>
			<td><input type="text" name="ram_info" value="<?=$ram_info?>"></td>
		</tr>
		<tr>
			<td>Processeur Info</td>
			<td><input type="text" name="proc_info" value="<?=$proc_info?>"></td>
		</tr>
		<tr>
			<td>Connexion Info</td>
			<td><input type="text" name="connexion" value="<?=$connexion?>"></td>
		</tr>
		<tr>
			<td>Bande Passante Info</td>
			<td><input type="text" name="bp" value="<?=$bp?>"></td>
		</tr>
		<tr>
			<td>Frais d'install</td>
			<td>
			<?
			if($fraisinstall == "1"){
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
			<td><input type="text" name="prix_install" value="<?=$prix_install?>"></td>
		</tr>
	</table>
<center><input type="submit" name="maj" value="Mettre à jour" /></center>
</form>

<?

if(isset($_POST['supp'])){

mysql_query("DELETE FROM prix_service WHERE id='".$_POST['idsupp']."' AND service_type='VPS'");

}

$result = mysql_query("SELECT service_id, jour_nbr, jour_texte, prix, id FROM prix_service WHERE service_id = '$id' AND service_type='VPS'");

echo '<table width="100%">';
echo '<tr align="center"><td>Nb de Jours</td><td>Jours</td><td>Prix</td><td>Supprimer</td></tr>';
while($res = mysql_fetch_array($result)){
	echo '<tr align="center">';
	echo '<td>'.$res['jour_nbr'].'</td><td>'.$res['jour_texte'].'</td><td>'.$res['prix'].'</td>
	<td><form method="POST" action="'.$_SERVER['REQUEST_URI'].'" onSubmit="return confirmation();"><input type="hidden" name="idsupp" value="'.$res['id'].'" /><input type="submit" name="supp" value="Supprimer"></td>
	</tr>';
}
echo '</table>';

echo '<br /><center><a href="index.php?page=admin/add_prixplan&id='.$id.'">Ajouter un Prix</a></center>';
?>

<?
}
else{
echo "Plan Inconnu";
}
?>