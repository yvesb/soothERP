<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">
	var table = $("TICKET");
	table.removeChild($("<?php echo $ref_ligne; ?>"));
	selected_line_name = "";
	calculette_caisse.setCible_type_action("TICKET");
	selected_col_name= "";

	if(table.rows.length>1){
		calculette_caisse.setCible_id(table.rows[table.rows.length-1].id);
		caisse_select_line(table.rows[table.rows.length-1].id);
	}else{
		caisse_unselect_line();
	}

	var montant =  "<?php echo $montant_to_pay; ?>";
	caisse_maj_total(price_format(montant));
	//caisse_maj_total("<?php echo price_format($montant_to_pay); ?>");

	H_loading();

</script>
