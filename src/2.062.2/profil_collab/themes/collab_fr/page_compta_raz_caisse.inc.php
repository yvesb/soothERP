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

$solde = 0;
foreach ($totaux_theoriques as $s_total) {
	$solde += $s_total;
}
?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<span style="float:right"><br />

<a  href="#" id="link_retour_caisse" style="float:right" class="common_link">retour au tableau de bord</a><br />
</span>
<script type="text/javascript">
Event.observe("link_retour_caisse", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_caisse','compta_gestion2_caisse.php?id_caisse=<?php echo $_REQUEST["id_caisse"];?>','true','sub_content');}, false);
</script>
<div class="titre" style="width:60%; padding-left:140px"><?php echo htmlentities($compte_caisse->getLib_caisse()); ?> -  Remise à zéro
</div>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_caisses">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style=" background-color:#FFFFFF" >
			<br />
			<br />
			<br />

			<div>
				<div style="padding: 15px 25px; display:block" id="first_before_raz">
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Remise à zéro de la caisse</div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
					<span style="color:#FF0000"> Attention, si vous réinitialisez cette caisse, toutes les valeurs seront remises à zéro sans préciser la destination des fonds.</span><br />
<br />
 <!--Attention, réinitialiser la caisse remet à zéro l'ensemble des valeurs sans préciser la destination des fonds.-->
Vous devriez plutôt utiliser le transfert de fonds (pour transférer tout ou partie des fonds vers une autre caisse) ou la remise en banque (pour effectuer une remise en banque de tout ou partie des fonds). 
					<br />
<br /><br />


					<div style="text-align:center">
						<div style="width:450px; padding-left:20%; padding-right:20%">
						
						<span id="transfert_fonds" class="grey_caisse" style="float:left"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Transfert entre caisses</span>
						<span id="remise_bancaire" class="grey_caisse" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Remise en banque</span>
						
						<br /><br /><br /><br />

						<span id="ignorer_continuer" style="cursor:pointer; font-weight:bolder; text-decoration:underline" >Ignorer cet avertissement et réinitialiser la caisse</span>
						<br /><br />
						</div>
					</div>
					
					<div style="text-align:center">
					<br /><br />
						<input type="image" name="annuler" id="annuler" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
					</div>
					<script type="text/javascript">
					Event.observe("annuler", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_caisse','compta_gestion2_caisse.php?id_caisse=<?php echo $_REQUEST["id_caisse"];?>','true','sub_content');}, false);
					</script>


						<script type="text/javascript">
						Event.observe("transfert_fonds", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_transfert_fonds_caisse", "compta_transfert_fonds_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
						}, false);
						Event.observe("remise_bancaire", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_remise_bancaire_caisse", "compta_remise_bancaire_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
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
					<div class="bold_caisse" style="font-size:16px">Remise à zéro de la caisse</div> 
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

						<?php if ($last_date_controle) {?>
						<div style="float:left; color:#999999">Dernier contrôle: <?php echo date_Us_to_Fr($last_date_controle);?></div>
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
						
					<form action="compta_raz_caisse_valid.php" target="formFrame" method="post" name="compta_raz_caisse_valid" id="compta_raz_caisse_valid">
					<input id="id_compte_caisse" name="id_compte_caisse"  value="<?php echo $compte_caisse->getId_compte_caisse(); ?>"  type="hidden">
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
	$("compta_raz_caisse_valid").submit();
}, false);
						
						
function setheight_gestion_caisse(){
set_tomax_height("corps_gestion_caisses" , -32);
}
Event.observe(window, "resize", setheight_gestion_caisse, false);
setheight_gestion_caisse();


//on masque le chargement
H_loading();
</SCRIPT>