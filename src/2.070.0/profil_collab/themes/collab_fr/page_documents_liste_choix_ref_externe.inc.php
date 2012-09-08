
<div style="height:200px; padding-right:3px;">
<ul class="complete_adresse">
<?php
$i=0;
foreach ($liste_choix_ref_externe as $choix_ref_externe) {
	?>
	<li class="complete_coordonnee" id="li_choix_ref_externe_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>">
	<?php
	if ($choix_ref_externe->ref_article_externe != "") {
		?>
		<?php echo $choix_ref_externe->ref_article_externe?><br />
		<?php 
	}
	?>
	</li>
	<?php 
	$i++;
}?>
</ul>

<script type="text/javascript">
<?php
$i=0;
foreach ($liste_choix_ref_externe as $choix_ref_externe) {
	?>
	
	Event.observe("li_choix_ref_externe_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseout",  function(){changeclassname ("li_choix_ref_externe_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee");}, false);
	
	Event.observe("li_choix_ref_externe_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseover",  function(){changeclassname ("li_choix_ref_externe_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee_hover");}, false);
	
	Event.observe("li_choix_ref_externe_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "click",  function(){
	$("<?php echo $_REQUEST["input"]?>").value = "<?php echo  htmlentities($choix_ref_externe->ref_article_externe)?>";
	$("<?php echo $_REQUEST["input"]?>").focus();
	delay_close ("<?php echo $_REQUEST["choix_ref_externe"]?>","<?php echo $_REQUEST["iframe_choix_ref_externe"]?>" );
	}, false);
	
	<?php 
	$i++;
} 
 ?>
</script>
</div>