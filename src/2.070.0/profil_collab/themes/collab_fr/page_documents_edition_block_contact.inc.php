<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<div style="width:100%;">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
	<tr style=" line-height:20px; height:20px;" class="document_head_list">
		<td colspan="3" style=" padding-left:3px;" class="doc_bold" >
			Contact
			<input type="hidden" name="ref_contact"  id="ref_contact" value="<?php echo $document->getRef_contact();?>"/>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;
		</td>
	</tr>
	<tr>
		<td style="width:150px; padding-left:3px;">
			Nom: 
		</td>
		<td style="width:250px;">
			<textarea type="text" name="nom_contact"  id="nom_contact" class="classinput_xsize" rows="2"><?php echo htmlentities($document->getNom_contact());?></textarea>
			<div id="nom_contact_old" style="display:none"><?php echo htmlentities($document->getNom_contact());?></div>
		</td>
		<td>
			&nbsp;<a href="#" id="" class="doc_link_standard">choisir un contact</a>
			 <script type="text/javascript">
				Event.observe("", "click",  function(evt){Event.stop(evt); show_mini_moteur_contacts ('docu_maj_contact', '\'<?php echo $document->getRef_doc();?>\''); preselect ('<?php
			//preselection du type de contact en fonction du type de document
			if ( $document->getID_TYPE_DOC() == $LIVRAISON_CLIENT_ID_TYPE_DOC || $document->getID_TYPE_DOC() == $COMMANDE_CLIENT_ID_TYPE_DOC || $document->getID_TYPE_DOC() == $DEVIS_CLIENT_ID_TYPE_DOC || $document->getID_TYPE_DOC() == $FACTURE_CLIENT_ID_TYPE_DOC ) {
			 echo $CLIENT_ID_PROFIL;
			 }
			 
			if ( $document->getID_TYPE_DOC() == $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC || $document->getID_TYPE_DOC() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC || $document->getID_TYPE_DOC() == $DEVIS_FOURNISSEUR_ID_TYPE_DOC || $document->getID_TYPE_DOC() == $FACTURE_FOURNISSEUR_ID_TYPE_DOC ) {
			 echo $FOURNISSEUR_ID_PROFIL;
			 }
			 ?>', 'id_profil_m');}, false);
				</script>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;
		</td>
	</tr>
	<tr>
		<td style=" padding-left:3px;">
			Adresse Contact:
		</td>
		<td colspan="2">
			<input type="hidden" name="ref_adr_contact"  id="ref_adr_contact" value="<?php echo $document->getRef_adr_contact();?>"/>
			<table cellpadding="0" cellspacing="0" border="0" style="width:268px;">
				<tr>
					<td style="width:250px;">
						<textarea name="adresse_contact" id="adresse_contact" class="classinput_xsize" rows="2"><?php echo  htmlentities($document->getAdresse_contact());?></textarea>
						<div id="adresse_contact_old" style="display:none"><?php echo htmlentities($document->getAdresse_contact());?></div>
					</td>
					<td style="width:18px; vertical-align:bottom">
					<div id="adresse_contact_choisie" class="simule_champs" style="width:15px;cursor: default;">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_adresse_contact_choisie">
					</div>
					</td>
					</tr>
					<tr>
					<td colspan="2">
					<div style="position:relative; top:-21px; left:0px; width:250px; height:0px;">
					<iframe id="iframe_liste_choix_adresse_contact" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none"></iframe>
					<div id="choix_liste_choix_adresse_contact"  class="choix_liste_choix_coordonnee" style="display:none"></div></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;
		</td>
	</tr>
	<?php
	if ($document->getID_TYPE_DOC() == "1" || $document->getID_TYPE_DOC() == "2") {
	 ?>
	<tr>
		<td style=" padding-left:3px;">
			Adresse Livraison: 
		</td>
		<td colspan="2">
			<input type="hidden" name="ref_adr_livraison"  id="ref_adr_livraison" value="<?php echo $document->getRef_adr_livraison();?>"/>
			<table cellpadding="0" cellspacing="0" border="0" style="width:268px;">
				<tr>
					<td style="width:250px;">
						<textarea name="adresse_livraison" id="adresse_livraison" class="classinput_xsize" rows="2"><?php echo  htmlentities($document->getAdresse_livraison());?></textarea>
						<div id="adresse_livraison_old" style="display:none"><?php echo htmlentities($document->getAdresse_livraison());?></div>
					</td>
					<td style="width:18px; vertical-align:bottom">
					<div id="adresse_livraison_choisie" class="simule_champs" style="width:15px;cursor: default;">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_adresse_livraison_choisie">
					</div>
					</td>
					</tr>
					<tr>
					<td colspan="2">
					<div style="position:relative; top:-21px; left:0px; width:250px; height:0px;">
					<iframe id="iframe_liste_choix_adresse_livraison" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none"></iframe>
					<div id="choix_liste_choix_adresse_livraison"  class="choix_liste_choix_coordonnee" style="display:none"></div></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;
		</td>
	</tr>
		<?php 
	}
	?>

</table>

<script type="text/javascript">
//observateur pour liste adresse contact
pre_start_adresse_doc ("adresse_contact_choisie", "bt_adresse_contact_choisie", $("ref_contact").value, "adresse_contact", "ref_adr_contact", "choix_liste_choix_adresse_contact", "iframe_liste_choix_adresse_contact", "documents_liste_choix_adresse.php", $("ref_doc").value, "adresse_contact");

// observateurde changement de texte dans les infos contact pour mise à jour des infos

Event.observe("nom_contact", "blur", function(evt){
		if ($("nom_contact").value != $("nom_contact_old").innerHTML) {
			docu_maj_contact_infos ($("ref_doc").value, "nom_contact"); 
			$("nom_contact_old").innerHTML = $("nom_contact").value;
			}
		}, false);
		
Event.observe("adresse_contact", "blur", function(evt){
		if ($("adresse_contact").value != $("adresse_contact_old").innerHTML) {
			docu_maj_contact_infos ($("ref_doc").value, "adresse_contact"); 
			$("adresse_contact_old").innerHTML = $("adresse_contact").value;
			}
		}, false);


<?php
if ($document->getID_TYPE_DOC() == "1" || $document->getID_TYPE_DOC() == "2") {
 ?>
// observateur pour liste adresse livraison
	pre_start_adresse_doc ("adresse_livraison_choisie", "bt_adresse_livraison_choisie", $("ref_contact").value, "adresse_livraison", "ref_adr_livraison", "choix_liste_choix_adresse_livraison", "iframe_liste_choix_adresse_livraison", "documents_liste_choix_adresse.php", $("ref_doc").value, "adresse_livraison");
	

// observateurde changement de textedans les infos contact pour mise à jour des infos
Event.observe("adresse_livraison", "blur", function(evt){
		if ($("adresse_livraison").value != $("adresse_livraison_old").innerHTML) {
			docu_maj_contact_infos ($("ref_doc").value, "adresse_livraison"); 
			$("adresse_livraison_old").innerHTML = $("adresse_livraison").value;
			}
		}, false);

	<?php 
}
?>


<?php 
//si on change de contact alors les infos sont retournées par $_infos
// on met juste à jour l'app_tarifs par rapport au contact mis à jour
if ($document->getApp_tarifs()) {
	?>
	$("app_tarifs").value				= "<?php echo htmlentities($document->getApp_tarifs());?>";
	if ($("app_tarifs").value	== "HT") {
	$("prix_afficher_ht").checked = "checked";
	} else {
	$("prix_afficher_ttc").checked = "checked";
	}
	document_calcul_tarif ();
	<?php
}
?>
	//on masque le chargement
	H_loading();

</script>
</div>