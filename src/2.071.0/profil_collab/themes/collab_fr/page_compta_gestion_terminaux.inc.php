<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES TERMINAUX DE PAIEMENT ELECTRONIQUE et VIRTUELS
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

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Gestion des terminaux de paiement 
</div>
<div class="emarge" style="text-align:right" >
<div>
	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:120px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
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
					<td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">Montant collecté</td>
					<td style="width:20%; font-weight:bolder; text-align:center">Derniere télécollecte </td>
					<td style="font-weight:bolder; text-align:center" colspan="3">Accès Direct</td>
				</tr>
			<?php 
			$id_mag = "";
			$solde_total = 0;
			foreach ($comptes_tpes as $tpe) {
				if ($_SESSION['user']->check_permission ("33",$tpe->id_compte_tpe)){
				if ($id_mag != $tpe->id_magasin) {
					?>
					<tr>
						<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
					</tr>
					<?php
					$id_mag = $tpe->id_magasin;
				}
				
				
				$compte_tpe	= new compte_tpe($tpe->id_compte_tpe);
				$last_date_telecollecte = $compte_tpe->getLast_date_telecollecte ();
				$totaux_theoriques = $compte_tpe->collecte_total ();
				$solde = 0;
				$solde += $totaux_theoriques;
				$solde_total += $solde;
				?>
				<tr id="choix_tpe_<?php echo $tpe->id_compte_tpe; ?>">
					<td style="font-weight:bolder; text-align:left"><?php echo htmlentities($tpe->lib_tpe); ?></td>
					<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo number_format($solde, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></td>
					<td style="font-weight:bolder; text-align:center; color:#999999;"><?php echo date_Us_to_Fr($last_date_telecollecte);?></td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="tb_<?php echo $tpe->id_compte_tpe; ?>" >Tableau de Bord</span></td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="rc_<?php echo $tpe->id_compte_tpe; ?>">Télécollecte</span>
					</td>
				</tr>
				<?php
				}
			}
			?>
					<tr>
						<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
					</tr>
			<?php 
			foreach ($comptes_tpv as $tpv) {
				if ($_SESSION['user']->check_permission ("37",$tpv->id_compte_tpv)){				
				
				$compte_tpv	= new compte_tpv($tpv->id_compte_tpv);
				$last_date_telecollecte = $compte_tpv->getLast_date_telecollecte ();
				$totaux_theoriques = $compte_tpv->collecte_total ();
				$solde = 0;
				$solde += $totaux_theoriques;
				$solde_total += $solde;
				?>
				<tr id="choix_tpv_<?php echo $tpv->id_compte_tpv; ?>">
					<td style="font-weight:bolder; text-align:left"><?php echo htmlentities($tpv->lib_tpv); ?></td>
					<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px"><?php echo number_format($solde, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></td>
					<td style="font-weight:bolder; text-align:center; color:#999999;"><?php echo date_Us_to_Fr($last_date_telecollecte);?></td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="tbv_<?php echo $tpv->id_compte_tpv; ?>" >Tableau de Bord</span></td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="rcv_<?php echo $tpv->id_compte_tpv; ?>">Télécollecte</span>
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

function setheight_choix_tpe(){
set_tomax_height("corps_choix_tpes" , -32);
}
Event.observe(window, "resize", setheight_choix_tpe, false);
setheight_choix_tpe();


<?php 
foreach ($comptes_tpes as $tpe) {
	if ($_SESSION['user']->check_permission ("33",$tpe->id_compte_tpe)){
	?>
	Event.observe("tb_<?php echo $tpe->id_compte_tpe; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_gestion2_terminaux", "compta_gestion2_terminaux.php?id_tpe=<?php echo $tpe->id_compte_tpe; ?>", "true", "sub_content");
	}, false);
	
	
	Event.observe("rc_<?php echo  $tpe->id_compte_tpe; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_tp_telecollecte", "compta_tp_telecollecte.php?id_tp=<?php echo  $tpe->id_compte_tpe; ?>&tp_type=TPE", "true", "sub_content");
	}, false);
	<?php
	}
}
?>
<?php 
foreach ($comptes_tpv as $tpv) {
		if ($_SESSION['user']->check_permission ("37",$tpv->id_compte_tpv)){	
	?>
	Event.observe("tbv_<?php echo $tpv->id_compte_tpv; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_gestion2_terminaux", "compta_gestion2_terminaux.php?id_tpv=<?php echo $tpv->id_compte_tpv; ?>", "true", "sub_content");
	}, false);
	
	
	Event.observe("rcv_<?php echo  $tpv->id_compte_tpv; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_tp_telecollecte", "compta_tp_telecollecte.php?id_tp=<?php echo  $tpv->id_compte_tpv; ?>&tp_type=TPV", "true", "sub_content");
	}, false);
	<?php
	}
}
?>
	
//on masque le chargement
H_loading();
</SCRIPT>