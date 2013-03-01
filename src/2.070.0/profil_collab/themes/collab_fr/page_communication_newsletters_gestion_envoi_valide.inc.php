<?php
// *************************************************************************************************************
// ENVOI DE LA NEWSLETTER
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

	historique.unshift("communication_newsletters_gestion_envoi_valide.php");
	default_show_url = "communication_newsletters_gestion_envoi_valide.php";
	document.location.hash = escape("communication_newsletters_gestion_envoi_valide.php");
	
</script>
<div class="emarge"><br />

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Envois en cours
</div>
<div class="emarge" style="text-align:right" >
<div>
	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:120px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_newsletters.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:90%">
			<div id="corps_choix_newsletter" style="width:90%; height:50px; padding:25px">
				<span class="green_underlined" style="font-weight:bolder; text-decoration:none; font-size:14px;">&gt;&gt; <?php echo $newsletter->getNom_newsletter() ?></span><br />
				<br /><br />
				<br />
				<br />
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%; ">
				<tr>
				<td style="width:50%"></td>
				<td align="center" style="text-align:center; width:650px">
				<div style="width:400px; text-align:center">
					<?php 
					if (isset ($erreur)) {
						echo $erreur;
					} else { ?>
					<div id="info_progress_more" style="font-weight:bolder" >Envoi en cours, veuillez ne pas quitter cette page</div><br />
					<br />
						<div style="text-align:left" class="bold_text" id="info_progress">&nbsp;</div>
						
						<div id="progress_barre" class="progress_barre">
							<div id="files_progress" class="files_progress">&nbsp;</div>
						</div>
						
						<br /><br />
					<?php } ?>
				</div>
				<div style="text-align:left" id="progress_script"></div><br />
<br />

				</td>
				<td style="width:50%"></td>
				</tr>
				</table>
			</div>
		</td>
	</tr>
</table>


</div>
</div>

</div>


<SCRIPT type="text/javascript">
function setheight_choix_newsletter(){
set_tomax_height("corps_choix_newsletter" , -75);
}
Event.observe(window, "resize", setheight_choix_newsletter, false);
setheight_choix_newsletter();
<?php 
if (!isset($erreur)) {?>
var AppelAjax = new Ajax.Updater(
									"progress_script",
									"communication_newsletters_gestion_envoi_progress.php", 
									{
									evalScripts:true, 
									parameters: {id_envoi: <?php echo $id_envoi;?>, page_to_show: "1"   },
									onLoading:S_loading
									}
									);
<?php } ?>
//on masque le chargement
H_loading();
</SCRIPT>