<?php
// *************************************************************************************************************
// CREATION D'UN NOUVEAU DOC À PARTIR DES LIGNES D'ARTICLES D'UN ANCIEN
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$modeles_lignes = charge_docs_infos_lines ($id_type_doc);


?>

<div id="pop_up_lines_info_modeles_doc" class="lines_info_modeles_doc">
<div id="lines_info_modeles_doc">
<div id="lines_info_modeles_doc_simple" class="menu_link_affichage">
	<a href="#" id="link_close_pop_up_lines_info_modeles_doc" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<script type="text/javascript">
Event.observe("link_close_pop_up_lines_info_modeles_doc", "click",  function(evt){Event.stop(evt); $("pop_up_lines_info_modeles_doc").style.display = "none";}, false);
</script>
<div style="font-weight:bolder">Lignes d'information prédéfinies</div>
</div>
</div><br />

<div style="height:330px; OVERFLOW-Y: auto; OVERFLOW-X: auto;">
<?php foreach ($modeles_lignes as $modele_infos) { ?>
<table style="width:100%" class="roundedtable">
	<tr class="smallheight">
		<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:80%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<span class="labelled_text" sty><?php echo $modele_infos->lib_line;?></span><br />
		<span style=" font-style:italic"><?php echo nl2br($modele_infos->desc_line_interne);?></span>
		</td>
		<td>
		<div style="position:relative" >
			<div class="common_link" id="view_line_info_modele_<?php echo $modele_infos->id_doc_info_line;?>" >Voir</div>
			<div style="position:absolute; top:1.1em; right:0px; width:450px; display:none; z-index:450 " class="roundedtable_over" id="view_more_<?php echo $modele_infos->id_doc_info_line;?>">

				<span class="labelled_text" ><?php echo $modele_infos->lib_line;?></span><br />
				<span style=" font-style:italic"><?php echo nl2br($modele_infos->desc_line);?></span>
			</div>
		</div>
			<script type="text/javascript">
			Event.observe("view_line_info_modele_<?php echo $modele_infos->id_doc_info_line;?>", "mouseover", function(evt){
				$("view_more_<?php echo $modele_infos->id_doc_info_line;?>").style.display = "";
			},false);
			Event.observe("view_line_info_modele_<?php echo $modele_infos->id_doc_info_line;?>", "mouseout", function(evt){
				$("view_more_<?php echo $modele_infos->id_doc_info_line;?>").style.display = "none";
			},false);
			</script>
		</td>
		<td style="width:20px">
			<span class="common_link" id="add_line_info_modele_<?php echo $modele_infos->id_doc_info_line;?>" >Insérer</span>
			<script type="text/javascript">
			Event.observe("add_line_info_modele_<?php echo $modele_infos->id_doc_info_line;?>", "click", function(evt){
				add_new_line_info_modele ($("ref_doc").value, "information", '<?php echo $modele_infos->id_doc_info_line;?>');
				$("pop_up_lines_info_modeles_doc").style.display = "none";
			},false);
			</script>
		</td>
	</tr>
</table>
<?php } ?>
<table style="width:100%" class="roundedtable_over">
	<tr class="smallheight">
		<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:80%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<span class="labelled_text" sty>Ligne vierge</span><br />
		<span style=" font-style:italic">Ligne d'informations vierge</span>
		</td>
		<td>

		</td>
		<td style="width:20px">
			<span class="common_link" id="add_line_info_modele" >Insérer</span>
			<script type="text/javascript">
			Event.observe("add_line_info_modele", "click", function(evt){
				add_new_line_info_modele ($("ref_doc").value, "information", '');
				$("pop_up_lines_info_modeles_doc").style.display = "none";
			},false);
			</script>
		</td>
	</tr>
</table>

</div>


<SCRIPT type="text/javascript">

//centrage de la pop up
centrage_element("pop_up_lines_info_modeles_doc");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_lines_info_modeles_doc");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>