<?php

// *************************************************************************************************************
// FENÊTRE D'AFFICHAGE DES NUMÉROS DE SÉRIE D'UNE LIGNE D'ARTICLE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>
<script type="text/javascript" language="javascript">
</script>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_mini_article_sn_iframe" class="mini_pop_up_article_sn_iframe"></iframe>
<div id="pop_up_mini_article_sn" class="mini_pop_up_article_sn">
	<div id="" class="corps_mini_pop_up_article_sn">
		<a href="#" id="link_close_mini_pop_up_article_sn" style="float:right">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
		</a>
		<script type="text/javascript">
		Event.observe("link_close_mini_pop_up_article_sn", "click",  function(evt){Event.stop(evt); close_mini_pop_up_article_sn();}, false);
		</script>
		<div style="font-weight:bolder">édition des numéros de série </div>
	</div>

<div id="resultat_article_sn" style="overflow:auto; height:355px; width:100%"></div>

<SCRIPT type="text/javascript">


//on masque le chargement
H_loading();
</SCRIPT>
</div>