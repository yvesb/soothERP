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

$couleurs = array("#97bf0d","#ab8cbc","#f29400","#8baed8","#ffed00");
?>
<script type="text/javascript">

	
</script><br />


<div class="emarge" id="corps_tb22">
<div >
<div style="border-bottom:2px solid #999999" class="titre_ter_stat">
Base de données Clientèle
</div>
<table style="width:100%; " cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:left; padding-bottom:10px; padding-top:10px;">
		<?php 
		$total = 0;
		foreach ($liste_type_clients as $type_c) {$total += $type_c["nb"];
			?>
			<div  class="list_stat_link">
			<span style="float:right"><?php echo $type_c["nb"];?></span>
			<?php echo $type_c["lib"];
			?><br />
			</div>
			<?php 
		}

		?><br />

			<div  class="list_stat_link">
			<span style="float:right"><?php echo $total;?></span>
			TOTAL<br />
			</div>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
		
		<div style="float:right; border:1px solid #999999; text-align:left; padding:5px;">
		<?php
		$i = 0;
		foreach ($liste_type_clients as $type_c) {
			?>
			<span style="height:5px; width:5px; font-size:8px; background-color:<?php echo $couleurs[$i];?>">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="5px" height="5px"/>
			</span>&nbsp;&nbsp; <?php echo $type_c["lib"];?><br />
			<?php
			$i ++;
			if ($i >= 5) {$i = 0;}
		}
		?>
		</div>
				<script type="text/javascript">
				swfobject.embedSWF("open-flash-chart.swf", "my_chart_4", "250", "200", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb4_data.php?type_data=type_client");?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
				</script>
 

				<div id="my_chart_4">
				</div>
		</td>
	</tr>
</table>
</div>


<br />
			<span style="cursor:pointer; font-weight:bolder; display:" id="tb4_2_more_1"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_case_plus.gif" style="vertical-align: text-bottom"  />	Détail par catégories de clients</span>
			
<SCRIPT type="text/javascript">

Event.observe("tb4_2_more_1", "click",  function(evt){Event.stop(evt); 
$("tb4_2_more_1_content").show();
$("tb4_2_more_1").hide();
}, false);

</SCRIPT>
<div style="display:none" id="tb4_2_more_1_content" >
<div style="border-bottom:2px solid #999999" class="titre_ter_stat">
Détail par catégories de clients
</div>
<table style="width:100%; " cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:left; padding-bottom:10px; padding-top:10px;">
		<?php 
		foreach ($liste_categories_client as $client) {
			?>
				<script type="text/javascript">
				swfobject.embedSWF("open-flash-chart.swf", "my_chart_5<?php echo $client->id_client_categ;?>", "180", "150", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb4_data.php?type_data=categ_client&id_client_categ=".$client->id_client_categ);?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
				</script>
 

				<div id="my_chart_5<?php echo $client->id_client_categ;?>">
				</div>
			<?php 
		}
		?>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
		</td>
	</tr>
</table>
</div>


</div>


</div>
<br />
<br />

<script type="text/javascript">
	swfobject.embedSWF("open-flash-chart.swf", "tb4_det_aff4", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb4_3_data.php?type=1", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
</script>
				<div id="tb4_det_aff4">
				</div>
<br />
<br />
<br />

<script type="text/javascript">
	swfobject.embedSWF("open-flash-chart.swf", "tb4_det_aff5", "780", "110", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_tb4_3_data.php?type=2", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
</script>
				
				<div style="text-align:center; margin:30px;"id="tb4_det_aff5">
					<a href="http://www.adobe.com/go/getflashplayer">
							<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				</div>
			
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>