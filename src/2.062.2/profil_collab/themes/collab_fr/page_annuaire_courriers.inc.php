<?php
// *************************************************************************************************************
// CHARGEMENTS DES COURRIERS D'UN CONTACT
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<p class="sous_titre1">Courriers</p>

<br/>
bouton NOUVEAU MESSAGE
<div style=" text-align:left; padding:0 20px">

	<table style="width:100%">
		<tr class="smallheight">
			<!-- 
			<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:38%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			-->
			<td style="width:100%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td>
				<?php
				if (count($courriers)) {
					?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr >
						<td style="width:35px;"><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
						<td style=" width:85px; font-weight:bolder; color:#00336c; font-size:14px; padding-left:3px; padding-right:3px">COURRIERS</td>
						<td ><div style="height:9px; border-bottom:1px solid #00336c">&nbsp;</div></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
					<tr class="smallheight" style="">
						<td id="12"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td id="14" style="width:100px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td id="11" style="width:85px; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td id="13" style="width:120px; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						<td id="15" style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
					</tr>
					<tr style="text-align:left; vertical-align:top; color:#00336c; font-weight:bolder">
						<td id="22" style=" text-align:left; padding-left:5px; font-weight:bolder">Sujet</td>
						<td id="24" style=" text-align:center; padding-left:5px; font-weight:bolder">Auteur</td>
						<td id="21" style="  text-align:left; padding-left:5px; font-weight:bolder">Date</td>
						<td id="23" style="  text-align:left; padding-left:5px; font-weight:bolder">Etat</td>
						<td id="25"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" width="25px"/></td>
					</tr>
				</table>
					
				<div class="art_new_info" >
					<?php
					foreach ($courriers as $courrier) {
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
						<tr class="smallheight" style="">
							<td id="32" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
							<td id="34" style="width:100px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
							<td id="31" style="width:85px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
							<td id="33" style="width:120px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
							<td id="35" style="width:18px;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
						</tr>
						<tr style="cursor:pointer; color:#002673">
							<td id="42" style="  border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_courrier_1_<?php echo $courrier->getId_courrier();?>">
								<?php echo $courrier->getObjet();?>
							</td>
							<td id="44" style=" border-bottom:1px solid #FFFFFF; text-align:right; padding-right:15px" id="open_courrier_2_<?php echo $courrier->getId_courrier();?>">
								AUTEUR !
							</td>
							<td id="41" style=" border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_courrier_3_<?php echo $courrier->getId_courrier();?>">
								<?php echo date_Us_to_Fr($courrier->getDate_courrier());?>
							</td>
							<td id="43" style=" border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_courrier_4_<?php echo $courrier->getId_courrier();?>">
								<?php echo ($courrier->getLib_etat_courrier());?>
							</td>
							<td id="45" style=" border-bottom:1px solid #FFFFFF; text-align:center; ">
							<a href="courrier_editing.php?id_courrier=<?php echo $courrier->getId_courrier()?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
							<script type="text/javascript">
								Event.observe('open_courrier_1_<?php echo $courrier->getId_courrier();?>', "click", function(evt){ open_courrier("<?php echo ($courrier->id_courrier);?>"); });
								Event.observe('open_courrier_2_<?php echo $courrier->getId_courrier();?>', "click", function(evt){ open_courrier("<?php echo ($courrier->id_courrier);?>"); });
								Event.observe('open_courrier_3_<?php echo $courrier->getId_courrier();?>', "click", function(evt){ open_courrier("<?php echo ($courrier->id_courrier);?>"); });
								Event.observe('open_courrier_4_<?php echo $courrier->getId_courrier();?>', "click", function(evt){ open_courrier("<?php echo ($courrier->id_courrier);?>"); });
							</script>
							</td>
						</tr>
					</table>
					<?php 
					}
					?>
				</div>
				<?php
				}else{ ?>
					Aucun courrier
				<?php 	
				} ?>
			</td>
			<!-- 
			<td>
				a
			</td>
			<td>
				b
			</td>
			 -->
		</tr>
	</table>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>