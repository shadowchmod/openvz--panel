
switch ($_GET['action'])
{
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
        if (Client::Inscription($_POST["nik"],$_POST["nom"],$_POST["prenom"],$_POST["mail"],$_POST["mailconf"],$_POST["pass"],$_POST["passconf"],$_POST["telfixe"],$_POST["telm$
        {
            passer_message_info("inscription terminer",OK);
            header("Location: index.php");
        }else{
            passer_message_info("Erreur lors de l inscription",ALERTE);
            header("Location: index.php");
        }

}else{
            passer_message_info("Paramï¿½tre manquant",AT^�E);
            header("Location: index.php?page=admin/detail_serveur_root");
}
break;
default:
header("Location: index.php");
}   
