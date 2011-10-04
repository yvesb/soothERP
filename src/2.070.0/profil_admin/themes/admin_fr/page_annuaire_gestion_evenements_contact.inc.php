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
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('annuaire_gestion_evenements_contact','annuaire_gestion_evenements_contact.php',"true" ,"sub_content", "Gestion des événements");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des événements</p>
<table class="minimizetable">
<tr>
<td class="contactview_corps">

	
<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Ajouter un type d'événement </td>
	</tr>
	<tr>
		<td colspan="3">

		<table>
			<tr>
				<td style="width:100%">
					<form action="annuaire_gestion_evenements_contact_add.php" method="post" id="annuaire_gestion_evenements_contact_add" name="annuaire_gestion_evenements_contact_add" target="formFrame" >
					<table>
						<tr class="smallheight">
							<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>	
						<tr>
							<td style="vertical-align:middle"><span class="labelled">Libell&eacute;:</span>
							</td>
							<td style="vertical-align:middle">
							<input name="lib_comm_event_type" id="lib_comm_event_type" type="text" value=""  class="classinput_lsize"/>
							</td>
							<td style="vertical-align:middle; text-align:center">
								<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	
	<?php 
	if ($liste_types_evenements) {
	?>
	<tr>
		<td class="titre_config" colspan="3">
		Liste des types d'événements

		</td>
	</tr>
	<?php 
	}
	foreach ($liste_types_evenements as $type_event) {
		if (!$type_event->systeme) {
		?>
		<tr>
			<td colspan="3" style="border-bottom:1px solid  #666666">
			<table>
				<tr>
					<td style="width:100%">
						<form action="annuaire_gestion_evenements_contact_mod.php" method="post" id="annuaire_gestion_evenements_contact_mod_<?php echo $type_event->id_comm_event_type; ?>" name="annuaire_gestion_evenements_contact_mod_<?php echo $type_event->id_comm_event_type; ?>" target="formFrame" >
						<table>
							<tr class="smallheight">
								<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center; vertical-align:middle">
									<input name="id_comm_event_type"  type="hidden" value="<?php echo $type_event->id_comm_event_type; ?>" />
								</td>
								<td style="vertical-align:middle">
									<input id="lib_comm_event_type_<?php echo $type_event->id_comm_event_type; ?>" name="lib_comm_event_type_<?php echo $type_event->id_comm_event_type; ?>" type="text" value="<?php echo htmlentities($type_event->lib_comm_event_type); ?>"  class="classinput_lsize"/>
								</td>
								<td style="vertical-align:middle; text-align:center;">
									<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
								</td>
							</tr>
						</table>
						</form>
					</td>
					<td style="vertical-align:middle">
					<form method="post" action="annuaire_gestion_evenements_contact_sup.php" id="annuaire_gestion_evenements_contact_sup_<?php echo $type_event->id_comm_event_type; ?>" name="annuaire_gestion_evenements_contact_sup_<?php echo $type_event->id_comm_event_type; ?>" target="formFrame">
					<input name="id_comm_event_type"  type="hidden" value="<?php echo $type_event->id_comm_event_type; ?>" />
					</form>
					<a href="#" id="link_annuaire_gestion_evenements_contact_sup_<?php echo $type_event->id_comm_event_type; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_annuaire_gestion_evenements_contact_sup_<?php echo $type_event->id_comm_event_type; ?>", "click",  function(evt){
						Event.stop(evt); 
						alerte.confirm_supprimer('evenements_contact_sup', 'annuaire_gestion_evenements_contact_sup_<?php echo $type_event->id_comm_event_type; ?>');
					}, false);
					</script>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<?php
		} else {
		?>
		<tr>
			<td colspan="3" style="border-bottom:1px solid  #666666">
			<table>
				<tr>
					<td style="width:100%">
						<table>
							<tr class="smallheight">
								<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center; vertical-align:middle">
								</td>
								<td style="vertical-align:middle"><?php echo ($type_event->lib_comm_event_type); ?>
								</td>
								<td style="vertical-align:middle; text-align:center;">
									Non modifiable.
								</td>
							</tr>
						</table>
					</td>
					<td style="vertical-align:middle">
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<?php
		}
	}
	?>
</table>	
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('annuaire_gestion_evenements_contact_add', function(element, value){formChanged();});

<?php 
foreach ($liste_types_evenements as $type_event) {
	?>
		new Form.EventObserver('annuaire_gestion_evenements_contact_mod_<?php echo $type_event->id_comm_event_type; ?>', function(element, value){formChanged();});
	<?php
}
?>

//on masque le chargement
H_loading();
</SCRIPT>
</div>