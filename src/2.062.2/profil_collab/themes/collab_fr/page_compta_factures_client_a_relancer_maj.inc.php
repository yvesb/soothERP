<?php
// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

?>
<script type="text/javascript">
window.parent.page.traitecontent('compta_factures_client_non_editees','<?php echo $url; ?>','true','<?php echo $target; ?>');
window.parent.page.traitecontent('compta_factures_client_a_relancer','compta_factures_client_a_relancer.php?niveau_relance_var=<?php echo $id_niveau_relance?>','true','sub_content');
</script>