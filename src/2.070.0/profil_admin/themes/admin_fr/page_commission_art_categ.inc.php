<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
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
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_commission_assistant.inc.php" ?>
<div class="emarge">
<div style=" float:right; text-align:right">
<span id="retour_compta_auto" style="cursor:pointer; text-decoration:underline">Retour au commissionnement des commerciaux</span>
<script type="text/javascript">
Event.observe('retour_compta_auto', 'click',  function(evt){
Event.stop(evt); 
page.verify('configuration_commission','configuration_commission.php','true','sub_content');
}, false);
</script>
</div>
<p class="titre">Commissionnement associés aux catégories d'articles</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div style="padding-left:10px; padding-right:10px">
<br />

	<table>
		<tr style="">
			<td>&nbsp;
			</td>
			<?php 
			foreach ($liste_commissions_regles as $comm_regle) {
				?>
			<td style="text-align:center; font-weight:bolder;  width:20%">
				<span><?php echo $comm_regle->lib_comm;?></span><br />
				<?php echo $comm_regle->formule_comm;?>
			</td>
				<?php
			}
			?>
			<td>&nbsp;
			</td>
		</tr>
		<tr style=" ">
			<td colspan="<?php echo count($liste_commissions_regles)+2;?>" style="border-bottom:1px solid #333333">&nbsp;
			</td>
		</tr>
<?php
foreach ($fiches as $fiche){
	?>
		<tr id="line_comm_art_categ_<?php echo $fiche->ref_art_categ;?>" style="">
			<td>
				<span><?php echo $fiche->lib_art_categ;?></span>
			</td>
			<?php 
			foreach ($liste_commissions_regles as $comm_regle) {
				?>
			<td style="text-align:center">
			<input name="formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>" id="formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>" value="<?php 
			if (!isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]) || !isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm)) {?>non définie<?php } else { echo $fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm; } ?>" type="hidden"  class="classinput_hsize"/>
			<span id="aff_formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>" style="cursor:pointer; text-decoration:underline;" class="classinput_lsize"><?php 
			if (!isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]) || !isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm)) {?>non définie<?php } else { echo $fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm; } ?></span>
			
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="del_formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle; ?>" style="cursor:pointer"/>
			
			<script type="text/javascript">
			
			Event.observe('aff_formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle; ?>', "click", function(evt){
			
				Event.stop(evt);
			  $('pop_up_assistant_comm_commission').style.display='block';
				$('pop_up_assistant_comm_commission_iframe').style.display='block';
				$('assistant_comm_cellule').value='_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>';
				$('assistant_comm_id_commission_regle').value='<?php echo $comm_regle->id_commission_regle;?>';
				$('assistant_comm_art_categ').value='<?php echo $fiche->ref_art_categ;?>';
				$('old_formule_comm').value='<?php 
			if (isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]) && isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm)) { echo $fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm; } ?>';
				edition_formule_commission_limited ("formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>", "<?php echo $comm_regle->formule_comm;?>"); });

			
			Event.observe('del_formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle; ?>', "click", function(evt){
				maj_commission_art_categ ('<?php echo $comm_regle->id_commission_regle; ?>', '<?php echo $fiche->ref_art_categ;?>', '', '');
				$('formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>').value = "";
				$('aff_formule_comm_<?php echo $fiche->ref_art_categ;?>_<?php echo $comm_regle->id_commission_regle;?>').innerHTML = "non définie";
			});
			</script>
									
			</td>
				<?php
			}
			?>
			<td>&nbsp;
			</td>
		</tr>
	<?php
}
?>
	</table>

</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">

//centrage de l'assistant commission

centrage_element("pop_up_assistant_comm_commission");
centrage_element("pop_up_assistant_comm_commission_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_comm_commission_iframe");
centrage_element("pop_up_assistant_comm_commission");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>