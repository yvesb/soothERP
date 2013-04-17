<?php

// *************************************************************************************************************
// RECHERCHE D'UN COURRIER
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

<script type="text/javascript" language="javascript">
array_menu_r_contact	=	new Array();
array_menu_r_contact[0] 	=	new Array('recherche_simple', 'menu_1');
array_menu_r_contact[1] 	=	new Array('recherche_avancee', 'menu_2');
</script>
<div class="emarge">
	<p class="titre">Recherche d'un courrier</p>
	
	<div>
		<ul id="menu_recherche" class="menu">
		<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
		</ul>
	</div>
	<div id="recherche" class="corps_moteur">
		<div id="recherche_simple" class="menu_link_affichage">
			<form action="#" id="form_recherche_simple" name="form_recherche_simple" method="POST" >
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
						<td><input type=hidden name="recherche" value="1" />
						<input type="hidden" name="orderby_s" id="orderby_s" value="nom" />
						<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
						<span class="labelled">Etat du courrier :</span></td>
						<td>
						<select id="etat_s" name="etat_s">
						<option value="">-- TOUS</option>
						<?php foreach($etats_courrier as $etat){?>
						<option value="<?php echo $etat->id_etat_courrier;?>"><?php echo $etat->lib_etat_courrier;?></option>
						<?php } ?>
						</select>
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><span class="labelled">Contact : </span></td>
						<td><input type="text" name="contact_s" id="contact_s"
							value="<?php if (isset($_REQUEST["acc_contact_courrier"])) { echo htmlentities($_REQUEST["acc_contact_courrier"]);}?>" 
							class="classinput_xsize"/>
						</td>
						<td>&nbsp;</td>
						<td style="text-align:right"></td>
					</tr>
					<tr>
						<td></td>
						<td><span class="labelled">Date : </span></td>
						<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
						<td></td>
						<td>au&nbsp; </td>
						<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
						<td style="text-align:right"></td>
					</tr>
					<tr>
						<td></td>
						<td>&nbsp;</td>
						<td><input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" /></td>
						<td>&nbsp;</td>
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

<div id="resultat"></div>

</div>
<SCRIPT type="text/javascript">
Event.observe("form_recherche_simple", "submit",  function(evt){
	Event.stop(evt);
	page.courrier_recherche_simple ();
}, false);


Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_contact );}, false);

$("etat_s").focus();


//on masque le chargement
H_loading();
</SCRIPT>