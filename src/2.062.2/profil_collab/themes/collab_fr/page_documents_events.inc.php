<?php

// *************************************************************************************************************
// ONGLET DES EVENEMENTS DU DOCUMENT
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
	<a href="#" id="link_close_pop_up_histo_doc" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
<script type="text/javascript">
Event.observe("link_close_pop_up_histo_doc", "click",  function(evt){Event.stop(evt); 
	$('historique_content').style.display = "none"; }, false);
</script>
<div style="width:100%; height: 340px; OVERFLOW-Y: auto; OVERFLOW-X: auto; ">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="document_head_list">
		<td style="width:5%">&nbsp;</td>
		<td class="doc_bold" style="width:15%">Date</td>
		<td style="width:5%">&nbsp;</td>
		<td class="doc_bold" style="width:35%">Ev&eacute;nement</td>
		<td style="width:5%">&nbsp;</td>
		<td class="doc_bold">Utilisateur</td>
		<td style="width:5%">&nbsp;</td>
	</tr>
	<tr>
		<td  colspan="7">&nbsp;</td>
	</tr>
<?php 
$indentation_events = 0;
$colorise=0;
$liste_events = $document->getEvents ();
foreach ($liste_events as $event) {
	$colorise++;
	$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	<tr class="<?php  echo  $class_colorise?>">
		<td>&nbsp;</td>
		<td>
		<?php 
		if ($event->date_event !=0000-00-00) {
			echo date_Us_to_Fr ($event->date_event);
			echo "&nbsp;&nbsp;". ( getTime_from_date($event->date_event));
		}?>
		</td>
		<td>&nbsp;</td>
		<td>
		<div style="font-weight:bolder"><?php echo ($event->lib_event_type);?></div>
		<div><?php echo (nl2br($event->event));?></div>
		</td>
		<td>&nbsp;</td>
		<td>
		<?php echo ($event->pseudo);?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<?php 
	$indentation_events++;
}
?>
</table>

<script type="text/javascript">
		

//on masque le chargement
H_loading();

</script>
</div>