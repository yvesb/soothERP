<?php

// *************************************************************************************************************
// RESUME DES STOCK par documents
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

<table style="width:100%">
<tr>
	<td>
		<div class="titre" id="titre_crea_art">Historique par documents </div>
	</td>
	<td style="width:20%; vertical-align: bottom;">
		<?php 
			if(isset($stock)){
				?>
				<p class="retour_tdb" id="retour_tdb" class="grey_caisse">Retour au tableau de bord</p>
				<?php
			}
		?>
	</td>
</tr>
</table>

<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:18%">&nbsp;</td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:12%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%; text-align: right"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Type de document:</span>	</td>
			<td>
			<select name="id_type_doc_s" id="id_type_doc_s" class="classinput_lsize" style="width:100%"/>
			<option value="">Tous</option>
				<?php 
				foreach ($types_liste as $type_liste) {
					?>
					<option value="<?php echo $type_liste->id_type_doc;?>" <?php if (isset($_REQUEST["id_type_doc"]) && $type_liste->id_type_doc == $_REQUEST["id_type_doc"]) { echo ' selected="selected"'; }?> ><?php echo htmlentities($type_liste->lib_type_doc);?></option>
					<?php 
				}
				?>
				</select>	</td>
			<td ><div class="labelled_text" style=" text-align:right">Lieux de stockage:</div>
			</td>
			<td >
			<select name="id_stock_l"  class="classinput_xsize" id="id_stock_l">
				<?php 
				if (count($stocks_liste) > 1) {
				?><option value=""  <?php if (!isset($_REQUEST["id_stock"])) {?>selected="selected"<?php } ?>>Tous</option><?php
				}
					foreach ($stocks_liste as $stock_liste) {
					?>
				<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if (isset($_REQUEST["id_stock"]) && $_REQUEST["id_stock"] == $stock_liste->getId_stock ()) {?>selected="selected"<?php } ?>><?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
				<?php }
					?>
			</select>			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text" >&Eacute;tat du document:</span></td>
			<td><select name="id_etat_doc_s" id="id_etat_doc_s" class="classinput_lsize" style="width:100%">
				<option value="">Tous</option>
				
				<option value="<?php 
				if (isset($_REQUEST["id_type_doc"])) {
				echo implode(",", get_etat_is_open(1, $_REQUEST["id_type_doc"]));
				} else {
				echo implode(",", get_etat_is_open(1));
				}
				
				?>" <?php if (isset($_REQUEST["is_open"]) && $_REQUEST["is_open"] == "1") { ?>selected="selected"<?php }?>>Documents en cours</option>
				
				<option value="<?php 
				if (isset($_REQUEST["id_type_doc"])) {
				echo implode(",", get_etat_is_open(0, $_REQUEST["id_type_doc"]));
				} else {
				echo implode(",", get_etat_is_open(0));
				}
				
				?>" 
				<?php if (isset($_REQUEST["is_open"]) && $_REQUEST["is_open"] == "0") { ?>selected="selected"<?php }?>>Documents en archive</option>
				
				</select>
			</td>
			<td class="labelled_text" style=" text-align:right" >du&nbsp; :</td>
			<td >
				
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
					<td>&nbsp;</td>
					<td class="labelled_text" style="width:23px" >au&nbsp; </td>
					<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
					<td>
					<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
					</td>
				</tr>
			</table>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:right"><span style="text-align:right">
				<input name="form_recherche_s" id="form_recherche_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			</span></td>
			<td style="padding-left:35px">&nbsp;</td>
			<td style="text-align:right">
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5"></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>



</div>
<br />
<br />

<div style="height:50px; width:99%">

<div id="stock_docs_liste" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;">

</div>

</div>
<SCRIPT type="text/javascript">

function setheight_stock_docs(){
set_tomax_height("stock_docs_liste" , -32);
}
Event.observe(window, "resize", setheight_stock_docs, false);
setheight_stock_docs();



Event.observe('form_recherche_s', "click", function(evt){
	page.stock_docs_result ("<?php echo $_SESSION['magasin']->getId_stock();?>"); 
	Event.stop(evt);
});

Event.observe("retour_tdb", "click",  function(evt){
	Event.stop(evt);
	page.verify('stocks_gestion2','stocks_gestion2.php?id_stock=<?php echo $stock->getId_stock(); ?>','true','sub_content');
}, false);


//masque de date

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	
//on charge le premier affichage
page.stock_docs_result ("<?php if (isset($_REQUEST["id_stock"])) { echo $_REQUEST["id_stock"];} else {echo $_SESSION['magasin']->getId_stock();}?>");
//on masque le chargement
H_loading();
</SCRIPT>