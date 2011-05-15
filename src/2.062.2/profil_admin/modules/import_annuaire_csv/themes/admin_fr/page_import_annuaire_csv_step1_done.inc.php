<?php
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
<?php 
//raz des css champs alerte

foreach ($_POST as $k => $v){
            {?>
                window.parent.document.getElementById("<?php echo $k;?>").className="classinput_lsize";
                <?php
            }
}


//traitement doublons colones
if (isset($array_verif_doublon)) {
	foreach ($array_verif_doublon as $ck=>$alt) {
		if (count($alt)<2) {continue;}
		
		?>
		texte_erreur += window.parent.document.getElementById("<?php echo  $alt[0];?>").options[<?php echo $ck-1;?>].text+" utilisé dans:<br />";
		<?php	
		foreach ($alt as $alerte => $value) {
			?>
			window.parent.document.getElementById("<?php echo str_replace(" ", "_", $value);?>").className="alerteform_lsize";
			texte_erreur += 	"<b>"+window.parent.document.getElementById("lib_champ_<?php echo $value;?>").innerHTML.replace(":","")+"</b>, ";
			<?php 
			$GLOBALS['_ALERTES']['doublons'] = 1;
		} 
		?>
		texte_erreur += "<br />";
		<?php
	}
}
?>
texte_erreur += "<br />";
<?php
//traitement doublons valeurs.

if (isset($array_verif_corresp_doublon)) {
	foreach ($array_verif_corresp_doublon as $alt=>$hd) {
		foreach ($hd as $alerte => $value) {
		if (count($value)<2) {continue;}
			?>
			texte_erreur += "Doublon de valeur pour "+window.parent.document.getElementById("lib_champ_<?php echo  $alt;?>").innerHTML+" <b> <?php echo $alerte;?></b><br />";
			<?php	
			foreach ($value as $value1) {
				?>
				window.parent.document.getElementById("<?php echo $value1;?>").className="alerteform_lsize";
				window.parent.document.getElementById("correspondances_<?php echo $alt;?>").style.display="";
				window.parent.document.getElementById("v_correspondances_<?php echo $alt;?>").style.display="none";
				window.parent.document.getElementById("unv_correspondances_<?php echo $alt;?>").style.display="";
				texte_erreur += "<br />";
				<?php 
				$GLOBALS['_ALERTES']['doublons'] = 1;
			}
		} 
	}
}
?>
<?php 
if (count($_ALERTES)) {
	if (isset($_ALERTES['flagChampNomObigatoire'])) {
		
			?>
				window.parent.document.getElementById("nom").className="alerteform_lsize";
			texte_erreur += "<br /><b>Au moins une correspondance dois être attribuée au nom du contact.</b><br />";
			<?php	
	}
	?>
	texte_erreur += "<br />";
	window.parent.alerte.alerte_erreur ('Doublons de correspondances', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	<?php
}
else
{
	?>
	window.parent.changed = false;
	window.parent.alerte.alerte_erreur ('Etape 2', "Correspondances des informations avec LMB effectuée",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	window.parent.page.verify('import_annuaire_csv_step2','modules/import_annuaire_csv/import_annuaire_csv_step2.php','true','sub_content');
	<?php
};
?>

</script>
