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

<div class="titre" style="width:60%; padding-left:140px">Tableau de bord des ventes
</div>
<div class="emarge" style="text-align:right" >
<div  id="corps_tb">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_stats.gif" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="background-color:#FFFFFF" >
			<br /><br />

			<div id="menu_tb" class="menu_tb" style="width:730px;">
			<ul>
			<li><a href="#" class="menu_tb_select" id="select_menu_tbv1" style="padding-left:50px;border-right:1px  solid #000000">Tableau de Bord des Ventes</a></li>
			<li><a href="#" class="menu_tb_unselect" id="select_menu_tbv2" style="border-right:1px  solid #000000">Analyse du Chiffre d'affaires</a></li>
			<li><a href="#" class="menu_tb_unselect" id="select_menu_tbv3" style="border-right:1px  solid #000000">Données Clients</a></li>
			<li><a href="#" class="menu_tb_unselect" id="select_menu_tbv4" style="">Historique des Ventes</a></li>
			<!--<li><a href="#" class="menu_tb_unselect" id="select_menu_tbv5">Prévisions</a></li>-->
			</ul>
			</div>
			<script type="text/javascript">
						
			array_menu_tbv	=	new Array();
			array_menu_tbv[0] 	=	new Array('tbv_aff', 'select_menu_tbv1');
			array_menu_tbv[1] 	=	new Array('tbv_aff', 'select_menu_tbv2');
			array_menu_tbv[2] 	=	new Array('tbv_aff', 'select_menu_tbv3');
			array_menu_tbv[3] 	=	new Array('tbv_aff', 'select_menu_tbv4');
			/*array_menu_tbv[4] 	=	new Array('tbv_aff', 'select_menu_tbv5');*/
			
			Event.observe("select_menu_tbv1", "click",  function(evt){Event.stop(evt); 
			 view_menu_accueil('tbv_aff', 'select_menu_tbv1', array_menu_tbv ,"menu_tb_unselect" ,"menu_tb_select");
			 page.traitecontent("tableau_bord_ventes_tb1_contener", "tableau_bord_ventes_tb1_contener.php", "true", "tbv_aff");
			}, false);
			Event.observe("select_menu_tbv2", "click",  function(evt){Event.stop(evt); 
			 view_menu_accueil('tbv_aff', 'select_menu_tbv2', array_menu_tbv ,"menu_tb_unselect" ,"menu_tb_select");
			 page.traitecontent("tableau_bord_ventes_tb2_contener", "tableau_bord_ventes_tb2_contener.php", "true", "tbv_aff");
			}, false);
			Event.observe("select_menu_tbv3", "click",  function(evt){Event.stop(evt); 
			 view_menu_accueil('tbv_aff', 'select_menu_tbv3', array_menu_tbv ,"menu_tb_unselect" ,"menu_tb_select");
			 page.traitecontent("tableau_bord_ventes_tb3_contener", "tableau_bord_ventes_tb3_contener.php", "true", "tbv_aff");
			}, false);
			Event.observe("select_menu_tbv4", "click",  function(evt){Event.stop(evt); 
			 view_menu_accueil('tbv_aff', 'select_menu_tbv4', array_menu_tbv ,"menu_tb_unselect" ,"menu_tb_select");
			 page.traitecontent("tableau_bord_ventes_tb4_contener", "tableau_bord_ventes_tb4_contener.php", "true", "tbv_aff");
			}, false);
			/*Event.observe("select_menu_tbv5", "click",  function(evt){Event.stop(evt);
			 view_menu_accueil('tbv_aff', 'select_menu_tbv5', array_menu_tbv ,"menu_tb_unselect" ,"menu_tb_select");
			}, false);*/
			</script>
			<div id="tbv_aff">
			
			
				<script type="text/javascript">
				swfobject.embedSWF("open-flash-chart.swf", "my_chart", "250", "200", "9.0.0", "expressInstall.swf", {"data-file":"tableau_bord_ventes_test.php", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
				
				</script>
 

				<div id="my_chart">
				</div>
			
			</div>
			</td>
		</tr>
</table>
</div>
</div>

</div>

<SCRIPT type="text/javascript">

function setheight_tb(){
set_tomax_height("corps_tb" , -32);
}
Event.observe(window, "resize", setheight_tb, false);
setheight_tb();

var AppelAjax = new Ajax.Updater(
																	"tbv_aff", 
																	"tableau_bord_ventes_tb1_contener.php",
																			{
																			evalScripts:true, 
																			onLoading:S_loading, 
																			onException: function () {S_failure();},
																			onComplete:function (originalRequest) {
																				H_loading();
																			}
																			}
																			);
	
//on masque le chargement
H_loading();
</SCRIPT>