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
tableau_smenu[0] = Array("smenu_site_internet", "smenu_site_internet.php" ,"true" ,"sub_content", "Interfaces");
tableau_smenu[1] = Array('site_internet_referencement','site_internet_referencement.php','true','sub_content', "Référencement");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Référencement</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="grey_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">
Gérer le référencement de votre site Internet vous permet d'&ecirc;tre plus facilement visible et accessible pour les internautes qui effectuent leurs recherches sur Internet.<br />
<br />
Note importante : Le titre et la description de chacune de vos pages apparaissent dans les résultats de recherche de certains moteurs. Si ces textes sont descriptifs et utiles, les internautes seront plus enclins à cliquer sur votre site. <br />

 Le système d'aide au référencement a détecté les pages suivantes sur votre site. Pour chacune d'entre elle, vous pouvez préciser un titre, une description, et une liste de mots clés.
<br />

En l'absence de ces informations sur une page, le système utilise les valeurs par défaut. <br />

<?php
//on récupère les informations par defaut
$tmp_defaut = get_reference("defaut_referencement");
if (count($tmp_defaut)) {
	$defaut_title 			= $tmp_defaut[0]->titre;
	$defaut_keyword 		= $tmp_defaut[0]->meta_motscles;
	$defaut_description = $tmp_defaut[0]->meta_desc;
} else {
	// si les infos par defaut ne sont pas encore crées 
	// on récupère les information du contact pricipal du site
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom = str_replace ("\r", " ", str_replace("\n", " ",$contact_entreprise->getNom()));
	$defaut_title = $nom." ";
	
	$adresse = "";
	$code = "";
	$ville = "";
	$liste_adresse = $contact_entreprise->getAdresses();
	if (isset($liste_adresse[0])) {
		$adresse = str_replace ("\r", " ", str_replace("\n", " ",$liste_adresse[0]->getText_adresse()));
		$code = $liste_adresse[0]->getCode_postal();
		$ville = $liste_adresse[0]->getVille();
	}
	
	$defaut_keyword = $nom." ".$adresse." ".$code." ".$ville;
	$defaut_description = "Site internet de ".$nom.", ".$adresse." ".$code." ".$ville;
	//et on génére les infos par defaut
	add_reference ("defaut_referencement", $defaut_title, $defaut_description, $defaut_keyword);
}
?>

<div>
<table style="width:100%">
	<tr>
		<td style="width:95%">
			<table style="width:100%">
				<tr class="smallheight">
					<td style="width:100%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td style="text-align:left">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_unvalide.png" class="ico_bt"/><span class="common_link" id="edit_referencement_defaut">Valeurs par défaut</span>
					<script type="text/javascript">
					
					Event.observe('edit_referencement_defaut', "click", function(evt){
							$("pop_up_referencement").style.display = "block";
							
							var AppelAjax = new Ajax.Updater(
								"pop_up_referencement", 
								"site_internet_referencement_details.php", {
								method: 'post',
								asynchronous: true,
								contentType:  'application/x-www-form-urlencoded',
								encoding:     'UTF-8',
								parameters: { nom_fichier: "defaut_referencement" },
								evalScripts:true, 
								onLoading:S_loading, onException: function () {S_failure();}, 
								onComplete:H_loading}
															);
						}
					);

					</script>
					</td>
				</tr>
			</table>
		</td>
		<td style="width:85px; text-align:center">
		</td>
	</tr>
</table>
</div>
<?php
if (isset($pages_referencees)) {
	?>
	<br />
	<div class="white_corps">Pages à référencer</div>
	<br />
	<?php
	$indent = 0;
	foreach ($pages_referencees as $page) {
		if ($page->nom_fichier == "defaut_referencement") {continue;}
		?>
		<div>
			<table style="width:100%">
			<tr>
				<td style="width:95%">
					<table style="width:100%">
						<tr class="smallheight">
							<td style="width:100%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>	
						<tr>
							<td style="text-align:left">
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_<?php if ($page->titre == "") { echo "un";}?>valide.png" class="ico_bt"/>
								<span class="common_link" id="edit_referencement_<?php echo $indent;?>"><?php echo ($page->nom_fichier);?></span>
								<script type="text/javascript">
								
								Event.observe('edit_referencement_<?php echo $indent;?>', "click", function(evt){
										$("pop_up_referencement").style.display = "block";
										
										var AppelAjax = new Ajax.Updater(
											"pop_up_referencement", 
											"site_internet_referencement_details.php", {
											method: 'post',
											asynchronous: true,
											contentType:  'application/x-www-form-urlencoded',
											encoding:     'UTF-8',
											parameters: { nom_fichier: "<?php echo $page->nom_fichier;?>" },
											evalScripts:true, 
											onLoading:S_loading, onException: function () {S_failure();}, 
											onComplete:H_loading}
																		);
									}
								);

								</script>
							</td>
							<td>
							
							<a href="#" id="link_del_referencement_<?php echo $indent;?>" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" title="Supprimer cette page du référencement"></a>
							
							<form action="site_internet_referencement_del.php" method="post" id="site_internet_referencement_del_<?php echo $indent;?>" name="site_internet_referencement_del_<?php echo $indent;?>" target="formFrame" >
							<input name="nom_fichier" id="nom_fichier" type="hidden" value="<?php echo ($page->nom_fichier);?>"/>
							</form>
							<script type="text/javascript">
							Event.observe("link_del_referencement_<?php echo $indent;?>", "click",  function(evt){Event.stop(evt); 
								$("pop_up_referencement").style.display = "none";
								$("site_internet_referencement_del_<?php echo $indent;?>").submit();
							}, false);
							</script>
							</td>
						</tr>
					</table>
				</td>
				<td style="width:85px; text-align:center">
				</td>
			</tr>
		</table>
		</div>
		<?php 
		$indent++;
		}
	?>
	<?php 
}
?>

</div>
</td>
</tr>
</table>
<div id="pop_up_referencement" class="edition_referencement">
</div>
<SCRIPT type="text/javascript">


//centrage ionventaire article
centrage_element("pop_up_referencement");
Event.observe(window, "resize", function(evt){
centrage_element("pop_up_referencement");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>