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
array_menu_taches	=	new Array();
array_menu_taches[1] 	=	new Array('nouvelle_tache_content', 'menu_2');
array_menu_taches[2] 	=	new Array('taches_crees_content', 'menu_3');
</script>
<div class="emarge">
<div style="height:50px">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div>
<ul id="menu_recherche" class="menu">
	<li id="doc_menu_2">
		<a href="#" id="menu_2" class="menu_select">Nouvelles t&acirc;ches</a>
	</li>
	<li id="doc_menu_3">
		<a href="#" id="menu_3" class="menu_unselect">T&acirc;ches cr&eacute;&eacute;es</a>
	</li>
</ul>
</div>


<div id="nouvelle_tache_content" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; height:350px; ">
<?php 
include $DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_nouvelle.inc.php";
?>
</div>

<div id="taches_crees_content" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:none; height:350px;">
</div>


</div>
</div>


<SCRIPT type="text/javascript">

function setheight_taches(){
set_tomax_height('nouvelle_tache_content' , -32); 
set_tomax_height('taches_crees_content' , -32); 
}
Event.observe(window, "resize", setheight_taches, false);
setheight_taches();

//actions du menu
Event.observe('menu_2', "click", function(evt){
	view_menu_1('nouvelle_tache_content', 'menu_2', array_menu_taches);  
	set_tomax_height('nouvelle_tache_content' , -32);
	$("taches_crees_content").innerHTML="";
	page.verify("planning_taches_nouvelle","planning_taches_nouvelle.php","true","nouvelle_tache_content");
	Event.stop(evt);
});

Event.observe('menu_3', "click", function(evt){
	view_menu_1('taches_crees_content', 'menu_3', array_menu_taches);  
	set_tomax_height('taches_crees_content' , -32);
	page.verify("planning_taches_crees_liste","planning_taches_crees_liste.php","true","taches_crees_content");
	Event.stop(evt);
});


//centrage du mini_moteur

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});


//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>