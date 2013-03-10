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
	<a href="#" id="close_mini_<?php echo $_REQUEST["lmb_col"];?>" style="float:right">
	<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" alt="X">
	</a>
	
	<script type="text/javascript">
	Event.observe("close_mini_<?php echo $_REQUEST["lmb_col"];?>", "click",  function(evt){Event.stop(evt);
					$("correspondances_<?php echo $_REQUEST['lmb_col'];?>").hide();
					$("v_correspondances_<?php echo $_REQUEST['lmb_col'];?>").show();
					$("unv_correspondances_<?php echo $_REQUEST['lmb_col'];?>").hide();
	}, false);
	</script>
<div style="font-weight:bolder">Renseigner les correspondances pour <?php echo $lib_champ;?></div>
<div>

<table style="width:100%">
<?php
foreach  ($listes_champs as $champ) {
	?>
	<tr>
		<td style="width:50%">
			<?php
				echo $champ["lib"];
			?>	
		</td>
		<td>&nbsp;</td>	
		<td>
			<select id="<?php echo $_REQUEST["lmb_col"]."_equiv_".str_replace(" ", "_", $champ["id"]);?>" name="<?php echo $_REQUEST["lmb_col"]."_equiv_".$champ["id"];?>" class="classinput_lsize">
				<option value="">Non d&eacute;termin&eacute;e</option>
				<?php 
				foreach ($arrayLigne as $indexArrayLigne)  {
					?>
					<option value="<?php echo $indexArrayLigne->__getValeur(); ?>" <?php
							if (strtolower(trim($indexArrayLigne->__getValeur())) == strtolower(trim($champ["lib"]))){ 
								echo ' selected="selected" ';
							}
						?>><?php echo $indexArrayLigne->__getValeur(); ?>
					</option>
					<?php 
				}
				?>
			</select>
		</td>
	</tr>
	<?php
}
?>
</table>
</div>
<SCRIPT type="text/javascript">
	
//on masque le chargement
H_loading();
</SCRIPT>