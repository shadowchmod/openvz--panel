	defined("INC") or die("403 restricted access");

	echo '<a href="index.php">< Retour au panneau </a><br/><br/>';

 <fieldset><legend><strong>Ajout d'un serveur PROXMOX</strong></legend>

<form id="form2" name="form2" method="post" action="index.php?page=action&amp;action=add_serveur_proxmox">
<table width="100%" border="0">
 
<TR>
        <TD align="right">Login du serveur:</TD>
        <TD align="right"><input type="text" name="login" /></TD>
</TR>
<TR>
        <TD align="right">Mot de passe du serveur:</TD>
        <TD align="right"><input type="text" name="password" /></TD>
</TR>

<TR>
                <TD align="right">Ip du serveur:</TD>
                <TD align="right"><input type="text" name="ip" /></TD>
</TR>
<TR>
                <TD align="right">Le nom de domaine du serveur:</TD>
                <TD align="right"><input type="text" name="host" /></TD>
</TR>
<TR>
                <TD align="right">Le nom du serveur:</TD>
                <TD align="right"><input type="text" name="nom" /></TD>
</TR>
<TR>
                <TD align="right">L\'Etat du serveur:</TD>
                <TD align="right">
        <select>
                        <option value="0">0 inactif</option>
                        <option value="1">1 actif</option>
        </select>       </TD>
</TR>
<TR>
                <TD align="right">Le port du serveur:</TD>
                <TD align="right"><input type="text" name="port" placeholder="22" /></TD>
</TR>
<TR>
        <TD align="right"><INPUT type="RESET" value="effacer" name="RESET"  /></TD>
        <TD align="right"><INPUT type="submit" value="ajouter mon serveur" name="submit" /></TD>
</TR>

</table>
</form>
</fieldset>
 
