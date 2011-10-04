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
<div class="emarge">
<p class="titre">Import terminé</p>
<div>
<table class="contactview_corps" style=" width:100%">
	<tr>
		<td >
		 	L'ensemble des informations présentes dans votre fichier CSV ont été importées. 
		</td>
	</tr>
</table>
<p><a href="#" id="retour_fiche_fournisseur">Retour à la fiche du fournisseur : <?php echo $fournisseur->getNom();?></a></p>
<p><a href="#" id="nouvel_import">Effectuer un nouvel import pour ce même fournisseur</a></p>

</div>
<div id="resultat_imports">
</div>

<SCRIPT type="text/javascript">
	Event.observe("retour_fiche_fournisseur", "click", function(evt){
		page.verify('fiche_fournisseur',
				'annuaire_view_fiche.php?ref_contact=<?php echo $import_tarifs_fournisseur->getRef_fournisseur() ; ?>',
				'true','sub_content');
	}, false);
	Event.observe("nouvel_import", "click", function(evt){
		page.verify('nouvel_import',
				'import_tarifs_fournisseur_csv.php?ref_contact=<?php echo $import_tarifs_fournisseur->getRef_fournisseur() ; ?>',
				'true','sub_content');
	}, false);
	//on masque le chargement
	H_loading();
</SCRIPT>
</div>