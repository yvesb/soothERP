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


<div style="font-weight:bolder; border-bottom:1px solid #000000;">Ajout d'un compte au plan comptable de l'entreprise </div>
<div>
<div>
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:50%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>					</td>
			<td>
			<strong>Recherche par mot clef:</strong>
			</td>
			<td>
			<input type="text" name="cpe_search_lib" id="cpe_search_lib" value=""   class="classinput_lsize"/>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="search_compte_kw" style="cursor:pointer"/>
			<script type="text/javascript">
			Event.observe("search_compte_kw", "click",  function(evt){
				Event.stop(evt);
				load_result_plan_compte_recherche("kw", $("cpe_search_lib").value,  "compta_plan_entreprise_add_search_result.php?&indent=<?php echo $_REQUEST['indent'];?>");
			}, false);
			
			</script>
			</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>
			<strong>Recherche par num&eacute;ro de compte:</strong>
			</td>
			<td>
			<input type="text" name="cpe_search_num" id="cpe_search_num" value=""   class="classinput_lsize"/>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="search_compte_num" style="cursor:pointer"/>
			<script type="text/javascript">
			Event.observe("search_compte_num", "click",  function(evt){
				Event.stop(evt);
				load_result_plan_compte_recherche("num", $("cpe_search_num").value,  "compta_plan_entreprise_add_search_result.php?&indent=<?php echo $_REQUEST['indent'];?>");
			}, false);
			
			</script>
			</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Sélectionnez un résultat et validez:
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
			<div id="result_search_compte" style="height:240px; width:450px; background-color:#FFFFFF; border:1px solid #aaaaaa; overflow:auto;"></div>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>
			</td>
			<td colspan="2">
				<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
						
				<form method="post" action="compta_plan_entreprise_add.php" id="compta_plan_entreprise_add" name="compta_plan_entreprise_add" target="formFrame">
				<input type="hidden" name="retour_value" id="retour_value" value=""  />
				</form>
				<script type="text/javascript">
				Event.observe("valider", "click",  function(evt){
					Event.stop(evt);
					$("compta_plan_entreprise_add").submit();
				}, false);
				</script>
			</td>
			<td></td>
		</tr>
	</table>
</div>
</div>

<script type="text/javascript">
//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function send_if_Key_RETURN (evt, type) {

	var id_field = Event.element(evt);
	var field_value = id_field.value;
	var key = evt.which || evt.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
			Event.stop(evt);
			load_result_plan_compte_recherche(type, field_value,  "compta_plan_entreprise_add_search_result.php?&indent=<?php echo $_REQUEST['indent'];?>");
	break;   
	}
}

Event.observe('cpe_search_num', "keypress", function(evt){send_if_Key_RETURN (evt, "num");});
Event.observe('cpe_search_lib', "keypress", function(evt){send_if_Key_RETURN (evt, "kw");});
//on masque le chargement
H_loading();
</SCRIPT>
</div>