<?php
//session_set_cookie_params("0",dirname($_SERVER["SCRIPT_NAME"]));
session_start();
Session::restaurer();

/**
* Class Session
*/
class Session
{
	public static $Client;
	public static $Admin;
	
	
	public static function LoginFail()
	{
		if (!isset($_SESSION["SESSDATALOGIN"]["loginfail"]))
			$_SESSION["SESSDATALOGIN"]["loginfail"]=0;
			
		$_SESSION["SESSDATALOGIN"]["loginfail"]=$_SESSION["SESSDATALOGIN"]["loginfail"]+1;
		$_SESSION["SESSDATALOGIN"]["loginlasttry"]=time();
		
		if (Session::TryLeft()!=0)
			passer_message_info("Nombre de tentative restante: ".Session::TryLeft(),ALERTE);
	}
	
	public static function CanLog()
	{
		if (!isset($_SESSION["SESSDATALOGIN"]) || $_SESSION["SESSDATALOGIN"]["loginfail"]<LOGIN_MAX_TRY)
		{
			return true;
		}else if (time()-$_SESSION["SESSDATALOGIN"]["loginlasttry"]>=LOGIN_NEXT_TRY)
		{
			$_SESSION["SESSDATALOGIN"]["loginfail"]=0;
			return true;
		}
	}
	
	public static function NextTry()
	{
		return $_SESSION["SESSDATALOGIN"]["loginlasttry"]+LOGIN_NEXT_TRY-time();
	}
	
	public static function TryLeft()
	{
		if (!isset($_SESSION["SESSDATALOGIN"]["loginfail"]))
			$_SESSION["SESSDATALOGIN"]["loginfail"]=0;
		return LOGIN_MAX_TRY-$_SESSION["SESSDATALOGIN"]["loginfail"];
	}

	/**
	* Permet de savoir si une session est ouverte
	*/
	public static function Ouverte()
	{
		return isset($_SESSION["SESSDATA"]);
	}

	/**
	*  Ouvre une session avec les informations de l'utilisateur
	*
	* array_utilisateur : tableau contenant les informations de l'utilisateur
	*/
	public static function Ouvrir($array_utilisateur,$admin=false)
	{
		$_SESSION["SESSDATA"]["client"]=$array_utilisateur;
		$_SESSION["SESSDATA"]["admin"]=$admin;
		self::restaurer();
	}
	
	/**
	* Fermer la session si elle est ouverte
	*/
	public static function Fermer()
	{
		unset($_SESSION["SESSDATA"]);
		passer_message_info("Vous avez été déconnecter",OK);
	}
	
	/**
	* Permet de restaurer les informations de la session dans la classe Session
	*/
	public static function Restaurer()
	{
		if(self::ouverte())
		{
			$data=$_SESSION["SESSDATA"];
			self::$Client=$data["client"];
			self::$Admin=$data["admin"];
		}		
	}	
}

defined("INC") or die("403 restricted access");
?>