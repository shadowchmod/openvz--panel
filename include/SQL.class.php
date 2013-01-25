<?php
/**
* Class DB
* pour la connexion à la base de données et exécuter des requetes SQL
*/
class DB
{
	public static $Base;

	/**
	* Permet de se connecter à la base de donnée
	*/
	public static function Init(){
		debug("ouverture de la base");
		
		self::$Base=@mysql_connect(DB_HOST,DB_USER,DB_PASS);
		@mysql_selectdb(DB_BASE);
		if(mysql_errno()>0){
			debug("Impossible d'ouvrir la base",ERREUR);
			debug(mysql_error());
			return false;
		}
		else{
			debug("Base ouverte ");
			return true;
		}
	}

	/**
	* Execute une requete SQL
	*
	* requete : requete SQL à executer
	*/
	public static function Sql($requete){
		if(!self::$Base)
			self::Init();
		
		debug($requete);
		$resultat= @mysql_query($requete);
	
		if(mysql_errno()>0)
			debug("Impossible d'executer la requête: '".mysql_error()."'",ERREUR);
		else
			return $resultat;
		return FALSE;
	}
	
	/**
	* Permet de retourner l'ID de l'élément inserer avec une requete SQL
	*/
	public static function GetInsertId()
	{
		return mysql_insert_id();
	}

	/**
	* Retourne le contenu d'un requete SQL sous forme de tableau
	*
	* requete : requete SQL à executer
	*/
	public static function SqlToArray($requete){
		$res=self::sql($requete);
		$tab=array();
		if ($res)
			while($row=mysql_fetch_array($res)){
				$tab[]=$row;
			}		

		return $tab;
	}
	
	/**
	* Retourne le nombre de réponse d'une requete SQL
	*
	* requete : requete SQL à executer
	*/
	public static function SqlCount($requete){
		// Execute la requete
		$res=self::sql($requete);
		// si la requete à été executé alors on retourne le nombre de résultat sinon on return false
		if ($res)
		{
			// Compte le nombre de resultat
			$count=mysql_num_rows($res);			
			return $count;	
		}else
			return false;

	}
	/**
	* Permet de savoir si base de donnée est correctement initialisé
	*/
	function BaseOperationnel()
	{
		// Tente de se connecter à la base de donnée
		mysql_selectdb(DB_BASE);
		
		// Si une erreur survient alors retourne false
		if(mysql_errno()>0)
			return false;
			
		// sinon true;
		return true;
	}
	
	/**
	* Permet de créer la base de donée
	*/
	function CreateDatabase()
	{
		passer_message_info("Base de donnée non initialisée",ALERTE);

		return false;
	}
}

defined("INC") or die("403 restricted access");
?>