<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Gestion des caisses 
</div>
<div class="emarge" style="text-align:right" >
<div>
	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:120px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:90%">
			<br />
<br />
<br />

			<div style="width:90%; height:50px; padding:25px">
			<table width="100%" border="0" cellspacing="4" cellpadding="2">
				<tr>
					<td style="width:25%; font-weight:bolder; text-align:left">Libellé</td>
					<td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">Solde</td>
					<td style="width:20%; font-weight:bolder; text-align:center">Dernier Relevé</td>
					<td style="font-weight:bolder; text-align:center" colspan="3">Accès Direct</td>
				</tr>
			<?php 
			$id_mag = "";
			$solde_total = 0;
			foreach ($comptes_caisses as $caisse) {
				if ($_SESSION['user']->check_permission ("9",$caisse->id_compte_caisse)){
				if ($id_mag != $caisse->id_magasin) {
					?>
					<tr>
						<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
					</tr>
					<?php
					$id_mag = $caisse->id_magasin;
				}
				
				
				$compte_caisse	= new compte_caisse($caisse->id_compte_caisse);
				$last_date_controle = $compte_caisse->getLast_date_controle ();
				$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
				$solde = 0;
				foreach ($totaux_theoriques as $s_total) {
					$solde += $s_total;
				}
				$solde_total += $solde;
				?>
				<tr id="choix_caisse_<?php echo $caisse->id_compte_caisse; ?>">
					<td style="font-weight:bolder; text-align:left"><?php echo htmlentities($caisse->lib_caisse); ?></td>
					<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo number_format($solde, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></td>
					<td style="font-weight:bolder; text-align:center; color:#999999;"><?php echo date_Us_to_Fr($last_date_controle);?></td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="tb_<?php echo $caisse->id_compte_caisse; ?>" >Tableau de Bord</span></td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="rc_<?php echo $caisse->id_compte_caisse; ?>">Relevé de Caisse</span>
					</td>
				</tr>
				<?php
			}
			}
			?>
				<tr>
					<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
				</tr>
				<tr>
					<td style="font-weight:bolder; text-align:left">TOTAL</td>
					<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo number_format($solde_total, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></td>
					<td style="font-weight:bolder; text-align:center; color:#999999;"></td>
					<td style="width:15%; text-align:center"></td>
					<td style="width:5%; text-align:center; color:#97bf0d"></td>
					<td style="width:15%; text-align:center">
					
					</td>
				</tr>
			</table>
			</div>
			</td>
		</tr>
</table>
</div>
</div>

</div>


<SCRIPT type="text/javascript">

function setheight_choix_caisse(){
set_tomax_height("corps_choix_caisses" , -32);
}
Event.observe(window, "resize", setheight_choix_caisse, false);
setheight_choix_caisse();


<?php 
foreach ($comptes_caisses as $caisse) {
	if ($_SESSION['user']->check_permission ("9",$caisse->id_compte_caisse)){	
	?>
	Event.observe("tb_<?php echo $caisse->id_compte_caisse; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_gestion2_caisse", "compta_gestion2_caisse.php?id_caisse=<?php echo $caisse->id_compte_caisse; ?>", "true", "sub_content");
	}, false);
	
	
	Event.observe("rc_<?php echo  $caisse->id_compte_caisse; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_controle_caisse", "compta_controle_caisse.php?id_caisse=<?php echo  $caisse->id_compte_caisse; ?>", "true", "sub_content");
	}, false);
	<?php
	}
}
?>
	
//on masque le chargement
H_loading();
</SCRIPT>