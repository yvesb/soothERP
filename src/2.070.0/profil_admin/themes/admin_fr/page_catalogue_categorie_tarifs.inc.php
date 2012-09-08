<?php

// *************************************************************************************************************
// GRILLES TARIFAIRES POUR LES CATEGORIES D'ARTICLES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<div style="height:30%;" >
		<table style="width:100%">
		<tr>
			<td colspan="6">
			<?php 
			$tarifs_count= count($tarifs_liste);
			$style_widthpc=round(100/($tarifs_count+1));
			?>
				<div class="tarif_table" id="tableau_des_tarifs">
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
					<tr> 
						<td style=" text-align:center; border-right:1px solid #FFFFFF; width:150px;" class="labelled_bold"><br />
<div style="width:150px;"><strong>GRILLE DE TARIFS</strong></div>&nbsp;
</td>
						<?php 
						foreach ($tarifs_liste as $tarif_liste) {
						?>
						<td style=" text-align:center; width:150px; <?php if(key($tarifs_liste)<$tarifs_count){?>border-right:1px solid #FFFFFF;<?php }?>" class="assist_labelled_bold"><br />
						<div style="width:150px">
						<?php echo htmlentities($tarif_liste->lib_tarif); ?>
						</div>
&nbsp;</td>
						<?php
						next($tarifs_liste);
						}
						?>
					</tr>
					</table>
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
					<tr>
						<td class="assist_labelled_bold" style="border-right:1px solid #FFFFFF; border-top:1px solid #FFFFFF; width:150px; text-align:center;"><br />
						<div style="width:150px">Valeur par defaut:</div><br />


							<input type="hidden" name="qte_tarif_0" id="qte_tarif_0" value="1" /></td>
						<?php 
						reset($tarifs_liste);
						$nb_liste_tarif=0;
						foreach ($tarifs_liste as $tarif_liste) {
						?>
						<td style=" text-align:center; border-top:1px solid #FFFFFF;<?php if(key($tarifs_liste)<$tarifs_count){?> border-right:1px solid #FFFFFF; <?php }?> width:150px;">
						<div style=" width:150px;">
						
							<form method="post" target="formFrame" action="catalogue_categorie_tarifs_sup.php?n_liste=<?php echo $nb_liste_tarif?>_0" id="catalogue_categorie_tarifs_sup_<?php echo $nb_liste_tarif?>_0" name="catalogue_categorie_tarifs_sup_<?php echo $nb_liste_tarif?>_0">
							<input type="hidden" name="formule_add_<?php echo $nb_liste_tarif?>_0" id="formule_add_<?php echo $nb_liste_tarif?>_0" value="<?php
							if ($tarif_liste->formule_tarif=="")
								{echo "0";
								}
								else 
								{ 
								echo "1";
								}
							?>" />
							<input type="hidden" name="id_tarif_<?php echo $nb_liste_tarif?>_0" id="id_tarif_<?php echo $nb_liste_tarif?>_0" value="<?php echo $tarif_liste->id_tarif?>" />
							<input type="hidden" name="formule_tarif_<?php echo $nb_liste_tarif?>_0" id="formule_tarif_<?php echo $nb_liste_tarif?>_0" value="<?php
							if ($tarif_liste->formule_tarif=="")
								{echo $tarif_liste->marge_moyenne;
								}
								else 
								{ 
								echo $tarif_liste->formule_tarif;?>
								<?php
							}
							?>" />
							<input type="hidden" name="indice_qte_<?php echo $nb_liste_tarif?>_0" id="indice_qte_<?php echo $nb_liste_tarif?>_0" value="1" />
							<input type="hidden" name="ref_art_categ_<?php echo $nb_liste_tarif?>_0" id="ref_art_categ_<?php echo $nb_liste_tarif?>_0" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
							</form>
							<a href="#" style="float:right; <?php if ($tarif_liste->formule_tarif=="")	{?>display:none;<?php }?>" id="tarif_del_<?php echo $nb_liste_tarif?>_0" title="Supprimer la formule cr&eacute;&eacute;e pour cette cat&eacute;gorie dans cette grille tarifaire">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
							</a>
							<br />


							<a id="aff_formule_tarif_<?php echo $nb_liste_tarif?>_0" style="color:#666666; cursor:pointer;">
							<?php if ($tarif_liste->formule_tarif=="")
							{echo $tarif_liste->marge_moyenne;
							}
	
							else 
							{ echo $tarif_liste->formule_tarif;}
							?>
							</a>
							</div>
						</td>
						<?php
						$nb_liste_tarif= $nb_liste_tarif+1;
						next($tarifs_liste);
						}
						?>
					</tr>
				</table>
				</div>

			<input type="hidden" name="nb_liste_tarif" id="nb_liste_tarif" value="<?php echo $tarifs_count?>" />
			<input type="hidden" name="nb_ligne_prix" id="nb_ligne_prix" value="1" />
			</td>
			</tr>
		</table>


		<p style="color:#666666">Vous pouvez d&eacute;finir des formules tarifaires pour la cat&eacute;gorie en lieu et place des marges d&eacute;finies dans les grilles tarifaires </p>

		</div>
<SCRIPT type="text/javascript">

<?php 
reset($tarifs_liste);
$nb_liste_tarif=0;
foreach ($tarifs_liste as $tarif_liste) {
?>
Event.observe('aff_formule_tarif_<?php echo $nb_liste_tarif?>_0', "click", function(evt){Event.stop(evt);  $('pop_up_assistant_tarif').style.display='block'; $('pop_up_assistant_tarif_iframe').style.display='block'; $('assistant_cellule').value='<?php echo $nb_liste_tarif?>_0'; $("assistant_indice_qte").value=$("qte_tarif_0").value; $("new_formule").value=$("formule_add_<?php echo $nb_liste_tarif?>_0").value; $("old_formule").value=$("formule_tarif_<?php echo $nb_liste_tarif?>_0").value; $("assistant_id_tarif").value=$("id_tarif_<?php echo $nb_liste_tarif?>_0").value; $("assistant_art_categ").value="<?php echo $art_categ->getRef_art_categ(); ?>";edition_formule_tarifaire ("formule_tarif_<?php echo $nb_liste_tarif?>_0");});


Event.observe('tarif_del_<?php echo $nb_liste_tarif?>_0', "click", function(evt){Event.stop(evt); alerte.confirm_supprimer('tarif_del_categ','catalogue_categorie_tarifs_sup_<?php echo $nb_liste_tarif?>_0');});

<?php
$nb_liste_tarif= $nb_liste_tarif+1;
next($tarifs_liste);
}
?>

//on masque le chargement
H_loading();
</SCRIPT>
