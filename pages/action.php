<?php
defined("INC") or die("403 restricted access");

vider_variables_formulaire();

switch ($_GET['action'])
{
//DB
case "initdb":
DB::CreateDatabase();
header("Location: index.php");
break;
// Connection d'un utilisateur
case "login":
if (Client::SeConnecter($_POST["login"],$_POST["pass"])==false)
{
if ($_POST["login"]!=NULL)
Session::LoginFail();
}
$refer = rawurldecode($_POST['refer']);

          $refer = substr($refer,1);

header("Location: ".$refer."");
break;
//Inscription 
case "inscription":
if (isset($_POST))
{
        $nik=$_POST["nik"];
        $nom=$_POST["nom"];
        $prenom=$_POST["prenom"];
        $mail=$_POST["mail"];
        $mailconf=$_POST["mailconf"];
        $pass=$_POST["pass"];
        $passconf=$_POST["passconf"];
	$telfixe=$_POST["telfixe"];
	$telmobile=$_POST["telmobile"];
	$adresse=$_POST["adresse"];
	$ville=$_POST["ville"];
	$cp=$_POST["cp"];
	$pays=$_POST["pays"];
	if (Client::Inscription($_POST["nik"],$_POST["nom"],$_POST["prenom"],$_POST["mail"],$_POST["mailconf"],$_POST["pass"],$_POST["passconf"],$_POST["telfixe"],$_POST["telmobile"],$_POST["adresse"],$_POST["ville"],$_POST["cp"],$_POST["pays"]))
        {
            passer_message_info("inscription terminer",OK);
            header("Location: index.php");
        }else{
            passer_message_info("Erreur lors de l inscription",ALERTE);
            header("Location: index.php");
        }

}else{
            passer_message_info("Parametre manquant",AT^LERTE);
            header("Location: index.php");
}
break;
//Dï¿œconnection de la seesion
case "logout":
Session::Fermer();
header("Location: index.php");
break;
//Inscription d'un client
case "ajouter_client":
if (Session::Ouverte() && Session::$Admin=true)
{
if (Client::Inscrire($_POST['nik'],$_POST['nom'],$_POST['prenom'],$_POST['mail'],$_POST['mailconf'],$_POST['pass'],$_POST['passconf'],$_POST['telfixe'],$_POST['telmobile']))
{
header("Location: index.php");
}else{
stocker_variables_formulaire($_POST);
header("Location: index.php?page=admin/ajouter_client");
}
}else{
passer_message_info("Vous ne possï¿œdez pas les droits pour cette action",ALERTE);
header("Location: index.php");
}
break;
//Inscription d'un client
case "newclient":
if (Session::CanLog())
{
if (Client::Inscrire($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['mail'],$_POST['mailconf'], $_POST['pass'],$_POST['passconf'],$_POST['tel_fixe'],$_POST['tel_mobile']))
{
header("Location: index.php");
}else{
stocker_variables_formulaire($_POST);
header("Location: index.php?page=new_client");
}
}else{
passer_message_info("Vous ne possï¿œdez pas les droits pour cette action",ALERTE);
header("Location: index.php");
}
break;
//Edition du profil d'un client(admin)
case "edit_client":
if (Session::Ouverte() && Session::$Admin=true && isset($_POST["id"]))
{
//echo $_POST['blocked'];
if (!Client::Edit($_POST['id'],$_POST['nik'],$_POST['nom'],$_POST['prenom'],$_POST['mail'],$_POST['telfixe'],$_POST['telmobile'],!isset($_POST['blocked'])))
{
stocker_variables_formulaire($_POST);
}
header("Location: index.php?page=admin/detail_client&client=".$_POST['id']);
}else{
passer_message_info("Vous ne possï¿œdez pas les droits pour cette action",ALERTE);
header("Location: index.php");
}
break;
//Edition du profil du client
case "edit_profil":
if (Session::Ouverte() && Session::$Client!=NULL)
{
if (Session::$Client->Email!=$_POST["mail"])
{
if ($_POST["mail"]==$_POST["mailconf"])
{
Client::ChangeMail(Session::$Client->Id,$_POST["mail"]);
}else{
passer_message_info("Adresse e-mail de confirmation incorrect",ALERTE);
}
}

if ( ($_POST["pass"]!="" || !empty($_POST["passconf"]) ) && $_POST["pass"]==$_POST["passconf"])
{
Client::ChangePassword(Session::$Client->Id,$_POST["pass"]);
}else{
if(!empty($_POST["pass"]) || !empty($_POST["passconf"]))
passer_message_info("Mot de passe de confirmation incorrect",ALERTE);
}

Client::EditInfoClient(Session::$Client->Id,$_POST["adresse"], $_POST["ville"], $_POST["cp"], $_POST["pays"]);

header("Location: index.php?page=edit_profil");
}else{
header("Location: index.php");
}
break;
//Regï¿œnï¿œrer le mot de passe (client)
case "regenpassword":
if ( isset($_POST["nik"]))
{
if (($client=Client::GetClientFromNik($_POST["nik"]))!=false)
{
$pass=Client::RegenPassword($client["id"]);
passer_message_info($pass,OK);
if ($pass!=false)
{
effacer_message_info();
passer_message_info("Un e-mail vous ï¿œ ï¿œtï¿œ transmis avec le nouveau mot de passe",OK);
}else{
//effacer_message_info();
passer_message_info("Erreur lors de la rï¿œgï¿œnï¿œration du mot de passe",ALERTE);
}
header("Location: index.php");
}else{
passer_message_info("Nik-Handle non existant",ALERTE);
if ($_POST["nik"]!=NULL)
Session::LoginFail();
header("Location: index.php?page=forget_pass");
}	
}else{
passer_message_info("URL mal formï¿œe",ALERTE);
header("Location: index.php");
}
break;
//Regï¿œnï¿œrer le mot de passe (admin)
case "resetpassword":
if (Session::Ouverte() && Session::$Admin=true && isset($_GET["client"]))
{
if (($pass=Client::RegenPassword($_GET["client"]))!=false)
{
effacer_message_info();
passer_message_info("Mot de passe rï¿œgï¿œnï¿œrer. ".$pass,OK);
}else{
//effacer_message_info();
passer_message_info("Erreur lors de la rï¿œgï¿œnï¿œration du mot de passe",ALERTE);
}
header("Location: index.php?page=admin/detail_client&client=".$_GET["client"]);
}else{
passer_message_info("Vous ne possï¿œdez pas les droits pour cette action",ALERTE);
header("Location: index.php");
}
break;
//Gï¿œnï¿œre un nom de client
case "generatenik":
if (isset($_GET["letters"]))
$letters=substr(strtoupper($_GET["letters"]),0,2);
else
$letters="AB";
$num=rand(10000,99999);
while(Client::Existe($letters.$num."-HD"))
$num=rand(10000,99999);
echo $letters.$num."-HD";	
break;
//Gï¿œnï¿œre un mot de pass
case "generatepass":
$pass=strtoupper(substr(md5(rand(0,99999999999999)),0,9));
echo $pass;
break;
case "validemail":
if (isset($_GET["email"]) && ValidMail($_GET["email"]))
echo "true";
else
echo "false";
break;
//proxmox

case "add_serveur_proxmox":
// voir page suivante "include/data/VPS.class.php"
if (isset($_POST))
{
        $login=$_POST["login"];
        $password=$_POST["password"];
        $ip=$_POST["ip"];
        $host=$_POST["host"];
        $nom=$_POST["nom"];
        $etat=$_POST["etat"];
        $port=$_POST["port"];
    if($root_serveur=VPS::Serveur_Root($_POST["login"],$_POST["password"],$_POST["ip"],$_POST["host"],$_POST["nom"],$_POST["etat"],$_POST["port"]) )
        {
            passer_message_info("Serveur Proxmox ajouter",OK);
            header("Location: index.php?page=admin/detail_serveur_root");
        }else{
            passer_message_info("Erreur lors de l ajout du serveur proxmox",ALERTE);
            header("Location: index.php?page=admin/detail_serveur_root");
        }

}else{
            passer_message_info("Paramï¿œtre manquant",ALERÃE);
            header("Location: index.php?page=admin/detail_serveur_root");
}


break;
//Crï¿œation d'un VPS":
case "create_vps":
if (isset($_POST))
{
        $ipOKvmid=Ip::BlockIP($_POST["ip"],$_POST["server"]);
        if($ipOKvmid!=false){
          $vpsid=VPS::CreateVPS($_POST["plan"],$_POST["server"],$_POST["ip"],$ipOKvmid);
          if ($vpsid!=false)
          {
            passer_message_info("VPS crï¿œer",OK);
            header("Location: index.php?page=admin/detail_vps&vps=$vpsid");	
          }else{
            passer_message_info("Erreur lors de la crï¿œation du VPS",ALERTE);
            header("Location: index.php?page=admin/ajouter_vps");
          }
        }else{
            passer_message_info("Erreur lors de la crï¿œatiodu VPS 1",ALERTE);
            header("Location: index.php?page=admin/ajouter_vps");
        }
}else{
header("Location: index.php?page=admin/ajouter_vps");
}
break;
case "linkvps":
if (isset($_POST))
{
$vpsid=$_POST["vpsid"];
$clientid=$_POST["clientid"];
if (VPS::LinkVPSToClient($vpsid,$clientid))
{
passer_message_info("VPS ajouter au client",OK);
}else{
passer_message_info("Erreur lors de l'ajout du VPS au client",ALERTE);
}
header("Location: index.php?page=admin/detail_client&client=$clientid");	
}else{
passer_message_info("Paramï¿œtre manquant",ALERTE);
header("Location: index.php");
}
break;
case "unlinkvps":
if (isset($_GET["vps"]))
{
$vpsid=$_GET["vps"];
if (VPS::LinkVPSToClient($_GET["vps"],0))
{
passer_message_info("VPS dï¿œbranchï¿œ du client",OK);
}else{
passer_message_info("Erreur lors du dï¿œbranchement du VPS au client",ALERTE);
}
header("Location: index.php?page=admin/detail_vps&vps=$vpsid");	
}else{
passer_message_info("Paramï¿œtre manquant",ALERTE);
header("Location: index.php");
}	
break;
//Bloquer le serveur au client
case "blockvps":
if (isset($_GET["vps"]))
{
$vpsid=$_GET["vps"];
if (VPS::BlockVPSToClient($_GET["vps"]))
{
passer_message_info("VPS du client bloquï¿œ",OK);
}else{
passer_message_info("Erreur lors du blocage du VPS au client",ALERTE);
}
header("Location: index.php?page=admin/detail_vps&vps=$vpsid");	
}else{
passer_message_info("Paramï¿œtre manquant",ALERTE);
header("Location: index.php");
}
    break;
  //Bloquer le serveur au client
case "deblockvps":
if (isset($_GET["vps"]))
{
$vpsid=$_GET["vps"];
if (VPS::DeblockVPSToClient($_GET["vps"]))
{
passer_message_info("VPS du client rï¿œactivï¿œ",OK);
}else{
passer_message_info("Erreur lors de la rï¿œactivation du VPS au client",ALERTE);
}
header("Location: index.php?page=admin/detail_vps&vps=$vpsid");	
}else{
passer_message_info("Paramï¿œtre manquant",ALERTE);
header("Location: index.php");
}
    break;

  //Supression d'un vps
  case "delete_vps":
if (isset($_GET["vps"])){
$vpsid=$_GET["vps"];
$vpsinfo=VPS::GetVPS($vpsid);
if ($vpsinfo["id_client"]==0){
if(VPS::DeleteVPS($vpsid))
            header("Location: index.php?page=admin/liste_vps");
          else
            header("Location: index.php?page=admin/detail_vps&vps=$vpsid");	
}else{
passer_message_info("Erreur ce VPS appartient encore Ã  un client",ALERTE);
header("Location: index.php?page=admin/detail_vps&vps=$vpsid");	
}

}else{
passer_message_info("ParamÃ©tre manquant",ALERTE);
header("Location: index.php");
}
    break;

//Redï¿œmarage d'un VPS
case "reboot":
echo VPS::Reboot($_GET["vps"]);
if (isset($_GET["noredirect"])==false)
header("Location: index.php");
break;
case "reinstall":	
if (($_POST["passroot"]==$_POST["passrootconf"] && $_POST["passroot"]!="") || isset($_GET["noredirect"]))
{
      //mail("aure.loiseaux@laposte.net","action",$_POST["os_choisit"].' '.$_POST["passroot"]);
VPS::Reinstall($_GET["vps"],$_POST["os_choisit"],$_POST["passroot"]);
if (isset($_GET["noredirect"])==false)
header("Location: index.php?page=vps_detail&vps=".$_GET["vps"]);
}else{
stocker_variables_formulaire($_POST);
passer_message_info("Les mots de passe ne corresponde pas ou sont nul",ALERTE);
header("Location: index.php?page=reinstall&vps=".$_GET["vps"]);
}
break;
case "createftpbackup":

if (VPS::CreateFTPBackup($_GET["vps"]))
{
if (isset($_GET["noredirect"])==false)
header("Location: index.php?page=ftpbackup&vps=".$_GET["vps"]);
}else{
if (isset($_GET["noredirect"])==false)
header("Location: index.php?page=ftpbackup&vps=".$_GET["vps"]);
}	
break;
//Message/newpassrootif (Session::Ouverte() && Session::$Client!=NULL)
//Changer pass ROOT
case "newpassroot":
if (Session::Ouverte() && Session::$Client!=NULL && isset($_GET["vps"]) && isset($_POST["passroot"]) && isset($_POST["passrootconf"])){
      if($_POST["passroot"]==$_POST["passrootconf"] ){
          VPS::ModifRoot($_GET["vps"],$_POST["passroot"]);
          header("Location: index.php");
      }else{
         passer_message_info("Les mots de passe ne corresponde pas ou sont nul",ALERTE);
         header("Location: index.php?page=new_root&vps=".$_GET["vps"]);
      }
    }else{
      passer_message_info("Accï¿œs interdit",ALERTE);
header("Location: index.php?page=new_root&vps=".$_GET["vps"]);
    }
break;
//Poste un message
case "post_message":
if (Session::Ouverte() && Session::$Client!=NULL)
{
      if((isset($_GET['titre']))&&(isset($_POST['message']))){
      //Ajoute un message a l'objet
        if(Session::$Client->Id==Messagerie::GetClientObjet($_GET['titre'])){
          if(Messagerie::PostMessage($_GET['titre'],Session::$Client->Id,addslashes(strip_tags($_POST['message'])))){
            passer_message_info("Message envoyï¿œ",ALERTE);
            header("Location: index.php?page=messagerie");
          }else{
            passer_message_info("Erreur, Message non envoyï¿œ",ALERTE);
            header("Location: index.php?page=messagerie");
          }
        }else{
          passer_message_info("Cette discution ne vous appartient pas",ALERTE);
          header("Location: index.php?page=messagerie");
        }
      }else{
      //Ajoute un objet avec un message
        if((isset($_POST['objet']))&&(isset($_POST['message']))){
          if(Messagerie::NewObjet(Session::$Client->Id,addslashes($_POST['objet']))){
            $idobjet=DB::GetInsertId();
            if(Messagerie::PostMessage($idobjet,Session::$Client->Id,addslashes(strip_tags($_POST['message'])))){
              passer_message_info("Message envoyï¿œ",ALERTE);
              header("Location: index.php?page=messagerie");
            }else{
              passer_message_info("Erreur, Message non envoyï¿œ",ALERTE);
              header("Location: index.php?page=messagerie");
            }
          }else{
            passer_message_info("Erreur, Message non envoyï¿œ",ALERTE);
            header("Location: index.php?page=messagerie");
          }
        }else{
          passer_message_info("Erreur, Message non envoyï¿œ",ALERTE);
          header("Location: index.php?page=messagerie");
        }
      }

}else{
header("Location: index.php");
}
break;
  //Poste un message
case "post_message_admin":
      if(isset($_POST['message'])){
      //Ajoute un message a l'objet
          if(Messagerie::PostMessageAdmin($_GET['titre'],addslashes($_POST['message']))){
            passer_message_info("Message envoyï¿œ",ALERTE);
            header("Location: index.php?page=admin/messagerie");
          }else{
            passer_message_info("Erreur, Message non envoyï¿œ",ALERTE);
            header("Location: index.php?page=admin/messagerie");
          }
      }else{
          passer_message_info("Erreur !",ALERTE);
          header("Location: index.php?page=admin/messagerie");
      }
break;
default:
header("Location: index.php");
}	
?>
