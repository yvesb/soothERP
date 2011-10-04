<?php

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


?>

<div id="pop_up_options" class="lines_info_modeles_doc">

	<!-- Bouton pour fermer la page sans sauvegarder -->
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fermer.gif" id="close_courrier_options" class="bt_fermer_popup" alt="Fermer" title="Fermer" />
	<SCRIPT type="text/javascript">
		Event.observe("close_courrier_options", "click", function(evt){
			Event.stop(evt);
			$("pop_up_options").style.display = "none";
			//$("articles_lies").innerHTML ="";
			//$("calcul_qte").innerHTML ="";
			//$("calcul_prix").innerHTML ="";
			}, false);
	</script>

	<div class="div_titre_popup" >
		<table width="100%">
				<tr>
					<td style="width:3%"></td>
					<td style="width:94%;" class="label_titre_popup" >Options</td>
					<td style="width:3%"></td>
				</tr>
		</table>
	</div>
	
	<br />
	<br />
	
	<script type="text/javascript" language="javascript">
		array_menu_doc_lines	=	new Array();
		array_menu_doc_lines[0] 	=	new Array('articles_lies', 'menu_popup_1');
		array_menu_doc_lines[1] 	=	new Array('calcul_qte', 'menu_popup_2');
		array_menu_doc_lines[2] 	=	new Array('calcul_prix', 'menu_popup_3');
	</script>
	
	<div>
		<ul id="menu_options" class="menu">
		<li><a href="#" id="menu_popup_1" class="menu_select">Articles li&eacute;s</a></li>
		<li><a href="#" id="menu_popup_2" class="menu_unselect">Calcul de Qt&eacute;</a></li>
		<li><a href="#" id="menu_popup_3" class="menu_unselect">Calcul de prix</a></li>
		</ul>
	</div>

	<div>
		<!-- Ongelt : Articles liés -->
		<!-- DIV mise à jour par _documents.js > maj_pop_up_link -->
		<div id="articles_lies">
			<div id="link_content" class="articletview_corps" style="overflow:auto; height:285px">
			</div>
		</div>
		
		<!-- Onglet : Calcul de Qté -->
		<!-- DIV mise à jour par _documents.js > maj_pop_up_calcul_qte -->
		<div id="calcul_qte"  style="display:none;" class="menu_link_affichage">
		</div>
		
		<!-- Onglet : Calcul de prix -->
		<!-- DIV mise à jour par _documents.js > maj_pop_up_calcul_prix -->
		<div id="calcul_prix"  style="display:none;" class="menu_link_affichage">
		</div>
		
	</div>
</div>

<SCRIPT type="text/javascript">
	Event.observe("menu_popup_1", "click",  function(evt){Event.stop(evt); view_menu_1('articles_lies', 'menu_popup_1', array_menu_doc_lines );}, false);
	Event.observe("menu_popup_2", "click",  function(evt){Event.stop(evt); view_menu_1('calcul_qte', 'menu_popup_2', array_menu_doc_lines );}, false);
	//@TODO CALCUL PRIX : Script pour gérer l'onglet "Calcul de prix"
	//Event.observe("menu_popup_3", "click",  function(evt){Event.stop(evt); view_menu_1('calcul_prix', 'menu_popup_3', array_menu_doc_lines );}, false);


	//centrage de la pop up
	centrage_element("pop_up_options");
	
	Event.observe(window, "resize", function(evt){
		centrage_element("pop_up_options");
	});
	
	//on masque le chargement
	H_loading();
</SCRIPT>