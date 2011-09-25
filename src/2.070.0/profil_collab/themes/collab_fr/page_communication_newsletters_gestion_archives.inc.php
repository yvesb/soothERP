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

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Archives des envois
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
			<div id="corps_choix_newsletter" style="width:96%; height:50px; padding:15px">
			<span class="green_underlined" style="font-weight:bolder; text-decoration:none; font-size:14px;">&gt;&gt; <?php echo $newsletter->getNom_newsletter() ?></span><br />
			<br /><br />
			<table style="width:100%" border="0" cellpadding="0" cellspacing="0"  >
			<tr>
			<td class="bolder">Date d'envoi
			</td>
			<td class="bolder">
			</td>
			<td class="bolder">Nombre d'envois
			</td>
			<td class="bolder">Lus
			</td>
			<td>&nbsp;
			</td>
			<td>&nbsp;
			</td>
			</tr>
			<?php 
			$colorise=0;
			foreach ($liste_envois as $envoi) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
				?>
				<tr class="<?php  echo  $class_colorise?>">
				<td> <?php echo date_Us_to_Fr($envoi->date_envoi);?> <?php echo getTime_from_date($envoi->date_envoi);?>
				</td>
				<td> <?php echo ($envoi->titre);?>
				</td>
				<td><a href="communication_newsletters_gestion_archives_dest.php?id_envoi=<?php echo ($envoi->id_envoi);?>&id_newsletter=<?php echo $newsletter->getId_newsletter();?>"  target="_blank" class="common_link" ><?php echo ($envoi->nb_inscrits);?></a>
				</td>
				<td><?php echo ($envoi->nb_lus);?>
				</td>
				<td>
				</td>
				<td style="text-align:right">
					<a href="communication_newsletters_gestion_archives_preview.php?id_envoi=<?php echo ($envoi->id_envoi);?>"  target="_blank"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_apercu.gif" /></a>
				</td>
				</tr>
				<?php 
			}
			?>
			</table>
			<br />
<br />
<br />
<br />
<br />
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


//on masque le chargement
H_loading();
</SCRIPT>