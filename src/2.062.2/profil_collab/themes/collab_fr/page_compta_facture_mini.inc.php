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
<div id="pop_up_compta_facture_mini_moteur" class="mini_moteur_compte_compta" style="display:none; width:750px">
	<a href="#" id="close_compta_facture_mini_moteur" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	
	<div id="compta_facture" style="overflow:auto; height:430px"></div>
	
	<script type="text/javascript">
	Event.observe("close_compta_facture_mini_moteur", "click",  function(evt){Event.stop(evt);
		$("pop_up_compta_facture_mini_moteur").style.display = "none";
	}, false);
		
	//on masque le chargement
	H_loading();
		
	//centrage du mini_moteur
	
	centrage_element("pop_up_compta_facture_mini_moteur");
	
	Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_compta_facture_mini_moteur");
	});
	</SCRIPT>
</div>