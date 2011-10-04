<?php

// *************************************************************************************************************
// ONGLET DES OPTIONS DU DOCUMENT
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
<div style="width:100%; ">
<div style="padding:20px">
        <!-- <a href="documents_mod_contenu_add.php?ref_doc=<?php //echo $document->getRef_doc();?>&types_docs=2;3&lib_mod=test&desc_mod=description_test" id="use_content_mod" style="float:right;" class="common_link">Utiliser ce document en tant que modèle de Contenu</a><br /><br /> -->
        <a href="#" id="use_content_mod" style="float:right;" class="common_link">Utiliser ce document en tant que modèle de Contenu</a><br /><br />
		<a href="#" id="aff_historique" style="float:right" class="common_link" >Consulter l'historique de ce document</a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<?php 
		if ($document->getId_etat_doc () != $document->getID_ETAT_ANNULE ()) {
			
			$stop_annule = false; // on empeche les actions d'annulation d'un document dont le stock n'est plus actif
			$use_stock = 0;
			$use_stock_source = 0;
			$use_stock_cible = 0;
			if (method_exists($document, 'getId_stock') && $document->getId_stock()) {$use_stock = $document->getId_stock();}
			if (method_exists($document, 'getId_stock_source') && $document->getId_stock_source()) {$use_stock_source = $document->getId_stock_source();}
			if (method_exists($document, 'getId_stock_cible') && $document->getId_stock_cible()) {$use_stock = $document->getId_stock_cible();}
			
			if ($use_stock || $use_stock_source || $use_stock_cible) {
				$stocks_supp	= fetch_all_stocks();
				foreach ($stocks_supp as $stock_supp) {
					if (!$stock_supp->actif && ($stock_supp->id_stock == $use_stock_source || $stock_supp->id_stock == $use_stock_cible || $stock_supp->id_stock == $use_stock)) {
						$stop_annule = true;
					}
				}
			}
			//si un document n'est pas terminé, alors de toutes façons on autorise l'annulation
			$etat_doc_termine = array(5 ,4 ,10 ,15, 19, 23, 24, 28, 31, 35, 40, 42, 46, 51, 56);
			if (!in_array($document->getId_etat_doc(), $etat_doc_termine )) {$stop_annule = false;}
			
			//sauf les inventaires terminés qui ne peuvent etre annulés
			if ($document->getId_etat_doc () == 46) {$stop_annule = true;}
			
			if (!$stop_annule) {
				?>
				<a href="#" id="annuler_document" class="doc_link_standard"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_annuler_doc.gif" alt="Annuler le document" title="Annuler le document" /></a>
			<?php 
			}
		} else {
			?>
			<a href="#" id="reactiver_document" class="doc_link_standard"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_reactiver_doc.gif" alt="Réactiver le document" title="Réactiver le document" /></a>
		<?php 
		}
		?>
		
		<div style="height:5px;line-height:5px;" ></div>
		<?php 
		if ($document->getId_etat_doc () == 27) {
			?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_cdc_traitee.gif" id="commande_traite" style="cursor:pointer"/>
			<div style="height:3px; line-height:3px;"></div>
			<?php 
		}
		?>
		<?php 
		if ($document->getId_etat_doc () == 28) {
			?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_cdf_reception.gif" id="creer_reception" style="cursor:pointer"/>
			<div style="height:3px; line-height:3px;"></div>
			<?php 
		}
		?>
		<?php 
		if ($document->getId_etat_doc () == 9) {
			?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_cdc_traitee.gif" id="commande_traite" style="cursor:pointer"/>
		<div style="height:3px; line-height:3px;"></div>
		<?php 
		}
		?>
		<?php 
		if ($document->getId_etat_doc () == 18) {
			?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_fac_acquitee.gif" id="facture_acquitee" style="cursor:pointer"/>
		<div style="height:3px; line-height:3px;"></div>
		<?php 
		}
		?>
		<?php 
		if ($document->getId_etat_doc () == 34) {
			?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_fac_acquitee.gif" id="facture_acquitee" style="cursor:pointer"/>
		<div style="height:3px; line-height:3px;"></div>
		<?php 
		}
		?>
		</td>
	</tr>
</table>
</div>

<script type="text/javascript">
<?php 
if ($document->getId_etat_doc () != $document->getID_ETAT_ANNULE ()) {
	?>
	<?php 
	if (!$stop_annule) {
		?>
		//annuler document
		Event.observe("annuler_document", "click", function(evt){Event.stop(evt); maj_etat_doc (<?php echo $document->getID_ETAT_ANNULE ();?>); }, false);
		<?php 
	}
} else {
	?>
	//reactiver
	Event.observe("reactiver_document", "click", function(evt){Event.stop(evt); maj_etat_doc (<?php echo $document->getDEFAUT_ID_ETAT ();?>); }, false);
<?php 
}
?>

<?php 
if ($document->getId_etat_doc () == 27) {
	?>
	//
	Event.observe("commande_traite", "click", function(evt){Event.stop(evt); maj_etat_doc (28); }, false);
<?php 
}
?>
<?php 
if ($document->getId_etat_doc () == 28) {
	?>
	//
	Event.observe("creer_reception", "click", function(evt){Event.stop(evt); generer_document("generer_br_fournisseur");  }, false);
<?php 
}
?>
<?php 
if ($document->getId_etat_doc () == 9) {
	?>
	//
	Event.observe("commande_traite", "click", function(evt){Event.stop(evt); maj_etat_doc (10); }, false);
<?php 
}
?>
<?php 
if ($document->getId_etat_doc () == 18) {
	?>
	//
	Event.observe("facture_acquitee", "click", function(evt){Event.stop(evt); maj_etat_doc (19); }, false);
<?php 
}
?>
<?php 
if ($document->getId_etat_doc () == 34) {
	?>
	//
	Event.observe("facture_acquitee", "click", function(evt){Event.stop(evt); maj_etat_doc (35); }, false);
<?php 
}
?>
//on masque le chargement
H_loading();

</script>
</div>
<div>
<?php 
if (isset($liste_doc_fusion) && count($liste_doc_fusion)) {
	?>
	Fusionner un document avec le document en cours<br />
	<select name="fusion_doc_choix" id="fusion_doc_choix">
		<option value=""></option>
	<?php 
	foreach ($liste_doc_fusion as $doc_fusion) {
		?>
		<option value="<?php echo $doc_fusion->ref_doc;?>"><?php echo $doc_fusion->ref_doc;?> - <?php echo $doc_fusion->lib_etat_doc;?> - <?php echo price_format($doc_fusion->montant_ttc);?> <?php echo $MONNAIE[1];?> - <?php echo Date_Us_to_Fr($doc_fusion->date_doc);?></option>
		<?php
	}
	?>
	</select>
	<input type="button" value="Fusionner les documents" name="fusion_de_doc" id="fusion_de_doc" />
	
<script type="text/javascript">
	Event.observe("fusion_de_doc", "click", function(evt){
		Event.stop(evt);
		if ($("fusion_doc_choix").value != "") {
			$("titre_alert").innerHTML = "Confirmer la fusion des documents";
			$("texte_alert").innerHTML = "Confirmer la fusion des deux documents<br /> Les règlements du document choisi seront ré-attribués au document en cours";
			$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
		
			$("alert_pop_up_tab").style.display = "block";
			$("framealert").style.display = "block";
			$("alert_pop_up").style.display = "block";
			
			$("bouton0").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			}
			$("bouton1").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			doc_edition_fusion ("<?php echo $document->getRef_doc ();?>", $("fusion_doc_choix").value);
			}
				
		}
		
	}, false);
</script>
	<?php
}
?>
<script type="text/javascript">

Event.observe('use_content_mod', "click", function(evt){
  charger_contenu_modeles();
  $('mod_contenu_content').style.display = "block";
  reglement_rapide = false;
  Event.stop(evt);
});
//centrage de la pop_up modèles de contenu
centrage_element("mod_contenu_content");

Event.observe('aff_historique', "click", function(evt){
	charger_contenu_events();
	$('historique_content').style.display = "block";  
	reglement_rapide = false;
	Event.stop(evt);
});
//centrage de la pop_up historique
centrage_element("historique_content");

Event.observe(window, "resize", function(evt){
centrage_element("mod_contenu_content");
centrage_element("historique_content");
});
</script>
</div>
