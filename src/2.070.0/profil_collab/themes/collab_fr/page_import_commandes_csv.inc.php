<?php 

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<div class="emarge">
	<p class="titre">Import de commandes (au format CSV)</p>
	<div>
	
		<!-- FORMULAIRE D'UPLOAD DU FICHIER CSV-->
		<form action="import_commandes_csv_done.php" 
			enctype="multipart/form-data" method="POST" id="import_commandes_csv_done" 
			name="import_commandes_csv_done" target="formFrame" class="classinput_nsize" />
			<table class="contactview_corps"  style="width:100%;">
				<tr>
					<td>
						<span style="width:280px; text-align: left; float:left;">Indiquez l'emplacement de votre fichier :</span>
						<input type="file" size="35" name="fichier_csv" class="classinput_nsize" />
					</td>
					<td>
						<input type="submit" name="Submit" value="Valider" />
					</td>
				</tr>
			</table>
		</form>
		
		<br />
		<span style="width:380px; text-align: right; float:left">&nbsp;</span> 
		<br />
		<span style="font-weight:bolder">L'utilisation de ce module demande des connaissances techniques (utilisation Excel)</span><br />
		En cas de doute, n'hésitez pas à posez vos questions sur <a href="http://community.sootherp.fr" target="_blank">l'espace d'échange dédié à la communnauté</a>
		<br />
		Le fichier doit être au format CSV. (texte séparé par ;)
		<br />
		Les informations de la première ligne doivent correspondre aux différentes informations des articles (Référence OEM, Référence interne, etc) sans symbole particulier.<br />
		Idéalement il est recommandé de supprimer les colonnes inutiles.
		<br />
		<br />
		<br />
		Télecharger <span class="common_link" id="download_exemple">ici</span> un exemple de fichier CSV
		<br />
		<br />
		<script type="text/javascript">
		Event.observe('download_exemple', "click", function(evt){
			page.verify('exemple_csv', '<?php echo $DIR.$_SESSION['theme']->getDir_theme(); ?>exemple_import_commandes.csv','true','_blank');  
			Event.stop(evt);
		});
		</script>
		
	</div>
	
	<SCRIPT type="text/javascript">
	//on masque le chargement
	H_loading();
	</SCRIPT>
	
</div>
