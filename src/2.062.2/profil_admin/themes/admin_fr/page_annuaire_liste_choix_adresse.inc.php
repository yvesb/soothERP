
<div style="height:200px; padding-right:3px;">
<ul class="complete_adresse">
<?php
$i=0;
foreach ($adresses as $adresse) {
	?>
	<li class="complete_coordonnee" id="li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>">
	<?php
	if ($adresse->getLib_adresse()!="") {
		?>
		<strong><?php echo  htmlentities($adresse->getLib_adresse())?></strong><br />
		<?php 
	}
	if ($adresse->getText_adresse()!="") {
		?>
		<span style="float: right;text-align:right"><?php echo  htmlentities(substr($adresse->getText_adresse(),0 ,25))?></span>
		Adresse: <br />
		<?php 
	}
	if ($adresse->getCode_postal()!="") {
		?>
		<span style="float: right;text-align:right"> <?php echo  htmlentities($adresse->getCode_postal())?></span>
		Code Postal:<br />
		<?php 
	}
	if ($adresse->getVille()!="") {
		?>
		<span style="float: right;text-align:right"> <?php echo  htmlentities(substr($adresse->getVille(),0 ,25))?></span>
		Ville:<br />
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
foreach ($adresses as $adresse) {
	?>
	
	Event.observe("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseout",  function(){changeclassname ("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee");}, false);
	
	Event.observe("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseover",  function(){changeclassname ("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee_hover");}, false);
	
	Event.observe("li_choix_adresse_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "click",  function(){$("<?php echo $_REQUEST["input"]?>").value="<?php echo htmlentities($adresse->getRef_adresse ())?>"; $("<?php echo $_REQUEST["choix_adresse"]?>").style.display="none"; $("<?php echo $_REQUEST["iframe_choix_adresse"]?>").style.display="none"; $("<?php echo $_REQUEST["div"]?>").innerHTML="<?php if ($adresse->getLib_adresse()!="") {echo addslashes(substr($adresse->getLib_adresse(),0,20));} else { echo addslashes(substr( str_replace (CHR(13), "" ,str_replace (CHR(10), "" ,preg_replace ("#((\r\n)+)#", "", nl2br(htmlentities($adresse->getText_adresse()))))) ."- " . $adresse->getCode_postal() ."- " . $adresse->getVille(),0,20));}?>.."; }, false);
	
	<?php 
	$i++;
} 
 ?>
</script>
</div>