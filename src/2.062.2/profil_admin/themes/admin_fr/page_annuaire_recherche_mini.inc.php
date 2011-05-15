<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Formulaire de recherche
?>

<script type="text/javascript" language="javascript">
</script>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_mini_moteur_iframe" class="mini_moteur_iframe"></iframe>
<div id="pop_up_mini_moteur" class="mini_moteur">
<div id="recherche_contact" class="corps_mini_moteur">
<div id="recherche_contact_simple" class="menu_link_affichage">
	<a href="#" id="close_mini_recherche_annu" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<div style="font-weight:bolder">Recherche d'un contact </div>
		<form action="#" id="form_recherche_mini" name="form_recherche_mini" method="GET">
			<table style="width:97%">
				<tr class="smallheight">
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:50%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type=hidden name="recherche" value="1" />
					<input type="hidden" name="orderby_m" id="orderby_m" value="nom" />
					<input type="hidden" name="orderorder_m" id="orderorder_m" value="ASC" />
					<input type="hidden" name="fonction_retour_m" id="fonction_retour_m" value="" />
					<input type="hidden" name="param_retour_m" id="param_retour_m" value="" />
					<span class="labelled">Nom&nbsp;ou&nbsp;D&eacute;nomination:</span></td>
					<td><input type="text" name="nom_m" id="nom_m" value=""   class="classinput_xsize"/></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><span class="labelled">Profil : </span></td>
					<td><select name="id_profil_m" id="id_profil_m"  class="classinput_xsize">
						<option value="0"> -- Tous </option>
						
						<?php
						for ($i=0; $i<count($profils_mini); $i++) {
							?>
							<option value="<?php echo $profils_mini[$i]->getId_profil()?>" ><?php echo $profils_mini[$i]->getLib_profil()?></option>
							<?php 
						}
						?>
					</select>
					</td>
					<td>&nbsp;</td>
					<td style="text-align:right"></td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_m" type="image" onclick="$('page_to_show_m').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" /></td>
					<td><!--<input type="image" name="res_s" id="res_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>-->	</td>
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
			<input type="hidden" name="page_to_show_m" id="page_to_show_m" value="1"/>
		</form>
	</div>

</div>

<div id="resultat_contact_mini" style="overflow:auto; height:266px"></div>

<script type="text/javascript">
Event.observe("close_mini_recherche_annu", "click",  function(evt){Event.stop(evt);close_mini_moteur_contacts();}, false);

//lance la recherche
Event.observe('form_recherche_mini', "submit", function(evt){page.annuaire_recherche_mini();  
	Event.stop(evt);});
	
//on masque le chargement
H_loading();
</SCRIPT>
</div>