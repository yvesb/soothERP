<?php

// *************************************************************************************************************
// AJOUT D'UNE LIGNE DE FORMULES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


			$nb_ligne_prix= $_REQUEST["nb_ligne_prix"];
			$tarifs_count= count($tarifs_liste);
			$style_widthpc=round(100/($tarifs_count+1));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
			
?>
<script type="text/javascript">
</script>
					<table style="width:100%" cellspacing="0" cellpadding="0" border="0" id="tarif_newqte_<?php echo $nb_ligne_prix?>">
					<tr>
						<td class="assist_labelled_bold" style="border-right:1px solid #FFFFFF; border-top:1px solid #FFFFFF;  width:180px;">
						<a href="#" style="float:left" id="tarif_newqte_bt_del_<?php echo $nb_ligne_prix?>">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">						</a>
					<div style="width:180px;">

						<div style=" text-align:center;">
						Quantit&eacute;: 
						<input type="text" name="qte_tarif_<?php echo $nb_ligne_prix?>" id="qte_tarif_<?php echo $nb_ligne_prix?>" value="1"  size="8" class="assistant_input"/>
						<input type="hidden" name="qte_tarif_old_<?php echo $nb_ligne_prix?>" id="qte_tarif_old_<?php echo $nb_ligne_prix?>" value="newqte" class="assistant_input"/>
						</div>
						</div>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<?php 
						reset($tarifs_liste);
						$nb_liste_tarif=0;
						foreach ($tarifs_liste as $tarif_liste) {
						?>
						<td style="  width:180px; text-align:center; border-top:1px solid #FFFFFF;<?php if(key($tarifs_liste)<$tarifs_count){?> border-right:1px solid #FFFFFF; <?php }?>">
							<a href="#" style="float:right; display:none;" id="tarif_del_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" title="Supprimer la formule">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
							</a>
					<div style="width:180px;">
							<input type="hidden" name="formule_cree_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="formule_cree_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="0" />
							<input type="hidden" name="id_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="id_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="<?php echo $tarif_liste->id_tarif?>" />
							<input type="hidden" name="formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="<?php
							if ($tarif_liste->formule_tarif=="")
								{echo $tarif_liste->marge_moyenne;
								}
								else 
								{ echo $tarif_liste->formule_tarif;
							}
							?>" />
							<div id="aff_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" style="font-weight:bolder;color:#023668;cursor:pointer;">&nbsp;</div>
			<span style="position:relative; width:100%;" >
				<div id="show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" style="display:none; z-index:250; position:absolute;  top: 0em; left: 0px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:105px; height:29px; overflow:auto; font-size:9px; text-align:left; padding:1px">
				</div>
			</span>
			<script type="text/javascript">
			Event.observe('aff_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>', "click", function(evt){
				Event.stop(evt); 
				if ($("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").style.display == "") {
					$("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").hide();
				}else {
					$("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").show();
					calcul_tarif_cell_marge("<?php echo $nb_liste_tarif?>", "<?php echo $nb_ligne_prix?>");
				}
				
			});
			</script>

							<a href="#" id="aff_formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" style="color:#7391a9;  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>display:none;<?php } ?>">D&eacute;finir un nouveau tarif
							</a>
							</div>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
							</td>
						<?php
						$nb_liste_tarif= $nb_liste_tarif+1;
						next($tarifs_liste);
						}
						?>
					</tr>
					</table>
				
<SCRIPT type="text/javascript">
<?php 
reset($tarifs_liste);
$nb_liste_tarif=0;
foreach ($tarifs_liste as $tarif_liste) {
?>
Event.observe('aff_formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>', "click", function(evt){Event.stop(evt); $('pop_up_assistant_tarif').style.display='block'; $('pop_up_assistant_tarif_iframe').style.display='block'; $('assistant_cellule').value='<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>';edition_formule_tarifaire ("formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>");});


Event.observe('tarif_del_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>', "click", function(evt){
	Event.stop(evt); 
	$("aff_formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").innerHTML="Définir un nouveau tarif";
	$("formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").value="<?php
							if ($tarif_liste->formule_tarif=="")
								{echo $tarif_liste->marge_moyenne;
								}
								else 
								{ echo $tarif_liste->formule_tarif;
							}
							?>";
	$("formule_cree_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").value="0";
	$("tarif_del_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").hide();
	//$("info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").hide();
	$("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").hide();
	grille_calcul_tarif("<?php echo $nb_ligne_prix?>");
});
<?php
$nb_liste_tarif= $nb_liste_tarif+1;
next($tarifs_liste);
}
?>



<?php if ($nb_ligne_prix!=1) {?>
recup_previous_qte ("tarif_newqte_<?php echo $nb_ligne_prix?>");
<?php }?>
$("nb_ligne_prix").value=<?php echo $nb_ligne_prix+1;?>;

Event.observe('qte_tarif_<?php echo $nb_ligne_prix?>', "blur", function(evt){nummask(evt,"<?php echo $nb_ligne_prix+1;?>", "X");grille_calcul_tarif("<?php echo $nb_ligne_prix?>");});

Event.observe('tarif_newqte_bt_del_<?php echo $nb_ligne_prix?>', "click", function(evt){Event.stop(evt); alerte.confirm_supprimer_tag('tarif_delqte', 'tarif_newqte_<?php echo $nb_ligne_prix?>');});



	//on masque le chargement
H_loading();
</SCRIPT>