<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
   

// Variables nécessaires à l'affichage
$page_variables = array ("page_source", "page_cible", "id_liste_agenda", "agendasAvecDroits");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<table width="99%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width: 5%"></td>
		<td style="width:20%"></td>
		<td style="width: 5%"></td>
		<td style="width:20%"></td>
		<td style="width: 5%"></td>
		<td style="width:20%"></td>
		<td style="width: 5%"></td>
		<td style="width:20%"></td>
	</tr>
	<?php 
	$nb_agendas = count($agendasAvecDroits);
	reset($agendasAvecDroits);

	//fait des lignes de 4 agenda.
	for($i=0; $i <floor($nb_agendas/4); $i++){?>
	<tr height="30px">
		<?php for($j = 1; $j<=4; $j++){
			$index = key($agendasAvecDroits); ?> 
		<td align="right" style="vertical-align:middle; padding-right: 3px;">
			<input type="checkbox" id="checkbox<?php echo $index;?>" name="checkbox<?php echo $index;?>" <?php if(!is_null($agendasAvecDroits[$index]["affiche"])){echo 'checked="checked"';}?> />
			<script type="text/javascript">
				Event.observe("checkbox<?php echo $index;?>", "click",  function(evt){
					Event.stop(evt);
					if(!$("checkbox<?php echo $index;?>").checked){
						majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", null, "page_agenda_selectionner_agendas_result_fct_retour('checkbox<?php echo $index;?>',false && maj,'<?php echo $index;?>');");
					}else{
						majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 1, 	 "page_agenda_selectionner_agendas_result_fct_retour('checkbox<?php echo $index;?>',true && maj,'<?php echo $index;?>');");
					}
				},false);
			</script>
		</td>
		<td style="vertical-align:middle;">
			<div style="height:20px; width:100%; -moz-border-radius:3px; border: 1px solid; text-align:left;" >
				&nbsp;<?php echo $index; //$agendasAvecDroits[$index]["libAgenda"];?>
			</div>
		</td>
		<?php 
			next($agendasAvecDroits);
		} ?>
	</tr>
	<?php
	}
	$nb_restant = $nb_agendas %4; //Si >0 alors, je fais une dernière ligne incomplete
	if ($nb_restant >0){ ?>
	<tr height="30px">
		<?php // des cellules avec un modele
			for($k=0; $k <$nb_restant; $k++){
				$index = key($agendasAvecDroits); ?>
		<td align="right" style="vertical-align:middle; padding-right: 3px;">
			<input type="checkbox" id="checkbox<?php echo $index;?>" name="checkbox<?php echo $index;?>" <?php if(!is_null($agendasAvecDroits[$index]["affiche"])){echo 'checked="checked"';}?> />
			<script type="text/javascript">
				Event.observe("checkbox<?php echo $index;?>", "click",  function(evt){
					Event.stop(evt);
					if(!$("checkbox<?php echo $index;?>").checked){
						majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", null, "page_agenda_selectionner_agendas_result_fct_retour('checkbox<?php echo $index;?>',false && maj,'<?php echo $index;?>');");
					}else{
						majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 1, 	 "page_agenda_selectionner_agendas_result_fct_retour('checkbox<?php echo $index;?>',true && maj,'<?php echo $index;?>');");
					}
				},false);
			</script>
		</td>
		<td style="vertical-align:middle;">
			<div style="height:20px; width:100%; -moz-border-radius:3px; border: 1px solid; text-align:left;" >
				&nbsp;<?php echo $index; //$agendasAvecDroits[$index]["libAgenda"];?>
			</div>
		</td>
		<?php
			next($agendasAvecDroits);
 			} // des cellules vides
			for($l=0; $l <4-$nb_restant; $l++){	?>
		<td></td>
		<td style="text-align:center;">
			&nbsp;	
		</td>
		<?php } ?>
	</tr>
	<?php } ?>
	
	<tr>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
	</tr>
</table>

<script type="text/javascript">
	//on masque le chargement
	H_loading();
</script>