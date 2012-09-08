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

	
</script><br />

<div  id="corps_tb22">
<div >
<table style="width:100%; " cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:left; padding-bottom:10px; padding-top:10px;">
			<div class="aff_CA_analyse">
			<div class="titre_ter_stat" style="height: 28px;line-height: 28px;" >Chiffre d'affaire: <?php echo $CA_global." ".$MONNAIE[1];?>
			</div>
			</div><br />
			<span style="cursor:pointer; font-weight:bolder" id="tb2_2_more_1"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_case_plus.gif" style="vertical-align: text-bottom"  />	Détail par magasin</span><br /><br />


			<span style="cursor:pointer; font-weight:bolder" id="tb2_2_more_2"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_case_plus.gif" style="vertical-align:text-bottom"  />	Détail par catégorie de client</span><br /><br />


			<span style="cursor:pointer; font-weight:bolder" id="tb2_2_more_3"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_case_plus.gif" style="vertical-align:text-bottom"  />	Détail par catégorie de commercial</span><br /><br />


			<span style="cursor:pointer; font-weight:bolder" id="tb2_2_more_4"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_case_plus.gif" style="vertical-align:text-bottom"  />	Détail par catégorie d'article</span>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
		<div style="float:right; border:1px solid #999999; text-align:left; padding:5px;">
		<?php
		$couleurs = array("#97bf0d","#ab8cbc","#f29400","#8baed8","#ffed00");
		$i = 0;
		foreach ($BDD_MODELES as $lib) {
			?>
			<span style="height:5px; width:5px; font-size:8px; background-color:<?php echo $couleurs[$i];?>">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="5px" height="5px"/>
			</span>&nbsp;&nbsp; <?php echo ($lib);?><br />
			<?php
			$i ++;
			if ($i >= count($BDD_MODELES)) {$i = 0;}
		}
		?>
		</div>
				<script type="text/javascript">
				swfobject.embedSWF("open-flash-chart.swf", "my_chart", "250", "200", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb2_2_data.php?date_debut=".$date_debut."&date_fin=".$date_fin);?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
				</script>
 

					<div style="text-align:center; margin:30px;"id="my_chart">
					<a href="http://www.adobe.com/go/getflashplayer">
							<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				
				</div>
		</td>
	</tr>
</table>
</div>


</div>
<div id="conteneur_tb2_3">

</div>
</div>

<SCRIPT type="text/javascript">

Event.observe("tb2_2_more_1", "click",  function(evt){Event.stop(evt); 
	var AppelAjax = new Ajax.Updater(
																	"conteneur_tb2_3", 
																	"tableau_bord_ventes_tb2_contener3.php?type=magasins<?php echo "&date_debut=".$date_debut."&date_fin=".$date_fin;?>",
																			{
																			evalScripts:true, 
																			onLoading:S_loading, 
																			onException: function () {S_failure();},
																			onComplete:function (originalRequest) {
																				H_loading();
																			}
																			}
																			);
}, false);

Event.observe("tb2_2_more_2", "click",  function(evt){Event.stop(evt); 
	var AppelAjax = new Ajax.Updater(
																	"conteneur_tb2_3", 
																	"tableau_bord_ventes_tb2_contener3.php?type=categ_client<?php echo "&date_debut=".$date_debut."&date_fin=".$date_fin;?>",
																			{
																			evalScripts:true, 
																			onLoading:S_loading, 
																			onException: function () {S_failure();},
																			onComplete:function (originalRequest) {
																				H_loading();
																			}
																			}
																			);
}, false);

Event.observe("tb2_2_more_3", "click",  function(evt){Event.stop(evt); 
	var AppelAjax = new Ajax.Updater(
																	"conteneur_tb2_3", 
																	"tableau_bord_ventes_tb2_contener3.php?type=categ_comm<?php echo "&date_debut=".$date_debut."&date_fin=".$date_fin;?>",
																			{
																			evalScripts:true, 
																			onLoading:S_loading, 
																			onException: function () {S_failure();},
																			onComplete:function (originalRequest) {
																				H_loading();
																			}
																			}
																			);
}, false);

Event.observe("tb2_2_more_4", "click",  function(evt){Event.stop(evt); 
	var AppelAjax = new Ajax.Updater(
																	"conteneur_tb2_3", 
																	"tableau_bord_ventes_tb2_contener3.php?type=art_categ<?php echo "&date_debut=".$date_debut."&date_fin=".$date_fin;?>",
																			{
																			evalScripts:true, 
																			onLoading:S_loading, 
																			onException: function () {S_failure();},
																			onComplete:function (originalRequest) {
																				H_loading();
																			}
																			}
																			);
}, false);


//on masque le chargement
H_loading();
</SCRIPT>