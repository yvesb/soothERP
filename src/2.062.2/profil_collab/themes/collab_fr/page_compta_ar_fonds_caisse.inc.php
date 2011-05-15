<?php

// *************************************************************************************************************
// ajout ar de fonds pour caisse 
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_v_ar	=	new Array();
array_menu_v_ar[0] 	=	new Array('ar_especes', 'chemin_etape_0');
array_menu_v_ar[1] 	=	new Array('ar_validation', 'chemin_etape_1');


	
</script>
<div class="emarge"><br />

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<span style="float:right"><br />
<a  href="#" id="link_retour_caisse" style="float:right" class="common_link">retour au tableau de bord</a>
</span>
<script type="text/javascript">
Event.observe("link_retour_caisse", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_caisse','compta_gestion2_caisse.php?id_caisse=<?php echo $_REQUEST["id_caisse"];?>','true','sub_content');}, false);
</script>
<div class="titre" style="padding-left:140px">Ajout / Retrait de fonds pour <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>
</div>


<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_caisses">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
	<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
		<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
		<span style="width:35px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			
	</td>
	<td colspan="2" style="width:85%; background-color:#FFFFFF" >
	
	<br />
	<br />
	<br />
		
	<form action="compta_ar_fonds_caisse_create.php" target="formFrame" method="post" name="ar_fonds_create" id="ar_fonds_create">
	<div >
		<input id="id_compte_caisse" name="id_compte_caisse"  value="<?php echo $compte_caisse->getId_compte_caisse(); ?>"  type="hidden">
		
		<table class="chemin_table" border="0"  cellspacing="0">
			<tr>
				<td style="width:6%">&nbsp;</td>
				<td class="chemin_numero_choisi" style="width:2%" id="chemin_etape_0_2">1</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_1_2">2</td>
				<td style="width:6%" >&nbsp;</td>
				<td style="width:2%">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" class="chemin_texte_choisi" style="width:14%" id="chemin_etape_0_3">Espèces</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_1_3">Validation</td>
				<td style="width:2%"></td>
				</tr>
		</table>
		<br />
	</div>
	
	
	<div id="ar_especes"  style="width:100%;"  >
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_0" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<br />
			<span class="controle_sub_title">ESPECES</span><br /><br />
			<div style="width:95%;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>
	
	
			
			</div>
		<div style="width:60%" ><br />
			<input type="radio" id="ajout_fonds" name="ar_fonds" value="+" checked="checked" /> Ajout / 
			<input type="radio" id="retrait_fonds" name="ar_fonds" value="-" /> Retrait <br /><br />


			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				
				<tr>
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<span style="width:40px; float:right ">&gt;&gt;&gt;</span> 
					<span style=" ">Fond de caisse actuel</span>
					</td>
					<td align="right" >
					<span id="toto_esp_theorique2" style="text-align:right;">
					<?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE])) {
						echo number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?>
					</span> 
					<?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</td>
					<td >
					<div style="width:10px"></div>
					</td>
				</tr>
				<tr>
					<td colspan="3" >
					<div style="width:10px">&nbsp;</div>
					</td>
				</tr>
				<tr>
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<div style="height:25px; line-height:25px; " class="controle_color_toto">
					Montant&nbsp;opérations: 
					</div>
					</td>
					<td align="right" class="controle_color_toto"><input type="text" id="TT_ESP" name="TT_ESP" value="0.00" style="text-align:right"> <?php echo "&nbsp;". $MONNAIE[1];?></td>
					<td class="controle_color_toto">
					<div style="width:10px"></div>
					</td>
				</tr>
				<tr>
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<div style="height:25px; line-height:25px; " class="controle_color_toto">
					Fond de caisse théorique: 
					</div>
					</td>
					<td align="right" class="controle_color_toto"><input type="text" id="RT_ESP" name="RT_ESP" value="<?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE])) {
						echo number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?>" style="text-align:right"> <?php echo "&nbsp;". $MONNAIE[1];?></td>
					<td class="controle_color_toto">
					<div style="width:10px"></div>
					</td>
				</tr>
			</table>
			<div style="height:25px">
			</div>
		</div>
<br />
		</td>
		</tr>
		</table>
	
	
	</div>
	
	
	
	
	<div  id="ar_validation"  style="width:100%; display:none  ">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">
			
			</td>
		</tr>
		<tr>
			<td colspan="2">
		<div class="emarge"><br />
			<span class="controle_sub_title">Validation </span><br /><br />
			<div style="width:95%;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>
	
	
			
			</div>
			<br />
			<span id="type_ar_text"></span> de fonds pour <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>
			<br />
			<br />
			<table width="780" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:135px" class="line_compta_bottom_rigth"><div style="width:135px; height:50px"></div></td>
					<td colspan="2" align="center" valign="middle" class="line_compta_bottom">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-espece.gif"/>		</td>
					<td align="center" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="center">
					<div style="width:75px; height:35px; line-height:35px;">TOTAL</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:135px; height:35px; line-height:35px;">Solde actuel</div>		</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_esp_theorique"><?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE]) && $totaux_theoriques[$ESP_E_ID_REGMT_MODE]) {
						$montant_especes += $totaux_theoriques[$ESP_E_ID_REGMT_MODE];
					}
						echo number_format($montant_especes, $TARIFS_NB_DECIMALES, ".", ""	);
					?></span><?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom">&nbsp;</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_theo"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:135px; height:35px; line-height:35px;">Solde de l'opération</div>		</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_esp_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom"><div style="width:35px;"></div></td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_right">
					<div style="width:135px; height:35px; line-height:35px; font-weight:bolder">Solde </div>		</td>
					<td height="35" valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder;">
					<span id="diff_esp"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle">&nbsp;</td>
					<td height="35" valign="middle" class="line_compta_right">&nbsp;</td>
					<td valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_diff"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div></td>
				</tr>
			</table>
			<br />
			
			<br />
			<br />
			<span style="font-weight:bolder">Informations:</span>   <span id="commentaire_add" style="color:#FF0000"></span><br />
			
			<textarea name="commentaire" rows="6" class="classinput_xsize" id="commentaire" style=" width:800px"></textarea>

			<div style="text-align:right">
			<img id="bt_etape_1" style=" cursor:pointer; font-weight:bolder; color:#97bf0d; " src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
			</div>
			</div>
			<br />
			<br />
			
			<input type="hidden" value="0" id="montant_ar_esp" name="montant_ar_esp" />
			<input type="hidden" value="0" id="montant_theorique" name="montant_theorique" />
			<input type="hidden" value="0" id="montant_ar" name="montant_ar" />
		</td>
		</tr>
		</table>
	</div>
</form>


			</td>
		</tr>
</table>
</div>
</div>
</div>
<SCRIPT type="text/javascript">





Event.observe($("chemin_etape_0_2"), "click", function(evt){Event.stop(evt); step_menu_ar ('ar_especes', 'chemin_etape_0', array_menu_v_ar);});
Event.observe($("chemin_etape_0_3"), "click", function(evt){Event.stop(evt);  step_menu_ar ('ar_especes', 'chemin_etape_0', array_menu_v_ar);});

Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt);  step_menu_ar ('ar_validation', 'chemin_etape_1', array_menu_v_ar);});


Event.observe($("chemin_etape_1_2"), "click", function(evt){Event.stop(evt); step_menu_ar ('ar_validation', 'chemin_etape_1', array_menu_v_ar);});
Event.observe($("chemin_etape_1_3"), "click", function(evt){Event.stop(evt); step_menu_ar ('ar_validation', 'chemin_etape_1', array_menu_v_ar);});

Event.observe($("bt_etape_1"), "click", function(evt){Event.stop(evt); $("ar_fonds_create").submit();});


Event.observe($("TT_ESP"), "blur", function(evt){
	nummask(evt, 0, "X.XY");
	calcul_ar_fonds ();
});
Event.observe($("RT_ESP"), "blur", function(evt){
	nummask(evt, 0, "X.XY");
	if ($("ajout_fonds").checked) {
		if ( (parseFloat($("RT_ESP").value)) < (parseFloat($("toto_esp_theorique").innerHTML)) ) {
			$("RT_ESP").value = (parseFloat($("toto_esp_theorique").innerHTML)).toFixed(tarifs_nb_decimales);
		}
		$("TT_ESP").value = (parseFloat($("RT_ESP").value) - parseFloat($("toto_esp_theorique").innerHTML)).toFixed(tarifs_nb_decimales);
	}
	if ($("retrait_fonds").checked) {
		if ( (parseFloat($("RT_ESP").value)) > (parseFloat($("toto_esp_theorique").innerHTML)) ) {
			$("RT_ESP").value = (parseFloat($("toto_esp_theorique").innerHTML)).toFixed(tarifs_nb_decimales);
		}
		$("TT_ESP").value = (parseFloat($("toto_esp_theorique").innerHTML) - parseFloat($("RT_ESP").value)).toFixed(tarifs_nb_decimales);
	}
	calcul_ar_fonds ();
});



Event.observe($("ajout_fonds"), "click", function(evt){
	calcul_ar_fonds ();
});
Event.observe($("retrait_fonds"), "click", function(evt){
	calcul_ar_fonds ();
});




centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});
//on masque le chargement
H_loading();
</SCRIPT>