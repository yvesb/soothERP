<?php

// *************************************************************************************************************
// RAZ CONTENU TP
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$solde = $totaux_theoriques;
?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<span style="float:right"><br />

<span style="float:right"><br />
<a  href="#" id="link_retour_tp" style="float:right" class="common_link">retour au tableau de bord</a>
</span>
<script type="text/javascript">
Event.observe("link_retour_tp", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_terminaux','compta_gestion2_terminaux.php?<?php echo $retour_var;?>','true','sub_content');}, false);
</script>
<div class="titre" style="width:60%; padding-left:140px"><?php echo htmlentities($compte_tp->getLib_tp()); ?> -  Remise à zéro
</div>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_tps">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style=" background-color:#FFFFFF" >
			<br />
			<br />
			<br />

			<div>
				<div style="padding: 15px 25px; display:block" id="first_before_raz">
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Remise à zéro du terminal de paiment </div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
					<span style="color:#FF0000"> Attention, réinitialiser le terminal de paiement remet à zéro l'ensemble des valeurs sans préciser la destination des fonds.</span><br />
<br />

Vous devriez plutôt utiliser la télécollecte (pour transférer tout ou partie des fonds vers les compte bancaires). 
					<br />
<br /><br />


					<div style="text-align:center">
						<div style="width:450px; padding-left:20%; padding-right:20%">
						
						<span id="telecollecte_tp" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; " vspace="3" /> Télécollecte</span>
						
						<br /><br /><br /><br />

						<span id="ignorer_continuer" style="cursor:pointer; font-weight:bolder; text-decoration:underline" >Ignorer cet avertissement et réinitialiser le terminal de paiement</span>
						<br /><br />
						</div>
					</div>
					
					<div style="text-align:center">
					<br /><br />
						<input type="image" name="annuler" id="annuler" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
					</div>
					<script type="text/javascript">
					Event.observe("annuler", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_terminaux','compta_gestion2_terminaux.php?<?php echo $retour_var;?>','true','sub_content');}, false);
					</script>

						<script type="text/javascript">
						Event.observe("telecollecte_tp", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_tp_telecollecte", "compta_tp_telecollecte.php?id_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $compte_tp->getTp_type(); ?>", "true", "sub_content");
						}, false);
	
						Event.observe("ignorer_continuer", "click", function(evt){
							Event.stop(evt);
							$("next_before_raz").show();
							$("first_before_raz").hide();
						}, false);
						</script>
			</div>
			<div style="padding: 15px 25px; display:none" id="next_before_raz">
			<table border="0" cellspacing="0" cellpadding="0" style="width:100%; height:100%">
				<tr>
					<td></td>
					<td>
					<div>
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Remise à zéro du terminal de paiement</div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td><div class="bold_caisse">Solde Théorique &gt;&gt;</div></td>
								<td align="right"><div class="bold_caisse" ><?php echo number_format($solde, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
								<td style="width:30%">&nbsp;</td>
							</tr>
						</table><br />

								<?php if ($last_date_telecollecte) {?>
								<div style="float:left; color:#999999">Derniere télécollecte: <?php echo date_Us_to_Fr($last_date_telecollecte)." ".getTime_from_date ($last_date_telecollecte);?></div>
								<?php } ?>
								<br />
								<br />
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_top">&nbsp;</td>
								<td style="width:30%">&nbsp;</td>
							</tr>
						</table><br />
						<br />
						<br />
						<div style=" text-align:center; font-weight:bolder"><span id="valid_raz" style="cursor:pointer; text-decoration:underline">Valider l'opération</span></div>
						
					<form action="compta_tp_raz_valid.php" target="formFrame" method="post" name="compta_tp_raz_valid" id="compta_tp_raz_valid">
					<input id="id_compte_tp" name="id_compte_tp"  value="<?php echo $compte_tp->getId_compte_tp(); ?>"  type="hidden">
					<input id="tp_type" name="tp_type"  value="<?php echo $compte_tp->getTp_type(); ?>"  type="hidden">
					<input id="montant_move" name="montant_move"  value="<?php echo number_format($solde, $TARIFS_NB_DECIMALES, ".", ""	); ?>"  type="hidden">
					</form>
					</div>
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

Event.observe("valid_raz", "click", function(evt){
	Event.stop(evt);
	$("compta_tp_raz_valid").submit();
}, false);
						
						
function setheight_gestion_tp(){
set_tomax_height("corps_gestion_tps" , -32);
}
Event.observe(window, "resize", setheight_gestion_tp, false);
setheight_gestion_tp();


//on masque le chargement
H_loading();
</SCRIPT>