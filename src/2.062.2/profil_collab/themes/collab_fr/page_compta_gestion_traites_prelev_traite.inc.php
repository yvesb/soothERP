<?php

// *************************************************************************************************************
// Remise en banque depuis la caisse (ou dépot bancaire depuis la caisse)
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_v_traitena	=	new Array();
array_menu_v_traitena[0] 	=	new Array('traitena_banque', 'chemin_etape_0');
array_menu_v_traitena[1] 	=	new Array('traitena_selection', 'chemin_etape_1');
array_menu_v_traitena[2] 	=	new Array('traitena_validation', 'chemin_etape_2');
</script>
<div class="emarge"><br />

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<span style="float:right"><br />
<a  href="#" id="link_retour_caisse" style="float:right" class="common_link">retour au tableau de bord</a>
</span>
<script type="text/javascript">
Event.observe("link_retour_caisse", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion_traites_prelev_tb','compta_gestion_traites_prelev_tb.php?id_compte_bancaire=<?php echo $id_compte_bancaire;?>','true','sub_content');}, false);
</script>
<div class="titre" style="width:60%; padding-left:140px">Traites vers <?php echo htmlentities($compte_bancaire->getLib_compte()); ?>
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

	<form action="compta_gestion_traites_prelev_traitena_create.php" target="formFrame" method="post" name="traitena_create" id="traitena_create">
	<div >
		<input id="id_compte_bancaire" name="id_compte_bancaire"  value="<?php echo $id_compte_bancaire; ?>"  type="hidden">

		<table class="chemin_table" border="0"  cellspacing="0">
			<tr>
				<td style="width:6%">&nbsp;</td>
				<td class="chemin_numero_choisi" style="width:2%" id="chemin_etape_0_2">1</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_1_2">2</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_2_2">3</td>
				<td style="width:6%"  >&nbsp;</td>
				<td style="width:2%">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" class="chemin_texte_choisi" style="width:14%" id="chemin_etape_0_3">Banque</td>
                                <td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_1_3">Traites</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_2_3">Validation</td>
				<td style="width:2%"></td>
				</tr>
		</table>
		<br />
	</div>

	<div  id="traitena_selection"  style="width:100%; display:none; background-color:#FFFFFF ">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">

			<div id="bt_etape_2" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span>
			</div>
			</td>
		</tr>
		<tr>
			<td  colspan="2"><br />
                            <span class="controle_sub_title">TRAITES </span><br /><br />
			<div style="width:95%;">

			Le <?php
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
				?><br />
			<br />
			<div  class="line_caisse_bottom"></div>



			</div>
			</td>
		</tr>
		<tr >
			<td colspan="2">
			<br />
				<div>
					<span style="width:120px; float:left">Solde Théorique</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span>
					<span id="toto_chq_theorique2" style="text-align:right; width:65px; float:left">
					<?php
					$montant_especes = 0;
					if (isset($traitena_a_effectuer)) {
						echo number_format($traitena_a_effectuer, $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?>
					</span>
					<?php
						echo "&nbsp;". $MONNAIE[1];
					?> <span style="padding-left:10px">(<?php
					if (isset($count_traitena_a_effectuer)) {
						echo $count_traitena_a_effectuer;
					}
                                        ?> traite(s))</span>
				</div>




		</td>
		</tr>
		<tr>
		<td colspan="52" style="text-align:left"><br />
			<br />
		<div style=" width:760px;">
			<table width="100%">
				<tr>
				<td style="width:60px">&nbsp;
				</td>
				<td style="width:120px; text-align:center">Montant
				</td>
				<td style="width:200px; text-align:center">Compte Source
				</td>
				<td style="width:100px; text-align:left">Client
				</td>
                                <td style="width:100px; text-align:center">Date d'écheance
				</td>
				</tr>
			</table>
		<?php
		for ($j = 0 ; $j < $count_traitena_a_effectuer ; $j++ ) {
			?>
			<div id="ligne_exist_chq_<?php echo $j;?>">
				<table width="100%">
                                <tr>
				<td style="width:60px">
				<div ><?php echo $j+1;?>:</div>
				</td>
				<td style="width:120px; text-align:center; padding-right:5px">
				<input name="EXIST_TRAITENA_<?php echo $j;?>" type="hidden" id="EXIST_CHQ_<?php echo $j;?>" value="<?php echo $infos_traitena[$j]->montant;?>" />
                                <input name="DOC_TRAITENA_<?php echo $j;?>" type="hidden" id="DOC_TRAITENA_<?php echo $j;?>" value="<?php echo $infos_traitena[$j]->ref_doc;?>" />			<?php echo number_format($infos_traitena[$j]->montant, $TARIFS_NB_DECIMALES, ".", "");?><?php echo "&nbsp;". $MONNAIE[1];?>
				<input name="CHK_EXIST_TRAITENA_<?php echo $j;?>" type="checkbox" id="CHK_EXIST_CHQ_<?php echo $j;?>" value="<?php echo $infos_traitena[$j]->montant;?>" />
				<script type="text/javascript">
					Event.observe($("CHK_EXIST_CHQ_<?php echo $j;?>"), "click", function(evt){
						calcul_traitena_banque ();
					}
					);
				</script>
				</td>
				<td style="width:150px; text-align:center;">
				<select id="id_compte_bancaire_source_<?php echo $j;?>" name="id_compte_bancaire_source_<?php echo $j;?>">
                                <?php
                                foreach ($infos_traitena[$j]->comptes_bancaires as $compte_b) {
                                        ?>
                                        <option value="<?php echo $compte_b->id_compte_bancaire;?>"><?php echo $compte_b->lib_compte;?></option>
                                        <?php
                                }
                                ?>
                                </select>
				</td>

				<td style="width:100px">
                                    <?php echo $infos_traitena[$j]->comptes_bancaires[0]->nom_contact; ?>
                                    <input name="date_traitena_<?php echo $j;?>" type="hidden" id="date_traitena_<?php echo $j;?>" value="<?php echo date_Us_to_Fr(date("Y-m-d")); ?>" class="classinput_xsize"   />
				</td>
                                <td style="width:100px;text-align:center">
                                   <?php echo date_Us_to_Fr($infos_traitena[$j]->date); ?>
				</td>
				</tr>
                                <?php if (($infos_traitena[$j]->date <= date("Y-m-d")) && isset($infos_traitena[$j + 1]) && ($infos_traitena[$j + 1]->date > date("Y-m-d"))){
                                ?> <tr> <br />
                                    <br/> Traites non échues :
                                    <br />
                                    <br />
                                </tr> <?php
                                }?>
				</table>
				<div style="height:5px"></div>
			</div>
			<?php
		}
		?>
		<span style="float:right">
			<a href="#" id="all_coche_chq" class="doc_link_simple">Tout cocher</a> /
			<a href="#" id="all_decoche_chq" class="doc_link_simple">Tout d&eacute;cocher</a> /
			<a href="#" id="all_inv_coche_chq" class="doc_link_simple">Inverser la s&eacute;lection</a>
			</span><br />

			<script type="text/javascript">

			Event.observe("all_coche_chq", "click", function(evt){
				Event.stop(evt);
				coche_line_gest_caisse ("coche", "CHQ", parseFloat($("indentation_exist_cheques").value));
				calcul_traitena_banque ();
			});
			Event.observe("all_decoche_chq", "click", function(evt){
				Event.stop(evt);
				coche_line_gest_caisse ("decoche", "CHQ", parseFloat($("indentation_exist_cheques").value));
				calcul_traitena_banque ();
			});
			Event.observe("all_inv_coche_chq", "click", function(evt){
				Event.stop(evt);
				coche_line_gest_caisse ("inv_coche", "CHQ", parseFloat($("indentation_exist_cheques").value));
				calcul_traitena_banque ();
			});
			</script>
		<?php

		$indentation_controle_cheques = 0;
                 /*
		for ($i=0; $i<=$indentation_controle_cheques ; $i++) {
			?>
			<div id="ligne_chq_<?php echo $i;?>">
				<table width="100%">
                                <tr>
				<td style="width:55px">
			<div>&nbsp;</div>
				</td>
				<td style="width:75px; text-align:right; padding-right:5px">
			<input name="CHQ_<?php echo $i;?>" type="text" class="classinput_lsize" id="CHQ_<?php echo $i;?>" size="15" style="text-align:right"/> <?php echo "&nbsp;". $MONNAIE[1];?>
			<script type="text/javascript">
				Event.observe($("CHQ_<?php echo $i;?>"), "blur", function(evt){
					nummask(evt, 0, "X.X");
					Event.stop(evt);
					calcul_prelev_banque ();
				}
				);
			</script>
				</td>
				<td style="width:75px">
				<input name="NUM_<?php echo $i;?>" type="text" id="NUM_<?php echo $i;?>" value="" class="classinput_xsize"  />
				</td>
				<td style="width:75px">
				<input name="BNQ_<?php echo $i;?>" type="text" id="BNQ_<?php echo $i;?>" value="" class="classinput_xsize"   />
				</td>
				<td style="width:75px">
				<input name="POR_<?php echo $i;?>" type="text" id="POR_<?php echo $i;?>" value="" class="classinput_xsize" />
				<input name="REF_<?php echo $i;?>" type="hidden" id="REF_<?php echo $i;?>" value="" />
				</td>
				</tr>
				</table>
			<div style="height:5px"></div>
			</div>
			<?php

		}
		?>
		<div style="text-align:right; cursor:pointer; width:205px; " id="add_line_chq">Ajouter un chèque</div>

			<script type="text/javascript">
				Event.observe($("add_line_chq"), "click", function(evt){
					insert_new_depot_line_chq ();
				}
				);
			</script>

			<?php

                 */
                 ?>
		<input name="indentation_exist_cheques" type="hidden" id="indentation_exist_cheques" value="<?php echo ($count_traitena_a_effectuer - 1);?>"/>
		<input name="indentation_controle_cheques" type="hidden" id="indentation_controle_cheques" value="<?php echo $indentation_controle_cheques;?>"/>

			<div style="width:760px;text-align:left; " class="controle_color_toto">
				<div style="width:40px; float:left; height:25px; line-height:25px; padding-left:5px; font-weight:bolder">Total: </div>
			<div style="  height:25px; line-height:25px; padding-left:155px" class="controle_color_toto"><span id="TT_CHQ">0.00</span> <?php echo "&nbsp;". $MONNAIE[1];?></div>
			</div>

			<div style="height:25px">
			</div>
		</div>
		</td>
		</tr>
		</table>
	</div>


	<div id="traitena_banque"  style=" width:100%; background-color:#FFFFFF">


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
			<span class="controle_sub_title">BANQUE </span><br /><br />
			<div style="width:95%;">
			Le <?php
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>



			</div>
			<br /><br />

			<span style="width:250px; float:left">
			Numéro de traite:</span>
			<input type="text" class="classinput_nsize" value="" id="num_prelev" name="num_traitena" />
			<br /><br />

			<span style="width:250px; float:left">
			Compte bancaire de destination:</span>
			<?php echo htmlentities($compte_bancaire->getLib_compte()); ?>
                        <input type="hidden" id="id_compte_bancaire_destination" name="id_compte_bancaire_destination" value="<?php echo htmlentities($compte_bancaire->getId_compte_bancaire()); ?>"/>
			</div>


		</td>
		</tr>
		</table>
	</div>

	<div  id="traitena_validation"  style="width:100%; display:none; background-color: #FFFFFF">
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
			Traites vers <?php echo htmlentities($compte_bancaire->getLib_compte()); ?>
			</span>
			<br />
			<br />
			<table width="780" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
                                            <div style="width:235px; height:35px; line-height:35px;">Traite(s) disponible(s)</div>		</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;"  id="line1_chq">
					<span id="toto_traitena_theorique"><?php
					if (isset($traitena_a_effectuer)) {
						echo number_format($traitena_a_effectuer, $TARIFS_NB_DECIMALES, ".", "");
					} else {
						echo "0.00";
					}
					?></span><?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</div>
					</td>
					<td height="35" valign="middle" class="line_compta_bottom">
					<div style="width:35px; height:35px; line-height:35px;" id="line2_esp">
					</div>
					<div style="width:35px; height:35px; line-height:35px; display:none;" id="line2_chq">
					<div style="padding-left:10px">
					(<?php
					if (isset($count_chq_theoriques)) {
						echo count($count_chq_theoriques);
					}
					?>)</div>
					</div>
					</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth" style="display:none">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="right" style="display:none">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_theo"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
                                            <div style="width:235px; height:35px; line-height:35px;">Traite(s) s&eacute;lection&eacute;(s)</div>		</td>
					<td height="35" width="40%" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;" id="line3_esp">
					<span id="toto_traitena_select">0.00</span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					<div style="width:75px; height:35px; line-height:35px; display:none;" id="line3_chq">
					<span id="toto_chq_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>				</td>
					<td height="35" valign="middle" class="line_compta_bottom">
					<div style="width:35px;" id="line4_esp"></div>
					<div style="width:35px; height:35px; line-height:35px; display:none;" id="line4_chq">
					<span style="padding-left:10px">(<span id="saisie_op_cheques"></span>)</span></div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth" style="display:none">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="right" style="display:none">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>

					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_right">
					<div style="width:235px; height:35px; line-height:35px; font-weight:bolder">Traite(s) restante(s)</div>		</td>
					<td height="35" valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder;" id="line5_chq">
					<span id="toto_traitena_diff"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					</td>
					<td height="35" valign="middle">&nbsp;</td>
					<td height="35" valign="middle" class="line_compta_right" style="display:none">&nbsp;</td>
					<td valign="middle" align="right" style="display:none">
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
			<img id="bt_etape_3" style=" cursor:pointer; font-weight:bolder; color:#97bf0d; " src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
			</div>
			</div>
			<br />
			<br />
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




Event.observe($("chemin_etape_0_2"), "click", function(evt){Event.stop(evt); step_menu_prelev ('traitena_banque', 'chemin_etape_0', array_menu_v_traitena);});
Event.observe($("chemin_etape_0_3"), "click", function(evt){Event.stop(evt); step_menu_prelev ('traitena_banque', 'chemin_etape_0', array_menu_v_traitena);});

Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt);
    step_menu_prelev ('traitena_selection', 'chemin_etape_1', array_menu_v_traitena);
});

Event.observe($("chemin_etape_1_2"), "click", function(evt){Event.stop(evt);
    step_menu_prelev ('traitena_selection', 'chemin_etape_1', array_menu_v_traitena);
});

Event.observe($("chemin_etape_1_3"), "click", function(evt){Event.stop(evt);
    step_menu_prelev ('traitena_selection', 'chemin_etape_1', array_menu_v_traitena);
});

Event.observe($("bt_etape_2"), "click", function(evt){ Event.stop(evt); step_menu_prelev ('traitena_validation', 'chemin_etape_2', array_menu_v_traitena);});

Event.observe($("chemin_etape_2_2"), "click", function(evt){Event.stop(evt); step_menu_prelev ('traitena_validation', 'chemin_etape_2', array_menu_v_traitena);});
Event.observe($("chemin_etape_2_3"), "click", function(evt){Event.stop(evt); step_menu_prelev ('traitena_validation', 'chemin_etape_2', array_menu_v_traitena);});

Event.observe($("bt_etape_3"), "click", function(evt){Event.stop(evt); $("traitena_create").submit();});

calcul_traitena_banque ();

centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});
//on masque le chargement
H_loading();
</SCRIPT>