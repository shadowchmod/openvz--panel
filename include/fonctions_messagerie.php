<?php
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//-------- Auteur :                                        					    ------------------------
//-------- Email : 							                                    ------------------------
//-------- Année : 2009                                                         ------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------------
//-------------- Affiche tous les objet du client ------------------------------------------------------
//------------------------------------------------------------------------------------------------------
function affiche_objets($idclient){

    $objets=Messagerie::GetObjetList($idclient);
		echo' <p><a href="index.php?page=post_message">Nouvelle Discution</a></p>
          <table class="tdmessage" width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
              <td width="8%">Status</td>
              <td width="15%">Date</td>
              <td width="73%">Objet</td>
              
            </tr>';
    $colortab=1;
    foreach($objets as $objet){	
      if($objet['new_client']==1){
        //Nouveau message
        echo '<tr>
                <td width="8%" class="tdmessage2"><a class="amessage" href="index.php?page=messagerie&objet='.$objet['id'].'"><img src="images/enveloppe_new.png" class="tdmessage"/></a></td>
                <td width="15%" class="tdmessage2"><a class="amessage" href="index.php?page=messagerie&objet='.$objet['id'].'"><strong>'.$objet['date'].'</strong></a></td>
                <td width="73%" class="tdmessage2"><a class="amessage" href="index.php?page=messagerie&objet='.$objet['id'].'"><strong>'.$objet['objet'].'</strong></a></td>
                
              </tr>';
      }else{
        //pas de message
        echo '<tr>
                <td width="8%" class="tdmessage1"><a class="amessage" href="index.php?page=messagerie&objet='.$objet['id'].'"><img src="images/enveloppe_old.png" class="tdmessage"/></a></td>
                <td width="15%" class="tdmessage1"><a class="amessage" href="index.php?page=messagerie&objet='.$objet['id'].'">'.$objet['date'].'</a></td>
                <td width="73%" class="tdmessage1"><a class="amessage" href="index.php?page=messagerie&objet='.$objet['id'].'">'.$objet['objet'].'</a></td>
              </tr>';        
      }
		}
		echo '</table>';

}


//------------------------------------------------------------------------------------------------------
//-------------- Affiche tous les message de l'objet ---------------------------------------------------
//------------------------------------------------------------------------------------------------------
function affiche_messages($idclient,$idobjet){

    $client_origine=Messagerie::GetClientObjet($idobjet);
    //Teste si objet est bien au client
    if(($client_origine==$idclient)&&($client_origine!=false)){
      $messages=Messagerie::GetMessageObjet($idobjet);
      echo' <p><a href="index.php?page=messagerie">< Retour à la liste </a><a href="index.php?page=post_message&objet='.$idobjet.'">Nouveau message</a></p>
            <table class="tdmessage" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15%">Date</td>
                <td width="73%">Objet</td>
                <td width="12%">Expéditeur</td>
              </tr>';
      $colortab=1;
      foreach($messages as $message){	
        $nom_exp=Client::GetClient($message['id_client']);
        if($message['id_client']==0){
          $nom_exp['nom']="CMD-WEB";
          $colortab=2;
        }else{
          $colortab=1;
        }
        echo '<tr>
                <td width="15%" class="tdmessage'.$colortab.'">'.$message['date'].'</td>
                <td width="73%" class="tdmessage'.$colortab.'">'.$message['message'].'</td>
                <td width="12%" class="tdmessage'.$colortab.'">'.$nom_exp['nom'].'</td>
              </tr>';
      }
      echo '</table>';
		}else{
      echo' <p><a href="index.php?page=messagerie">< Retour à la liste </a></p>';
      passer_message_info("Cette page ne vous appartient pas",ALERTE);
		}
}
//------------------------------------------------------------------------------------------------------
//-------------- Fonction  admin -----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//-------------- Affiche tous les objet du client ------------------------------------------------------
//------------------------------------------------------------------------------------------------------
function affiche_objets_admin(){

    $objets=Messagerie::GetObjetAdmin();
		echo' 
          <table class="tdmessage" width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
              <td width="8%">Status</td>
              <td width="15%">Date</td>
              <td width="50%">Objet</td>
              <td width="28%">Client</td>
              
            </tr>';
    $colortab=1;
    foreach($objets as $objet){	
      if($objet['new_admin']==1){
        //Nouveau message
        echo '<tr>
                <td width="8%" class="tdmessage2"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'"><img src="images/enveloppe_new.png" class="tdmessage"/></a></td>
                <td width="15%" class="tdmessage2"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'"><strong>'.$objet['date'].'</strong></a></td>
                <td width="73%" class="tdmessage2"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'"><strong>'.$objet['objet'].'</strong></a></td>
                <td width="73%" class="tdmessage2"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'"><strong>'.strtoupper($objet['nom']).' '.ucfirst(strtolower($objet['prenom'])).'</strong></a></td>
                
              </tr>';
      }else{
        //pas de message
        echo '<tr>
                <td width="8%" class="tdmessage1"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'"><img src="images/enveloppe_old.png" class="tdmessage"/></a></td>
                <td width="15%" class="tdmessage1"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'">'.$objet['date'].'</a></td>
                <td width="73%" class="tdmessage1"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'">'.$objet['objet'].'</a></td>
                <td width="73%" class="tdmessage1"><a class="amessage" href="index.php?page=admin/messagerie&objet='.$objet['id'].'">'.strtoupper($objet['nom']).' '.ucfirst(strtolower($objet['prenom'])).'</a></td>
              </tr>';        
      }
		}
		echo '</table>';

}

function affiche_messages_admin($idobjet){

      $messages=Messagerie::GetMessageObjetAdmin($idobjet);
      echo' <p><a href="index.php?page=admin/messagerie">< Retour à la liste </a><a href="index.php?page=admin/post_message&objet='.$idobjet.'">Nouveau message</a></p>
            <table class="tdmessage" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15%">Date</td>
                <td width="73%">Objet</td>
                <td width="12%">Expéditeur</td>
              </tr>';
      $colortab=1;
      foreach($messages as $message){	
        $nom_exp=Client::GetClient($message['id_client']);
        if($message['id_client']==0){
          $nom_exp['nom']="CMD-WEB";
          $colortab=2;
        }else{
          $colortab=1;
        }
        echo '<tr>
                <td width="15%" class="tdmessage'.$colortab.'">'.$message['date'].'</td>
                <td width="73%" class="tdmessage'.$colortab.'">'.$message['message'].'</td>
                <td width="12%" class="tdmessage'.$colortab.'">'.$nom_exp['nom'].'</td>
              </tr>';
      }
      echo '</table>';

}

?>
