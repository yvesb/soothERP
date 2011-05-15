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
<div class="emarge">

<p class="titre">Création d'Article </p>
	<table class="minimizetable"><tr><td style="width:300px">
<div id="list_art_categs">
<select>
<option value="">Racine</option>
<?php
	$list_art_categ =	get_articles_categories();
	foreach ($list_art_categ  as $art_categ){
?>
<option value="<?php echo ($art_categ->ref_art_categ)?>"><?php echo htmlentities($art_categ->lib_art_categ)?></option>
<?php
}
?>
</select>
</div>
</td><td>
<div id="content_art_categs">



</div>
</td></tr></table>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>