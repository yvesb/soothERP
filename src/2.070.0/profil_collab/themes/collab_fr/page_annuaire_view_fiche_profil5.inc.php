<table style="width:100%">
<tr>
<td>
<div>
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil5_suppression" name="annu_edition_profil5_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations fournisseur </p>
<div class="reduce_in_edit_mode">
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil5" name="annu_edition_profil5" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de fournisseur:</span>
			</td>
			<td>
				<select  id="id_fournisseur_categ"  name="id_fournisseur_categ" class="classinput_xsize">
				<?php
				foreach ($liste_categories_fournisseur as $liste_categorie_fournisseur){
					?>
					<option value="<?php echo $liste_categorie_fournisseur->id_fournisseur_categ;?>" <?php if ($profils[$id_profil]->getId_fournisseur_categ () == $liste_categorie_fournisseur->id_fournisseur_categ) {echo 'selected="selected"'; $id_fournisseur_categ =  htmlentities($liste_categorie_fournisseur->id_fournisseur_categ);}?>>
					<?php echo htmlentities($liste_categorie_fournisseur->lib_fournisseur_categ)?></option>
					<?php 
				}?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Identifiant client:</span>
			</td>
			<td>
				<input name="code_client" id="code_client" type="text" class="classinput_xsize" value="<?php echo htmlentities($profils[$id_profil]->getCode_client ()) ?>" />
				</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions commerciales:</span>
			</td>
			<td>
				<textarea name="conditions_commerciales" id="conditions_commerciales" class="classinput_xsize"><?php echo htmlentities($profils[$id_profil]->getConditions_commerciales ()) ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse d'exp&eacute;dition des marchandises:</span>
			</td>
			<td>
			<select  id="id_stock_livraison"  name="id_stock_livraison" class="classinput_xsize">
				<?php
				$lib_stock = "";
				foreach ($stocks_liste as $stock_liste){
					?>
					<option value="<?php echo $stock_liste->getId_stock();?>" <?php if ($stock_liste->getId_stock() == $profils[$id_profil]->getId_stock_livraison ()) { echo 'selected="selected"'; $lib_stock = htmlentities($stock_liste->getLib_stock());}?>>
					<?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Afficher Tarifs:</span>
			</td><td>
			<select id="app_tarifs" name="app_tarifs" class="classinput_xsize">
				<option value="">Automatique</option>
				<option value="HT" <?php if ($profils[$id_profil]->getApp_tarifs () == "HT") {echo 'selected="selected"';}?>>HT</option>
				<option value="TTC" <?php if ($profils[$id_profil]->getApp_tarifs () == "TTC") {echo 'selected="selected"';}?>>TTC</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai de livraison:</span>
			</td><td>
			<input name="delai_livraison" id="delai_livraison" type="text" class="classinput_xsize" value="<?php echo htmlentities($profils[$id_profil]->getDelai_livraison ()) ?>" />
			</td>
		</tr>
	</table>
	<p style="text-align:center">
<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
</p>
	</form>
	
	<table class="minimizetable"  id="start_visible_profil<?php echo $id_profil?>">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de fournisseur :</span>
			</td>
			<td>
			<a href="#" id="show5_id_fournisseur_categ" class="modif_select1">
			<?php
			foreach ($liste_categories_fournisseur as $liste_categorie_fournisseur){
				if ($profils[$id_profil]->getId_fournisseur_categ () == $liste_categorie_fournisseur->id_fournisseur_categ) {?>
				<?php echo htmlentities($liste_categorie_fournisseur->lib_fournisseur_categ)?>
				<?php 
				}
			}
			?>
			</a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Identifiant client:</span>
			</td>
			<td>
			<a href="#" id="show5_code_client" class="modif_input1">
			<?php echo  htmlentities($profils[$id_profil]->getCode_client ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions commerciales:</span>
			</td>
			<td>
			<a href="#" id="show5_conditions_commerciales" class="modif_input1"><?php echo  nl2br(htmlentities($profils[$id_profil]->getConditions_commerciales ()))?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse d'exp&eacute;dition des marchandises::</span>
			</td>
			<td>
			<a href="#" id="show5_lib_stock" class="modif_input1"><?php echo  $lib_stock;?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Tarifs:</span>
			</td>
			<td>
			<a href="#" id="show5_app_tarifs" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getApp_tarifs ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai de livraison:</span>
			</td>
			<td>
			<a href="#" id="show5_delai_livraison" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getDelai_livraison ())?></a>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>

<script type="text/javascript" language="javascript">
Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
	Event.stop(evt); 
	$('annu_edition_profil<?php echo $id_profil?>').toggle();
	$('start_visible_profil<?php echo $id_profil?>').toggle();
}, false);


Event.observe("show5_delai_livraison", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','delai_livraison');}, false);

Event.observe("show5_lib_stock", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','conditions_commerciales');}, false);

Event.observe("show5_conditions_commerciales", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','conditions_commerciales');}, false);

Event.observe("show5_code_client", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','code_client');}, false);

Event.observe("show5_app_tarifs", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','app_tarifs');}, false);

Event.observe("show5_id_fournisseur_categ", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_fournisseur_categ');}, false);

new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});

//affichage de la liste des boutons des documents fournisseurs
$("liste_document_fournisseur").show();

//on masque le chargement
H_loading();

</script>
</div>
<br/>
<table>
	<tr>
		<td colspan="2" style="height: 20px; vertical-align: middle;">
			<span id="import_tarifs_fournisseur_csv" style="cursor:pointer;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif" align="absmiddle" />
				Import d'articles depuis un fichier CSV
			</span>
			<script type="text/javascript">
				Event.observe("import_tarifs_fournisseur_csv", "click", function(evt){
					page.verify('import_tarifs_fournisseur_csv', 'import_tarifs_fournisseur_csv.php?ref_contact=<?php echo $contact->getRef_contact()?>', "true", 'sub_content');
					Event.stop(evt);
				});
			</script>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="height: 20px; vertical-align: middle;">
			<span id="articlesDispDuFournisseur" style="cursor:pointer;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif" align="absmiddle" />
				Liste des articles disponibles auprès de ce fournisseur
			</span>
			<script type="text/javascript">
				Event.observe("articlesDispDuFournisseur", "click", function(evt){
					page.verify('articlesDispDuFournisseur', 'catalogue_articles_proposes_fournisseur.php?ref_fournisseur=<?php echo $contact->getRef_contact()?>', "true", 'sub_content');
					Event.stop(evt);
				});
			</script>
		</td>
	</tr>
</table>
</div><br />


<p class="sous_titre2">	Documents en cours:</p>
<?php
$first_docs = 0;
if (count($client_last_DEF_en_cours )) {
	?>

Devis en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_DEF_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_DEF_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Devis en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_DEF_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=5&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_CDF_en_cours )) {
	?>

Commandes en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_CDF_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_CDF_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Commandes en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_CDF_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=6&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?><?php
$first_docs = 0;
if (count($client_last_BLF_en_cours )) {
	?>

Bons de Livraisons en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_BLF_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_BLF_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Bons de livraisons en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_BLF_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=7&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_FAF_en_cours )) {
	?>

Factures en cours:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_FAF_en_cours as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_en_cours_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_en_cours_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_FAF_en_cours" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Factures en cours </div><br />
	<script type="text/javascript">
	Event.observe('show_all_FAF_en_cours', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=1&id_type_doc=8&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<p class="sous_titre2">	Documents en archive:</p>
<?php
$first_docs = 0;
if (count($client_last_DEF_archive )) {
	?>
Devis en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_DEF_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_DEF_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des devis en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_DEF_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=5&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_CDF_archive )) {
	?>
Commandes en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_CDF_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_CDF_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Commandes en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_CDF_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=6&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_BLF_archive )) {
	?>
Bons de commandes en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_BLF_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_BLF_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Bons de commandes en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_BLF_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=7&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
<?php
$first_docs = 0;
if (count($client_last_FAF_archive )) {
	?>
Factures en archive:
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-top:1px solid #93bad7; border-right:1px solid #93bad7;">
	<tr class="smallheight" style="background-color:#93bad7;">
		<td style="width:85px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style=" border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:120px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:100px; border-right:1px solid #FFFFFF;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr style="background-color:#93bad7;">
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Date</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Document</td>
		<td style=" border-right:1px solid #FFFFFF; text-align:left; padding-left:5px">Etat</td>
		<td style=" border-right:1px solid #FFFFFF;text-align:center; padding-left:5px">Prix</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="1"/></td>
	</tr>
	</table>
	<?php
	foreach ($client_last_FAF_archive as $contact_last_doc) {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left:1px solid #93bad7; border-right:1px solid #93bad7;">
		<tr class="smallheight" style="background-color:#FFFFFF;">
			<td style="width:85px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style=" border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:120px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:100px; border-right:1px solid #93bad7;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr style="cursor:pointer; background-color:#FFFFFF; color:#002673">
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo date_Us_to_Fr($contact_last_doc->date_creation);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_type_doc);?> - <?php echo htmlentities($contact_last_doc->ref_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7; border-bottom:1px solid #93bad7; text-align:left; padding-left:5px" id="open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>">
				<?php echo htmlentities($contact_last_doc->lib_etat_doc);?>
			</td>
			<td style=" border-right:1px solid #93bad7;  border-bottom:1px solid #93bad7; text-align:center; padding-left:5px" id="open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>">
			<?php echo htmlentities(price_format($contact_last_doc->montant_ttc))." ".$MONNAIE[1];?>
			</td>
			<td style=" border-bottom:1px solid #93bad7; text-align:center; ">
			<a href="documents_editing.php?ref_doc=<?php echo $contact_last_doc->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
			</td>
		</tr>
		</table>
		<script type="text/javascript">
			Event.observe('open_doc_archive_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_1_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_2_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
			Event.observe('open_doc_archive_3_<?php echo ($contact_last_doc->ref_doc);?>', "click", function(evt){ open_doc("<?php echo ($contact_last_doc->ref_doc);?>"); });
		</script>
		<?php 
		$first_docs ++;
	}
	?>
	<div id="show_all_FAF_archive" style="cursor:pointer; font-size:11px; color:#002673;">&gt;&gt;Consulter l'ensemble des Factures en archive </div><br />
	<script type="text/javascript">
	Event.observe('show_all_FAF_archive', "click", function(evt){
	lib_contact_docsearch = $("nom").value.truncate (38);
	page.verify("document_recherche","documents_recherche.php?ref_contact_docsearch=<?php echo $contact->getRef_contact();?>&is_open=0&id_type_doc=8&lib_contact_docsearch=<?php echo urlencode((nl2br(addslashes(substr (str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", $contact->getNom()))),0, 38)))))?>", "true", "sub_content");
	});
	</script>
	<?php 
}
?>
</td>
<td style="width:35%">
<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px">
						<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
							<tr style="">
								<td class="aff_an_article">&nbsp;</td>
								<td class="aff_an_article">N</td>
								<td class="aff_an_article">N-1</td>
								<td class="aff_an_article">N-2</td>
							</tr>
							<tr>
								<td class="aff_tit_article">C.A. Fournisseur </td>
								<td class="aff_ca_article">
									<?php if (isset($fournisseur_CA[0])) {?>
									<?php echo price_format($fournisseur_CA[0])." ".$MONNAIE[1];?>
									<?php } ?>
								</td>
								<td class="aff_ca_article">
									<?php if (isset($fournisseur_CA[1])) {?>
									<?php echo price_format($fournisseur_CA[1])." ".$MONNAIE[1];?>
									<?php } ?>
								</td>
								<td class="aff_ca_article">
									<?php if (isset($fournisseur_CA[2])) {?>
									<?php echo price_format($fournisseur_CA[2])." ".$MONNAIE[1];?>
									<?php } ?>
								</td>
							</tr>
						</table>
					</td>
			</tr>
		</table>
	<br />
	<span style="font-weight:bolder">Solde comptable: <?php echo price_format($solde_comptable)." ".$MONNAIE[1];?></span>
	<br />
	<br />
	</td>
</tr>
</table>
