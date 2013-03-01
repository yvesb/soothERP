<?php

// *************************************************************************************************************
// AFFICHAGE DU GRAND LIVRE D'UN CONTACT
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
<a  href="#" id="link_retour_contact" style="float:right" class="common_link">retour à la fiche du contact</a><br />
</span>
<script type="text/javascript">
Event.observe("link_retour_contact", "click",  function(evt){Event.stop(evt); page.verify('annuaire_view_fiche','annuaire_view_fiche.php?ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');}, false);
</script>
<div class="titre" id="titre_crea_art">Extrait de compte de 
<?php if (isset($profils[$CLIENT_ID_PROFIL] )){
	echo htmlentities($_SESSION['profils'][$CLIENT_ID_PROFIL]->getLib_profil());
}
?>

<?php if (isset($profils[$FOURNISSEUR_ID_PROFIL] )){
	 echo htmlentities($_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getLib_profil());
}
?> <?php echo htmlentities($contact->getNom())?>
</div>
<div >
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td style="width:5%">Exercice&nbsp;</td>
		<td width="2%"></td>
		<td style="width:30%;">
		<select name="exercice_choix" id="exercice_choix"  class="classinput_lsize" >
			<?php
			foreach ($liste_exercices as $exercice) {
				?>
				<option value="<?php echo $exercice->id_exercice;?>" <?php 
				if ($exercice->date_fin < date("Y-m-d") && $exercice->etat_exercice) {
					echo ' style="font-style:italic; color: #FF0000"';
				}
				?>><?php echo htmlentities($exercice->lib_exercice);?></option>
				<?php
			}
			?>
			<option value="">Tous</option>
		</select>
		</td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="reload_search" style="cursor:pointer" /></td>
		<td>&nbsp; </td>
		<td></td>
		<td style="text-align:right"><span id="exercice_imprimer" style="cursor:pointer">Imprimer</span></td>
	</tr>
</table>
</div>
<br />
<br />

<div style="height:50px; width:99%">

<div id="grand_livre_liste" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;">

</div>

<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</div>


<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<SCRIPT type="text/javascript">
//centrage de l'editeur
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});

Event.observe('exercice_imprimer', "click", function(evt){
	Event.stop(evt); 
	//if ($("exercice_choix").value != "") {
		window.open('compta_extrait_compte_imprimer.php?ref_contact=<?php echo $contact->getRef_contact();?>&exercice='+$("exercice_choix").value, '_blank');
	//}
});

Event.observe("exercice_choix", "change", function(evt){
	Event.stop(evt);
//	if ($("exercice_choix").value != "") {
		$("page_to_show_s").value = "1";
		page.grand_livre_result ("<?php echo $contact->getRef_contact();?>");
//	}
}, false);


Event.observe("reload_search", "click", function(evt){
	Event.stop(evt);
		page.grand_livre_result ("<?php echo $contact->getRef_contact();?>");
}, false);
	
//on charge le premier affichage
page.grand_livre_result ("<?php echo $contact->getRef_contact();?>");
//on masque le chargement
H_loading();
</SCRIPT>