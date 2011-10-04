
<a href="#" id="link_close_pop_up_inventory" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_inventory", "click",  function(evt){Event.stop(evt); 
		$("pop_up_invetory_article").style.display = "none";}, false);
</script>
<span class="sous_titre1">Inventaire de <?php echo  nl2br(($article->getLib_article ()));?></span>
<div id="inventory_info_under" style="padding-left:2%; padding-right:3%; OVERFLOW-Y: auto; OVERFLOW-X: auto; height:265px">
<form action="catalogue_articles_view_inventory_valide.php?ref_article=<?php echo $article->getRef_article();?>&step=1" target="formFrame" method="post" name="article_view_inventory" id="article_view_inventory">
<input type="hidden" name="ref_article_inventory" id="ref_article_inventory" value="<?php echo $article->getRef_article ();?>" />
	
	
	<table style="width:100%">
		<tr class="smallheight">
			<td height="13" style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:65%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">Lieu de stockage:</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">
				<select id="id_stock_inventory" name="id_stock_inventory" class="classinput_xsize" >
				<?php 
					foreach ($_SESSION['stocks'] as $stock) {
					?>
					<option value="<?php echo $stock->getId_stock (); ?>" <?php if ($stock->getId_stock () == $_SESSION['magasin']->getId_Stock ()){echo 'selected="selected"';}?>><?php echo htmlentities($stock->getLib_stock()); ?>					</option>
					<?php 
				}
				?>
				</select>
			</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:center">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">Quantit&eacute; inventori&eacute;es </td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:center">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">
				<input type="text" id="qte_inventory" name="qte_inventory" value="0" class="classinput_nsize"  size="5"/>
				<input type="hidden" id="old_qte_inventory" name="old_qte_inventory" value="0" class="classinput_nsize"  size="5"/>
			</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:center">&nbsp;</td>
			<td style="text-align:left"><span style="text-align:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_inv_valider.gif" id="valid_inventory" style="cursor:pointer" /></span></td>
			<td></td>
		</tr>
		<?php 
		if ($article->getGestion_sn()) {
			?>
			<tr>
				<td style="text-align:left">&nbsp;</td>
				<td style="text-align:left">
				<div id="art_gest_sn"></div>
				<div id="art_gest_nl"></div>
				</td>
				<td style="text-align:left">&nbsp;</td>
				<td style="text-align:right" colspan="2">
				<div id="info_fill_sn" style="text-decoration:none; color:#FF0000; font-weight:bolder"></div>
				</td>
				<td></td>
			</tr>
		<tr>
			<td style="text-align:left; height:95px">&nbsp;</td>
			<td style="text-align:left">&nbsp;
			<?php 
			if ($article->getGestion_sn() == 2) {
				?>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" width="15px" style="cursor:pointer" id="add_line_nl_content" />
							<script type="text/javascript">
							
								Event.observe("add_line_nl_content", "click", function(evt){
									$("qte_nl_inventory").value = parseInt($("qte_nl_inventory").value)+1;
					affichage_inventory_nl_update ($("qte_nl_inventory").value, $("old_qte_nl_inventory").value);
					$("old_qte_nl_inventory" ).value = $("qte_nl_inventory" ).value;
								},  false );
							</script>
	<input type="hidden" value="<?php echo count($choix_sns);?>" id="qte_nl_inventory" name="qte_nl_inventory" />
	<input type="hidden" value="0" id="old_qte_nl_inventory" name="old_qte_nl_inventory" />
				<?php
			}
			?>
			</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:right">&nbsp;</td>
			<td></td>
		</tr>
			<?php
			
		}
		?>
		<tr>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:right">&nbsp;</td>
			<td></td>
		</tr>
	</table>
</form>
</div>
<script type="text/javascript">
$("qte_inventory").value = $("info_stock_qte_"+$("id_stock_inventory").options[$("id_stock_inventory").selectedIndex].value).innerHTML;
<?php 
if ($article->getGestion_sn() == 1) {
	?>
	if ($("qte_inventory" ).value != $("old_qte_inventory" ).value) {
		affichage_inventory_sn_update ($("qte_inventory").value, $("old_qte_inventory").value);
		$("old_qte_inventory" ).value = $("qte_inventory" ).value;
		is_inventory_sn_filled ();
	}
	<?php
}
?>
<?php 
if ($article->getGestion_sn() == 2) {
	?>
	if ($("qte_inventory" ).value != $("old_qte_inventory" ).value) {
		affichage_inventory_nl_update ($("qte_nl_inventory").value, $("old_qte_nl_inventory").value);
		$("old_qte_nl_inventory" ).value = $("qte_nl_inventory" ).value;

	}
	<?php
}
?>

	Event.observe("id_stock_inventory", "change", function(evt){
			$("qte_inventory").value = $("info_stock_qte_"+$("id_stock_inventory").options[$("id_stock_inventory").selectedIndex].value).innerHTML;
			<?php 
			if ($article->getGestion_sn() == 1) {
				?>
				if ($("qte_inventory" ).value != $("old_qte_inventory" ).value) {
					affichage_inventory_sn_update ($("qte_inventory").value, $("old_qte_inventory").value);
					$("old_qte_inventory" ).value = $("qte_inventory" ).value;
					is_inventory_sn_filled ();
				}
				<?php
			}
			?>
			<?php 
			if ($article->getGestion_sn() == 2) {
				?>
				if ($("qte_inventory" ).value != $("old_qte_inventory" ).value) {
					affichage_inventory_nl_update ($("qte_nl_inventory").value, $("old_qte_nl_inventory").value);
					$("old_qte_nl_inventory" ).value = $("qte_nl_inventory" ).value;
				}
				<?php
			}
			?>
	});		

	Event.observe("qte_inventory", "blur", function(evt){
		if (nummask(evt, $("old_qte_inventory" ).value, "X.X")) {
		<?php 
		if ($article->getGestion_sn() == 1) {
			?>
			if ($("qte_inventory" ).value != $("old_qte_inventory" ).value) {
				affichage_inventory_sn_update ($("qte_inventory").value, $("old_qte_inventory").value);
				$("old_qte_inventory" ).value = $("qte_inventory" ).value;
				is_inventory_sn_filled ();
			}
			<?php
		}
		?>
		<?php 
		if ($article->getGestion_sn() == 2) {
			?>
			if ($("qte_inventory" ).value != $("old_qte_inventory" ).value) {
				affichage_inventory_nl_update ($("qte_nl_inventory").value, $("old_qte_nl_inventory").value);
				$("old_qte_nl_inventory" ).value = $("qte_nl_inventory" ).value;
			}
			<?php
		}
		?>
		}
		
	});		
	
	Event.observe("valid_inventory", "click", function(evt){
		Event.stop(evt);
				 
		$("titre_alert").innerHTML = 'Confirmer';
		$("texte_alert").innerHTML = 'Confirmer la validation de l\'inventaire';
		$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
		
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		$("article_view_inventory").submit();
		$("pop_up_invetory_article").style.display = "none";
		}
		
		$("bouton1").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		} 
		}, false);
	
	
</script>