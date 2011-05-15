<?php

// *************************************************************************************************************
// RECHERCHE DES EVENEMENTS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>
<div class="emarge">
<p class="titre">Recherche des événements</p>

<div id="recherche" class="corps_moteur">
	<div id="recherche_simple" class="menu_link_affichage">
		<form action="#" id="form_recherche_simple" name="form_recherche_simple" method="GET" onsubmit="page.evenements_recherche(); return false;">
			<table style="width:97%">
				<tr class="smallheight">
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type=hidden name="recherche" value="1" />
					<input type="hidden" name="orderby_s" id="orderby_s" value="date_event" />
					<input type="hidden" name="orderorder_s" id="orderorder_s" value="DESC" />
					<span class="labelled">Type:</span></td>
					<td>
					<select id="id_comm_event_type" name="id_comm_event_type" class="classinput_xsize">
							<option value="">Tous</option>
						<?php 
						foreach ($liste_types_evenements as $type_event) {
							?>
							<option value="<?php echo $type_event->id_comm_event_type;?>"><?php echo $type_event->lib_comm_event_type;?></option>
							<?php 
						}
						?>
					</select>
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" /></td>
					<td>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
		</form>
	</div>


</div>

<div id="resultat_evenements"></div>

</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>