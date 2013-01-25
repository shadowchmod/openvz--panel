<?php
	define("INC",1);
	// Inclut toutes les sources du dossier inclut
	require("include/all.php");
	// Initialise la base de donn�e
	$active=DB::Init();
	
	if ( isset ( $_GET["page"] ) )
	{
          $var = $_SERVER["REQUEST_URI"];
     }
	else
	{
          $var = "/index.php";
	}
	
	$var_encoer = rawurlencode($var);
	// Si on appelle la page action alors on l'inclut avant pour pouvoir utiliser les header("Location: ...")
	if (@$_GET['page']=="action")
	{
		include("pages/action.php");
	}else{

		include('pages/entete.php');
          if (Session::Ouverte()==false)
          {
               if (isset($_GET["page"]) && $_GET["page"]=="invoice")
               {
                    include("pages/invoice.php");
               }
			   elseif (isset($_GET["page"]) && $_GET["page"]=="2co")
               {
                    include("pages/2co.php");
               }elseif(isset($_GET["page"]) && $_GET["page"]=="details_maintenance"){
			    include("pages/details_maintenance.php");
			   }else{
                    include('pages/login.php');
               }
          }else{
               if ($active)
               {		
                    if (@$_GET["page"]!="action")
                    {
                         // V�rifie si des message sont mis en attente
                         if (existe_message_info())
                         {
                              // Affiche les message d'erreur ou de r�ussite
                              message_info();
                         }
                    }
               
                    //Si aucune session en cour, on affiche le formulaire
                    
                    if (@$_GET['page']!="action")
                    {
                         if (isset($_GET["page"]))
                         {
                              $id_client=@Session::$Client->Id;
                              
                              $page = $_GET["page"];
                              $req_plan = DB:: SQLToArray("SELECT * FROM client WHERE id='$id_client' ") or die(mysql_error());
                              $admin_acces = $req_plan[0]['admin'];
                              if ( preg_match("#admin#", $page ) AND $admin_acces != 1)
                              {
                                   if ( $id_client = NULL )
                                   {
                                        $id_client = "0";
                                   }
                                   $message=mysql_real_escape_string('Le '.date('d/m/y H:i:s').' une personne a essayer d acceder a une page admin. Page : '.$page.'');
                                             $time=time();
                                             $ip=$_SERVER['REMOTE_ADDR'];
                                   echo "<center><strong>Acc�s interdit !<br />Cette acc�s est reserver au administrateur du site uniquement !</strong></center>";
                              //	mysql_query("INSERT INTO `cmdweb_panel`.`warning` (`id`, `id_client`, `ip`, `message`, `page`, `time`, `type`, `TYPE_W`) VALUES (NULL, '".$id_client."', '".$ip."', '".$message."', '', '".$time."', 'ACCES_DENY', 'CLIENT'))";
                              }
                              else
                              {
                                   
                                   if (file_exists("pages/".$_GET["page"].".php") && !strstr ($_GET["page"],".."))
                                        include("pages/".$_GET["page"].".php");
                                   else // Sinon la page n'existe pas alors on affiche une message d'erreur
                                        Message("Erreur 404 : Impossible de trouver la page",ALERTE);
                              }				
                         }else{
                              if (Session::Ouverte()==false)
                              {
                                   include('pages/login.php');
                              }else{
                                   include('pages/menu.php');
                                   $id_client=@Session::$Client->Id;
                                   $req_plan = DB:: SQLToArray("SELECT * FROM client WHERE id='$id_client' ") or die(mysql_error());
                                   $admin_acces = $req_plan[0]['admin'];
                                   if ($admin_acces == "1")
                                   {
                                        include('pages/admin/espace_admin.php');
                                   }
                                   include('pages/espace_client.php');
                              }
                         }
                    }


               }else{
                    Message("Erreur de connection � la base de donn�e",ALERTE);
                    include('pages/login.php');
               }
          }
			
		include('pages/piedpage.php');
	}
?>
