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
<ul class="choix_email" style="width:100%">
<?php 
$i=0;
if (is_array($liste_email)){
	foreach ($liste_email as $email) {
		if ($email->email == "" ) {continue;}
		?>
		<li class="complete_ville" id="email_<?php echo $i;?>"><?php echo $email->email;?></li>
		<?php 
		$i++;
	}
} else {
	?>
	Aucun email défini.
	<?php
}
?>
		<li class="complete_ville" id="email_perso">Envoyer un email personnalisé</li>
</ul>
<script type="text/javascript">
<?php
if (isset($_REQUEST["message"])) {echo $_REQUEST["message"];}
global $LIVRAISON_CLIENT_ID_TYPE_DOC;
if ($document->getId_type_doc() == $LIVRAISON_CLIENT_ID_TYPE_DOC){
    $modele = new msg_modele_blc(2);
}else{
    $modele = new msg_modele_doc_standard(1);
}
$modele->initvars($document->getRef_doc());
$message = urlencode($modele->get_html());

$i=0;
if (is_array($liste_email)){
	foreach ($liste_email as $email) {
		if ($email->email == "" ) {continue;}
		?>
Event.observe("email_<?php echo $i;?>", "mouseout",  function(){changeclassname ("email_<?php echo $i;?>", "complete_ville");}, false);

Event.observe("email_<?php echo $i;?>", "mouseover",  function(){changeclassname ("email_<?php echo $i;?>", "complete_ville_hover");}, false);

Event.observe("email_<?php echo $i;?>", "click",  function(){
	$("choix_send_mail").style.display="none";
	$("iframe_choix_send_mail").style.display="none";
	var AppelAjax = new Ajax.Request(
																	"documents_contact_email_send_doc.php", 
																	{parameters: {ref_doc: "<?php echo $document->getRef_doc()?>", destinataires: "<?php echo $email->email;?>", titre: "<?php echo $document->getLib_type_printed ()." ".$document->getRef_doc()?>", message: "<?php echo $message ?>",encode : true},
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
Event.observe("email_perso", "mouseout",  function(){changeclassname ("email_perso", "complete_ville");}, false);

Event.observe("email_perso", "mouseover",  function(){changeclassname ("email_perso", "complete_ville_hover");}, false);

Event.observe("email_perso", "click",  function(){
	$("choix_send_mail").style.display="none";
	$("iframe_choix_send_mail").style.display="none";
	PopupCentrer("documents_editing_email.php?ref_doc=<?php echo  $document->getRef_doc(); ?>&mode_edition=2",780,550,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes")
	
}, false);
//on masque le chargement
H_loading();

</script>