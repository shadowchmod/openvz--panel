<?php
		echo '<a href="index.php">< Retour aux panneaux</a><br/>';
?>
			<br/>
			<script language="JavaScript" type="text/javascript">
				function GenerateNik()
				{
					var fl=document.getElementById("nom").value.substring(0,1).toUpperCase();
					var sl=document.getElementById("prenom").value.substring(0,1).toUpperCase();
					if (fl=="")
						fl="A";
					if (sl=="")
						sl="B";
					var letters=fl+sl;
					var text=GetURLOutput("index.php?page=action&action=generatenik&letters="+letters);
										
					document.getElementById("nik").value=text;
				}
				function GeneratePass()
				{
					var text=GetURLOutput("index.php?page=action&action=generatepass");
					document.getElementById("pass").value=text;
					document.getElementById("passconf").value=text;
					ChangeColorPassword();
					document.getElementById("pass").type="text";
					document.getElementById("passconf").type="text";
				}
			</script>
			<fieldset><legend><strong>Création d'un VPS</strong></legend>
				<table border="\&quot;0\&quot;" align="center" >
					<tr>
						<th> 
							<center>
								<form id="form1" name="form1" method="post" action="index.php?page=action&amp;action=create_vps">
									<table width="100%" border="0">
										<tr>
										<td>Plan</td>
										<td><label>
											<select name="plan" id="plan">
<?php
	$plans = Plan::GetPlanList();
	foreach ($plans as $plan)
	{
		$planid=$plan["id"];
		$plannom=$plan["nom"];
		echo "
											<option value=\"$planid\">$plannom</option>";
	}
?>
											</select>
										</label></td>
									</tr>
									<tr>
										<td>Server</td>
										<td>
											<label>
												<select name="server" id="server">
<?php
	$servers = Server::GetServerList();
	echo count($servers);
	foreach ($servers as $server)
	{
		$serverid=$server["id"];
		$servernom=$server["nom"];
		echo "
											<option value=\"$serverid\">$servernom</option>";
	}
?>	
												</select>
											</label>
										</td>
                                    </tr>
									<tr>
                                        <td>Ip</td>
										<td>
											<label>
												<select name="ip" id="ip">
<?php
	$ips = Ip::GetIpDispoList();
	echo count($ip);
	foreach ($ips as $ip)
	{
		$ipid=$ip["id"];
		$ipentier=$ip["ip"];
		$ipdns=$ip["reverse_original"];
		echo "
											<option value=\"$ipid\">$ipentier --> $ipdns</option>";
	}
?>	
												</select>
										  </label>
										</td>
									</table>
									<p>
										<label>
											<input type="submit" name="Envoyer" id="Envoyer" value="Envoyer" />
										</label>
									</p>
								</form>
							</center>
						</th>
					</tr>
				</table>
			</fieldset>
			<script language="JavaScript" type="text/javascript">
				document.getElementById("pass").onkeyup=ChangeColorPassword;
				document.getElementById("passconf").onkeyup=ChangeColorPassword;
				document.getElementById("pass").onchange=ChangeColorPassword;
				document.getElementById("passconf").onchange=ChangeColorPassword;
				function ChangeColorPassword()
				{
					document.getElementById("pass").type="password";
					document.getElementById("passconf").type="password";
					var color="FFFFFF";
					if (document.getElementById("pass").value==document.getElementById("passconf").value &&
						document.getElementById("pass").value!="")
						color='#A4FFA4';
					else
						color='#FFA4A4';
					document.getElementById("pass").style.backgroundColor=color;
					document.getElementById("passconf").style.backgroundColor=color;
				}
				
				document.getElementById("mail").onkeyup=ChangeColorMail;
				document.getElementById("mailconf").onkeyup=ChangeColorMail;
				document.getElementById("mail").onchange=ChangeColorMail;
				document.getElementById("mailconf").onchange=ChangeColorMail;
				function ChangeColorMail()
				{
					var color="FFFFFF";
					if (document.getElementById("mail").value==document.getElementById("mailconf").value &&
						GetURLOutput("index.php?page=action&action=validemail&email="+document.getElementById("mail").value)=="true")
						color='#A4FFA4';
					else
						color='#FFA4A4';
					document.getElementById("mail").style.backgroundColor=color;
					document.getElementById("mailconf").style.backgroundColor=color;
				}

				if (document.getElementById("pass").value!="" || document.getElementById("passconf").value!="")
					ChangeColorPassword();

				if (document.getElementById("mail").value!="" || document.getElementById("mailconf").value!="")
					ChangeColorMail();	
					

			</script>
<?php
		vider_variables_formulaire();
?>
