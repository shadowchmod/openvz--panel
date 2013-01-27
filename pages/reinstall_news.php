<?

echo '
<style>
.gauche{
font-weight:bold;
text-align:left;
padding-left:50px;	
padding-top:20px;
padding-bottom:20px;
}
.form{
  color:#000000;
  font-size:12px;
  font-weight:bold;
  text-align:center;

}
.droite{
font-weight:bold;
text-align:center;
padding-left:20px;	
padding-right:20px;	
padding-top:20px;
padding-bottom:20px;
}
</style>
<fieldset><legend><strong>Reinstallation du serveur</strong></legend>';

echo '<center><table border="0">

<tr class="tablepair">

<td class="gauche">Systeme d\'exploitation : </td><td class="droite">
';
echo '<table border="0">

';
$req_os = mysql_query("SELECT * FROM os WHERE etat='1' ");
while ($sql_os = mysql_fetch_array($req_os))
{
echo '<tr>
<td><input   type="radio" name="frites" value="oui" /> </td>
<td>'.$sql_os['nom_os'].'</td>
</tr>';

}
echo '</table>';
echo '
</td>

</tr>

<tr class="tableimpair">

<td class="gauche">Hostname : </strong></td><td class="droite"><input class="form"  type="text" value="vps6527.heberge-hd.fr"></td>

</tr>

<tr class="tablepair">

<td class="gauche">Serveur Dns 1 : </td><td class="droite"><input class="form"  type="text" value="127.0.0.1"></td>

</tr>

<tr class="tableimpair">

<td class="gauche">Serveur Dns 2 : </td><td class="droite"><input class="form"  type="text" value="213.186.33.99"></td>

</tr>
<tr class="tablepair">


<td class="gauche">Nom de l\'utilisateur : </td><td class="droite"><input class="form"  type="text" value="admin"></td>

</tr>

<tr class="tableimpair">

<td class="gauche">Password de l\'utilisateur : </td><td class="droite"><input class="form"  type="password" ></td>

</tr>

<tr class="tableimpair">

<td class="gauche">Password de l\'utilisateur (vérfication) : </td><td class="droite"><input class="form"  type="password" ></td>

</tr>


<tr class="tablepair">

<td class="gauche">Pasword du super utilisateur (root) : </td><td class="droite"><input class="form"  type="password" ></td>

</tr>

<tr class="tablepair">

<td class="gauche">Pasword du super utilisateur (root) (vérification) : </td><td class="droite"><input class="form"  type="password" ></td>

</tr></table></center>
';
echo '</fieldset>';

?>
