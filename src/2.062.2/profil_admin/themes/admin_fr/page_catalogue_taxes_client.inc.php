

	<?php
// liste des taxes par pays
	if (count($taxes)>0) {
		foreach ($taxes  as $taxe){
	?>
		<form method="post" action="catalogue_taxes_sup.php" id="catalogue_taxes_sup_<?php echo $taxe['id_taxe']; ?>" name="catalogue_taxes_sup_<?php echo $taxe['id_taxe']; ?>" target="formFrame">
			<input name="id_taxe" id="id_taxe" type="hidden" value="<?php echo $taxe['id_taxe']; ?>" />
		</form>
		<a href="#" id="link_catalogue_taxes_sup_<?php echo $taxe['id_taxe']; ?>" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe("link_catalogue_taxes_sup_<?php echo $taxe['id_taxe']; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('catalogue_taxes_sup', 'catalogue_taxes_sup_<?php echo $taxe['id_taxe']; ?>');}, false);
		</script>
	 		<?php echo htmlentities($taxe['lib_taxe']);?> (<?php echo htmlentities($taxe['info_calcul']);?>)<br />
<?php 

	}
	}else{
?>Pas de taxe import&eacute; &agrave; ce jour pour ce pays 

<?php 
	}
?>
</div>

<SCRIPT type="text/javascript">
ceux_present.clear();
<?php
// liste des taxes par pays
		foreach ($taxes  as $taxe){
	?>
ceux_present.push(<?php echo $taxe['id_taxe'];?>);
<?php 

	}
?>

taxes_dispo(fin_array);
//on masque le chargement
H_loading();
</SCRIPT>