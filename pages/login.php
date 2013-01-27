<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::CanLog())
	{

?>
<center>
	<table border="0" >
		<tr> 
			<th>
				<img src="images/manager.png" alt=""/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</th>
			<th>
			<center>	
				<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=login">
                    <table width="100%" border="0">
                        <tr>
                            <td><strong>Nik-handle :</strong></td>
                            <td><input type="text" name="login" id="login" /></td>
                        </tr>
                        <tr>
                            <td><strong>Mot de passe :</strong></td>
                            <td><input type="password" name="pass" id="pass" /></td>
                        </tr>
                    </table>
                    <p>
                        <label>
                            <input type="submit" name="Envoyer" id="Envoyer" value="Envoyer" />
                        </label>
                    </p>
					<p><a href="index.php?page=forget_pass">Mot de passe oubli&eacute;</a></p>
				
<input type="hidden" name="refer" value="<?echo $var_encoer;?>" />
</form>
			</center>
			</th>
		</tr>
	</table>
</center>
<?php
	}else{
		Message("Vous avez d�pass� le nombre de tentative de connection, prochaine tentative dans ".Session::NextTry()." seconds",ALERTE);
	}