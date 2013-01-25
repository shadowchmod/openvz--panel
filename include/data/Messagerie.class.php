<?php

class Messagerie
{
  //Retoune si un nouveau message est disponible
  public static function GetNewMessage($id_client)
	{
		$vpsarray=DB::SqlToArray("SELECT * FROM messagerie_objet WHERE new_client=1 AND id_client=$id_client");
		if (count($vpsarray)>0)
			return count($vpsarray);
		else
      return false;
	}


  //Retourne les objet des message du client
	public static function GetObjetList($idclient)
	{
		return DB::SqlToArray("SELECT * FROM messagerie_objet WHERE id_client=$idclient ORDER BY new_client DESC ,date DESC");
	}
	
	//Retourne les messages de objet slectionné 
	public static function GetMessageObjet($idobjet)
	{
    DB::Sql("UPDATE messagerie_objet SET new_client=0 WHERE id=".$idobjet);
		return DB::SqlToArray("SELECT * FROM messagerie_message WHERE id_objet=$idobjet ORDER BY date DESC");
	}
	
	//Retourne les messages de objet slectionné 
	public static function GetClientObjet($idobjet)
	{
		$objetarray=DB::SqlToArray("SELECT * FROM messagerie_objet WHERE id=$idobjet LIMIT 1");
		if (count($objetarray)==1)
			return $objetarray[0]['id_client'];
		else
      return false;
	}
	
	//INscrit nouveau message dans un objet 
	public static function PostMessage($idobjet,$idclient,$message)
	{
    $date=date("Y-m-d H:i:s");//2009-10-06 22:30:16
    DB::Sql("UPDATE messagerie_objet SET new_admin=1 WHERE id=".$idobjet);
		return DB::Sql("INSERT INTO messagerie_message (id,id_objet,date,message,id_client) VALUES ('','$idobjet','$date','$message','$idclient')");
	}
	
	//INscrit nouveau un nouveau objet 
	public static function NewObjet($idclient,$objet)
	{
    $date=date("Y-m-d H:i:s");
		return DB::Sql("INSERT INTO messagerie_objet (id,date,objet,id_client,status,new_client) VALUES ('','$date','$objet','$idclient','1','0')");
	}
  
  //Fonction admin
  //Retourne les objet des message du client
	public static function GetObjetAdmin()
	{
		return DB::SqlToArray("SELECT messagerie_objet.id,messagerie_objet.date,
                            messagerie_objet.objet,messagerie_objet.new_admin,client.nom,client.prenom
                            FROM messagerie_objet,client 
                            WHERE id_client=client.id 
                            ORDER BY new_admin DESC ,date DESC");
	}
	
	//Retourne les messages de objet slectionné 
	public static function GetMessageObjetAdmin($idobjet)
	{
    DB::Sql("UPDATE messagerie_objet SET new_admin=0 WHERE id=".$idobjet);
		return DB::SqlToArray("SELECT * FROM messagerie_message WHERE id_objet=$idobjet ORDER BY date DESC");
	}
	
		public static function PostMessageAdmin($idobjet,$message)
	{
    $date=date("Y-m-d H:i:s");//2009-10-06 22:30:16
    DB::Sql("UPDATE messagerie_objet SET new_client=1 WHERE id=".$idobjet);
		return DB::Sql("INSERT INTO messagerie_message (id,id_objet,date,message,id_client) VALUES ('','$idobjet','$date','$message','0')");
	}
}

?>