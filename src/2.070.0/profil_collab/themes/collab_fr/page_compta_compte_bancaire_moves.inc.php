<?php

// *************************************************************************************************************
// CONSULTATION DES OPERATIONS DE COMPTE BANCAIRE
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

<span class="titre" style="float:left; padding-left:140px; width: 40%">Opérations du compte <?php echo $compte_bancaire->getLib_compte ();?></span>


<span style=" float:right; text-align:right; width:19%"><br />
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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
			<td>
		<span >Compte:</span> </td>
			<td colspan="4">
			<select  name="id_compte_bancaire" id="id_compte_bancaire" class="classinput_xsize">
			<?php 
			foreach ($comptes_bancaires as $cpt_bancaire) {
				?>
				<option  value="<?php echo $cpt_bancaire->id_compte_bancaire;?>" <?php if ($_REQUEST["id_compte_bancaire"] == $cpt_bancaire->id_compte_bancaire) { echo 'selected="selected"';}?>><?php echo $cpt_bancaire->lib_compte;?></option>
				<?php	
			}
			?>
			</select>
			</td>
			<td rowspan="6" style="text-align:right;">
			<div>
			<div style="width:250px; text-align:left; float:right">
					<span id="add_releve" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Enregistrer un relevé.</span><br /><br />

					<span id="add_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Enregistrer des opérations</span><br /><br />
					<span id="search_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Rechercher une opération</span><br /><br />

					<span id="print_ope" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Imprimer le relevé</span><br /><br />
			<script type="text/javascript">
			
						Event.observe("add_releve", "click",  function(evt){
							Event.stop(evt);
							page.verify('add_compta_compte_bancaire_releves','compta_compte_bancaire_releves_add.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','edition_operation');
							$("edition_operation").show();
						}, false);
						
						Event.observe("add_ope", "click",  function(evt){
							Event.stop(evt);
							page.verify('add_mouvement_compte','compta_compte_bancaire_operations_add.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','edition_operation');
							$("edition_operation").show();
						}, false);
						
			
						Event.observe('search_ope', 'click',  function(evt){
						Event.stop(evt); 
						page.verify('compte_bancaire_recherche','compta_compte_bancaire_recherche.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','sub_content');
						}, false);
						
						Event.observe("print_ope", "click",  function(evt){
							Event.stop(evt);
							page.verify('compta_compte_bancaire_operations_imprimer','compta_compte_bancaire_operations_imprimer.php?id_compte_bancaire='+$("id_compte_bancaire").value+'&id_exercice='+$("id_exercice").value+'&date_fin='+$("date_fin").value+'&print=1','true','_blank');
						}, false);
			
			
			</script>
			<div id="more_releve_infos">
			
			</div>
			</div>
			</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">
			</td>
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
			</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">
			</td>
		</tr>
		<tr>
			<td>
			</td>
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
			</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp; </td>
			<td colspan="4">
			</td>
		</tr>
	</table>
			<input type="hidden" name="page_to_show" id="page_to_show" value="1"/>
			<div id="liste_operations" style="padding-left:10px; padding-right:10px; OVERFLOW-Y: scroll; OVERFLOW-X: hidden;">
			
			
			
			</div>
			</td>
	</tr>
</table>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_operation_iframe" class="edition_operation_iframe" style="display:none"></iframe>
<div id="edition_operation" class="edition_operation" style="display:none; text-align:left">
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
set_tomax_height("liste_operations" , -46);
set_tomax_height("liste_releves" , -46);  
}

Event.observe(window, "resize", setheight_compta_view_ope, false);
setheight_compta_view_ope();

//centrage de l'editeur
centrage_element("edition_operation");
centrage_element("edition_operation_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_operation");
centrage_element("edition_operation_iframe");
});


Event.observe("id_compte_bancaire", "change",  function(evt){
	page.verify('compta_compte_bancaire_moves','compta_compte_bancaire_moves.php?id_compte_bancaire='+$("id_compte_bancaire").value,'true','sub_content');
}, false);

Event.observe("id_exercice", "change",  function(evt){
	page.verify('compta_compte_bancaire_moves','compta_compte_bancaire_moves.php?id_compte_bancaire='+$("id_compte_bancaire").value+'&id_exercice='+$("id_exercice").value,'true','sub_content');
}, false);
Event.observe("date_fin", "change",  function(evt){
page.compte_bancaire_moves();
}, false);

page.compte_bancaire_moves();

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>