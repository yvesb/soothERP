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
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('<?php echo $import_annuaire_csv['menu_admin'][1][0];?>','<?php echo $import_annuaire_csv['menu_admin'][1][1];?>','<?php echo $import_annuaire_csv['menu_admin'][1][2];?>','<?php echo $import_annuaire_csv['menu_admin'][1][3];?>', "<?php echo $import_annuaire_csv['menu_admin'][1][4];?>");
update_menu_arbo();
</script>
<div class="emarge">


<p class="titre">Import de fichier contact format CSV</p>
<div>

<?php
if ($import_annuaire->getEtape() == "2") {
	?>
	Un précédent import non terminé a été détecté.<br />
	Souhaitez vous reprendre l'import des données concernées?  <span id="reprendre_import" style="cursor:pointer; font-weight:bolder"> Reprendre l'import</span>
	<script type="text/javascript">
	Event.observe('reprendre_import', "click", function(evt){
		page.verify('<?php echo $import_annuaire_csv['menu_admin'][1][0];?>','modules/<?php echo $import_annuaire_csv['folder_name']?>import_annuaire_csv_step2.php','true','sub_content');  
		Event.stop(evt);
	});
	</script><br /><br />


	<?php 
}
?>
<form action="modules/import_annuaire_csv/import_annuaire_csv_done.php" enctype="multipart/form-data" method="POST" id="import_annuaire_csv_done" name="import_annuaire_csv_done" target="formFrame" class="classinput_nsize" />

<table class="contactview_corps">
	<tr>
		<td>
		<span style="width:280px; text-align: left; float:left">Indiquez l'emplacement de votre fichier:</span> 
		<input type="file" size="35" name="fichier_csv" class="classinput_nsize" />	
		</td>
		<td>
		<span style="width:280px; text-align: left; float:left">Indiquez le type de contact à importer:</span> 
		<select name="profil_import" id="profil_import" class="classinput_nsize">
		<option value="">Contacts simples</option>
		<option value="<?php echo $CLIENT_ID_PROFIL; ?>">Contacts Clients</option>
		<option value="<?php echo $FOURNISSEUR_ID_PROFIL; ?>">Contacts Fournisseurs</option>
		<option value="<?php echo $CONSTRUCTEUR_ID_PROFIL; ?>">Contacts Constructeurs</option>
		</select>
		</td>
		<td><br />

		<input type="submit" name="Submit" value="Valider" />
		</td>
	</tr>
</table>
<br />

		<span style="width:380px; text-align: right; float:left">&nbsp;</span> 
		<br />
		<br />
		<span style="font-weight:bolder">L'utilisation de ce module demande des connaissances techniques (utilisation Excel)</span><br />
		
		En cas de besoin n'hésitez pas à contact les équipes de <a href="http://www.lundimatin.fr/site2/contact_ssll.php" target="_blank">LundiMatin</a>
		<br />

	Le fichier dois être au format CSV. (texte séparé par ;)<br />
	Les informations de la première ligne doivent correspondre aux différentes informations des contacts (nom, adresse ect.) sans symbole particulier.<br />
	Idéalement il est recommandé de supprimer les colonnes inutiles.<br />


		<br />
		<br />
		Télecharger <span class="common_link" id="download_exemple">ici</span> un exemple de fichier CSV<br /><br />

		<script type="text/javascript">
		Event.observe('download_exemple', "click", function(evt){
			page.verify('exemple_csv','modules/<?php echo $import_annuaire_csv['folder_name']?>exemple.csv','true','_blank');  
			Event.stop(evt);
		});
		</script>

<br />
<br />

</form>
</div>

<SCRIPT type="text/javascript">
	
//on masque le chargement
H_loading();
</SCRIPT>
</div>