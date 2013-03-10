<?php

// *************************************************************************************************************
// RAZ DU STOCK
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
<div class="emarge">

<table style="width:100%">
<tr>
	<td>
		<div class="titre" style="width:60%; padding-left:140px"><?php echo $stock->getLib_stock()?> -  Remise à zéro</div>
	</td>
	<td style="width:20%; vertical-align: bottom;">
		<?php 
			if(isset($stock)){
				?>
				<p class="retour_tdb" id="retour_tdb" class="grey_caisse">Retour au tableau de bord</p>
				<?php
			}
		?>
	</td>
</tr>
</table>
<script type="text/javascript">
Event.observe("retour_tdb", "click",  function(evt){Event.stop(evt); page.verify('stocks_gestion2','stocks_gestion2.php?id_stock=<?php echo $stock->getId_stock()?>','true','sub_content');}, false);
</script>

<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_caisses">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style=" background-color:#FFFFFF" >
			<br />
			<br />
			<br />

			<div>
				<div style="padding: 15px 25px; display:block" id="first_before_raz">
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Remise à zéro du stock</div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
					<span style="color:#FF0000"> Attention, si vous réinitialisez ce stock, les quantités et la valorisation monétaire de chaque article de ce stock seront remises à zéro.</span><br />
<br />
<!--Attention, réinitialiser le stock remet à zéro l'ensemble de quantités des articles pour ce stock et la valorisation du stock.-->
			<br />


					<div style="text-align:center">
						<div style="width:450px; padding-left:20%; padding-right:20%">
						<br /><br />

						<span id="ignorer_continuer" style="cursor:pointer; font-weight:bolder; text-decoration:underline" >Ignorer cet avertissement et réinitialiser le stock</span>
						<br /><br />
						</div>
					</div>
					
					<div style="text-align:center">
					<br /><br />
						<input type="image" name="annuler" id="annuler" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
					</div>
					<script type="text/javascript">
					Event.observe("annuler", "click",  function(evt){Event.stop(evt); page.verify('stocks_gestion2','stocks_gestion2.php?id_stock=<?php echo $stock->getId_stock()?>','true','sub_content');}, false);
					</script>

						<script type="text/javascript">
						Event.observe("ignorer_continuer", "click", function(evt){
							Event.stop(evt);
							$("next_before_raz").show();
							$("first_before_raz").hide();
						}, false);
						</script>
			</div>
			<div style="padding: 15px 25px; display:none" id="next_before_raz">
			<table border="0" cellspacing="0" cellpadding="0" style="width:100%; height:100%">
				<tr>
					<td></td>
					<td>
					<div>
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Remise à zéro du stock</div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td><div class="bold_caisse">Valorisation &gt;&gt;</div></td>
								<td align="right"><div class="bold_caisse" ><?php echo number_format($stock->valeur_stock (), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
								<td style="width:30%">&nbsp;</td>
							</tr>
						</table><br />

						<div style="float:left; color:#999999">Dernier inventaire: <?php echo date_Us_to_Fr($stock->last_inventaire_stock ())." ".getTime_from_date ($stock->last_inventaire_stock ());?></div>
								<br />
								<br />
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_top">&nbsp;</td>
								<td style="width:30%">&nbsp;</td>
							</tr>
						</table><br />
						<br />
						<br />
						<div style=" text-align:center; font-weight:bolder"><span id="valid_raz" style="cursor:pointer; text-decoration:underline">Valider l'opération</span></div>
						
					<form action="stocks_raz_valid.php" target="formFrame" method="post" name="stock_raz_valid" id="stock_raz_valid">
					<input id="id_stock" name="id_stock"  value="<?php echo $stock->getId_stock(); ?>"  type="hidden">
					<input id="raz_stock" name="raz_stock"  value="1"  type="hidden">
					</form>
					</div>
					</td>
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

Event.observe("valid_raz", "click", function(evt){
	Event.stop(evt);
	$("stock_raz_valid").submit();
}, false);
						
						
function setheight_gestion_caisse(){
set_tomax_height("corps_gestion_caisses" , -32);
}
Event.observe(window, "resize", setheight_gestion_caisse, false);
setheight_gestion_caisse();


//on masque le chargement
H_loading();
</SCRIPT>