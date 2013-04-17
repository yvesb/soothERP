

<div style="height:50px;padding-right:3px;">
<ul class="complete_coordonnee">
<?php
$i=0;
foreach ($coordonnees as $coordonnee) {
	if ($coordonnee->getEmail() != "") {
		?>
		<li class="complete_coordonnee" id="li_choix_coord_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>">
		<?php 
		if ($coordonnee->getLib_coord()!="") {
			?>
			<strong><?php echo  htmlentities($coordonnee->getLib_coord())?></strong><br />
			<?php 
		}
		if ($coordonnee->getTel1()!="") {
			?>
			<span style="float: right;text-align:right"><?php echo  htmlentities($coordonnee->getTel1())?></span>
			T&eacute;l&nbsp;1: <br />
			<?php 
		}
		if ($coordonnee->getTel2()!="") {
			?>
			<span style="float: right;text-align:right"> <?php echo  htmlentities($coordonnee->getTel2())?></span>
			T&eacute;l&nbsp;2:<br />
			<?php 
		}
		if ($coordonnee->getEmail()!="") {
			?>
			<span style="float: right;text-align:right"> <?php echo  htmlentities(substr($coordonnee->getEmail(),0 ,15))?></span>
			Email:<br />
			<?php 
		}
		?>
		<?php 
		if ($coordonnee->getFax()!="") {
			?>
			<span style="float: right;text-align:right"> <?php echo  htmlentities($coordonnee->getFax())?></span>
			Fax:<br />
			<?php
		}
		?>
		</li>
		<?php 
		$i++;
	}
}?>
</ul>

<script type="text/javascript">
<?php
$i=0;
foreach ($coordonnees as $coordonnee) {
	if ($coordonnee->getEmail() != "") {
		?>
		
		Event.observe("li_choix_coord_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseout",  function(){changeclassname ("li_choix_coord_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee");}, false);
		
		Event.observe("li_choix_coord_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "mouseover",  function(){changeclassname ("li_choix_coord_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "complete_coordonnee_hover");}, false);
		
		Event.observe("li_choix_coord_<?php echo $_REQUEST["input"]?>_<?php echo $i;?>", "click",  function(){$("<?php echo $_REQUEST["input"]?>").value="<?php echo htmlentities($coordonnee->getRef_coord ())?>"; $("<?php echo $_REQUEST["choix_coord"]?>").style.display="none"; $("<?php echo $_REQUEST["iframe_choix_coord"]?>").style.display="none"; $("<?php echo $_REQUEST["div"]?>").innerHTML="<?php if ($coordonnee->getLib_coord()!="") {echo substr($coordonnee->getLib_coord(),0,20);} else { echo substr( $coordonnee->getTel1() ."- " . $coordonnee->getTel2() ."- " . $coordonnee->getFax() ."- " . $coordonnee->getEmail(),0,20);}?>.."; }, false);
		
		<?php 
		$i++;
	}
} 
 ?>
</script>
</div>