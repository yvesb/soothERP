<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

if(1==2){
	$document = new doc_tic();
	$ligne;
	;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


/*
STRUCTURE DU TABLEAU D'UNE DOC_LINE
$doc_line['type_of_line']
$doc_line['ref_doc_line']
$doc_line['ref_doc_line_parent']
$doc_line['ref_article']
$doc_line['lib_article']
$doc_line['desc_article']
$doc_line['qte']
$doc_line['pu_ht']
$doc_line['tva']
$doc_line['ordre']
$doc_line['visible']
*/


?>
<!-- Cette page est destiné a être appelé dans un TR d'une table -->
<td>
	<!-- LIB COURT -->
	<span><?php echo $id_ligne;?> - <?php echo $article->getDesc_courte(); ?></span>
</td>
<td>
	<!-- QTE -->
	<span><?php echo $ligne->qte; ?></span>
</td>
<td>
	<!-- PU TTC -->
	<span><?php echo $ligne->pu_ht; ?> HT</span>
</td>
<td>
	<!-- REMISE -->
	<span><?php echo $ligne->remise; ?></span>
</td>
<td>
	<span>prix</span>
	
	<script type="text/javascript">
		Event.observe("ligne_<?php echo $id_ligne;?>", "click", function(evt){
			caisse_select_line("ligne_"+<?php echo $id_ligne;?>);
		}, false);
		
	</script>
</td>
