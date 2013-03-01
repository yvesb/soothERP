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
	$("line_compte_choix_<?php echo $compte->numero_compte;?>").style.background = "#aaaaaa";
	}, false);
	</script>
	<script type="text/javascript">
	//GESTION DU DOUBLE CLICK POUR VALIDER LE FORM PARENT
	Event.observe("line_compte_choix_<?php echo $compte->numero_compte;?>", "dblclick",  function(evt){
		Event.stop(evt);
		if ($("retour_value").value == "") {
			$("aff_<?php echo $_REQUEST["indent"];?>").innerHTML = "...";
			$("aff_<?php echo $_REQUEST["indent"];?>").title = "Sélectionnez un n° de compte";
		} else {
			$("aff_<?php echo $_REQUEST["indent"];?>").innerHTML = $("retour_value").value;
			$("aff_<?php echo $_REQUEST["indent"];?>").title = $("retour_lib").value;
		}
		$("retour_value").value = "<?php echo $compte->numero_compte;?>";
		$("retour_lib").value = "<?php echo $compte->lib_compte;?>";
		$("retour_value").form.submit();
		close_compta_plan_mini_moteur();
	}, false);
	</script>
	</li>
	<?php
}
?>
</ul>
<SCRIPT type="text/javascript">	
//on masque le chargement
H_loading();
</SCRIPT>