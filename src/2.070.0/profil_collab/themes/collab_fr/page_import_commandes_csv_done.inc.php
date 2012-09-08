<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
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
echo 'jsfdlkqfjdsmfj';

?>
<script type="text/javascript">
	var texte = "";
	var erreur = false;
	var titre = "Etape 1";
	<?php 
	
	// Si l'utilisateur a choisi un fichier
	if (!empty($_FILES['fichier_csv']['tmp_name'])) {
		
		$erreurs = $import_commandes->getErreurs();
		if(empty($erreurs)){ 
			?>
			var nb_lignes = <?php echo $import_commandes->getNb_lignes(); ?>;
			texte += "L'analyse du fichier <b><?php echo $_FILES['fichier_csv']['name'];?></b> est terminé .<br />";
			texte += "<b>"+nb_lignes+"</b> ligne";
			if(nb_lignes > 0){ texte += "s"; }
			texte += " ont été traitées.<br />";
			<?php 
		}else{
			foreach($erreurs as $erreur){
				?>
				texte += "<?php echo $erreur;?><br />";
				<?php 
			}
		}

	// Si l'utilisateur n'a pas choisi de fichier
	}else{
		?>
		erreur = true;
		titre = 'Erreur';
		texte = 'Veuillez choisir un fichier !';
		<?php
	}
	?>
	window.parent.alerte.alerte_erreur (titre, texte,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

	//redirection vers l'etape suivante
	if(!erreur){
		window.parent.changed = false;
		window.parent.page.verify('default_content','import_commandes_csv_step1.php','true','sub_content');
	}
</script>
