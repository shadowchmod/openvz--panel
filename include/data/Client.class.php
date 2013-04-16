<?php

/**
* Classe User
* Permet la connexion/déconnexion d'un client, recherche de membre,...
*/
class Client
{
	var $Id;
	var $Nom;
	var $Prenom;
	var $Email;
	var $TelFixe;
	var $TelMobile;
	var $Password;
	var $NikHandle;
	var $Etat;
	var $Ville;
	var $Cp;
	var $Adresse;
	var $Pays;
	

//inscription via formulaire
	public static function Inscription($nik,$nom,$prenom,$mail,$mailconf,$pass,$passconf,$telfixe,$telmobile,$adresse,$ville,$cp,$pays)
	{
		$nik=ProtectSQL($nik);
                $nom=ProtectSQL($nom);
                $prenom=ProtectSQL($prenom);
                $mail=ProtectSQL($mail);
                $mailconf=ProtectSQL($mailconf);
                $pass=ProtectSQL($pass);
                $passconf=ProtectSQL($passconf);
                $telfixe=ProtectSQL($telfixe);
                $telmobile=ProtectSQL($telmobile);
                $adresse=ProtectSQL($adresse);
                $ville=ProtectSQL($ville);
                $cp=ProtectSQL($cp);
                $pays=ProtectSQL($pays);
		// Si le nik saisie existe deja alors on définie error à true et on passe un message d'erreur
                if (self::Existe($nik)){
                        passer_message_info("Nik déja utilisé",ALERTE);
                        $error=true;
                }else if (strlen($nik)<6) // Sinon si le nik est trop court alors on définie error à true et on passe un message d'erreur
                {
                        passer_message_info("Longeur du nik inférieur à 6 caractére",ALERTE);
                        $error=true;
                }

                if ($mail=="" | !ValidMail($mail)) // Si l'email 1 ne correspond pas à l'email 2 ou 
                //que l'email 1 n'est pas une adresse valide alors on définie error à true et on passe un message d'erreur
                {
                        passer_message_info("Adresse e-mail invalide",ALERTE);
                        $error=true;
                }else if ($mail!=$mailconf)
                {
                        passer_message_info("Adresse e-mail incorrect",ALERTE);
                        $error=true;
                }


		// Si la longeur du nom est trop long alors on affiche un message d'erreur et on définit une erreur
                if (strlen($nom)>30)
                {
                        passer_message_info("Le longueur du nom est supérieur à 30 caractéres",ALERTE);
                        $error=true;
                }

                // Si la longeur du prenom est trop long alors on affiche un message d'erreur et on définit une erreur
                if (strlen($prenom)>30)
                {
                        passer_message_info("Le longueur du prenom est supérieur à 30 caractéres",ALERTE);
                        $error=true;
                }

		if (strlen($pass)<6) // Si le mot de passe est vide
                {
                        passer_message_info("Mot de passe trop court, 6 caractéres minimum",ALERTE);
                        $error=true;
                }else if ($pass!=$passconf) // Si le mot de passe 1 ne correspond pas au mot de passe 2 alors on définie error à true et on passe un message d'erreur
                {
                        passer_message_info("Mot de passe incorect",ALERTE);
                        $error=true;
                }
		// Si il y a des erreurs alors on retourne false
		if ($error==true)
			return false;
			
		// Sinon on crypte le mot de passe
		$pass=MD5($pass);
		// Et on execute la requete d'insertion d'un client
                $requete = "INSERT INTO client (
`id`, 
`nom`, 
`prenom`, 
`email`, 
`tel_fixe`, 
`tel_mobile`, 
`password`, 
`nikhandle`, 
`etat`, 
`ville`, 
`cp`, 
`adresse`, 
`pays`, 
`credit`, 
`langue`, 
`ip_register`, 
`status`, 
 `admin` ) VALUES ( NULL, '$nom' , '$prenom' , '$mail' , '$telfixe', '$telmobile', '$pass', '$nik', 1, '$ville', '$cp', '$adresse', '$pays', '', '', '', '', '0')";

                // Sinon l'inscription est un succée alors on passe un message de réussite et on retourne true
                if (DB::Sql($requete))
                {
                        $headers ='From: "your-domaine"<support@your-domaine.fr>'."\n";
                        $headers .='Reply-To: support@hyour-domaine.fr'."\n";
                        $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
                        $headers .='Content-Transfer-Encoding: 8bit';

                        $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Vos identifiants [your-domaine]</title>
</head>

<body>
<p>Bienvenue chez your-domaine.fr.</p>
<p>Vos identifiants sont :</p>
<blockquote>
        <p>Nik-handle : <strong>$nik<br />
        </strong>Mot de passe : <strong>$pass</strong></p>
</blockquote>
<p>Pour vous connectez, veuiller vous rendre à cette adresse : <a href=\"http:/urldevotre.com/panel/\">http:urldevotrepanel.com/</a> .</p>
Pour plus d'information merci de contacter le support.<br/>
Cordialement,<br/>
L'equipes de your-domaine.fr.<br/>
Site web : <a href=\"http://your-domaine.fr\">http://your-domaine.fr</a><br/>
Forum : <a href=\"http://your-domaine.fr\">http://your-domaine.fr</a><br/>
Contact email : support@your-domaine.fr
</body>
</html>";
                        mail($mailconf, 'Vos identifiants [your-domaine]', $message, $headers);

                        passer_message_info("Inscription du client terminer",OK);
                        return true;
                }else{ // Sinon on passe un message d'erreur  et on retourne false
                        passer_message_info("Erreur lors de la création du client",ALERTE);
                        return false;
                }
        }

	/**
	* Retourne les information d'un membre à partir de son identifiant
	*
	* id : identifiant du membre
	*/
	public static function GetClient($id)
	{
		// Récupére les information d'un membre
		$users=DB::SqlToArray("SELECT * FROM client WHERE `id`=$id");
		// Retourne les informations du membre
		if (count($users)==1)
			return $users[0];
		else 
			return false;
	}
	
	
	public static function GetClientFromNik($nik)
	{
		$nik=ProtectSQL($nik);
		// Récupére les information d'un membre
		$users=DB::SqlToArray("SELECT * FROM client WHERE `nikhandle`='$nik'");
		// Retourne les informations du membre
		if (count($users)==1)
			return $users[0];
		else 
			return false;
	}
	
	/**
	* Retourne la liste des clients
	*/
	public static function GetClientList($page=1,$parPage=20,$sortid=0)
	{
		switch ($sortid)
		{
		case 0:
			$sort="id";
			break;
		case 1:
			$sort="nikhandle";
			break;
		case 2:
			$sort="nom";
			break;
		case 3:
			$sort="prenom";
			break;
		case 4:
			$sort="email";
			break;
		case 5:
			$sort="etat";
			break;
		}

		$start=($page-1)*$parPage;
		$users=DB::SqlToArray("SELECT * FROM `client` ORDER BY `client`.`$sort` ASC LIMIT $start , $parPage");
		return $users;
	}
	
	public static function GetClientCount()
	{
		return DB::SqlCount("SELECT * FROM `client`");
	}
	
	/**
	* Inscrit un nouveau membre
	*
	* nik : nik du nouveau membre
	* nom : nom du nouveau membre
	* prenom : prenom du novueau membre
	* mail2 : mail du nouveau membre
	* mail2 :verification du  mail du nouveau membre
	* pass1 : mot de passe du nouveau membre
	* pass2 : verification du mot de passe du nouveau membre
	* telfixe : téléphone fixe
	* telmobile : télécphone mobile
	*/	
	public static function Inscrire($nik,$nom,$prenom,$mail1,$mail2,$pass1,$pass2,$telfixe,$telmobile)
	{
		passer_message_info($mail1);
		passer_message_info($mail2);
		echo $mail2;
		$error=false;
		// Si le nik saisie existe deja alors on définie error à true et on passe un message d'erreur
		if (self::Existe($nik))
		{
			passer_message_info("Nik déja utilisé",ALERTE);
			$error=true;
		}else if (strlen($nik)<6) // Sinon si le nik est trop court alors on définie error à true et on passe un message d'erreur
		{
			passer_message_info("Longeur du nik inférieur à 6 caractére",ALERTE);
			$error=true;
		}

		if ($mail1=="" | !ValidMail($mail1)) // Si l'email 1 ne correspond pas à l'email 2 ou 
		//que l'email 1 n'est pas une adresse valide alors on définie error à true et on passe un message d'erreur
		{
			passer_message_info("Adresse e-mail invalide",ALERTE);
			$error=true;
		}else if ($mail1!=$mail2)
		{
			passer_message_info("Adresse e-mail incorrect",ALERTE);
			$error=true;
		}
	
		if (strlen($pass1)<6) // Si le mot de passe est vide
		{
			passer_message_info("Mot de passe trop court, 6 caractéres minimum",ALERTE);
			$error=true;
		}else if ($pass1!=$pass2) // Si le mot de passe 1 ne correspond pas au mot de passe 2 alors on définie error à true et on passe un message d'erreur
		{
			passer_message_info("Mot de passe incorect",ALERTE);
			$error=true;
		}
		
		// Si la longeur du nom est trop long alors on affiche un message d'erreur et on définit une erreur
		if (strlen($nom)>30)
		{
			passer_message_info("Le longueur du nom est supérieur à 30 caractéres",ALERTE);
			$error=true;
		}
		
		// Si la longeur du prenom est trop long alors on affiche un message d'erreur et on définit une erreur
		if (strlen($prenom)>30)
		{
			passer_message_info("Le longueur du prenom est supérieur à 30 caractéres",ALERTE);
			$error=true;
		}

		// Si il y a des erreurs alors on retourne false
		if ($error==true)
			return false;
			
		// Sinon on crypte le mot de passe
		$pass1=MD5($pass1);
		// Et on execute la requete d'insertion d'un client
		$requete = "INSERT INTO client (
`id` ,
`nom` ,
`prenom` ,
`email` ,
`tel_fixe` ,
`tel_mobile` ,
`password` ,
`nikhandle` ,
`etat` ) VALUES ( NULL, '$nom' , '$prenom' , '$mail1' , '$telfixe', '$telmobile', '$pass1', '$nik', 1)";
		// Sinon l'inscription est un succée alors on passe un message de réussite et on retourne true
		if (DB::Sql($requete))
		{
			$headers ='From: "your-domaine"<support@your-domaine.fr>'."\n";
			$headers .='Reply-To: support@hyour-domaine.fr'."\n";
			$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
			$headers .='Content-Transfer-Encoding: 8bit';
			
			$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Vos identifiants [your-domaine]</title>
</head>

<body>
<p>Bienvenue chez your-domaine.fr.</p>
<p>Vos identifiants sont :</p>
<blockquote>
	<p>Nik-handle : <strong>$nik<br />
	</strong>Mot de passe : <strong>$pass2</strong></p>
</blockquote>
<p>Pour vous connectez, veuiller vous rendre à cette adresse : <a href=\"http://178.32.40.40/panel/\">http://178.32.40.40/panel/</a> .</p>
Pour plus d'information merci de contacter le support.<br/>
Cordialement,<br/>
L'equipes de your-domaine.fr.<br/>
Site web : <a href=\"http://your-domaine.fr\">http://your-domaine.fr</a><br/>
Forum : <a href=\"http://your-domaine.fr\">http://your-domaine.fr</a><br/>
Contact email : support@your-domaine.fr
</body>
</html>";
			
			mail($mail2, 'Vos identifiants [your-domaine]', $message, $headers);

			passer_message_info("Inscription du client terminer",OK);
			return true;
		}else{ // Sinon on passe un message d'erreur  et on retourne false
			passer_message_info("Erreur lors de la création du client",ALERTE);
			return false;
		}
	}
	
	/**
	* Inscrit un nouveau membre
	*
	* nik : nik du nouveau membre
	* nom : nom du nouveau membre
	* prenom : prenom du novueau membre
	* mail2 : mail du nouveau membre
	* mail2 :verification du  mail du nouveau membre
	* pass1 : mot de passe du nouveau membre
	* pass2 : verification du mot de passe du nouveau membre
	* telfixe : téléphone fixe
	* telmobile : télécphone mobile
	*/	
	public static function Edit($id,$nik,$nom,$prenom,$mail,$telfixe,$telmobile,$blocked)
	{
		$error=false;
		$client = Client::GetClient($id);
		// Si le nik saisie existe deja alors on définie error à true et on passe un message d'erreur
		if (self::Existe($nik) && $client["nikhandle"]!=$nik)
		{
			passer_message_info("Nik déja utilisé",ALERTE);
			$error=true;
		}else if (strlen($nik)<6) // Sinon si le nik est trop court alors on définie error à true et on passe un message d'erreur
		{
			passer_message_info("Longeur du nik inférieur à 6 caractére",ALERTE);
			$error=true;
		}

		if ($mail=="" | !ValidMail($mail)) // Si l'email 1 ne correspond pas à l'email 2 ou 
		//que l'email 1 n'est pas une adresse valide alors on définie error à true et on passe un message d'erreur
		{
			passer_message_info("Adresse e-mail invalide",ALERTE);
			$error=true;
		}
		
		// Si la longeur du nom est trop long alors on affiche un message d'erreur et on définit une erreur
		if (strlen($nom)>30)
		{
			passer_message_info("Le longueur du nom est supérieur à 30 caractéres",ALERTE);
			$error=true;
		}
		
		// Si la longeur du prenom est trop long alors on affiche un message d'erreur et on définit une erreur
		if (strlen($prenom)>30)
		{
			passer_message_info("Le longueur du prenom est supérieur à 30 caractéres",ALERTE);
			$error=true;
		}

		// Si il y a des erreurs alors on retourne false
		if ($error==true)
			return false;
			
		$id=ProtectSQL($id);
		$nik=ProtectSQL($nik);
		$nom=ProtectSQL($nom);
		$prenom=ProtectSQL($prenom);
		$mail=ProtectSQL($mail);
		$telfixe=ProtectSQL($telfixe);
		$telmobile=ProtectSQL($telmobile);
		
		// Et on execute la requete d'edition d'un client
		$requete = "UPDATE `client` 
			SET `nikhandle` = '$nik',
			`nom` = '$nom',
			`prenom` = '$prenom',
			`email` = '$mail',
			`tel_fixe` = '$telfixe',
			`tel_mobile` = '$telmobile',
			`etat` = '$blocked'
			WHERE `id` = $id LIMIT 1";
		echo $requete;
		// Sinon l'inscription est un succée alors on passe un message de réussite et on retourne true
		if (DB::Sql($requete))
		{
			passer_message_info("Edition du profil terminer",OK);
			return true;
		}else{ // Sinon on passe un message d'erreur  et on retourne false
			passer_message_info("Erreur lors de l'édition du profil",ALERTE);
			return false;
		}
	}
	

	public static function EditInfoClient($client, $adresse, $ville, $cp, $pays){
		$adresse=ProtectSQL($adresse);
		$ville=ProtectSQL($ville);
		$cp=ProtectSQL($cp);
		$pays=ProtectSQL($pays);
		$requete = "UPDATE `client` 
			SET `adresse` = '$adresse',
			`ville` = '$ville',
			`cp` = '$cp',
			`pays` = '$pays'
			WHERE `id` = $client LIMIT 1";
		if (DB::Sql($requete))
		{
			passer_message_info("Edition du profil terminer",OK);
			return true;
		}else{ // Sinon on passe un message d'erreur  et on retourne false
			passer_message_info("Erreur lors de l'édition du profil",ALERTE);
			return false;
		}


	}

	public static function ChangeNik($client, $value)
	{
		if (Client::Existe($value)==false)
		{
			$valueP=ProtectSQL($value);
			if (DB::Sql("UPDATE client SET nikhandle='$valuep' WHERE id=$client LIMIT 1"))
			{
				if (Session::Ouverte() && Session::$Client && Session::$Client->Id=$client)
					Session::$Client->NikHandle=$value;
				passer_message_info("Nik changer",OK);
				return true;
			}else{
				passer_message_info("Erreur lors du changement de nik",ALERTE);
			}
		}else{
			passer_message_info("Nik déja utilisé",ALERTE);
		}
		return false;
	}
	
	public static function ChangeNom($client, $value)
	{
		$valueP=ProtectSQL($value);
		if (DB::Sql("UPDATE client SET nom='$valuep' WHERE id=$client LIMIT 1"))
		{
			if (Session::Ouverte() && Session::$Client && Session::$Client->Id=$client)
				Session::$Client->Nom=$value;
			passer_message_info("Nom changer",OK);
			return true;
		}else{
			passer_message_info("Erreur lors du changement de nom",ALERTE);
			return false;
		}
	}
	
	public static function ChangePrenom($client, $value)
	{
		$valueP=ProtectSQL($value);
		if (DB::Sql("UPDATE client SET prenom='$valuep' WHERE id=$client LIMIT 1"))
		{
			if (Session::Ouverte() && Session::$Client && Session::$Client->Id=$client)
				Session::$Client->Prenom=$value;
			passer_message_info("Prénom changer",OK);
			return true;
		}else{
			passer_message_info("Erreur lors du changement de prénom",ALERTE);
			return false;
		}
	}
	
	public static function ChangeMail($client, $value)
	{
		if (ValidMail($value))
		{
			$valueP=ProtectSQL($value);
			if (DB::Sql("UPDATE client SET email='$valueP' WHERE id=$client LIMIT 1"))
			{
				if (Session::Ouverte() && Session::$Client && Session::$Client->Id=$client)
					Session::$Client->Email=$value;
				passer_message_info("E-mail changer",OK);
				return true;
			}else{
				passer_message_info("Erreur lors du changement d'e-mail",ALERTE);
			}
		}else{
				passer_message_info("E-mail non valide",ALERTE);
		}
		return false;
	}
	
	public static function ChangeTelFixe($client, $value)
	{
		$valueP=ProtectSQL($value);
		if (DB::Sql("UPDATE client SET tel_fixe='$valuep' WHERE id=$client LIMIT 1"))
		{
			if (Session::Ouverte() && Session::$Client && Session::$Client->Id=$client)
				Session::$Client->TelFixe=$value;
			passer_message_info("Téléphone fixe changer",OK);
			return true;
		}else{
			passer_message_info("Erreur lors du changement de téléphone fixe",ALERTE);
			return false;
		}
	}
	
	public static function ChangeTelMobile($client, $value)
	{
		$valueP=ProtectSQL($value);
		if (DB::Sql("UPDATE client SET tel_mobile='$valuep' WHERE id=$client LIMIT 1"))
		{
			if (Session::Ouverte() && Session::$Client && Session::$Client->Id=$client)
				Session::$Client->telMobile=$value;
			passer_message_info("Téléphone mobile changer",OK);
			return true;
		}else{
			passer_message_info("Erreur lors du changement de téléphone mobile",ALERTE);
			return false;
		}
	}	
	
	public static function ChangePassword($client, $pass)
	{
		$md5pass=md5($pass);
		if (DB::Sql("UPDATE client SET password='$md5pass' WHERE id='$client' LIMIT 1"))
		{
			passer_message_info("Mot de passe changer",OK);
			return true;
		}else{
			passer_message_info("Erreur lors du changement du mot de passe",ALERTE);
			return false;
		}
	}
	
	public static function RegenPassword($client)
	{
		$detailclient=Client::GetClient($client);
		$nik=$detailclient["nikhandle"];
		$pass=strtoupper(substr(md5(rand(0,99999999999999)),0,9));
		if (Client::ChangePassword($client,$pass))
		{
			$headers ='From: "Heberge-hd"<support@hyour-domaine.fr>'."\n";
			$headers .='Reply-To: support@your-domaine.fr'."\n";
			$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
			$headers .='Content-Transfer-Encoding: 8bit';
			
			$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Vos identifiants [your-domaine]</title>
</head>

<body>
<p>Bienvenue chez your-domaine.fr.</p>
<p>Vos identifiants sont :</p>
<blockquote>
	<p>Nik-handle : <strong>$nik<br />
	</strong>Mot de passe : <strong>$pass</strong></p>
</blockquote>
<p>Pour vous connectez, veuiller vous rendre à cette adresse : <a href=\"http://panel.your-domaine.info/\">http://panel.your-domaine.info</a> .</p>
Pour plus d'information merci de contacter le support.<br/>
Cordialement,<br/>
L'equipes de your-domaine.fr.<br/>
Site web : <a href=\"http://your-domaine.fr\">http://your-domaine.fr</a><br/>
Forum : <a href=\"http://your-domaine.fr\">http://your-domaine.fr</a><br/>
Contact email : support@your-domaine.fr
</body>
</html>";
			
			mail($detailclient["email"], 'Vos identifiants [your-domaine.fr]', $message, $headers);
			return $pass;
		}else{
			return false;
		}
	}
	
	/**
	* Permet de savoir si un nik est deja utiliser
	*
	* nik : nik à verifier
	*/
	public static function Existe($nik)
	{
		// Si le nomre de résultat est égale à 1 alors on retourne true
		if (DB::SqlCount("SELECT * FROM client WHERE nikhandle='$nik'")==1)
			return true;
		else // Sinon on retourne false
			return false;
	}
	
	/**
	* Permet de connecter un client
	*
	* nik : nik du membre à connecter
	*
	* pass : mot de passe du membre à connecter
	*/
	public static function SeConnecter($nik,$pass)
	{
		// Crypte le mot de passe
		$pass=MD5($pass);
		// On empéche l'injection SQL
		$nik=ProtectSQL($nik);
		$Admin=false;
		/*if ($nik==ADMIN_LOGIN && $pass==MD5(ADMIN_PASS))
		{
			Session::Ouvrir(NULL,true);
			passer_message_info("Vous êtes maintenant connecté en tant qu'administrateur",OK);
			return true;
		}else */
		if (count($user=DB::SqlToArray("SELECT * FROM client WHERE nikhandle='$nik' AND password='$pass'"))==1)
		{
			if ($user[0]['etat']==1)
			{
				$sess=new Client;
				$sess->Id=$user[0]['id'];
				$sess->Nom=$user[0]['nom'];
				$sess->Prenom=$user[0]['prenom'];
				$sess->Email=$user[0]['email'];
				$sess->TelFixe=$user[0]['tel_fixe'];
				$sess->TelMobile=$user[0]['tel_mobile'];
				$sess->Password=$user[0]['password'];
				$sess->NikHandle=$user[0]['nikhandle'];
				$sess->Etat=$user[0]['etat'];
				$sess->Ville=$user[0]['cp'];
				if ($sess->Id==1)
				{
					Session::Ouvrir($sess,true);
					passer_message_info("Vous êtes maintenant connecté en tant qu'administrateur",OK);
				}else{
					Session::Ouvrir($sess,false);		
					passer_message_info("Vous êtes maintenant connecté",OK);
				}
				return true;
			}else{
				passer_message_info("Votre compte client est bloqué, veuillez contacter l'administrateur",ALERTE);
				return true;
			}
		}else{ // Sinon on passe un message d'erreur
			passer_message_info("Nik-handle et ou mot de passe invalide",ALERTE);
			return false;
		}
	}
	
	/**
	* Permet de récuperer le nik d'un membre à partir de son identifiant
	*
	* id : identifiant du membre
	*/
	public static function IdToNik($id)
	{
		// Si l'id est vide alors on retourne false
		if ($id==null)
			return false;
			
		// On récupére le nik de l'client correspondant
		$user=DB::SqlToArray("SELECT nikhandle FROM client WHERE `id`=$id");
		// On retourne le nik du membre
		return $user[0][0];
	}
	
	/**
	* Permet de récuperer l'identifiant d'un membre à partir de son nik
	*
	* nik : nik du membre
	*/
	public static function NikToId($nik)
	{			
		// On récupére l'id du membre à partir de son nik
		$user=DB::SqlToArray("SELECT id FROM client WHERE `nikhandle`='$nik'");
		// On retourne l'id du membre
		return $user[0][0];
	}
	
	
	/**
	* Modifie les informations relative à un membre
	*
	* post : informations  récupérer par un $_POST envoyer par l'client
	*/
	public static function EditerProfile($post)
	{
		// On stocke dans dans variables les données saisie
		$id=$post['id'];
		$nom=$post['nom'];
		$prenom=$post['prenom'];
		$mail=$post['mail'];
		$telfixe=$post['telfixe'];
		$ville=$post['ville'];
		$cp=$post['cp'];
		$adresse=$post['adresse'];
		$pays=$post['pays'];
		
		$error=false;
		
		// On vérifie que le membre connecté modifie son profil ou qu'il est un administrateur
		if (Session::Ouverte() && $id==Session::$Client->Id)
		{
			// Si les mot de passes ne sont pas vide et qu'ils sont identique alors
			if ($post['pass1']==$post['pass2'] && $post['pass1']!="")
			{
				// On crypte le mot de passe
				$pass=MD5($post['pass1']);
				// Et on met à jour le profile de l'uilisateur
				$req="UPDATE client SET `password` = '$pass' WHERE `id`=$id;";
				if (DB::SQL($req)) // Si le mot de passe est modifier alors on passe un message d'info
					passer_message_info("Mot de passe changer",OK);
				else{ // Sinon on passe un message d'erreur et on définie une erreur
					passer_message_info("Erreur lors du changement du mot de passe",ALERTE);
					$error=true;
				}			
			// Sinon si les mot de passe n'est pas vide alors on passe un message d'erreur et on définie une erreur
			}else if ($post['pass1']!="" | $post['pass2']!="") 
			{
				passer_message_info("Vérification du mot de passe érroné",ALERTE);
				$error=true;
			}
			
			// Si la longeur du nom est trop long alors on affiche un message d'erreur et on définit une erreur
			if (strlen($nom)>30)
			{
				passer_message_info("Le longueur du nom est supérieur à 30 caractéres",ALERTE);
				$error=true;
			}
			
			// Si la longeur du prenom est trop long alors on affiche un message d'erreur et on définit une erreur
			if (strlen($prenom)>30)
			{
				passer_message_info("Le longueur du prenom est supérieur à 30 caractéres",ALERTE);
				$error=true;
			}
			
			// Si la longeur du mail est trop long alors on affiche un message d'erreur et on définit une erreur
			if (strlen($mail)>50)
			{
				passer_message_info("Le longueur de l'adresse e-mail est supérieur à 50 caractéres",ALERTE);
				$error=true;
			}						
			
			// Si il n'y a pas d'erreur alors 
			if ($error==false)
			{
				// On met à jour le profile de l'client
				$req="UPDATE client SET `nom`='$nom',`prenom` = '$prenom',`email` = '$mail' WHERE `id` =$id LIMIT 1 ;";
				// Si le profil à était modifié alors en passe un message de réussite et on retourne true
				if (DB::SQL($req))
				{
					passer_message_info("Profile mis à jour",OK);
					return true;
				}else{
				// Sinon on passe un message d'erreur et on retourne false
					passer_message_info("Erreur lors de la modification du client",ALERTE);
					return false;
				}			
			}else // Sinon si il y a des erreurs on retourne false
				return false;
		
		}else{ // Sinon si l'client n'a pas l'authorisation de modifier le profil alors on retourne false
			passer_message_info("Vous n'avez pas l'authorisation de modifier ce profile",ALERTE);
			return false;
		}
	}
	
	public static function SupprimerClient($id)
	{
		
	}
}

defined("INC") or die("403 restricted access");

?>
