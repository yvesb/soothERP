
<div style="height:200px; padding-right:3px;">
<ul class="complete_adresse">
<?php
$i=0;
foreach ($_SESSION['stocks'] as $stocks) {
	?>
	<li class="complete_coordonnee" id="li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>">
	<?php echo htmlentities($stocks->getLib_stock ()) ?>
	</li>
	<?php 
$i++;
}


?>
</ul>

<script type="text/javascript">
<?php
$i=0;




foreach ($_SESSION['stocks'] as $stocks) {
	?>
	Event.observe("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseout",  function(){changeclassname ("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee");}, false);
	
	Event.observe("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseover",  function(){changeclassname ("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee_hover");}, false);
	
	Event.observe("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "click",  function(){documents_maj_adresse ("<?php echo ($stocks->getId_stock())?>", "<?php echo $_REQUEST["type_adresse"]?>", "<?php echo $_REQUEST["ref_doc"]?>", "<?php echo $_REQUEST["ref_contact"]?>"); }, false);
	<?php 
$i++;
}


?>
</script>
</div>