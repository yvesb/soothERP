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
</script>
<a href="#" id="link_close_pop_up_referencement" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_referencement", "click",  function(evt){Event.stop(evt); 
		$("pop_up_referencement").style.display = "none";}, false);
</script>

	<div class="white_corps">
	<?php 
	if ($pages_referencees[0]->nom_fichier == "defaut_referencement") {
		?>
	Valeurs par defaut.<br /><br />
		<?php
	} else {
		?>
		Page selectionnée<br />
		<br />
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" class="ico_bt" style="padding-left:35px"/> <?php echo $pages_referencees[0]->nom_fichier;?>
		<?php
	}
	?>
	</div>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td>
<div >

	<?php
	foreach ($pages_referencees as $page) {
		?>
		<div>
		<form action="site_internet_referencement_mod.php" method="post" id="site_internet_referencement_mod" name="site_internet_referencement_mod" target="formFrame" >
		<span class="bolder">Titre</span><br />
		<input name="nom_fichier" id="nom_fichier" type="hidden" value="<?php echo ($page->nom_fichier);?>"/>
		<input name="titre" id="titre" type="text" value="<?php echo ($page->titre);?>"  class="classinput_xsize" maxlength="100"  />
		<div style="color:#999999"><span id="count_car_titre"></span> caractères sur 100</div>
		<br />
		<span class="bolder">Description de la page</span><br />
		<textarea name="meta_desc" id="meta_desc"  wrap="hard" rows="2" class="classinput_xsize" ><?php echo ($page->meta_desc);?></textarea>
		<div style="color:#999999"><span id="count_car_desc"></span> caractères sur 255</div>
		<br />
		<span class="bolder">Mots clefs</span><br />
		<textarea name="meta_motscles" id="meta_motscles" wrap="hard" rows="7" class="classinput_xsize" ><?php echo ($page->meta_motscles);?></textarea>
		<div style="color:#999999"><span id="count_car_keyword"></span> caractères sur 1000</div>

<br />

		<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
		
		
		</form> 
			
		</div>
		<?php 
		}
	?>
	
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
<?php
foreach ($pages_referencees as $page) {
	?>	
	new Form.EventObserver('site_internet_referencement_mod', function(){formChanged();});
	<?php 
}
?>
//limitation sur le titre
Event.observe("titre", "keypress",  function(evt){
	count_titre = count_car_field("titre");
	if (parseInt(count_titre) >100) {
		Event.stop(evt); 
		count_titre = limit_car_field ("titre", 100);
	}
	$("count_car_titre").innerHTML = count_titre;
}, false);
Event.observe("titre", "blur",  function(evt){
	count_titre = count_car_field("titre");
	if (parseInt(count_titre) >100) {
		Event.stop(evt); 
		count_titre = limit_car_field ("titre", 100);
	}
	$("count_car_titre").innerHTML = count_titre;
}, false);

//limitation des caracteres sur la description
Event.observe("meta_desc", "keypress",  function(evt){
	count_desc = count_car_field("meta_desc");
	if (parseInt(count_desc) >255) {
		Event.stop(evt); 
		count_desc = limit_car_field ("meta_desc", 255);
	}
	$("count_car_desc").innerHTML = count_desc;
}, false);
Event.observe("meta_desc", "blur",  function(evt){
	count_desc = count_car_field("meta_desc");
	if (parseInt(count_desc) >255) {
		Event.stop(evt); 
		count_desc = limit_car_field ("meta_desc", 255);
	}
	$("count_car_desc").innerHTML = count_desc;
}, false);

//limitation des caracteres sur les kyword
Event.observe("meta_motscles", "keypress",  function(evt){
	count_keyword = count_car_field("meta_motscles");
	if (parseInt(count_keyword) >1000) {
		Event.stop(evt); 
		count_keyword = limit_car_field ("meta_motscles", 1000);
	}
	$("count_car_keyword").innerHTML = count_keyword;
}, false);
Event.observe("meta_motscles", "blur",  function(evt){
	count_keyword = count_car_field("meta_motscles");
	if (parseInt(count_keyword) >1000) {
		Event.stop(evt); 
		count_keyword = limit_car_field ("meta_motscles", 1000);
	}
	$("count_car_keyword").innerHTML = count_keyword;
}, false);



count_titre = count_car_field("titre");
$("count_car_titre").innerHTML = count_titre;
count_desc = count_car_field("meta_desc");
$("count_car_desc").innerHTML = count_desc;
count_keyword = count_car_field("meta_motscles");
$("count_car_keyword").innerHTML = count_keyword;
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>