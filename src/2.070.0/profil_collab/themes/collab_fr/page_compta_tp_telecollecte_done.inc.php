<?php

// *************************************************************************************************************
// controle de tp
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

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<div class="titre" style="width:60%; padding-left:140px">Télécollecte <?php echo htmlentities($compte_tp->getLib_tp()); ?> effectuée
</div>


<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_tps">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
	<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
		<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
		<span style="width:35px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			
	</td>
	<td colspan="2" style="width:85%; background-color:#FFFFFF" >
	
	<br />
	<br />
	<br />
		
	
	
	<div  ><br />

	<span id="link_retour_tp" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Retour au Tableau de bord</span><br /><br />


	<span id="print_rapport" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />Impression du rapport de télécollecte</span><br />
<br />

						<script type="text/javascript">
						Event.observe("print_rapport", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_tp_telecollecte_imprimer", "compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $_REQUEST["id_compte_tp_telecollecte"]; ?>", "true", "_blank");
						}, false);
						
						Event.observe("link_retour_tp", "click",  function(evt){
							Event.stop(evt); 
							<?php if ($_REQUEST["tp_type"] == "TPE") { ?>
							page.verify('compta_gestion2_terminaux','compta_gestion2_terminaux.php?id_tpe=<?php echo $_REQUEST["id_compte_tp"];?>','true','sub_content');
							<?php } else { ?>
							page.verify('compta_gestion2_terminaux','compta_gestion2_terminaux.php?id_tpv=<?php echo $_REQUEST["id_compte_tp"];?>','true','sub_content');
							<?php } ?>
						}, false);
						</script>
	</div>
		

			</td>
		</tr>
</table>
</div>
</div>
</div>
<SCRIPT type="text/javascript">



//on masque le chargement
H_loading();
</SCRIPT>