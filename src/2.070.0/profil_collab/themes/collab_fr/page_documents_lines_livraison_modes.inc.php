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



?>
<div id="lines_livraison_modes_doc">
<div id="lines_livraison_modes_doc_simple" class="menu_link_affichage">
	<a href="#" id="link_close_pop_up_lines_livraison_modes_doc" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<script type="text/javascript">
Event.observe("link_close_pop_up_lines_livraison_modes_doc", "click",  function(evt){Event.stop(evt); $("pop_up_lines_livraison_modes_doc").style.display = "none";}, false);
</script>
<div style="font-weight:bolder">Calcul des frais de transport </div>
</div>
</div><br />

<div style="height:330px; OVERFLOW-Y: auto; OVERFLOW-X: auto;">
<table style="width:100%">
	<tr class="smallheight">
		<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:95%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="roundedtable_over" style="padding-left:15px; padding-right:15px">
		<span class="labelled_text" sty>Mode de transport sélectionné:</span><br />
		<span style=" font-style:italic">
		<select name="id_livraison_mode" id="id_livraison_mode_choisi"class="classinput_xsize">
		<?php 
		foreach ($livraison_modes as $mode_liv) {
			?>
			<option value="<?php echo $mode_liv->id_livraison_mode;?>" <?php if (method_exists($document, 'getId_livraison_mode') &&$document->getId_livraison_mode() == $mode_liv->id_livraison_mode ) {?>selected="selected"<?php } ?> <?php if ($mode_liv->nd ) {?>style="color: #FF0000;"<?php } ?>><?php echo $mode_liv->article->getLib_article();?></option>
			<?php
		}
		?>
		</select>
		</span>
		</td>
		<td>
	
		</td>
	</tr>
	<tr>
		<td>
	
		</td>
		<td style="text-align:left">
		<br />
		<span style="font-weight:bolder">Adresse de livraison:</span><br />
			<br />
			<?php if (method_exists($document, 'getAdresse_livraison')) {echo nl2br($document->getAdresse_livraison());} else { echo nl2br($document->getAdresse_contact());}?>
			<br />
		</td>
		<td>
	
		</td>
	</tr>
	<tr>
		<td>
	
		</td>
		<td align="center">
<br />

		<div style="text-align:center; width:100%">
		
			<div id="add_line_livraison_mode" class="document_calculer_livraison"  >Calculer</div>
		
		</div>
			<script type="text/javascript">		
			Event.observe("add_line_livraison_mode", "click", function(evt){	
				add_new_line_livraison_mode ($("ref_doc").value, $("id_livraison_mode_choisi").options[$("id_livraison_mode_choisi").selectedIndex].value);
				$("pop_up_lines_livraison_modes_doc").style.display = "none";
			},false);
			</script>
		</td>
		<td>
	
		</td>
	</tr>
</table>
<SCRIPT type="text/javascript">
//centrage de la pop up
centrage_element("pop_up_lines_livraison_modes_doc");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_lines_livraison_modes_doc");
});
//on masque le chargement

$("pop_up_lines_livraison_modes_doc").style.display = "block";
H_loading();
</SCRIPT>
</div>

