<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
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

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Gestion des Newsletters 
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
			<br /><br /><br />

			<table width="100%" border="0" cellspacing="4" cellpadding="2">
				<tr>
					<td style="width:25%; font-weight:bolder; text-align:left">Libellé de la Newsletter</td>
					<td style="width:20%; font-weight:bolder; text-align:right; padding-right:25px">Dernier envoi</td>
					<td style="width:20%; font-weight:bolder; text-align:center">Nombre d'abonnés</td>
					<td style="font-weight:bolder; text-align:center" colspan="3">Options</td>
				</tr>
				<tr>
					<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
				</tr>
			<?php 
			foreach ($newsletters as $newsletter) {
				?>
				<tr id="choix_newsletter_<?php echo $newsletter->id_newsletter; ?>">
					<td style="font-weight:bolder; text-align:left"><?php echo ($newsletter->nom_newsletter);?></td>
					<td style="font-weight:bolder; text-align:right; color:#999999; padding-right:25px">
					<?php echo date_Us_to_Fr($newsletter->date_envoi);?> <?php echo getTime_from_date($newsletter->date_envoi);?>
					</td>
					<td style="font-weight:bolder; text-align:center; color:#999999;">
					<a href="communication_newsletters_gestion_abo.php?id_newsletter=<?php echo $newsletter->id_newsletter;?>"  target="_blank" class="common_link" >
					<?php echo count(charger_total_abonnes ($newsletter->id_newsletter));?>
					</a>
					</td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="tb_<?php echo $newsletter->id_newsletter; ?>" >Envoi</span></td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>
					<td style="width:15%; text-align:center"><span class="green_underlined" id="rc_<?php echo $newsletter->id_newsletter; ?>">Archives</span>
					</td>
				</tr>
				<?php
			}
			?>
				<tr>
					<td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td>
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
foreach ($newsletters as $newsletter) {
	?>
	Event.observe("tb_<?php echo $newsletter->id_newsletter; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("communication_newsletters_gestion_envoi", "communication_newsletters_gestion_envoi.php?id_newsletter=<?php echo $newsletter->id_newsletter; ?>", "true", "sub_content");
	}, false);
	
	
	Event.observe("rc_<?php echo $newsletter->id_newsletter; ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("communication_newsletters_gestion_archives", "communication_newsletters_gestion_archives.php?id_newsletter=<?php echo $newsletter->id_newsletter; ?>", "true", "sub_content");
	}, false);
	<?php
}
?>
	
//on masque le chargement
H_loading();
</SCRIPT>