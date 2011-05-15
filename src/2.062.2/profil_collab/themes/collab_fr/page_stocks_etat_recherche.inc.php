<?php

// *************************************************************************************************************
// RECHERCHE D'UN ARTICLE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<script type="text/javascript" language="javascript">
</script>
<div class="emarge">
<table style="width:100%">
<tr>
	<td>
		<p class="titre">Etat des stocks </p>
	</td>
	<td style="width:20%; vertical-align: bottom;">
		<?php 
			if(isset($stock)){
				?>
				<p class="retour_tdb" id="retour_tdb" class="grey_caisse">Retour au tableau de bord</p>
				<?php
			}
		?>
	</td>
</tr>
</table>

<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche_s" name="form_recherche_s">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:18%">&nbsp;</td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%; text-align: right"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
                            <br />
                            <span class="labelled_text">Cat&eacute;gorie:</span>
                            <input type="hidden" name="id_stock_s" id="id_stock_s" value="" />
                            <input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
                            <input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
                            <input type=hidden name="recherche" value="1" />	
                        </td>
                        <td>
                            <br />
                            <select  name="ref_art_categ_s" id="ref_art_categ_s" class="classinput_xsize">
                                <option value="">Toutes</option>
                                <?php
                                        $select_art_categ =	get_articles_categories();
                                        foreach ($select_art_categ  as $s_art_categ){
                                ?>
                                <option value="<?php echo ($s_art_categ->ref_art_categ)?>">
                                <?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
                                </option>
                                <?php
                                        }
                                ?>
                            </select>
                        </td>
			<!--<td>&nbsp;</td>-->
			<td style="padding-left:35px">
				<span class="labelled_text"> Filtre par état de stock:</span><br />
				<select name="in_stock_s" id="in_stock_s" class="classinput_xsize" style="width:100%">
					<option value='2'>Uniquement les articles en stock</option>
					<option value='1'>Uniquement les articles en erreur</option>
					<option value='0'>Tous les articles</option>
				</select>	
			</td>
			<td rowspan="2" style="padding-left:35px"><span class="labelled_text">Lieux de stockage:</span><br />
                            <select name="id_stock_l" size="4" multiple="multiple" class="classinput_lsize" id="id_stock_l">
                                    <?php
                                    if (count($stocks_liste) > 1) {
                                    ?><option value=""  <?php if (!isset($_REQUEST["id_stock"])) {?>selected="selected"<?php } ?>>Tous</option><?php
                                    }
                                            foreach ($stocks_liste as $stock_liste) {
                                            ?>
                                    <option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if (isset($_REQUEST["id_stock"]) && $_REQUEST["id_stock"] == $stock_liste->getId_stock ()) {?>selected="selected"<?php } ?>><?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
                                    <?php }
                                            ?>
                            </select>
                        </td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
                            <br />
                            <span class="labelled_text" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span>
                        </td>
                        <td>
                            <br />
                            <select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style="  <?php if(!$GESTION_CONSTRUCTEUR){?> display:none<?php } ?>"><option value=''>Tous</option></select>			</td>
			<!--<td>&nbsp;</td>-->
			<td style="padding-left:35px">
				<span class="labelled_text"> Filtre par emplacement de stock:</span><br />
				<input name="emplacement_s" id="emplacement_s" value="" class="classinput_xsize" type="text">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
				<td colspan="2"><?php if($GESTION_SN == 1){ ?>
                                        <br />
					<input type="checkbox" name="aff_info_tracab_s" id="aff_info_tracab_s" value="1" />
					<span class="labelled_text">Afficher les informations de tra&ccedil;abilit&eacute;es</span>				
				<?php } ?>
				<br />
				<?php 
				if ($_SESSION['user']->check_permission ("6")){?>
				<input type="checkbox" name="aff_pa_s" id="aff_pa_s" value="1" />
				<span class="labelled_text">Afficher Prix d'achat</span>
				<?php 
				}else{
				?>
				<input type="hidden" name="aff_pa_s" id="aff_pa_s" value="0" />
				<span class="labelled_text" style="display:none;">Afficher Prix d'achat</span>
				<?php
				}
				?>
				</td>	
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
			<input name="submit2" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
		

		<input type="image" name="annuler_recherche_s" id="annuler_recherche_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
	</span></td>
		<td style="text-align:right"><span><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" id="stock_etat_imprimer" style="cursor:pointer" /></span></td>
		<td>&nbsp;</td><td style="text-align:right"><span><img id="export_stock" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ods.gif" alt="ODS" title="ODS" style="cursor:pointer;"/></span></td>
		
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</form>
</div>



</div>

<div id="resultat" ></div>

</div>
<?php
include ("page_stock_export.php");
?>
<SCRIPT type="text/javascript">
//remise à zero du formulaire
Event.observe('annuler_recherche_s', "click", function(evt){Event.stop(evt); reset_moteur_s ('form_recherche_s', 'ref_art_categ_s');	});

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){page.stock_etat_recherche_simple();  
	Event.stop(evt);});

Event.observe('stock_etat_imprimer', "click", function(evt){Event.stop(evt); stock_etat_imprimer ();	});

//Exporter
Event.observe('export_stock', "click", function(evt){	
		var f_aff_pa_s= "0";
		var f_aff_info_tracab_s= "0";
		var id_stock_s = "";
		
		if ($F("aff_pa_s")=="1") { f_aff_pa_s="1";}
		if ($("aff_info_tracab_s")){
			if ($F("aff_info_tracab_s")=="1") { f_aff_info_tracab_s="1";}
		}
		
		id_stock_s = "";

		if ($F('id_stock_l').length >0) {
			if($F('id_stock_l')=='' || $F('id_stock_l').length ==2){

                        alerte.alerte_erreur('Erreur de stock','Veuillez sélectionner un seul stock',"<input type='submit' value='Valider' name='button_0' onclick='hide_pop_alerte ();'/>");
			}else{
			id_stock_s = $F('id_stock_l');
			$("pop_up_export_det").style.display = "block";
			page.traitecontent('pop_up_export_det','stock_export.php?ref_art_categ='+$F('ref_art_categ_s')+'&ref_constructeur='+$F('ref_constructeur_s')+'&aff_pa='+f_aff_pa_s+'&aff_info_tracab='+f_aff_info_tracab_s+'&orderby='+$F('orderby_s')+'&orderorder='+$F('orderorder_s')+'&id_stock='+id_stock_s+'&in_stock='+$F("in_stock_s")+'&emplacement_s='+$F('emplacement_s')+'','true','pop_up_export_det');
			}
		}
	Event.stop(evt);
});
//centrage de la pop up comm
centrage_element("pop_up_export_det");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_export_det");
});

//
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});

Event.observe("retour_tdb", "click",  function(evt){
	Event.stop(evt);
	page.verify('stocks_gestion2','stocks_gestion2.php?id_stock=<?php echo $stock->getId_stock(); ?>','true','sub_content');
}, false);



//remplissage si on fait un retour dans l'historique
if (historique_request[4][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	//history sur recherche simple
	if (historique_request[4][1] == "simple") {
	preselect ((historique_request[4]["ref_art_categ_s"]), 'ref_art_categ_s') ;
	preselect ((historique_request[4]["ref_constructeur_s"]), 'ref_constructeur_s') ;
	
	if (historique_request[4]["in_stock_s"] == "1") {	$('page_to_show_s').checked = true;	}
	
	$('page_to_show_s').value = 	historique_request[4]["page_to_show_s"];  
	$('orderby_s').value = 	historique_request[4]["orderby_s"]; 
	$('orderorder_s').value = 	historique_request[4]["orderorder_s"];
	
	$('id_stock_s').value = 	historique_request[4]["id_stock_s"];
	
	page.stock_etat_recherche_simple();
	}
	
}
//on masque le chargement
H_loading();
</SCRIPT>