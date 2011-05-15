<?php

// *************************************************************************************************************
// AFFICHAGE DES FACTURES CLIENTS NON REGLEES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("factures");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div id="recherche_simple" class="menu_link_affichage">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:30%">&nbsp;</td>
                        <td style="width:2%">&nbsp;</td>
			<td style="width:30%">&nbsp;</td>
                        <td style="width:2%">&nbsp;</td>
			<td style="width:30%">&nbsp;</td>
			<!--<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			--><td style="width:3%; text-align: right"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
                            <br />
                            <span class="labelled_text">Cat&eacute;gorie de client:</span>
                            
                        </td>
                        <td>&nbsp;</td>
                        <td width="30">
                            <br />
                            <span class="labelled_text">Niveaux de relances:</span>
                            
                        </td>
                        <td>&nbsp;</td>
                        <td width="30">
                            <br />
                            <span class="labelled_text">Mode de R&egrave;glement:</span>
                           <!-- <input type="hidden" name="id_stock_s" id="id_stock_s" value="" />
                            <input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
                            <input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
                            <input type=hidden name="recherche" value="1" />-->
                        </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <!-- Catégories client-->
                       <!-- <select name="categ_client" id="categ_client" class="classinput_lsize" style="width:80%">
                            <option value='0'>Toutes</option>-->
                           <input type="checkbox" name="" id="categ_all"/> Toutes<br/>
                            <?php
                            $all_categories_client = contact_client::charger_clients_categories ();
                            $i = 0;
                            foreach($all_categories_client as $categorie_client){?>
                            <input type="checkbox" name="<?php echo $categorie_client->id_client_categ;?>" id="categ_<?php echo $i;?>"/> <?php echo $categorie_client->lib_client_categ;?><br />
                                <!--<option value='<?php echo $categorie_client->id_client_categ;?>'><?php echo $categorie_client->lib_client_categ;?></option>-->
                           <?php $i++; }?>
                        <!--</select>-->
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <!-- Niveaux de relances-->
                         <!--<select name="niv_relance" id="niv_relance" class="classinput_lsize" style="width:80%">
                            <option value='0'>Tous</option>-->
                           <input type="checkbox" name="" id="niveau_all"/>Tous<br/>
                            <?php
                            $liste_niveaux_relance_actifs = getNiveaux_relance ($liste_categories_client[$categorie_client_var]->id_relance_modele) ;
                            $i = 0;
                            foreach($liste_niveaux_relance_actifs as $niveau_relance){
                                if ($niveau_relance->actif == 1){?>
                                <input type="checkbox" name="<?php echo $niveau_relance->id_niveau_relance;?>" id="niveau_<?php echo $i;?>"/> <?php echo $niveau_relance->lib_niveau_relance;?><br />
                                <!--<option value='<?php echo $niveau_relance->id_niveau_relance;?>'><?php echo $niveau_relance->lib_niveau_relance;?></option>-->
                           <?php $i++;}
                           }?>
                        <!--</select>-->
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <input type="checkbox" name="" id="reglement_all"/> Tous<br/>
                        <!-- Mode de reglement-->
                         <!--<select name="mode_regmt" id="mode_regmt" class="classinput_lsize" style="width:80%">
                            <option value='0'>Tous</option>-->
                            <?php $reglements_modes = getReglements_modes();
                            $i = 0;
                            foreach($reglements_modes as $reglement_mode){?>
                                <input type="checkbox" name="<?php echo $reglement_mode->id_reglement_mode;?>" id="reglement_<?php echo $i;?>"/> <?php echo $reglement_mode->lib_reglement_mode;?><br />
                                <!--<option value='<?php echo $reglement_mode->id_reglement_mode;?>'><?php echo $reglement_mode->lib_reglement_mode;?></option>-->
                           <?php $i++; }?>
                        <!--</select>-->
                    </td>
                </tr>
		<tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                    <br />
                    </td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
		<input name="bt-recherche" id="bt-recherche" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
	</span></td>
		<!--<td style="text-align:right"><span><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" id="stock_etat_imprimer" style="cursor:pointer" /></span></td>
		<td>&nbsp;</td><td style="text-align:right"><span><img id="export_stock" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ods.gif" alt="ODS" title="ODS" style="cursor:pointer;"/></span></td>
-->
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</div>
    
<div id="main_doc_div" style="" class="emarge">
<br />

<div id="fac_liste_content" class="articletview_corps"  style="width:100%;">
<?php //include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_client_nonreglees_liste.inc.php";?>
</div>


</div>
<script type="text/javascript">
    Event.observe('bt-recherche', "click", function(evt){
        Event.stop(evt);
        //load_facture_nonreglees ($('categ_client').value, $('niv_relance').value);
        var categ_client = new Array();
        var niv_relance = new Array();
        var mode_regmnt = new Array();
        var i = 0;
        var j = 0;
        while ($('categ_' + i)){
            if ($('categ_' + i).checked == true){
                categ_client[j++] = $('categ_' + i).name;
            }
            i++;
        }
        i = 0;
        j = 0;
        while ($('niveau_' + i)){
            if ($('niveau_' + i).checked == true){
                niv_relance[j++] = $('niveau_' + i).name;
            }
            i++;
        }
        i = 0;
        j = 0;
        while ($('reglement_' + i)){
            if ($('reglement_' + i).checked == true){
                mode_regmnt[j++] = $('reglement_' + i).name;
            }
            i++;
        }
        load_facture_nonreglees (Object.toJSON(categ_client), Object.toJSON(niv_relance), Object.toJSON(mode_regmnt), "");
});

//on masque le chargement
H_loading();

</script>