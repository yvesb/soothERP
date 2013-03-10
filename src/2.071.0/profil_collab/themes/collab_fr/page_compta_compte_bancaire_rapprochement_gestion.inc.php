<?php

// *************************************************************************************************************
// Gestion des comptes bancaires
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<div class="emarge"><br />
<span class="titre" style="padding-left:140px">Rapprochements bancaires</span>

<div class="emarge">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
	<tr>
		<td rowspan="2" style="width:120px; height:50px">
			<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_banque.jpg" />				</div>
			<span style="width:35px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			
		</td>
		<td style="width:90%;">
		<br /><br /><br />
		<?php 
		if ($comptes_bancaires) {
			?>
			<table style="width:90%">
				<tr class="smallheight">
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:19%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:13%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:1%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:12%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td style="text-align:left; font-weight:bolder;">Libell&eacute;
					</td>
					<td style="text-align:left; font-weight:bolder;">N&deg; compte
					</td>
					<td style="text-align: center; font-weight:bolder;">
					Opérations à rapprocher
					</td>
					<td style="text-align:center; font-weight:bolder;" colspan="3">
					Rapprochement
					</td>
				</tr>
				<tr><td colspan="7" style=" border-bottom:1px solid #999999">&nbsp;</td></tr>
			<?php
			$fleches_ascenseur=0;
			foreach ($comptes_bancaires as $compte_bancaire) {
				?>
				<tr><td colspan="7" style="">&nbsp;</td></tr>
					<tr style=" border-bottom:1px solid #999999">
						<td style="text-align:left; font-weight:bolder;">
						<?php echo htmlentities($compte_bancaire->lib_compte);?>
						</td>
						<td style=" color:#999999; font-weight:bolder;">
						<?php echo htmlentities($compte_bancaire->numero_compte);?>
						</td>
						<td style=" color:#999999; font-weight:bolder; text-align:center">
						<?php echo $compte_bancaire->a_rapprocher;?>
						</td>
						<td style="text-align:right">
						<span id="rapprochement_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" style="cursor:pointer" class="green_underlined" > Manuel </span>
						</td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>

						<td style="text-align:left">
						<span id="auto_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>" style="cursor:pointer" class="green_underlined" > Automatique </span>
						</td>
					</tr>
				<tr><td colspan="7" style=" border-bottom:1px solid #999999">&nbsp;</td></tr>
				<?php 
				$fleches_ascenseur++;
				}
			?>
			<?php 
			}
		?>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		</td>
	</tr>
</table>
</div>
<SCRIPT type="text/javascript">

<?php
foreach ($comptes_bancaires as $compte_bancaire) {
	?>
	Event.observe('rapprochement_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'click',  function(evt){
	Event.stop(evt); 
	page.verify('compta_compte_bancaire_rapprochement','compta_compte_bancaire_rapprochement.php?id_compte_bancaire=<?php echo $compte_bancaire->id_compte_bancaire;?>','true','sub_content');
	}, false);
	
	Event.observe('auto_compte_<?php echo $compte_bancaire->id_compte_bancaire;?>', 'click',  function(evt){
	Event.stop(evt); 
	page.verify('compta_compte_bancaire_rapprochement_auto','compta_compte_bancaire_rapprochement_auto.php?id_compte_bancaire=<?php echo $compte_bancaire->id_compte_bancaire;?>&a_rapprocher=<?php echo $compte_bancaire->a_rapprocher;?>','true','sub_content');
	}, false);
	

	<?php 
	}
?>
	

//on masque le chargement
H_loading();
</SCRIPT>
</div>