<?php

// *************************************************************************************************************
// visualisation d'un controle de caisse
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
<div class="emarge">
<span style="float:right">
<a  href="#" id="link_retour_caisse" style="float:right" class="common_link">retour au tableau de bord</a><br />
</span>
<script type="text/javascript">
Event.observe("link_retour_caisse", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_caisse','compta_gestion2_caisse.php?id_caisse=<?php echo $compte_caisse_controle->id_compte_caisse;?>','true','sub_content');}, false);
</script>
<div class="titre">Contrôle <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>
</div>

<div class="articletview_corps" id="controle_validation"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;">
<div class="emarge"><br />
<span class="controle_sub_title">
Contrôle effectué par <span style="font-weight:bolder"><?php echo htmlentities($compte_caisse_controle->pseudo);?></span> le 
<?php echo Date_Us_To_Fr($compte_caisse_controle->date_controle);?> à
 <?php echo getTime_from_date($compte_caisse_controle->date_controle);?>
</span>
<br />
<br />

<table width="850" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:135px" class="line_compta_bottom_rigth"><div style="width:135px; height:50px"></div></td>
		<td colspan="2" align="center" valign="middle" class="line_compta_bottom">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-espece.gif"/>		</td>
		<td align="center" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td colspan="2" align="center" valign="middle" class="line_compta_bottom">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-cheque.gif"/>		</td>
		<td align="center" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td colspan="2" align="center" valign="middle" class="line_compta_bottom_rigth">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-carte_bancaire.gif"/>		</td>
		<td valign="middle" class="line_compta_bottom" align="center"
		<div style="width:85px; height:35px; line-height:35px;">TOTAL</div>		</td>
		<td valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">
		<div style="width:125px; height:35px; line-height:35px;">Total saisie</div>		</td>
		<td height="35" align="right" valign="middle" class="line_compta_bottom">
		<div style="width:85px; height:35px; line-height:35px;">
			<?php
			$montant_saisie = 0;
			if (isset($compte_caisse_controle->montant_especes)) { 
			echo  price_format($compte_caisse_controle->montant_especes)." ".$MONNAIE[1]; 
			$montant_saisie .= price_format($compte_caisse_controle->montant_especes);
			}
			?>
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom"><div style="width:125px;"></div></td>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td height="35" align="right" valign="middle" class="line_compta_bottom">
		<div style="width:85px; height:35px; line-height:35px;">
			<?php	
			if (isset($compte_caisse_controle->montant_CHQ)) { 
				echo price_format(array_sum($compte_caisse_controle->montant_CHQ))." ".$MONNAIE[1]; 
				$montant_saisie .= price_format($compte_caisse_controle->montant_CHQ);
			}
			?>
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom">
		<div style="width:125px; height:35px; line-height:35px;">
					<span style="padding-left:15px" id="saisie_op_cheques2">
					<?php echo count($compte_caisse_controle->montant_CHQ);?>
					</span> op&eacute;rations
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td height="35" align="right" valign="middle" class="line_compta_bottom">
		<div style="width:85px; height:35px; line-height:35px;">
			<?php
			if (isset($compte_caisse_controle->montant_CB)) { 
				echo price_format(array_sum($compte_caisse_controle->montant_CB))." ".$MONNAIE[1]; 
				$montant_saisie .= price_format($compte_caisse_controle->montant_CB);	
			}
			?>
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">
		<div style="width:125px; height:35px; line-height:35px;">
					<span style="padding-left:15px" id="saisie_op_cb2">
					<?php echo count($compte_caisse_controle->montant_CB);?>
					</span> op&eacute;rations
		</div>
		</td>
		<td valign="middle" class="line_compta_bottom" align="right">
		<div style="width:85px; height:35px; line-height:35px; padding-right:10px; font-weight:bolder;">
					<?php echo price_format($montant_saisie)." ".$MONNAIE[1];?>
		</div>
		</td>
		<td valign="middle"></td>
	</tr>
	<tr>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">
		<div style="width:125px; height:35px; line-height:35px; font-weight:bolder">Erreur</div>		</td>
		<td height="35" valign="middle" align="right" class="line_compta_bottom">
		<div style="width:85px; height:35px; line-height:35px; font-weight:bolder;">
					<?php	if (isset($compte_caisse_controle->montant_erreur_esp)) { 
					echo price_format($compte_caisse_controle->montant_erreur_esp)." ".$MONNAIE[1]; }
					?>	
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom">&nbsp;</td>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td height="35" valign="middle" align="right" class="line_compta_bottom">
		<div style="width:85px; height:35px; line-height:35px; font-weight:bolder;">
					<?php	if (isset($compte_caisse_controle->montant_erreur_chq)) { 
					echo price_format($compte_caisse_controle->montant_erreur_chq)." ".$MONNAIE[1]; }
					?>	
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom">&nbsp;</td>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td height="35" valign="middle" align="right" class="line_compta_bottom">
		<div style="width:85px; height:35px; line-height:35px; font-weight:bolder;">
					<?php	if (isset($compte_caisse_controle->montant_erreur_cb)) { 
					echo price_format($compte_caisse_controle->montant_erreur_cb)." ".$MONNAIE[1]; }
					?>	
		</div>
		</td>
		<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
		<td valign="middle"  class="line_compta_bottom" align="right">
		<div style="width:85px; height:35px; line-height:35px; padding-right:10px; font-weight:bolder;">
					<?php	if (isset($compte_caisse_controle->montant_erreur)) { 
					echo price_format($compte_caisse_controle->montant_erreur)." ".$MONNAIE[1]; }
					?>	
		</div>
		</td>
		<td valign="middle">
		</td>
	</tr>
	<tr>
		<td height="5" valign="middle">		</td>
		<td height="5" valign="middle" align="right">		</td>
		<td height="5" valign="middle">&nbsp;</td>
		<td height="5" valign="middle" class="line_compta_right">&nbsp;</td>
		<td height="5" valign="middle" align="right">		</td>
		<td height="5" valign="middle">&nbsp;</td>
		<td height="5" valign="middle" class="line_compta_right">&nbsp;</td>
		<td height="5" valign="middle" align="right">		</td>
		<td height="5" valign="middle" class="line_compta_right">&nbsp;</td>
		<td valign="middle" class="">&nbsp;</td>
		<td valign="middle" class="">
		<div style="text-align:right">
		<!--<a href="compta_controle_caisse_editing.php?id_compte_caisse_controle=<?php echo $_REQUEST["id_compte_caisse_controle"];?>&print=1" target="edition" >-->
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" style="cursor:pointer" />
		<!--</a>-->
		</div></td>
	</tr>
	<tr>
		<td height="35" colspan="3"><div style=" font-weight:bolder; text-align:right">Rappel des opérations saisies: </div></td>
		
		<td height="35" valign="middle" class="line_compta_right">&nbsp;</td>
		<td height="35" valign="middle" align="right">
		<div style="width:85px;">
		<div id="rappel_liste_chq">
			<?php	foreach ($compte_caisse_controle->montant_CHQ as $cheque) { 
			echo price_format($cheque)." ".$MONNAIE[1]."<br />"; }
			?>	
		</div>
		</div>		</td>
		<td height="35" valign="middle">&nbsp;</td>
		<td height="35" valign="middle" class="line_compta_right">&nbsp;</td>
		<td height="35" valign="middle" align="right">
		<div style="width:85px;">
		<div id="rappel_liste_cb">
			<?php	foreach ($compte_caisse_controle->montant_CB as $cb) { 
			echo price_format($cb)." ".$MONNAIE[1]."<br />"; }
			?>	
		</div>
		</div>		</td>
		<td height="35" valign="middle" class="line_compta_right">
		<input type="hidden" value="0" id="montant_erreur" name="montant_erreur" />
		<input type="hidden" value="0" id="montant_especes" name="montant_especes" />		</td>
		<td height="35" valign="middle">&nbsp;</td>
		<td valign="middle">&nbsp;</td>
	</tr>
</table>
<br />


</div>
</div>

</form>
</div>
<SCRIPT type="text/javascript">

function setheight_controle_caisse(){
set_tomax_height('controle_validation' , -32);
}

Event.observe(window, "resize", setheight_controle_caisse, false);
setheight_controle_caisse();



//on masque le chargement
H_loading();
</SCRIPT>