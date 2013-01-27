<?php
	defined("INC") or die("403 restricted access");
	
	if (Session::CanLog())
	{
?>
		<fieldset><legend><strong>Mot de passe oublié</strong></legend>
			<center>
				<form action="index.php?page=action&action=regenpassword" method="post">
					<p>
						<label>
							Nik-handle: 
							<input type="text" name="nik" id="nik">
						</label>
					</p>
					<p>
						<label>
							<input type="submit" name="button" id="button" value="Envoyer">
						</label>
					</p>
				</form>
			</center>
		</fieldset>
<?php
	}else{
		Message("Vous avez dépassé le nombre de tentative",ALERTE);
	}
?>