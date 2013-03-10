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
<ul class="choix_fax" style="width:100%">
<?php 
$i=0;
if (is_array($liste_fax)){
	foreach ($liste_fax as $fax) {
		if ($fax->fax == "" ) {continue;}
		?>
		<li class="complete_ville" id="fax_<?php echo $i;?>"><?php echo $fax->fax;?></li>
		<?php 
		$i++;
	}
} else {
	?>
	Aucun fax défini.
	<?php
}
?>
</ul>
<script type="text/javascript">
<?php 
$i=0;
if (is_array($liste_fax)){
	foreach ($liste_fax as $fax) {
		if ($fax->fax == "" ) {continue;}
		?>
Event.observe("fax_<?php echo $i;?>", "mouseout",  function(){changeclassname ("fax_<?php echo $i;?>", "complete_ville");}, false);

Event.observe("fax_<?php echo $i;?>", "mouseover",  function(){changeclassname ("fax_<?php echo $i;?>", "complete_ville_hover");}, false);

Event.observe("fax_<?php echo $i;?>", "click",  function(){
	$("choix_send_fax").style.display="none";
	$("iframe_choix_send_fax").style.display="none";
	var AppelAjax = new Ajax.Request(
																	"documents_contact_fax_send_doc.php", 
																	{parameters: {ref_doc: "<?php echo $document->getRef_doc()?>", destinataires: "<?php echo $fax->fax;?>", titre: "", message: ""},
																	evalScripts:true, 
																	onLoading:S_loading, onException: function () {S_failure();}, 
																	onComplete: function(requester) {
																						H_loading(); 
																						requester.responseText.evalScripts();

																					}
																	}
																	);
}, false);
			<?php 
		$i++;
	}
}
?>
//on masque le chargement
H_loading();

</script>