<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<span class="titre" style="padding-left:140px">Gestion de stock</span>

<div class="emarge">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
	<tr>
		<td rowspan="2" style="width:120px; height:50px">
			<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_stock.jpg" />				</div>
			<span style="width:35px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="120px" height="20px" id="imgsizeform"/>				</span>			
		</td>
		<td style="width:90%;">
		<br /><br /><br />
		<?php 
		if ($_SESSION['stocks']) {
			?>
			<table style="width:90%">
				<tr class="smallheight">
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td style="text-align:left; font-weight:bolder;">Libell&eacute;
					</td>
					<td style="text-align:left; font-weight:bolder;">Valeur
					</td>
					<td style="text-align:center; font-weight:bolder;">
					Dernier inventaire
					</td>
					<td style="text-align:center; font-weight:bolder;" colspan="3">
					Accès direct
					</td>
				</tr>
				<tr><td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td></tr>
			<?php
			$fleches_ascenseur=0;
			foreach ($_SESSION['stocks'] as $stock) {
				?>
				<tr><td colspan="6" style="">&nbsp;</td></tr>
					<tr style=" border-bottom:1px solid #999999">
						<td style="text-align:left; font-weight:bolder;">
						<?php echo ($stock->getLib_stock ());?>
						</td>
						<td style=" color:#999999; font-weight:bolder;">
						<?php
						if($_SESSION['user']-> check_permission("6")){
							echo price_format($stock->valeur_stock ())." ".$MONNAIE[1];
						}else{
							echo "ND";
						}
						?>
						</td>
						<td style="text-align:center; color:#999999; font-weight:bolder;">
						<?php echo date_Us_to_Fr($stock->last_inventaire_stock ());?>
						</td>
						<td style="text-align:right">
						<span id="tableau_stock_<?php echo $stock->getId_stock ();?>" style="cursor:pointer" class="green_underlined" > Tableau de bord </span>
						</td>
					<td style="width:5%; text-align:center; color:#97bf0d">-</td>

						<td style="text-align:left">
						<span id="etat_stock_<?php echo $stock->getId_stock ();?>" style="cursor:pointer" class="green_underlined" >Etat de stock </span>
						</td>
					</tr>
				<tr><td colspan="6" style=" border-bottom:1px solid #999999">&nbsp;</td></tr>
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
			foreach ($_SESSION['stocks'] as $stock) {
	?>
	Event.observe('etat_stock_<?php echo $stock->getId_stock ();?>', 'click',  function(evt){
	Event.stop(evt); 
	page.verify('stocks_etat_recherche','stocks_etat_recherche.php?id_stock=<?php echo $stock->getId_stock ();?>','true','sub_content');
	}, false);
	Event.observe('tableau_stock_<?php echo $stock->getId_stock ();?>', 'click',  function(evt){
	Event.stop(evt); 
	page.verify('stocks_gestion2','stocks_gestion2.php?id_stock=<?php echo $stock->getId_stock ();?>','true','sub_content');
	}, false);

	<?php 
	}
?>
	

//on masque le chargement
H_loading();
</SCRIPT>
</div>