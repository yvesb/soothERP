<?php

// *************************************************************************************************************
// historiques des orpérations de caisse
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
<div class="emarge"><br />

<span style="float:right"><br />
<a  href="#" id="link_retour_caisse" style="float:right" class="common_link">retour au tableau de bord</a>
</span>
<script type="text/javascript">
Event.observe("link_retour_caisse", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_caisse','compta_gestion2_caisse.php?id_caisse=<?php echo $_REQUEST["id_caisse"];?>','true','sub_content');}, false);
</script>
<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Historique des opérations <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>
</div>
<input id="choix_id_caisse" name="choix_id_caisse"  value="<?php echo $compte_caisse->getId_compte_caisse(); ?>"  type="hidden">
<div class="emarge">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:120px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:90%">
				<div >
				<table width="75%" border="0" cellspacing="0" cellpadding="0">
				
					<tr>
						<td width="55px"></td>
						<td width="15px">&nbsp; </td>
						<td width="20%" colspan="4">		</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Type d'opération</td>
						<td>&nbsp; </td>
						<td colspan="4">
						<select name="id_reglement_mode" size="5" multiple="multiple" id="id_reglement_mode" >
							<option value="" selected="selected" >Tous</option>
							<option value="ESP"  >Espèces</option>
							<option value="CHQ"  >Chèques</option>
							<option value="CB"  >Cartes bancaires</option>
							<option value="OP"  >Autres opérations</option>
						</select>		</td>
						<td rowspan="2" style="text-align:right"><br />		</td>
						<td rowspan="3" style="text-align:center"><span id="moves_of_day" style="cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_compta_moves_of_day.gif" style="cursor:pointer;"/></span>
						<div style="height:5px"></div>
							<span id="moves_of_week" style="cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_compta_moves_of_week.gif" style="cursor:pointer;"/></span>
						<div style="height:5px"></div>
							<span id="moves_of_month" style="cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_compta_moves_of_month.gif" style="cursor:pointer;"/></span>
						<div style="height:5px"></div>
							<span id="print_mouvement_caisse" style="display:none;text-decoration:underline;cursor:pointer;text-align:center">
							Imprimer
							</span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>&nbsp; </td>
						<td colspan="4"></td>
						</tr>
					<tr>
						<td>Période&nbsp;</td>
						<td>du&nbsp; </td>
						<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
						<td>&nbsp;</td>
						<td>au&nbsp; </td>
						<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
						<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_ok.gif" id="reload_etat_caisse" style="cursor:pointer;"/></td>
						</tr>
				</table>
				</div>
				<br />
				
				<div style="height:50px; width:99%">
				
				<div id="etat_caisse_result">
				
				</div>
			</td>
		</tr>
	</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</div>
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
//masque de date

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("reload_etat_caisse", "click", function(evt){
		Event.stop(evt);
		$("page_to_show_s").value = "1";
		etat_caisse_result ();
	}, false);
	
	Event.observe("moves_of_day", "click", function(evt){
		Event.stop(evt);
		$("date_debut").value = "<?php echo date("d/m/Y");?>";
		$("date_fin").value = "<?php echo date("d/m/Y");?>";
		$("page_to_show_s").value = "1";
		etat_caisse_result ();
	}, false);
	<?php
	$semaine_derniere = mktime (0, 0, 0, date("m"), date("d")-7, date("Y"));
	$mois_dernier = mktime (0, 0, 0, date("m")-1, date("d"), date("Y"));
	?>
	Event.observe("moves_of_week", "click", function(evt){
		Event.stop(evt);
		$("date_debut").value = "<?php echo date("d/m/Y", $semaine_derniere);?>";
		$("date_fin").value = "<?php echo date("d/m/Y");?>";
		$("page_to_show_s").value = "1";
		etat_caisse_result ();
	}, false);
	Event.observe("moves_of_month", "click", function(evt){
		Event.stop(evt);
		$("date_debut").value = "<?php echo date("d/m/Y", $mois_dernier);?>";
		$("date_fin").value = "<?php echo date("d/m/Y");?>";
		$("page_to_show_s").value = "1";
		etat_caisse_result ();
	}, false);
	
	Event.observe("print_mouvement_caisse", "click", function(evt){
		Event.stop(evt);
		window.open ("compta_mouvement_caisse_result.php?recherche=1&print=1&id_compte_caisse=<?php echo $_REQUEST['id_caisse'];?>&page_to_show_s="+$("page_to_show_s").value+"&date_fin="+$("date_fin").value+"&date_debut="+$("date_debut").value, "_blank");
	}, false);
	
//on masque le chargement
H_loading();
</SCRIPT>