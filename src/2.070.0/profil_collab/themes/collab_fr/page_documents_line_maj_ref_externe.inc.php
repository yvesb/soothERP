<?php

// *************************************************************************************************************
// AFFICHAGE mise à jour ref_article_externe
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
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
<?php 
if (isset($_REQUEST['ref_doc'])) {
	if (isset($GLOBALS['_INFOS']['ref_article_externe'])) {
		?>
			$("old_ref_article_externe_<?php echo $_REQUEST['indentation'];?>").value = "<?php echo $GLOBALS['_INFOS']['ref_article_externe'];?>";
		<?php
		} else {
		?>
			$("ref_article_externe_<?php echo $_REQUEST['indentation'];?>").value = $("old_ref_article_externe_<?php echo $_REQUEST['indentation'];?>").value;
		<?php
	}
}
?>
</script>