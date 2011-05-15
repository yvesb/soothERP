<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

$lib_compte_error_str = "";
$num_compte_error_str = "";
$num_compte_img = "images/point_vert.gif";
$lib_compte_img = "images/point_vert.gif";

if(count($check_erreurs)>0){
	$div_error_block = "block";
	// Num errors
	if ( ! empty ($check_erreurs['num'])) {
		foreach($check_erreurs['num'] as $erreur){
			$num_compte_error_str .= $erreur.'<br/>';
		}
		$num_compte_img = "images/point_rouge.gif";
	}
	//Lib errors
	if ( ! empty ($check_erreurs['lib']) ) {
		foreach($check_erreurs['lib'] as $erreur){
			$lib_compte_error_str .= $erreur.'<br/>';
		}
		$lib_compte_img = "images/point_rouge.gif";
	}
	$span_valider = "block";
} else {
	$div_error_block = "none";
	$span_valider = "block";
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div id="titre_add_compte_comptable" style="font-weight:bolder; border-bottom:1px solid #000000;">Ajout d'un numéro de compte </div>
<div id="form_add_compte_comptable" >
	<form id="ajouter_compte_comptable" name="ajouter_compte_comptable" action="compte_plan_comptable_add.php" target="formFrame">
	<table style="width:99%">
		<tr class="smallheight">
			<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td>
				Numéro de compte:
			</td>
			<td>&nbsp;</td>
			<td>
				Libélle du compte:
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<input type="text" id="numero_compte" name="numero_compte" value="<?php echo $form['numero_compte'];?>" />
				<script type="text/javascript">
				Event.observe('numero_compte', 'blur',  function(evt){
					Event.stop(evt);
                                        $('lib_compte').focus();
					//valider_compta_plan_add_mini_moteur (false);
				}, false);
				</script>
			</td>
			<td>
				<img alt="Numéro de compte valide" name="img_numero_compte_etat" id="img_numero_compte_etat" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme().$num_compte_img?>" align="left" />
			</td>
			<td>
				<input type="text" id="lib_compte" name="lib_compte" value="<?php echo $form['lib_compte'];?>" />
				<script type="text/javascript">
				Event.observe('lib_compte', 'blur',  function(evt){
					Event.stop(evt);
					//valider_compta_plan_add_mini_moteur (false);
					$('numero_compte').focus();
				}, false);
				</script>
			</td>
			<td>
				<img alt="Numéro de compte " name="img_lib_compte_etat" id="img_lib_compte_etat" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme().$lib_compte_img?>" align="left" />
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<input type="hidden" id="favori" name="favori" value="0" />
				<input type="hidden" id="cible_id_num" name="cible_id_num" value="<?php echo $_REQUEST['cible_id_num'];?>" />
				<input type="hidden" id="cible_id_lib" name="cible_id_lib" value="<?php echo $_REQUEST['cible_id_lib'];?>" />	
				<input type="hidden" id="favori" name="favori" value="0" />	
				<span id="span_valider" style="display:<?php echo $span_valider;?>;">
					<img alt="Valider" name="add_compte_comptable" id="add_compte_comptable" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" align="left" />
					<script type="text/javascript">
					Event.observe('add_compte_comptable', 'click',  function(evt){
						Event.stop(evt);
						valider_compta_plan_add_mini_moteur (false);
					}, false);
					</script>
				</span>
			</td>
		</tr>
	</table>
	</form>
</div>

<div id="error_add_compte_comptable" style="display:<?php echo $div_error_block;?>;" >
<div id="titre_error_add_compte_comptable" style="font-weight:bolder; border-bottom:1px solid #000000;">Erreur(s):</div>
	<table style="width:99%">
		<tr>
			<td style="width:45%">
			<span id="err_num_compte" class="alerteform_xsize">
				<?php echo $num_compte_error_str;?>
			</span>
			
			</td>
			<td style="width:5%">&nbsp;</td>
			<td style="width:45%">
			<span id="err_lib_compte" class="alerteform_xsize">
				<?php echo $lib_compte_error_str;?>
			</span>
			</td>
			<td style="width:5%">&nbsp;</td>
		</tr>
	</table>
</div>