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
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('catalogues_clients','catalogues_clients.php' ,"true" ,"sub_content", "Gestion des catalogues clients");
update_menu_arbo();
array_menu_catalogue_client	=	new Array();
array_menu_catalogue_client[0] 	=	new Array('content_catalogues_clients', 'catalogues_clients_a');
array_menu_catalogue_client[1] 	=	new Array('content_catalogues_clients', 'catalogues_clients_b');
array_menu_catalogue_client[2] 	=	new Array('content_catalogues_clients', 'catalogues_clients_c');
</script>
<div class="emarge">

<p class="titre">Gestion des catalogues clients </p>
<div id="contactview_menu" class="menu">
<ul id="menu_ul">

<li><a href="#" id="catalogues_clients_a"  class="menu_select">Création des catalogues</a>
</li>
<li><a href="#" id="catalogues_clients_b" class="menu_unselect">Gestion du contenu</a>
</li>
<li><a href="#" id="catalogues_clients_c" class="menu_unselect">Contenu avanc&eacute;</a>
</li>
</ul>
</div>


<div id="content_catalogues_clients" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">



</div>

<SCRIPT type="text/javascript">
	
function setheight_catalogues_clients(){
set_tomax_height("content_catalogues_clients" , -46);
}

Event.observe(window, "resize", setheight_catalogues_clients, false);
setheight_catalogues_clients();


Event.observe("catalogues_clients_a", "click",  function(evt){
	Event.stop(evt); 
	view_menu_1('content_catalogues_clients', 'catalogues_clients_a', array_menu_catalogue_client); 
	page.verify('catalogues_clients_liste','catalogues_clients_liste.php','true','content_catalogues_clients');
	set_tomax_height('content_catalogues_clients' , -46);
}, false);

Event.observe("catalogues_clients_b", "click",  function(evt){
	Event.stop(evt); 
	view_menu_1('content_catalogues_clients', 'catalogues_clients_b', array_menu_catalogue_client); 
	page.verify('catalogues_clients_edition_simple','catalogues_clients_edition_simple.php','true','content_catalogues_clients');
	set_tomax_height('contactview_specifiques' , -46);
}, false);

Event.observe("catalogues_clients_c", "click",  function(evt){
	Event.stop(evt); 
	view_menu_1('content_catalogues_clients', 'catalogues_clients_c', array_menu_catalogue_client); 
	page.verify('catalogues_clients_edition_avance','catalogues_clients_edition_avance.php','true','content_catalogues_clients');
	set_tomax_height('contactview_specifiques' , -46);
}, false);
//on masque le chargement
	page.verify('catalogues_clients_liste','catalogues_clients_liste.php','true','content_catalogues_clients');
H_loading();
</SCRIPT>
</div>