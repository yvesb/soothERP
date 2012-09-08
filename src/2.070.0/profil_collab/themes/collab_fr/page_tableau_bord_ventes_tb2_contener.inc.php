<?php
// *************************************************************************************************************
// AFFICHAGE DU TABLEAU DE BORD DES VENTES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<div class="emarge" >
<div style=" float:right; color:#97bf0d">
<span class="green_link_stat_actif" id="tb2_det_J">Jour</span> | <span class="green_link_stat" id="tb2_det_S">Semaine</span> | <span class="green_link_stat" id="tb2_det_M">Mois</span> | <span class="green_link_stat" id="tb2_det_A">Année</span>
</div> 
<div ><span class="titre_ter_stat" >Période analysée </span> 
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_date_prev.gif" style="vertical-align:middle; cursor:pointer" id="goto_prev" />
	 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_date_next.gif" style="vertical-align:middle; cursor:pointer" id="goto_next"  />	<span id="periode_select" style="font-weight:bolder"></span>
</div>
<script type="text/javascript">
Event.observe("goto_prev", "click",  function(evt){
	recalcul_date_search ($("date_debut").value, $("date_fin").value, $("type_progress").value, -1);
	tb2_aff_resultat_1 ();
}, false);
Event.observe("goto_next", "click",  function(evt){
	recalcul_date_search ($("date_debut").value, $("date_fin").value, $("type_progress").value, 1);
	tb2_aff_resultat_1 ();
}, false);
	

	$("periode_select").innerHTML = "Jour";
Event.observe("tb2_det_J", "click",  function(evt){
	Event.stop(evt); 
	$("tb2_det_J").className="green_link_stat_actif";
	$("type_progress").value = "J";
	$("date_debut").value = "<?php echo date("d-m-Y");?>";
	$("date_fin").value = "<?php echo date("d-m-Y");?>";
	$("periode_select").innerHTML = "Jour";
	$("tb2_det_S").className="green_link_stat";
	$("tb2_det_M").className="green_link_stat";
	$("tb2_det_A").className="green_link_stat";
	tb2_aff_resultat_1 ();
}, false);

Event.observe("tb2_det_S", "click",  function(evt){
	Event.stop(evt); 
	$("type_progress").value = "S";
	<?php 
	$lasemaine = get_semaine(date("W"), date("Y"));
	?>
	$("date_debut").value = "<?php echo date_Us_to_Fr(date($lasemaine[0]));?>";
	$("date_fin").value = "<?php echo date_Us_to_Fr(date($lasemaine[6]));?>";
	$("periode_select").innerHTML = "Semaine";
	$("tb2_det_J").className="green_link_stat";
	$("tb2_det_S").className="green_link_stat_actif";
	$("tb2_det_M").className="green_link_stat";
	$("tb2_det_A").className="green_link_stat";
	tb2_aff_resultat_1 ();
}, false);

Event.observe("tb2_det_M", "click",  function(evt){
	Event.stop(evt); 
	$("type_progress").value = "M";
	$("date_debut").value = "<?php echo date("d-m-Y", mktime(0,0,0, date("m"), 1, date("Y")) );?>";
	$("date_fin").value = "<?php echo date("d-m-Y", mktime(0,0,0, date("m")+1, 0, date("Y")) );?>";
	$("periode_select").innerHTML = "Mois";
	$("tb2_det_J").className="green_link_stat";
	$("tb2_det_S").className="green_link_stat";
	$("tb2_det_M").className="green_link_stat_actif";
	$("tb2_det_A").className="green_link_stat";
	tb2_aff_resultat_1 ();
}, false);

Event.observe("tb2_det_A", "click",  function(evt){
	Event.stop(evt); 
	$("type_progress").value = "A";
	$("date_debut").value = "<?php echo date("d-m-Y", mktime(0,0,0, 1, 1, date("Y")) );?>";
	$("date_fin").value = "<?php echo date("d-m-Y", mktime(0,0,0, 12, 31, date("Y")) );?>";
	$("periode_select").innerHTML = "Année";
	$("tb2_det_J").className="green_link_stat";
	$("tb2_det_S").className="green_link_stat";
	$("tb2_det_M").className="green_link_stat";
	$("tb2_det_A").className="green_link_stat_actif";
	tb2_aff_resultat_1 ();
}, false);

</script>
<br />
<input type="hidden" id="type_progress" name="type_progress" value="J" class="classinput_nsize" />

Période personnalisée 

<input type="text" id="date_debut" name="date_debut" value="<?php echo date("d-m-Y");?>" class="classinput_nsize" />
 au&nbsp;<input type="text" id="date_fin" name="date_fin" value="<?php echo date("d-m-Y");?>" class="classinput_nsize" />
 <br />


<div style="">
<div id="tb2_det_aff">
</div>
</div>



</div>
</div>

</div>

<SCRIPT type="text/javascript">
function submit_simple_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:  
		datemask (event);
		tb2_aff_resultat_1 ();
		Event.stop(event);
	break;   
	}
}
	Event.observe("date_debut", "keypress", function(evt){
		 submit_simple_if_Key_RETURN (evt);
	}, false);
	Event.observe("date_fin", "keypress", function(evt){
		 submit_simple_if_Key_RETURN (evt);
	}, false);
	
	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	
	tb2_aff_resultat_1 ();
//on masque le chargement
H_loading();
</SCRIPT>