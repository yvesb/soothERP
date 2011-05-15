<?php

// *************************************************************************************************************
// CHOIX DES CATEGORIES POUR UN INVENTAIRE
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

<div>
Sélectionner les catégories d'articles concernées par l'inventaire
<form action="" method="post" id="creer_document_inventaire" name="creer_document_inventaire" target="formFrame" >
ou faire un <span id="inventaire_complet" style="cursor:pointer; text-decoration:underline" title="générer un inventaire comportant toutes les catégories">Inventaire complet</span>
<table style="">
	<tr class="smallheight">
		<td>
		
<table cellpadding="0" cellspacing="0"  id="" style="">
<tr id="" class="list_art_categs">
	<td width="5px">
	</td>
	<td width="350px">
	<div style="display:block; font-weight:bolder">
	Catégories
	</div>
	</td>
	<td width="1px">
	</td>
	<td width="180px">
	<div style="display:block; font-weight:bolder">
	Constructeurs
	</div>
	</td>
	<td style="width:50px">
	</td>
	</tr>
</table>
			<div id="liste_de_categorie_selectable" >
		<?php
$indentation_case_a_cocher = 0;
while ($art_categ = current($list_art_categ) ){
next($list_art_categ);
?>

<table cellpadding="0" cellspacing="0"  id="<?php echo ($art_categ->ref_art_categ)?>" style="">
<tr id="tr_inv_<?php echo ($art_categ->ref_art_categ)?>" class="list_art_categs">
	<td width="5px">
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
	</tr>
	</table>
	</td>
	<td width="350px">
	<div style="display:block;">
		<?php echo str_replace(" ", "&nbsp;", htmlentities($art_categ->lib_art_categ));?>
	</div>
	</td>
	<td width="1px">
		<a href="#" class="insertion" id="ins_inv_<?php echo ($art_categ->ref_art_categ)?>" title="Inserer une cat&eacute;gorie dans <?php echo htmlentities($art_categ->lib_art_categ)?>"></a>
		</td>
			<td width="180px">
			<div style="width:180px; text-align: center">
			
				<select name="ref_constructeur_<?php echo $indentation_case_a_cocher?>" id="ref_constructeur_<?php echo $indentation_case_a_cocher;?>" class="classinput_xsize"><option value="">Tous</option></select>
				<script type="text/javascript">
				
				Event.observe('ref_constructeur_<?php echo $indentation_case_a_cocher;?>', "click", function(evt){
					if ($("ref_constructeur_<?php echo $indentation_case_a_cocher;?>").innerHTML == "<option value=\"\">Tous</option>") {
						var constructeurUpdater = new SelectUpdater("ref_constructeur_<?php echo $indentation_case_a_cocher;?>", "constructeurs_liste.php?ref_art_categ=<?php echo $art_categ->ref_art_categ;?>");
						constructeurUpdater.run("");
					}
				});
				</script>
				</div>
			</td>
			<td width="50px">
			<div style="width:50px; text-align: center">
				<input type="checkbox" id="ins_art_<?php echo $indentation_case_a_cocher?>" name="ins_art_<?php echo $indentation_case_a_cocher?>" value="<?php echo $art_categ->ref_art_categ;?>" />
				
			</div>
			</td>
	</tr>
</table>
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

$indentation_case_a_cocher ++;
}
?>
			
			
			
			</td>
		</tr><tr>
		<td>
		<table cellpadding="0" cellspacing="0" style="">
			<tr>
				<td width="5px">
				<table cellpadding="0" cellspacing="0" width="5px">
					<tr>
					<td>
				
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td>
					<td>
					</td>
					</tr>
					</table>
					</td>
					<td width="350px">
					</td>
					<td width="15px">
					</td>
						<td width="180px">
						<div style="display:block; width:180px; text-align: center">
							<span id="coche_all" style="cursor:pointer">Tout cocher</span><br />
							<span id="decoche_all" style="cursor:pointer">Tout décocher</span>
							<script type="text/javascript">
							Event.observe('coche_all', 'click',  function(evt){
								add_all_art_categ_to_inv (<?php echo $indentation_case_a_cocher?>);
							}, false);
							Event.observe('decoche_all', 'click',  function(evt){
								del_all_art_categ_to_inv (<?php echo $indentation_case_a_cocher?>);
							}, false);
							</script>
							</div>
						</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
 <input type="checkbox" name="pre_remplir" id="pre_remplir" value="1"/>	Pré-remplir le document
<br /><br />

<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" name="Submit"


<input type="hidden" name="inv_ref_doc" id="inv_ref_doc" value="<?php echo $_REQUEST["ref_doc"];?>" />
</form><br />
<br />
<br />
<br />


<SCRIPT type="text/javascript">

Event.observe('creer_document_inventaire', "submit", function(evt){page.documents_inventaire();  
	Event.stop(evt);});
	
	
Event.observe('inventaire_complet', "click", function(evt){
	add_all_art_categ_to_inv (<?php echo $indentation_case_a_cocher?>);
	page.documents_inventaire();  
	Event.stop(evt);
	}
);
	
								

<?php
	foreach ($list_art_categ  as $art_categ){
?>
	Event.observe('tr_inv_<?php echo ($art_categ->ref_art_categ)?>', 'mouseover',  function(){changeclassname ('tr_inv_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs_hover');}, false);
	
	Event.observe('tr_inv_<?php echo ($art_categ->ref_art_categ)?>', 'mouseout',  function(){changeclassname ('tr_inv_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs');}, false);
	
<?php 
	}
?>
//on masque le chargement
//H_loading();
</SCRIPT>
</div>