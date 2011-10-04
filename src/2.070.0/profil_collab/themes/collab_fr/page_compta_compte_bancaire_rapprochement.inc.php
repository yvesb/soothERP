<?php
// *************************************************************************************************************
// Affichage RAPPROCHEMENT BANCAIRE
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

<span class="titre" style="float:left; padding-left:140px; width: 70%">Rapprochements compte <?php echo $compte_bancaire->getLib_compte ();?></span>


<span style=" float:right; text-align:right;"><br />
<span id="retour_gestion" style="cursor:pointer; text-decoration:underline">Retour</span>

<script type="text/javascript">
Event.observe('retour_gestion', 'click',  function(evt){
Event.stop(evt); 
page.verify('compta_compte_bancaire_rapprochement_gestion','compta_compte_bancaire_rapprochement_gestion.php','true','sub_content');
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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
			<td style="width:15%">
		<span >Compte:</span> </td>
			<td colspan="4" style="width:25%">
			<select  name="id_compte_bancaire" id="id_compte_bancaire" class="classinput_xsize">
			<?php 
			foreach ($comptes_bancaires as $cpt_bancaire) {
				?>
				<option  value="<?php echo $cpt_bancaire->id_compte_bancaire;?>" <?php if ($_REQUEST["id_compte_bancaire"] == $cpt_bancaire->id_compte_bancaire) { echo 'selected="selected"';}?>><?php echo $cpt_bancaire->lib_compte." ".$cpt_bancaire->numero_compte;?></option>
				<?php	
			}
			?>
			</select>			</td>
			<td style="text-align:right; width:5%">			</td>
			<td style=" width:15%"></td>
			<td style="text-align:right; "></td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">			</td>
			<td style="text-align:right; width:5%"></td>
			<td style=""></td>
			<td style="text-align:right; "></td>
		</tr>
		<tr>
			<td></td>
			<td style="width:85px">Exercice:&nbsp;&nbsp; </td>
			<td colspan="4">
			<select id="id_exercice" name="id_exercice" class="classinput_nsize">
			<?php
			for($i = 0; $i< count($liste_exercices); $i++) {
				//affichage de l'exercice
				?>
				<option value="<?php echo $liste_exercices[$i]->id_exercice; ?>" style="font-weight:bolder;<?php 
							if (!$liste_exercices[$i]->etat_exercice) {
								?>color: #999999;<?php
							} else {
								if ($liste_exercices[$i]->date_fin >= date("Y-m-d")) {
									?>color: #66CC33;<?php
								} else {
									?>color: #CC3333;<?php
								}
							}
							?>" <?php if (isset($_REQUEST["id_exercice"]) && $_REQUEST["id_exercice"] == $liste_exercices[$i]->id_exercice) { echo 'selected="selected"';}?>><?php echo $liste_exercices[$i]->lib_exercice;?></option>
				
			
				<?php 
			}
			?>
			</select>			</td>
			<td style="text-align:right; width:5%"></td>
			<td style="width:15%">Op&eacute;rations: :</td>
			<td style="">
			<select id="montants" name="montants" class="classinput_nsize">
			<option value="">Toutes</option>
			<option value="deb">En débits</option>
			<option value="cre">En crédits</option>
			</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">			</td>
			<td style="text-align:right; width:5%"></td>
			<td style=""></td>
			<td style="text-align:right; "></td>
		</tr>
		<tr>
			<td>			</td>
			<td >Relevés: </td>
			<td colspan="4">
			<select  name="date_fin" id="date_fin" class="classinput_xsize">
			<?php 
					setlocale(LC_TIME, $INFO_LOCALE);
			if (!isset($_REQUEST["id_exercice"]) || $liste_exercices[0]->id_exercice == $_REQUEST["id_exercice"]) { 
				?> 
				
				<option  value="<?php echo date("Y-m-d");?>" >En cours</option>
				<?php
			}
			?>
			<?php 
			foreach ($liste_releves as $releve) {
				?>
				<option  value="<?php echo date("Y-m-d", strtotime($releve->date_releve));?>" ><?php echo date("d F y", strtotime($releve->date_releve));?></option>
				<?php	
			}
			?>
			</select>			</td>
			<td style="text-align:right; width:5%"></td>
			<td style="width:25%">Uniquement &agrave; rapprocher: </td>
			<td style="">
			<input type="checkbox" value="1" name="arapp" id="arapp" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">			</td>
			<td style="text-align:right; width:5%"></td>
			<td style=""></td>
			<td style="text-align:right; "> </td>
		</tr>
	</table>

	
			<input type="hidden" name="page_to_show" id="page_to_show" value="1"/>
			<div id="liste_rapprochement" style="padding-left:10px; padding-right:10px; OVERFLOW-Y: scroll; OVERFLOW-X: hidden;">
			
			
			
			</div>
			</td>
	</tr>
</table>

<div id="edition_rapprochement" class="edition_rapprochement" style="display:none; text-align:left">
</div>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<SCRIPT type="text/javascript">
//centrage de l'editeur
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});

function setheight_compta_view_ope(){
set_tomax_height("liste_rapprochement" , -46);
set_tomax_height("liste_releves" , -46);  
}

Event.observe(window, "resize", setheight_compta_view_ope, false);
setheight_compta_view_ope();

//centrage de l'editeur
centrage_element("edition_rapprochement");

Event.observe(window, "resize", function(evt){
centrage_element("edition_rapprochement");
});

Event.observe("id_compte_bancaire", "change",  function(evt){
	page.verify('compta_compte_bancaire_rapprochement','compta_compte_bancaire_rapprochement.php?id_compte_bancaire='+$("id_compte_bancaire").value,'true','sub_content');
}, false);

Event.observe("id_exercice", "change",  function(evt){
	page.verify('compta_compte_bancaire_rapprochement','compta_compte_bancaire_rapprochement.php?id_compte_bancaire='+$("id_compte_bancaire").value+'&id_exercice='+$("id_exercice").value,'true','sub_content');
}, false);

Event.observe("date_fin", "change",  function(evt){
$("page_to_show").value = "1";
page.compte_bancaire_rapprochement();
}, false);

Event.observe("montants", "change",  function(evt){
$("page_to_show").value = "1";
page.compte_bancaire_rapprochement();
}, false);

Event.observe("arapp", "click",  function(evt){
$("page_to_show").value = "1";
page.compte_bancaire_rapprochement();
}, false);

page.compte_bancaire_rapprochement();

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>