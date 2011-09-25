<?php
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
<?php 
// Remise à zéro des css champs alerte
foreach ($_POST as $k => $v){
	?>
	window.parent.document.getElementById("<?php echo $k;?>").className="classinput_lsize";
	<?php		
}

// Traitement doublons colonnes
if (isset($array_verif_doublon)) {
	foreach ($array_verif_doublon as $ck=>$alt) {
		if(count($alt)>=2) {
			$i = 1; ?>
			texte_erreur += window.parent.document.getElementById("<?php echo  $alt[0];?>").options[<?php echo $ck-1;?>].text+" utilisé dans:<br />";
			<?php	
			foreach ($alt as $alerte => $value) {
				?>
				window.parent.document.getElementById("<?php echo $value;?>").className="alerteform_lsize";
				texte_erreur += "<b>"+window.parent.document.getElementById("lib_champ_<?php echo $value;?>").innerHTML.replace(":","")+"</b>";
				<?php
				if(++$i < count($alt)){
					?>
					texte_erreur += ", ";
					<?php	
				}elseif($i == count($alt)){
					?>
					texte_erreur += " et ";
					<?php
				}
			}
			?>
			texte_erreur += "<br />";
			<?php
		}
	}
}

// Traitement des champs obligatoires
if(isset($_ALERTES['obligatoire'])){
	foreach($_ALERTES['obligatoire'] as $obl){
		?>
		texte_erreur += "Le champ <b><?php echo $obl; ?></b> est obligatoire !<br />"; 
		<?php
	}
}
?>

texte_erreur += "<br />";
<?php
if (count($_ALERTES)) {
?>
	window.parent.alerte.alerte_erreur ('Erreur', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	<?php
}else{
	?>
	window.parent.changed = false;
	window.parent.alerte.alerte_erreur ('Etape 2', "Correspondances des informations avec LMB effectuée",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	window.parent.page.verify('import_tarifs_fournisseur_csv_step2','import_tarifs_fournisseur_csv_step2.php','true','sub_content');
	<?php
};
?>
</script>