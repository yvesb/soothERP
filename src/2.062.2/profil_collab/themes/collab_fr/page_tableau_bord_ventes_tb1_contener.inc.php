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
<div class="titre_ter_stat" >Chiffre d'affaire comparatif
</div>
<div  id="corps_tb1">
<div >
<table style="width:100%;  border:1px solid #999999; " cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px; background-image: url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/stats_bg_1.gif); background-repeat:repeat-y; background-position:left;">
		<script type="text/javascript">
		swfobject.embedSWF("open-flash-chart.swf", "tb1_data1", "100", "150", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb1_data.php?data=by_day&val_1=".$CA_day_1."&val_2=".$CA_day_0); ?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
		
		</script>
		<div id="tb1_data1">
		</div>
		<div style="text-align:center; font-weight:bolder">Aujourd'hui<br />
			<span style="color:#999999"><?php echo $CA_day_0." ".$MONNAIE[1];?></span></div>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
		<script type="text/javascript">
		swfobject.embedSWF("open-flash-chart.swf", "tb1_data2", "100", "150", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb1_data.php?data=by_week&val_1=".$CA_week_1."&val_2=".$CA_week_0); ?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
		
		</script>
		<div id="tb1_data2">
		</div>
		<div style="text-align:center; font-weight:bolder">Cette semaine<br />
			<span style="color:#999999"><?php echo $CA_week_0." ".$MONNAIE[1];?></span></div>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
		<script type="text/javascript">
		swfobject.embedSWF("open-flash-chart.swf", "tb1_data3", "100", "150", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb1_data.php?data=by_month&val_1=".$CA_month_1."&val_2=".$CA_month_0); ?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
		
		</script>
		<div id="tb1_data3">
		</div>
		<div style="text-align:center; font-weight:bolder">Ce mois<br />
			<span style="color:#999999"><?php echo $CA_month_0." ".$MONNAIE[1];?></span></div>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
		<script type="text/javascript">
		swfobject.embedSWF("open-flash-chart.swf", "tb1_data4", "100", "150", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb1_data.php?data=by_year&val_1=".$CA_year_1."&val_2=".$CA_year_0); ?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
		
		</script>
		<div id="tb1_data4">
		</div>
		<div style="text-align:center; font-weight:bolder">Cette année<br />
			<span style="color:#999999"><?php echo $CA_year_0." ".$MONNAIE[1];?></span></div>
		</td>
		<td style="width:70px; background-image: url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/stats_bg_2.gif); background-repeat:repeat-y; background-position:right; padding-bottom:10px; padding-top:10px;">
		<div style="border:1px solid #999999; background-color:#FFFFFF; font-size:10px; text-align:left; padding:5px; width:70px">
		<span style="height:5px; width:5px; background-color:#f29400">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="5px" height="5px"/>
		</span>&nbsp;&nbsp; Année N-1<br /><br />

		<span style="height:5px; width:5px; background-color: #8a5b9d">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="5px" height="5px"/>
		</span>&nbsp;&nbsp; Année N<br />
        <img id="print_stats" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF" style="cursor:pointer;"/>
		<img id="export_stats" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ods.gif" alt="ODS" title="ODS" style="cursor:pointer;"/>
		</div>
		</td>
	</tr>
</table>
</div>
<div style="text-align:right; color:#999999; font-size:10px">
Les données de la période N-1 correspondent à la période équivalente prise en compte pour la période N
</div><br />
<br />
<div style=" float:right; color:#97bf0d">
<span class="green_link_stat_actif" id="tb1_det_7">7 jours</span> | <span class="green_link_stat" id="tb1_det_30">30 jours</span> | <span class="green_link_stat" id="tb1_det_12">12 mois</span> | <span class="green_link_stat" id="tb1_det_3">3 années</span>
</div>
<script type="text/javascript">

Event.observe("tb1_det_7", "click",  function(evt){
	Event.stop(evt); 
	$("tb1_det_7").className="green_link_stat_actif";
	$("more_7").show();
	$("tb1_det_30").className="green_link_stat";
	$("more_30").hide();
	$("tb1_det_12").className="green_link_stat";
	$("more_12").hide();
	$("tb1_det_3").className="green_link_stat";
	$("more_3").hide();
	
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=7", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=7_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	
}, false);

Event.observe("tb1_det_30", "click",  function(evt){
	Event.stop(evt); 
	$("tb1_det_7").className="green_link_stat";
	$("more_7").hide();
	$("tb1_det_30").className="green_link_stat_actif";
	$("more_30").show();
	$("tb1_det_12").className="green_link_stat";
	$("more_12").hide();
	$("tb1_det_3").className="green_link_stat";
	$("more_3").hide();
	
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=30", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "870", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=30_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);


Event.observe("tb1_det_12", "click",  function(evt){
	Event.stop(evt); 
	$("tb1_det_7").className="green_link_stat";
	$("more_7").hide();
	$("tb1_det_30").className="green_link_stat";
	$("more_30").hide();
	$("tb1_det_12").className="green_link_stat_actif";
	$("more_12").show();
	$("tb1_det_3").className="green_link_stat";
	$("more_3").hide();
	
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=12", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=12_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);


Event.observe("tb1_det_3", "click",  function(evt){
	Event.stop(evt); 
	$("tb1_det_7").className="green_link_stat";
	$("more_7").hide();
	$("tb1_det_30").className="green_link_stat";
	$("more_30").hide();
	$("tb1_det_12").className="green_link_stat";
	$("more_12").hide();
	$("tb1_det_3").className="green_link_stat_actif";
	$("more_3").show();
	
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=3", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	
	$("pre_aff_tb1_det_aff2").innerHTML = "<div id=\"tb1_det_aff2\"></div>";
}, false);

	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=7", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=7_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
</script>

<div class="titre_ter_stat" style="text-align:left" >Evolution du chiffre d'affaire
</div>

<div style="border:1px solid #999999; ">
<div id="tb1_det_aff">
</div>
</div>


<div id="more_7" style="padding-left:45px; display:">
Comparer avec: <span class="underline_stat_link" id="tb1_det_7_less">7 jours précédents</span> | <span class="underline_stat_link" id="tb1_det_7_equi">Période équivalente l'an passé</span>
<script type="text/javascript">
Event.observe("tb1_det_7_less", "click",  function(evt){
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "800", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=7_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);
Event.observe("tb1_det_7_equi", "click",  function(evt){
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "800", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=7_equi", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);
</script>
</div>
<div id="more_30" style="padding-left:45px; display:none">
Comparer avec: <span class="underline_stat_link" id="tb1_det_30_less">30 jours précédents</span> | <span class="underline_stat_link" id="tb1_det_30_equi">Période équivalente l'an passé</span>
<script type="text/javascript">
Event.observe("tb1_det_30_less", "click",  function(evt){
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "800", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=30_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);
Event.observe("tb1_det_30_equi", "click",  function(evt){
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "800", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=30_equi", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);
</script>
</div>

<div id="more_12" style="padding-left:45px; display:none">
Comparer avec: <span class="underline_stat_link" id="tb1_det_12_less">12 mois précédents</span> 
<script type="text/javascript">
Event.observe("tb1_det_12_less", "click",  function(evt){
	swfobject.embedSWF("open-flash-chart.swf", "tb1_det_aff2", "800", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb1_cont_det_data.php?data=12_less", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
}, false);
</script>
</div>
<div id="more_3" style="padding-left:45px; display:none">
</div>
<br />



<div style="border:1px solid #999999" id="pre_aff_tb1_det_aff2">
<div style="text-align:center; margin:30px;"id="tb1_det_aff2">
	<a href="http://www.adobe.com/go/getflashplayer">
			<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
	</a>

</div>
</div>

</div>
</div>

</div>
<?php
include ("page_stat_export.php");
?>
<SCRIPT type="text/javascript">
Event.observe('print_stats', "click", function(evt){
  page.verify("stats_print","stats_editing.php<?php //echo $article->getRef_article ();?>", "true", "_blank");
});
Event.observe('export_stats', "click", function(evt){
	$("pop_up_export_det").style.display = "block";
	page.traitecontent('pop_up_export_det','stats_export.php','true','pop_up_export_det');
	Event.stop(evt);
});

//centrage de la pop up comm
centrage_element("pop_up_export_det");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_export_det");
});
//on masque le chargement
H_loading();
</SCRIPT>