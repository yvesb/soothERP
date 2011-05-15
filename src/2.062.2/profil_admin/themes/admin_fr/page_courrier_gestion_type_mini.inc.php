<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Formulaire de recherche
?>
<div id="pop_up_mini_moteur_doc_type" class="mini_moteur_doc_type" style="display:none">
	<a href="#" id="close_mini_moteur_doc_type" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	
	<div id="aff_pop_up_mini_moteur_doc_type" style="overflow:auto; height:430px"></div>
	
	<script type="text/javascript">
	Event.observe("close_mini_moteur_doc_type", "click",  function(evt){Event.stop(evt); close_mini_moteur_doc_type();}, false);
		
	//on masque le chargement
	H_loading();
		
	//centrage du mini_moteur
	
	centrage_element("pop_up_mini_moteur_doc_type");
	
	Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_mini_moteur_doc_type");
	});
	</SCRIPT>
</div>