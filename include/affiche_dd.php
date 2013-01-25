<?php

//On récupère dans la table disque
$sql_info = "SELECT ram_total,ram_use,disque_total,disque_use 
            FROM stats_mem_dd ,vps
            WHERE vps.status=1
            AND stats_mem_dd.id_vps=vps.id
            AND stats_mem_dd.id_vps=".$vpsid;

$detail_info=DB::SqlToArray($sql_info);
if(count($detail_info)>0){
  $detail_info=$detail_info[0];

  //Convertit le taux d'utilisation ram en % et retire la taille de l'arrondi
  $barre_ram=($detail_info['ram_use']/$detail_info['ram_total'])*100;
  ?>

  <center>
  Ram : <?php echo OctetToString($detail_info['ram_use']/2).' / '.OctetToString($detail_info['ram_total']/2); echo ' ('.number_format($barre_ram, 0, ',', 2).' %)'; ?>
  <table width="400" height="22" border="0" cellspacing="0" cellpadding="0">
    <tr>

  <?php
  if($barre_ram<3){
  ?>

      <td width="2%" background="images/rouge_g.png">&nbsp;</td>
      <td width="96%" background="images/rouge_m.png">&nbsp;</td>
      <td width="2%" background="images/rouge_d.png">&nbsp;</td>
      
  <?php
  }else{
    if($barre_ram>=97){
  ?>

      <td width="2%" background="images/bleu_g.png">&nbsp;</td>
      <td width="96%" background="images/bleu_m.png">&nbsp;</td>
      <td width="2%" background="images/bleu_d.png">&nbsp;</td>


  <?php
    }else{
      $barre_ram-=2;

  ?>
      
      <td width="2%" background="images/bleu_g.png">&nbsp;</td>
      <td width="<?php echo number_format($barre_ram, 0);?>%" background="images/bleu_m.png">&nbsp;</td>
      <td background="images/rouge_m.png">&nbsp;</td>
      <td width="2%" background="images/rouge_d.png">&nbsp;</td>
      
  <?php
    }
    
  }
  ?>
    </tr>
  </table>
  <?php

  //Convertit le taux d'utilisation ram en % et retire la taille de l'arrondi
  $barre_dd=($detail_info['disque_use']/$detail_info['disque_total'])*100;
  ?>

  Disque Dur : <?php echo OctetToString($detail_info['disque_use']).' / '.OctetToString($detail_info['disque_total']); echo ' ('.number_format($barre_dd, 0, ',', 2).' %)'; ?>
  <table width="400" height="22" border="0" cellspacing="0" cellpadding="0">
    <tr>

  <?php
  if($barre_dd<3){
  ?>

      <td width="2%" background="images/rouge_g.png">&nbsp;</td>
      <td width="96%" background="images/rouge_m.png">&nbsp;</td>
      <td width="2%" background="images/rouge_d.png">&nbsp;</td>
      
  <?php
  }else{
    if($barre_dd>=97){
  ?>

      <td width="2%" background="images/bleu_g.png">&nbsp;</td>
      <td width="96%" background="images/bleu_m.png">&nbsp;</td>
      <td width="2%" background="images/bleu_d.png">&nbsp;</td>


  <?php
    }else{
      $barre_dd-=2;

  ?>
      
      <td width="2%" background="images/bleu_g.png">&nbsp;</td>
      <td width="<?php echo number_format($barre_dd, 0);?>%" background="images/bleu_m.png">&nbsp;</td>
      <td background="images/rouge_m.png">&nbsp;</td>
      <td width="2%" background="images/rouge_d.png">&nbsp;</td>
      
  <?php
    }
    
  }
  ?>
    </tr>
  </table>
  </center>
  
<?php
//Fin du IF
}

?>