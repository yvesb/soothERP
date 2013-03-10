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


<div style="font-weight:bolder; border-bottom:1px solid #000000;">Modification du numéro de compte </div>
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
			<td>	</td>
			<td>
			<strong>Recherche par mot clef:</strong>			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="search_compte_kw" style="cursor:pointer; float:right"/>
			<input type="text" name="cpe_search_lib" id="cpe_search_lib" value=""   class="classinput_lsize"/>
			<script type="text/javascript">
			Event.observe("search_compte_kw", "click",  function(evt){
				Event.stop(evt);
				load_result_plan_compte_recherche("kw", $("cpe_search_lib").value,  "compte_plan_comptable_search_result.php?indent=<?php echo $search['indent'];?>");
			}, false);
			
			</script>	</td>
			<td>	</td>
		</tr>
		<tr>
			<td></td>
			<td>			</td>
			<td>&nbsp;	</td>
			<td></td>
		</tr>
		<tr>
			<td>					</td>
			<td>
			<strong>Recherche par num&eacute;ro de compte:</strong>			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="search_compte_num" style="cursor:pointer; float:right"/>
			<input type="text" name="cpe_search_num" id="cpe_search_num" value="<?php if(isset($_REQUEST["num_compte"])) {echo $_REQUEST["num_compte"];}?>"   class="classinput_lsize"/>
			<script type="text/javascript">
			Event.observe("search_compte_num", "click",  function(evt){
				Event.stop(evt);
				load_result_plan_compte_recherche("num", $("cpe_search_num").value,  "compte_plan_comptable_search_result.php?retour_value_id=<?php echo $search['retour_value_id'];?>&retour_lib_id=<?php echo $search['retour_lib_id'];?>&indent=<?php echo $search['indent'];?>");
			}, false);
			
			</script>	</td>
			<td>					</td>
		</tr>
		<tr>
			<td>					</td>
			<td>&nbsp;			</td>
			<td>	</td>
			<td>					</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" id="search_compte_fav" style="cursor:pointer; float:right"/>
			<strong>Recherche à partir de la liste de Favoris</strong>
			<script type="text/javascript">
			Event.observe("search_compte_fav", "click",  function(evt){
				Event.stop(evt);
				load_result_plan_compte_recherche("fav", "1",  "compte_plan_comptable_search_result.php?retour_value_id=<?php echo $search['retour_value_id'];?>&retour_lib_id=<?php echo $search['retour_lib_id'];?>&indent=<?php echo $search['indent'];?>");
			}, false);
			
			</script></td>
			<td>					</td>
		</tr>
		<tr>
			<td>					</td>
			<td>&nbsp;			</td>
			<td>	</td>
			<td>					</td>
		</tr>
		<tr>
			<td>					</td>
			<td>Sélectionnez un résultat et validez:			</td>
			<td>					</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
			<div id="result_search_compte" style="height:190px; width:450px; background-color:#FFFFFF; border:1px solid #aaaaaa; overflow:auto;"></div>			</td>
			<td></td>
		</tr>
		<tr>
			<td>			</td>
			<td colspan="2">
				<?php //@FIXME _blank ?>		
				<form method="post" action="compte_plan_comptable_mod.php" id="compte_plan_comptable_mod" name="compte_plan_comptable_mod" target="formFrame">
				<input type="hidden" name="retour_value" id="retour_value" value=""  />
				<input type="hidden" name="retour_lib" id="retour_lib" value=""  />
				<?php if (isset($_REQUEST["ref_art_categ"])) { ?>
				<input type="hidden" name="ref_art_categ" value="<?php echo $_REQUEST["ref_art_categ"];?>"  />
				<?php } ?>
				<?php if (isset($_REQUEST["type"])) { ?>
				<input type="hidden" id="type" name="type" value="<?php echo $_REQUEST["type"];?>"  />
				<?php } ?>
				<?php if (isset($_REQUEST["cible_id"])) { ?>
				<input type="hidden" id="type" name="cible_id" value="<?php echo $_REQUEST["cible_id"];?>"  />
				<?php } ?>
				<?php if (isset($_REQUEST["cible"])) { ?>
				<input type="hidden" id="type" name="cible" value="<?php echo $_REQUEST["cible"];?>"  />
				<?php } ?>
				<?php if (isset($_REQUEST["indent"])) { ?>
				<input type="hidden" id="indent" name="indent" value="<?php echo $_REQUEST["indent"];?>"  />
				<?php } ?>
				</form>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<img alt="Valider" name="valider" id="valider" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" align="left" style="cursor:pointer;" />
				<script type="text/javascript">
				Event.observe("valider", "click",  function(evt){
					Event.stop(evt);
					<?php if (isset($_REQUEST["retour_value_id"])) { ?>
					if ($("retour_value").value == "") {
						$("<?php echo $_REQUEST["retour_value_id"];?>").innerHTML = "<?php if(isset($_REQUEST["num_compte"])) {echo $_REQUEST["num_compte"];} else {echo "...";}?>";
						$("<?php echo $_REQUEST["retour_lib_id"];?>").innerHTML = "Sélectionnez un n° de compte";
					} else {
						$("<?php echo $_REQUEST["retour_value_id"];?>").innerHTML = $("retour_value").value;
						$("<?php echo $_REQUEST["retour_lib_id"];?>").innerHTML = $("retour_lib").value;
					}
					<?php } ?>
					$("compte_plan_comptable_mod").submit();
					close_compta_plan_mini_moteur();
				}, false);
				</script>
			</td>
			<td>
				<img alt="Ajouter" name="ajouter" id="ajouter" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" align="right" style="cursor:pointer;" />
				<script type="text/javascript">
				Event.observe("ajouter", "click",  function(evt){
					Event.stop(evt);
					ouvre_compta_plan_add_mini_moteur(); 
					charger_compta_plan_add_mini_moteur ('<?php echo $_REQUEST["retour_value_id"];?>"','<?php echo $_REQUEST["retour_lib_id"];?>'); 
				}, false);
				</script>
			</td>
			<td>&nbsp;</td>
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
			load_result_plan_compte_recherche(type, field_value,  "compte_plan_comptable_search_result.php?indent=retour_value_id=<?php echo $search['retour_value_id'];?>&retour_lib_id=<?php echo $search['retour_lib_id'];?>&<?php echo $search['indent'];?>");
	break;   
	}
}

<?php if(isset($_REQUEST["num_compte"])) {?>
load_result_plan_compte_recherche("num", $("cpe_search_num").value,  "compte_plan_comptable_search_result.php?retour_value_id=<?php echo $search['retour_value_id'];?>&retour_lib_id=<?php echo $search['retour_lib_id'];?>&indent=<?php echo $search['indent'];?>");
<?php }?>
Event.observe('cpe_search_num', "keypress", function(evt){send_if_Key_RETURN (evt, "num");});
Event.observe('cpe_search_lib', "keypress", function(evt){send_if_Key_RETURN (evt, "kw");});
//on masque le chargement
H_loading();
</SCRIPT>
</div>