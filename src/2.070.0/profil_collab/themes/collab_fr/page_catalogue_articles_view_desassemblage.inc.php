
<a href="#" id="link_close_pop_up_inventory" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_inventory", "click",  function(evt){Event.stop(evt); 
		$("pop_up_invetory_article").style.display = "none";}, false);
</script>
<span class="sous_titre1">Désassembler <?php echo  nl2br(($article->getLib_article ()));?></span>
<div id="inventory_info_under" style="padding-left:2%; padding-right:3%; OVERFLOW-Y: auto; OVERFLOW-X: auto; height:265px">
<form action="catalogue_articles_view_desassemblage_valide.php?ref_article=<?php echo $article->getRef_article();?>&step=1" target="formFrame" method="post" name="article_view_desassemblage" id="article_view_desassemblage">
<input type="hidden" name="ref_article_des" id="ref_article_des" value="<?php echo $article->getRef_article ();?>" />
<input type="hidden" name="id_type_doc_des" id="id_type_doc_des" value="<?php echo $_REQUEST["id_type_doc"];?>" />
	
	
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
				<select id="id_stock_des" name="id_stock_des" class="classinput_xsize" >
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
			<td style="text-align:left">Quantit&eacute; désassemblée </td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:center">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:left">
				<input type="text" id="qte_des" name="qte_des" value="" class="classinput_nsize"  size="5"/>
				<input type="hidden" id="old_qte_des" name="old_qte_des" value="" class="classinput_nsize"  size="5"/>
			</td>
			<td style="text-align:left">&nbsp;</td>
			<td style="text-align:center">&nbsp;</td>
			<td style="text-align:left"><span style="text-align:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_des_valider.gif" id="valid_des" style="cursor:pointer" /></span></td>
			<td></td>
		</tr>
		<?php 
		if ($article->getGestion_sn()) {
			?>
			<tr>
				<td style="text-align:left">&nbsp;</td>
				<td style="text-align:left">
				<div id="art_gest_sn"></div>
				</td>
				<td style="text-align:left">&nbsp;</td>
				<td style="text-align:right" colspan="2">
				<div id="info_fill_sn" style="text-decoration:none; color:#FF0000; font-weight:bolder"></div>
				</td>
				<td></td>
			</tr>
		<tr>
			<td style="text-align:left; height:95px">&nbsp;</td>
			<td style="text-align:left">&nbsp;</td>
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
$("qte_des").value = $("old_qte_des").value = $("info_stock_qte_"+$("id_stock_des").options[$("id_stock_des").selectedIndex].value).innerHTML;

	Event.observe("id_stock_des", "change", function(evt){
			$("qte_des").value = $("info_stock_qte_"+$("id_stock_des").options[$("id_stock_des").selectedIndex].value).innerHTML;
	});		

	Event.observe("qte_des", "blur", function(evt){
		if (nummask(evt, $("old_qte_des" ).value, "X.X")) {
			if (parseFloat($("old_qte_des" ).value) < parseFloat($("qte_des" ).value)) {
				
				$("qte_des" ).value = $("old_qte_des" ).value;
				
						 
				$("titre_alert").innerHTML = 'Désassemblage impossible';
				$("texte_alert").innerHTML = 'Vous ne pouvez pas désassembler plus d\'article que la quantité en stock';
				$("bouton_alert").innerHTML = '<input type="submit" id="bouton1" name="bouton1" value="Ok" />';
				
				$("alert_pop_up_tab").style.display = "block";
				$("framealert").style.display = "block";
				$("alert_pop_up").style.display = "block";
								
				$("bouton1").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				} 
			}
		}
		
	});		
	
	Event.observe("valid_des", "click", function(evt){
		Event.stop(evt);
		if (parseFloat($("qte_des" ).value) > 0 ) {
			$("titre_alert").innerHTML = 'Confirmer';
			$("texte_alert").innerHTML = 'Confirmer la validation du désassemblage';
			$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
			
			$("alert_pop_up_tab").style.display = "block";
			$("framealert").style.display = "block";
			$("alert_pop_up").style.display = "block";
			
			$("bouton0").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				$("article_view_desassemblage").submit();
				$("pop_up_invetory_article").style.display = "none";
			}
			
			$("bouton1").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
			} 
		}
		}, false);
	
	
</script>