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
?>
<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs"	>Sélectionner un Client</td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>
	
	<div style="height: 10px"></div>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="vertical-align:top; padding-left:8px; padding-right:8px" width="650px">
				<input type="text" name="nom_s" id="nom_s" class="input_rechercher_client" style="width: 98%" value="<?php if (isset($_REQUEST["acc_ref_contact"])) { echo htmlentities($_REQUEST["acc_ref_contact"]);}?>"/>
			</td>
			<td>
				<img  id="submit_s" name="submit_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_rechercher2.gif" alt="Rechercher" title="Rechercher" />
				<script type="text/javascript">
					Event.observe('submit_s', 'click',  function(evt){
						Event.stop(evt);
						$('page_to_show_s').value=1;
						caisse_recherche_client_simple();
					}, false);

					Event.observe('nom_s', "keypress", function(evt){
						var key = evt.which || evt.keyCode; 
						switch (key) {
						case Event.KEY_RETURN:     
							Event.stop(evt);
							$('page_to_show_s').value=1;
							caisse_recherche_client_simple();
							break;   
						}
					}, false);
				</script>
				<input type="hidden" name="recherche" value="1" />
				<input type="hidden" name="orderby_s" id="orderby_s" value="nom" />
				<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
				<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
			</td>
		</tr>
		<tr style="min-height: 215px;">
			<td colspan="2" style="padding:8px;" id="resultat"></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$("nom_s").focus();
</script>
