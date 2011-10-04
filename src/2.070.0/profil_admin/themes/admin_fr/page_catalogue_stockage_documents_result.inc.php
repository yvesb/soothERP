<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Affichage des résultats
?><br />
<p class="titre">Documents non traités du stock <?php echo $_SESSION['stocks'][$id_stock]->getLib_stock();?></p>
<div class="mt_size_optimise">

<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:10%">
			<a href="#"  id="order_ref_doc">R&eacute;f&eacute;rence
			</a>
		</td>
		<td style="width:18%; text-align:left">
			<a href="#"  id="order_type_doc">Type de Document
			</a>
		</td>
		<td style="width:14%; text-align:center">
			<a href="#"  id="order_etat_doc">&Eacute;tat
			</a>
		</td>
		<td style=" text-align:left">
			<a href="#"  id="order_contact_doc">Contact
			</a>
		</td>
		<td style="width:9%; text-align:center">
			<a href="#"  id="order_montant_doc">
			Montant TTC
			</a>
		</td>
		<td style="width:10%; text-align:center">
			<a href="#"  id="order_date_doc">
			Date
			</a>
		</td>
		<td style="width:5%"></td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>">
	<td class="reference">
		<a  href="#" id="link_ref_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_doc) { echo htmlentities($fiche->ref_doc)."&nbsp;";}?>		
		</a>
	<script type="text/javascript">
	Event.observe("link_ref_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td>
		<a  href="#" id="link_type_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">
		<span class="r_doc_lib"><?php echo nl2br(htmlentities($fiche->lib_type_doc))?></span>
		</a>
	<script type="text/javascript">
	Event.observe("link_type_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="text-align:center">
		<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->lib_etat_doc) { echo htmlentities($fiche->lib_etat_doc); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="text-align:left">
		<a  href="#" id="link_contact_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%" alt="<?php	if ($fiche->nom_contact) { echo htmlentities($fiche->nom_contact); }?>" title="<?php	if ($fiche->nom_contact) { echo htmlentities($fiche->nom_contact); }?>">
		<?php	if ($fiche->nom_contact) { echo htmlentities(substr($fiche->nom_contact, 0, 38)); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_contact_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="text-align:right; padding-right:5px">
		<a  href="#" id="link_montant_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->montant_ttc) { echo number_format($fiche->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_montant_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="text-align:center">
		<a  href="#" id="link_date_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->date_doc) { echo htmlentities(date_Us_to_Fr($fiche->date_doc)); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_date_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a  href="#" id="link_edit_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%; text-decoration:underline">Editer</a>
	<script type="text/javascript">
	Event.observe("link_edit_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a href="<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>&print=1" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_imprime.gif" alt="Imprimer" title="Imprimer"/></a>
	</td>
	
	</tr>
	
<?php
}
?></table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />

</div>

<script type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>