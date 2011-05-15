<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

//******************************************************************
// Traitement Javascript
//******************************************************************
?>

<?php 
if(is_null($import_commandes)){ ?>
	<script type="text/javascript">
		window.parent.changed = false;
		window.parent.page.verify('default_content','import_commandes_csv.php','true','sub_content');
	</script>
<?php 
}else{ ?>
	<script type="text/javascript">
	
		var texte = "";
		var erreur = false;
		var titre = "Etape 2";
		<?php $erreurs = $import_commandes->getErreurs();
		if(empty($erreurs)){ 
			?>
			texte += "L'import s'est terminé avec succès.<br />";
			<?php 
		}else{
			foreach($erreurs as $erreur){
				?>
				texte += "<?php echo $erreur;?><br />";
				<?php 
			}
		}?>
		window.parent.alerte.alerte_erreur (titre, texte,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
		window.parent.changed = false;
		window.parent.page.verify('default_content','accueil.php','true','sub_content');
	</script> 
<?php } /*	
	?>
	window.parent.alerte.alerte_erreur (titre, texte,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	
	// On masque le chargement
	H_loading();
</script>

<?php 
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

/*
?>

<p class="titre">Renseigner les correspondances</p>
<div>
	Sélectionnez les correspondances entre les informations de LMB et les différentes colonnes de votre fichier CSV.
	
	<form action="import_commandes_csv_step1_done.php" enctype="multipart/form-data" 
			method="POST" id="import_commandes_csv_step1_done" name="import_commandes_csv_step1_done" 
			target="formFrame" style ="margin:20px;" />
		<table>
			<tr>
				<td><span id="lib_type_ref_article">Référence article :</span></td>
				<td><select id="val_type_ref_article" name="val_type_ref_article" >
					<option value="interne" >Référence interne		</option>
					<option value="oem" 	>Référence constructeur	</option>
					<option value="lmb" 	>Référence LMB			</option>
				</select></td>
			</tr>
			<tr>
				<td><span id="lib_categ_client">Catégorie client :</span></td>
				<td><select id="val_categ_client" name="val_categ_client" >
					<?php
					contact::load_profil_class($CLIENT_ID_PROFIL);
					$categories  = contact_client::charger_clients_categories();			
					foreach($categories as $categ){
						echo "<option value='".$categ->id_client_categ."' >".$categ->lib_client_categ."</option>";
					}
					?>
				</select></td>
			</tr>
		</table>	
		
		<p>
			<input type="submit" value="Valider les correspondances">
			<input type="reset" value="Annuler" />
		</p>
		
	</form>
	
</div>
*/ ?>


</div>