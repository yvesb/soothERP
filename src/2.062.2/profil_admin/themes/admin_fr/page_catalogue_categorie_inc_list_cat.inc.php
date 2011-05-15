	
<span class="sous_titre2">Cat&eacute;gories</span>


<div class="menu">
<table cellpadding="0" cellspacing="0"  id="racine" style="width:96%">
	<tr id="tr_racine" class="list_art_categs"><td width="2px"></td>
	<td>
		<a href="#" class="" id="racine" title="Inserer une cat&eacute;gorie &agrave; la racine" style="display:block; width:100%">Racine</a>
		</td><td width="15px">
		<a href="#" class="" id="ins_racine" title="Inserer une cat&eacute;gorie &agrave; la racine"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
		</a> 
			</td></tr></table></div>
<div id="liste_de_categorie" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">

			<div id="liste_de_categorie_selectable" >
<?php
	$list_art_categ =	get_articles_categories();
	while ($art_categ = current($list_art_categ) ){
	

next($list_art_categ);
?>
	
	<table cellpadding="0" cellspacing="0"  id="<?php echo ($art_categ->ref_art_categ)?>" style="width:96%">
	<tr id="tr_<?php echo ($art_categ->ref_art_categ)?>" class="list_art_categs"><td width="5px">
		<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
		<?php 
		for ($i=0; $i<=$art_categ->indentation; $i++) {
			if ($i==$art_categ->indentation) {
			 
				if (key($list_art_categ)!="") {
					if ($art_categ->indentation < current($list_art_categ)->indentation) {
						
					?><a href="#" id="link_div_art_categ_<?php echo $art_categ->ref_art_categ?>">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="extend_<?php echo $art_categ->ref_art_categ?>"/>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="collapse_<?php echo $art_categ->ref_art_categ?>" style="display:none"/></a>
					<script type="text/javascript">
					Event.observe("link_div_art_categ_<?php echo $art_categ->ref_art_categ?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $art_categ->ref_art_categ?>') ; Element.toggle('extend_<?php echo $art_categ->ref_art_categ?>'); Element.toggle('collapse_<?php echo $art_categ->ref_art_categ?>');}, false);
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
		<a href="#" id="mod_<?php echo ($art_categ->ref_art_categ)?>" style="display:block; width:100%">
				
			<?php echo htmlentities($art_categ->lib_art_categ); if (!$art_categ->lib_art_categ) { echo "Pas de libellé";}?>
		</a>
		</td><td width="15px">
			<a href="#" class="insertion" id="ins_<?php echo ($art_categ->ref_art_categ)?>" title="Inserer une cat&eacute;gorie dans <?php echo htmlentities($art_categ->lib_art_categ)?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
				</a>
			</td></tr></table>
<?php 
if (key($list_art_categ)!="") {
	if ($art_categ->indentation < current($list_art_categ)->indentation) {
		echo '<div id="div_'.$art_categ->ref_art_categ.'" style="">';
	}
	
	
	if ($art_categ->indentation > current($list_art_categ)->indentation) {
					for ($a=$art_categ->indentation; $a>current($list_art_categ)->indentation ; $a--) {
					echo '</div>';
				}
	}
}

}
?>
	</div>
	
	
</div>
<script type="text/javascript">

	Event.observe('tr_racine', 'mouseover',  function(){changeclassname ('tr_racine', 'list_art_categs_hover');changeclassname ('ins_racine', 'insertion_hover');}, false);
	Event.observe('tr_racine', 'mouseout',  function(){changeclassname ('tr_racine', 'list_art_categs');changeclassname ('ins_racine', 'insertion');}, false);
	
	
		Event.observe('ins_racine', 'click',  function(evt){Event.stop(evt); page.verify('art_categs_add', 'catalogue_categorie_inc_add.php?ref_art_categ_parent=&lib_art_categ_parent=Racine', 'true', 'content_art_categs');}, false);
	
	Event.observe('racine', 'click',  function(evt){Event.stop(evt); page.verify('art_categs_add', 'catalogue_categorie_inc_add.php?ref_art_categ_parent=&lib_art_categ_parent=Racine', 'true', 'content_art_categs');}, false);

	
<?php
	foreach ($list_art_categ  as $art_categ){
?>
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs_hover');changeclassname ('ins_<?php echo ($art_categ->ref_art_categ)?>', 'insertion_hover');}, false);
	
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs');changeclassname ('ins_<?php echo ($art_categ->ref_art_categ)?>', 'insertion');}, false);
	
	Event.observe('ins_<?php echo ($art_categ->ref_art_categ)?>', 'click',  function(evt){Event.stop(evt); page.verify('art_categs_add', 'catalogue_categorie_inc_add.php?ref_art_categ_parent=<?php echo ($art_categ->ref_art_categ)?>&lib_art_categ_parent=<?php echo urlencode($art_categ->lib_art_categ)?>', 'true', 'content_art_categs');}, false);
	
	Event.observe('mod_<?php echo ($art_categ->ref_art_categ)?>', 'click',  function(evt){Event.stop(evt); page.verify('art_categs_mod', 'catalogue_categorie_inc_mod.php?ref_art_categs=<?php echo ($art_categ->ref_art_categ)?>', 'true', 'content_art_categs');}, false);


<?php 
	}
?>

function setheight_catalogue_categorie_inc_list_cat(){
set_tomax_height("liste_de_categorie" , -55);
set_tomax_height("liste_de_categorie_selectable" , -55);

}

Event.observe(window, "resize", setheight_catalogue_categorie_inc_list_cat, false);

setheight_catalogue_categorie_inc_list_cat();

//on masque le chargement
H_loading();
</script>