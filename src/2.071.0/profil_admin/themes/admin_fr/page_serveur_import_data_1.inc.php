
<p class="titre">Import du catalogue <?php echo $import_serveur->getLib_serveur_import();?></p>

<div style="text-align:center"><span style="cursor:pointer" id="maj_art_categ">Mettre à jour les catégories déjà importées</span></div>
<script type="text/javascript">
	Event.observe('maj_art_categ', 'click',  function(evt){
		Event.stop(evt); 
		page.traitecontent('serveur_import_data_1_maj','serveur_import_data_1_maj.php?ref_serveur=<?php echo htmlentities($import_serveur->getRef_serveur_import ());?>','true','sub_content');
	}, false);
	</script>
<table class="minimizetable"><tr><td style="width:300px">
<div id="list_art_categs">
<span class="sous_titre2">Cat&eacute;gories Disponibles</span>
<div id="liste_de_categorie" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">

<div id="liste_de_categorie_selectable" >
<?php
	while ($art_categ = current($list_art_categ) ){
next($list_art_categ);
	$current_list_art_categ = current($list_art_categ);
	//comparaison avec les categ deja présentes
	$exist_categ = true;
	foreach ($presentes_art_categ as $p_art_categ) {
		if ($art_categ["REF_ART_CATEG"] == $p_art_categ->ref_art_categ) {
			$exist_categ = false;
		}
	}
?>

	
	<table cellpadding="0" cellspacing="0"  id="<?php echo ($art_categ["REF_ART_CATEG"])?>" style="width:99%">
	<tr id="tr_<?php echo ($art_categ["REF_ART_CATEG"])?>" class="list_art_categs" <?php 
	if (!$exist_categ) { echo 'style="background-color:#FFEDFE;"';	}?>><td width="5px">
		<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
		<?php 
		for ($i=0; $i<=$art_categ["indentation"]; $i++) {
			if ($i==$art_categ["indentation"]) {
			 
				if (key($list_art_categ)!="") {
					if ($art_categ["indentation"] < $current_list_art_categ["indentation"]) {
						
					?><a href="#" id="link_div_art_categ_<?php echo $art_categ["REF_ART_CATEG"]?>">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="extend_<?php echo $art_categ["REF_ART_CATEG"]?>"/>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="collapse_<?php echo $art_categ["REF_ART_CATEG"]?>" style="display:none"/></a>
					<script type="text/javascript">
					Event.observe("link_div_art_categ_<?php echo $art_categ["REF_ART_CATEG"]?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $art_categ["REF_ART_CATEG"]?>') ; Element.toggle('extend_<?php echo $art_categ["REF_ART_CATEG"]?>'); Element.toggle('collapse_<?php echo $art_categ["REF_ART_CATEG"]?>');}, false);
					</script>
					<?php
					}
					else 
					{
					?>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
					<?php
					}
				}
				else 
				{
				?>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
				<?php
				}
			}
			else
			{
		?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td><td>
		<?php 
			}
		}
		?></td>
		</tr></table>
		</td><td>
		<span id="mod_<?php echo ($art_categ["REF_ART_CATEG"])?>" style="display:block; width:100%">
				
			<?php echo urldecode($art_categ["LIB_ART_CATEG"])?>
		</span>
		</td><td width="15px">
			<a href="#" class="insertion" id="ins_<?php echo ($art_categ["REF_ART_CATEG"])?>" title="Importer cette cat&eacute;gorie "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
				</a>
			</td></tr></table>
<?php 
if (key($list_art_categ)!="") {
	if ($art_categ["indentation"] < $current_list_art_categ["indentation"]) {
		echo '<div id="div_'.$art_categ["REF_ART_CATEG"].'" style="">';
	}
	
	
	if ($art_categ["indentation"] > $current_list_art_categ["indentation"]) {
					for ($a=$art_categ["indentation"]; $a>$current_list_art_categ["indentation"] ; $a--) {
					echo '</div>';
				}
	}
}

}
?><br />
	</div>
	
</div>
<script type="text/javascript">

<?php
$indentation_array = 0;
foreach ($list_art_categ  as $art_categ){
	//comparaison avec les categ deja présentes
	$exist_categ = true;
	foreach ($presentes_art_categ as $p_art_categ) {
		if ($art_categ["REF_ART_CATEG"] == $p_art_categ->ref_art_categ) {
			$exist_categ = false;
		}
	}
	if ($exist_categ) {	
	?>
		array_groupe_carac_<?php echo $indentation_array;?> = new Array();
		<?php
		foreach ($import_art_categs_carac_groupe as $carac_groupe) {
			if ($carac_groupe["REF_ART_CATEG"] == $art_categ["REF_ART_CATEG"]) {
				?>
				array_groupe_carac_<?php echo $indentation_array;?>.push(new Array( "<?php echo $carac_groupe["REF_CARAC_GROUPE"];?>", "<?php echo urlencode($carac_groupe["LIB_CARAC_GROUPE"]);?>", "<?php echo urlencode($carac_groupe["ORDRE"]);?>"));
				<?php
			}
		}
		?>
		array_carac_<?php echo $indentation_array;?> = new Array();
		<?php
		foreach ($import_art_categs_carac as $carac) {
			if ($carac["REF_ART_CATEG"] == $art_categ["REF_ART_CATEG"]) {
				?>
				array_carac_<?php echo $indentation_array;?>.push(new Array("<?php  echo $carac["REF_CARAC"];?>", "<?php  echo urlencode($carac["LIB_CARAC"]);?>", "<?php  echo urlencode($carac["UNITE"]);?>", "<?php  echo urlencode($carac["ALLOWED_VALUES"]);?>", "<?php  echo urlencode($carac["DEFAULT_VALUE"]);?>", "<?php  echo ($carac["MOTEUR_RECHERCHE"]);?>", "<?php  echo urlencode($carac["VARIANTE"]);?>", "<?php  echo urlencode($carac["AFFICHAGE"]);?>", "<?php  echo urlencode($carac["REF_CARAC_GROUPE"]);?>", "<?php  echo urlencode($carac["ORDRE"]);?>"));
				<?php
			}
		}
		?>
	Event.observe('tr_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'list_art_categs_hover');changeclassname ('ins_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'insertion_hover');}, false);
	
	Event.observe('tr_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'list_art_categs');changeclassname ('ins_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'insertion');}, false);
	
	Event.observe('ins_<?php echo ($art_categ["REF_ART_CATEG"])?>', 'click',  function(evt){
		Event.stop(evt); 
		import_art_categ("<?php echo ($art_categ["REF_ART_CATEG"])?>", "<?php echo urlencode($art_categ["LIB_ART_CATEG"])?>", "<?php echo ($art_categ["MODELE"])?>", "<?php echo ($art_categ["DESC_ART_CATEG"])?>", "<?php echo ($art_categ["DEFAUT_ID_TVA"])?>", "<?php echo ($art_categ["DUREE_DISPO"])?>", "<?php echo ($art_categ["REF_ART_CATEG_PARENT"])?>", array_groupe_carac_<?php echo $indentation_array;?>, array_carac_<?php echo $indentation_array;?>);
	}, false);


	<?php 
	}
$indentation_array ++;
}
?>

function setheight_catalogue_categorie_inc_list_cat(){
set_tomax_height("liste_de_categorie" , -85);
set_tomax_height("liste_de_categorie_selectable" , -85);

}

Event.observe(window, "resize", setheight_catalogue_categorie_inc_list_cat, false);

setheight_catalogue_categorie_inc_list_cat();

//on masque le chargement
H_loading();
</script>
</div>
</td><td>
<div id="content_art_categs">



</div>
</td></tr>
<tr><td>
<span style="background-color:#FFEDFE; height:25px; width:25px; border:1px solid #333333 ">&nbsp;&nbsp;&nbsp;</span> catégories déjà importées
</td><td>
	<br />

</td></tr></table>