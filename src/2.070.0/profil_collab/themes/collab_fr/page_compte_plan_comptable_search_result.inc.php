<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<ul>
<?php 
foreach ($result as $compte) {
	?>
	<li style="display:block; line-height:22px; cursor:pointer" class="colorise1"  id="line_compte_choix_<?php echo $compte->numero_compte;?>">
	<div style="display:inline">
	<table>
		<tr>
			<td style="width:70px; ">
			<div  style="width:70px; display:block "><?php echo $compte->numero_compte;?></div>
			</td>
			<td>
			<span ><?php echo str_replace(" ", "&nbsp;", $compte->lib_compte);?>
			</span>
			</td>
		</tr>
	</table>
	</div>
	<script type="text/javascript">
	Event.observe("line_compte_choix_<?php echo $compte->numero_compte;?>", "click",  function(evt){
	Event.stop(evt);
	if ($("retour_value").value != "<?php echo $compte->numero_compte;?>" && $("retour_value").value != "") {
		if ($("line_compte_choix_"+$("retour_value").value)) {
			$("line_compte_choix_"+$("retour_value").value).style.background = "#FFFFFF";
		}
	}
	
	$("retour_value").value = "<?php echo $compte->numero_compte;?>";
	$("retour_lib").value = "<?php echo $compte->lib_compte;?>";
	$("line_compte_choix_<?php echo $compte->numero_compte;?>").style.background = "#aaaaaa";
	}, false);
	</script>
	<script type="text/javascript">
	//GESTION DU DOUBLE CLICK POUR VALIDER LE FORM PARENT
	Event.observe("line_compte_choix_<?php echo $compte->numero_compte;?>", "dblclick",  function(evt){
		Event.stop(evt);
		$("retour_value").value = "<?php echo $compte->numero_compte;?>";
		$("retour_lib").value = "<?php echo $compte->lib_compte;?>";
		$("<?php echo $_REQUEST['retour_value_id'];?>").innerHTML = $("retour_value").value;
		$("<?php echo $_REQUEST['retour_lib_id'];?>").innerHTML = $("retour_lib").value;
		$("retour_value").form.submit();
		close_compta_plan_mini_moteur();
		}, false);
	</script>
	</li>
	<?php
}
?>
	<li style="display:block; line-height:22px; cursor:pointer" class="colorise1"  id="line_compte_choix_">
	<div style="display:inline">
	<table>
		<tr>
			<td style="width:70px; ">
			<div  style="width:70px; display:block ">Néant</div>
			</td>
			<td>
			<span >
			</span>
			</td>
		</tr>
	</table>
	</div>
	<script type="text/javascript">
	Event.observe("line_compte_choix_", "click",  function(evt){
	Event.stop(evt);
	if ($("retour_value").value != "") {
		if ($("line_compte_choix_"+$("retour_value").value)) {
			$("line_compte_choix_"+$("retour_value").value).style.background = "#FFFFFF";
		}
	}
	
	$("retour_value").value = "";
	$("retour_lib").value = "";
	$("line_compte_choix_").style.background = "#aaaaaa";
	}, false);
	</script>
	</li>
</ul>
<SCRIPT type="text/javascript">	
//on masque le chargement
H_loading();
</SCRIPT>