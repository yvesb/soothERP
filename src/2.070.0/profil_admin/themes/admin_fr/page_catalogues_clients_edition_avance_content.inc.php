<?php

// *************************************************************************************************************
// GESTION AVANCEE DU CONTENU DES CATALOGUES CLIENTS (AFFICHAGE DES CATEGORIES)
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
<div >
<table class="minimizetable">
	<tr>
		<td style="width:300px">
		<div id="list_catalogues_client_dir">
		<span class="sous_titre2">Cat&eacute;gories</span>


		<div class="menu">
		<table cellpadding="0" cellspacing="0"  id="racine" style="width:96%">
			<tr id="tr_racine" class="list_art_categs"><td width="2px"></td>
			<td>
				<a href="#" class="" id="racine" title="Inserer une cat&eacute;gorie &agrave; la racine" style="display:block; width:100%">Racine</a>
				</td><td width="15px">
				<a href="#" class="" id="ins_racine" title="Inserer une cat&eacute;gorie &agrave; la racine"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
				</a> 
					</td></tr></table>
		</div>
		<div id="liste_de_categorie" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">
		<div id="liste_de_categorie_selectable" >
		<?php
			while ($catalogue_dir = current($list_catalogue_dir) ){
			
		
		next($list_catalogue_dir);
		?>
			
			<table cellpadding="0" cellspacing="0"  id="<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" style="width:96%">
			<tr id="tr_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" class="list_art_categs"><td width="5px">
				<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
				<?php 
				for ($i=0; $i<=$catalogue_dir->indentation; $i++) {
					if ($i==$catalogue_dir->indentation) {
					 
						if (key($list_catalogue_dir)!="") {
							if ($catalogue_dir->indentation < current($list_catalogue_dir)->indentation) {
								
							?><a href="#" id="link_div_art_categ_<?php echo $catalogue_dir->id_catalogue_client_dir?>">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="extend_<?php echo $catalogue_dir->id_catalogue_client_dir?>"/>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="collapse_<?php echo $catalogue_dir->id_catalogue_client_dir?>" style="display:none"/></a>
							<script type="text/javascript">
							Event.observe("link_div_art_categ_<?php echo $catalogue_dir->id_catalogue_client_dir?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $catalogue_dir->id_catalogue_client_dir?>') ; Element.toggle('extend_<?php echo $catalogue_dir->id_catalogue_client_dir?>'); Element.toggle('collapse_<?php echo $catalogue_dir->id_catalogue_client_dir?>');}, false);
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
				<a href="#" id="mod_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" style="display:block; width:100%">
						
					<?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir)?>
				</a>
				</td><td width="15px">
					<a href="#" class="insertion" id="ins_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" title="Inserer une cat&eacute;gorie dans <?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir)?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
						</a>
					</td></tr></table>
		<?php 
		if (key($list_catalogue_dir)!="") {
			if ($catalogue_dir->indentation < current($list_catalogue_dir)->indentation) {
				echo '<div id="div_'.$catalogue_dir->id_catalogue_client_dir.'" style="">';
			}
			
			
			if ($catalogue_dir->indentation > current($list_catalogue_dir)->indentation) {
							for ($a=$catalogue_dir->indentation; $a>current($list_catalogue_dir)->indentation ; $a--) {
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
			
			
			Event.observe('ins_racine', 'click',  function(evt){
			Event.stop(evt); 
			page.verify('catalogues_clients_edition_avance_dir_add', 'catalogues_clients_edition_avance_dir_new.php?id_catalogue_client=<?php echo $_REQUEST["id_catalogue_client"]?>&id_catalogue_client_dir_parent=&lib_catalogue_client_dir=Racine', 'true', 'catalogues_client_dir_edition');
			}, false);
			
			Event.observe('racine', 'click',  function(evt){Event.stop(evt); 
			page.verify('catalogues_clients_edition_avance_dir_add', 'catalogues_clients_edition_avance_dir_new.php?id_catalogue_client=<?php echo $_REQUEST["id_catalogue_client"]?>&id_catalogue_client_dir_parent=&lib_catalogue_client_dir=Racine', 'true', 'catalogues_client_dir_edition');
			}, false);
		
			
		<?php
			foreach ($list_catalogue_dir  as $catalogue_dir){
		?>
			Event.observe('tr_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'list_art_categs_hover');changeclassname ('ins_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'insertion_hover');}, false);
			
			Event.observe('tr_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'list_art_categs');changeclassname ('ins_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'insertion');}, false);
			
			Event.observe('ins_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'click',  function(evt){
			Event.stop(evt); 
			page.verify('catalogues_clients_edition_avance_dir_add', 'catalogues_clients_edition_avance_dir_new.php?id_catalogue_client=<?php echo $_REQUEST["id_catalogue_client"]?>&id_catalogue_client_dir_parent=<?php echo ($catalogue_dir->id_catalogue_client_dir)?>&lib_catalogue_client_dir=<?php echo urlencode($catalogue_dir->lib_catalogue_client_dir)?>', 'true', 'catalogues_client_dir_edition');
			}, false);
			
			Event.observe('mod_<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'click',  function(evt){Event.stop(evt); page.verify('catalogues_clients_edition_avance_dir_mod', 'catalogues_clients_edition_avance_dir.php?id_catalogue_client_dir=<?php echo ($catalogue_dir->id_catalogue_client_dir)?>', 'true', 'catalogues_client_dir_edition');}, false);
		
		
		<?php 
			}
		?>
		
		function setheight_catalogue_categorie_inc_list_cat(){
		set_tomax_height("list_catalogues_client_dir" , -55);
		set_tomax_height("liste_de_categorie_selectable" , -55);
		}
		
		Event.observe(window, "resize", setheight_catalogue_categorie_inc_list_cat, false);
		
		setheight_catalogue_categorie_inc_list_cat();
		
		</script>
		</div>
		</td>
		<td>
		<div id="catalogues_client_dir_edition">
		</div>
		</td>
	</tr>
</table>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>