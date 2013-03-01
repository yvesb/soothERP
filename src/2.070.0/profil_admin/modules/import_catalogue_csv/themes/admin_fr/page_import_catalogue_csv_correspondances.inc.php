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
	<a href="#" id="close_mini_<?php echo $_REQUEST["lmb_col"]; if (isset($_REQUEST["id_tarif"])) { echo "_".$_REQUEST["id_tarif"];}?>" style="float:right">
	<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" alt="X"
	>
	</a>
	
	<script type="text/javascript">
	Event.observe("close_mini_<?php echo $_REQUEST["lmb_col"]; if (isset($_REQUEST["id_tarif"])) { echo "_".$_REQUEST["id_tarif"];}?>", "click",  function(evt){Event.stop(evt);
					$("correspondances_<?php echo $_REQUEST['lmb_col']; if (isset($_REQUEST["id_tarif"])) { echo "_".$_REQUEST["id_tarif"];}?>").hide();
					$("v_correspondances_<?php echo $_REQUEST['lmb_col']; if (isset($_REQUEST["id_tarif"])) { echo "_".$_REQUEST["id_tarif"];}?>").show();
					$("unv_correspondances_<?php echo $_REQUEST['lmb_col']; if (isset($_REQUEST["id_tarif"])) { echo "_".$_REQUEST["id_tarif"];}?>").hide();
	}, false);
	</script>
<div style="font-weight:bolder">Renseigner les correspondances pour <?php echo $lib_champ;?></div>
<div>



<?php
switch ($_REQUEST["lmb_col"]) {
	case "ref_art_categ": case  "ref_constructeur":
	?>
	<table style="width:100%">
	<?php
	foreach  ($arrayLigne as $indexArrayLigne) {
		?>
		<tr>
			<td style="width:50%">
				<?php
					echo $indexArrayLigne->__getValeur();
				?>	
			</td>
			<td>&nbsp;</td>	
			<td>
				<select id="<?php echo $_REQUEST["lmb_col"]."_pend_".$indexArrayLigne->__getId();?>" name="<?php echo $_REQUEST["lmb_col"]."_pend_".$indexArrayLigne->__getId();?>" class="classinput_lsize">
					<option value="">Non d&eacute;termin&eacute;e</option>
					<option value="creer">Créer</option>
					<?php 
					foreach ($listes_champs as $champ)  {
						?>
						<option value="<?php echo $champ["id"]; ?>" <?php
								if (strtolower(trim($indexArrayLigne->__getValeur())) == strtolower(trim($champ["lib"]))){ 
									echo ' selected="selected" ';
								}
							?>><?php echo strtolower(trim($champ["lib"])); ?>
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
	<?php 
	break;
	case "id_valo": case "gestion_sn":
	?>
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
				<select id="<?php echo $_REQUEST["lmb_col"]."_equiv_".$champ["id"];?>" name="<?php echo $_REQUEST["lmb_col"]."_equiv_".$champ["id"];?>" class="classinput_lsize">
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
	<?php
	break;
	case "id_tarif":
	?>
	<table style="width:100%">
		<tr>
			<td style="width:50%">
				Indique quantitatif
			</td>
			<td>&nbsp;</td>	
			<td>
				<select id="<?php echo $_REQUEST["lmb_col"]."_qte_".$_REQUEST["id_tarif"];?>" name="<?php echo $_REQUEST["lmb_col"]."_qte_".$_REQUEST["id_tarif"];?>" class="classinput_lsize">
					<option value="">Qté 1 par défaut</option>
					<?php 
					foreach ($arrayColonne as $indexArrayColonne)  {
						?>
						<option value="<?php echo $indexArrayColonne->__getId(); ?>" ><?php echo $indexArrayColonne->__getLibelle(); ?>
						</option>
						<?php 
					}
					?>
				</select>
			</td>
		</tr>
	</table>
	<?php 
	break;
}
?>
</div>
<SCRIPT type="text/javascript">
	
//on masque le chargement
H_loading();
</SCRIPT>