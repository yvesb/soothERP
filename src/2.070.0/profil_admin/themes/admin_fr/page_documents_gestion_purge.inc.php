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
tableau_smenu[0] = Array("smenu_maintenance", "smenu_maintenance.php" ,"true" ,"sub_content", "Maintenance");
tableau_smenu[1] = Array('gestion_document_purge','documents_gestion_purge.php','true','sub_content', "Délestage des documents annulés. ");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Délestage des documents annulés.  </p>
<div style="height:50px">

<table class="minimizetable">
<tr>
<td class="contactview_corps">


<br />
<div style="text-align:center">
<?php if (isset($nb_docs_purged)) {?>
<?php echo $nb_docs_purged ;?> documents annulés ayant dépassé leur durée de conservation ont été effacés.<br />
<?php } ?>
</div>
<br />

	<?php 
	foreach ($documents_type as $document_type) {
	?>
	<div class="caract_table" id="document_type_<?php echo $document_type->id_type_doc; ?>">

					<table>
						<tr class="smallheight">
							<td style="width:75%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<tr>
							<td>Les <?php echo htmlentities($document_type->lib_type_doc); ?> annulé(e)s dont la date est antérieure au <?php echo date("d-m-Y" , mktime(0, 0, 0, date("m"), date("d")-(${"DUREE_AVANT_PURGE_ANNULE_".$document_type->code_doc}), date("Y")));?> vont être définitivement supprimé(e)s.
							</td>
							<td style="text-align:center">
							
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" id="purge_type_<?php echo $document_type->id_type_doc; ?>" style="cursor:pointer" />
								<script type="text/javascript">
								Event.observe("purge_type_<?php echo $document_type->id_type_doc; ?>", "click",  function(evt){Event.stop(evt);page.verify('gestion_document_purge','documents_gestion_purge.php?id_type_doc=<?php echo $document_type->id_type_doc; ?>&purge=1','true','sub_content');}, false);
								</script>
							</td>
						</tr>
					</table>
	</div>
	<br />
	<?php
	
	}
	?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" id="purge_type" style="cursor:pointer" /> le délestage de tout les types de documents.
								<script type="text/javascript">
								Event.observe("purge_type", "click",  function(evt){Event.stop(evt);page.verify('gestion_document_purge','documents_gestion_purge.php?purge=1','true','sub_content');}, false);
								</script>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>