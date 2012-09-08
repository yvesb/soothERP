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
<div class="emarge"><br />

<span class="titre" style="float:left; padding-left:140px; width:50%">Recherche un chèque déposé en banque</span>

<span style=" float:right; text-align:right; width:15%"><br />

<span id="retour_gestion" style="cursor:pointer; text-decoration:underline">Retour au tableau de bord</span>

<script type="text/javascript">
Event.observe('retour_gestion', 'click',  function(evt){
Event.stop(evt); 
page.verify('compte_bancaire_gestion2','compta_compte_bancaire_gestion2.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','sub_content');
}, false);
</script>
</span>

<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_compte_bancaire">

<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
		<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
			<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_banque.jpg" />				</div>
			<span style="width:35px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
		<td colspan="2" style="width:90%; background-color:#FFFFFF" ><br />

		<table style="width:100%">
		<tr>
		<td style="width:15%">
		<span class="labelled">Compte:</span>
		</td><td style="width:20%">
		<select  name="id_compte_bancaire" id="id_compte_bancaire" class="classinput_xsize">
		<option  value="">Tous</option>
		<?php 
		foreach ($comptes_bancaires as $compte_bancaire) {
			?>
			<option  value="<?php echo $compte_bancaire->id_compte_bancaire;?>" <?php if ($_REQUEST["id_compte_bancaire"] == $compte_bancaire->id_compte_bancaire) { echo 'selected="selected"';}?>><?php echo $compte_bancaire->lib_compte;?></option>
			<?php	
		}
		?>
		</select>
		
		<input type="hidden" name="orderby" id="orderby" value="date_depot" />
		<input type="hidden" name="orderorder" id="orderorder" value="DESC" />
		<input type="hidden" name="page_to_show" id="page_to_show" value="1"/>
		</td>
		<td style="width:30px">&nbsp;</td>
		<td style="width:20%"></td>
		<td >&nbsp;</td>
		</tr>
		<tr>
			<td>
			<span class="labelled">Montant:</span>
			</td>
			<td>
			<input type="text" name="montant" id="montant" value="" class="classinput_xsize"/>
			</td>
			<td>&agrave; +/-
			</td>
			<td>
			<input type="text" name="delta_montant" id="delta_montant" value="0.00" class="classinput_nsize" size="5"/> <?php	 echo $MONNAIE[1]; ?> 
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			<span class="labelled">Nom du porteur:</span>
			</td>
			<td>
			<input type="text" name="nom_porteur" id="nom_porteur" value="" class="classinput_xsize"/>
			</td>
			<td>
			</td>
			<td>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			<span class="labelled">Numéro de chèque:</span>
			</td>
			<td>
			<input type="text" name="num_cheque" id="num_cheque" value="" class="classinput_xsize"/>
			</td>
			<td>
			</td>
			<td>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			<span class="labelled">Banque:</span>
			</td>
			<td>
			<input type="text" name="banque" id="banque" value="" class="classinput_xsize"/>
			</td>
			<td>
			</td>
			<td>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			<span class="labelled">Période du</span>
			</td><td>
			<input type="text" name="date_debut" id="date_debut" value="" class="classinput_xsize"/>  
			</td>
			<td><span>au</span>
			</td>
			<td>
			<input type="text" name="date_fin" id="date_fin" value="<?php echo date("d-m-Y");?>" class="classinput_xsize"/>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			
			</td>
			<td>
		<input name="submit_s" id="submit_s" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" />
			</td>
			<td>
			</td>
			<td>
			</td>
			<td>
			</td>
		</tr>
		</table><br />

		<div id="liste_chq" style="padding-left:10px; padding-right:10px; OVERFLOW-Y: scroll; OVERFLOW-X: hidden;">
		
		
		
		</div>
		

		</td>
	</tr>
</table>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<SCRIPT type="text/javascript">

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);

new Event.observe("delta_montant", "blur", function(evt) {nummask(evt, 0, "X.XY")}, false);


function setheight_compta_view_ope(){
set_tomax_height("liste_chq" , -166);
}

//centrage de l'editeur
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});


set_tomax_height("liste_chq" , -46);

Event.observe("submit_s", "click",  function(evt){
	Event.stop(evt);
	$('page_to_show').value=1;
	page.compte_bancaire_recherche_chq();
}, false);
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>