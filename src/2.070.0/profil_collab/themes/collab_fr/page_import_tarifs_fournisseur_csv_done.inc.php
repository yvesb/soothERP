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
?>
<p>Import de tarifs fournisseur (au format CSV) : Etape 0</p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
	var texte = "";
	var erreur = false;
	var titre = "Etape 1";
	<?php
	// Si l'utilisateur a choisi un fichier
	if (!empty($_FILES['fichier_csv']['tmp_name'])) {
		// Si le fichier est vide
		if(isset($GLOBALS['_ALERTES']['import_fichier_vide'])){ ?>
			erreur = true;
			texte += "Votre fichier est vide ! ";
		<?php
		}else{
			// S'il y a trop de colonnes
			if (isset($GLOBALS['_ALERTES']['import_fichier_trop_de_colonnes'])) {?>
				erreur = true;
				texte += "Nombre de colonnes trop important dans votre fichier.<br />Veuillez vérifier le format d'export de votre fichier";
			<?php 
			// Si le nombre de colonnes est ok
			}else{
				?>
				texte += "L'import du fichier <b><?php echo $_FILES['fichier_csv']['name'];?></b> est terminé .<br />";
				<?php 
				// Le nombre de lignes traitées
				if (isset($GLOBALS['_INFOS']['nb_lignes'])) {?>
					texte += "<b><?php echo $GLOBALS['_INFOS']['nb_lignes'];?></b> ligne<?php if($GLOBALS['_INFOS']['nb_lignes'] > 0) echo 's';?> ont été traitées.<br />";
				<?php
				}
				// Si certaines lignes de l'import contiennent des erreurs
				if (isset($GLOBALS['_INFOS']['count_erreur'])) {
					if(!$GLOBALS['_INFOS']['count_erreur']){ ?>
						texte += "<span style='color:#5D5;'><?php echo $GLOBALS['_INFOS']['count_erreur'];?> ligne en erreur lors de l'import.</span><br />";
					<?php }else{?>
						texte += "<span style='color:#F00;'><?php echo $GLOBALS['_INFOS']['count_erreur'];?> ligne<?php if($GLOBALS['_INFOS']['count_erreur'] > 1) echo 's';?> en erreur lors de l'import.</span><br />";
					<?php }?>
				<?php
				}
			}
		}
	// Si l'utilisateur n'a pas choisi de fichier
	}else{
		?>
		erreur = true;
		titre = 'Etape 0';
		texte = 'Veuillez choisir un fichier !';
		<?php
	}
	?>
	window.parent.alerte.alerte_erreur (titre, texte,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	if(!erreur){
		window.parent.changed = false;
		window.parent.page.verify('default_content','import_tarifs_fournisseur_csv_step1.php','true','sub_content');
	}
</script>