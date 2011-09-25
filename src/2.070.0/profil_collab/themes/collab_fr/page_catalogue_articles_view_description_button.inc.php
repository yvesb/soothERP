
<div style=" border-bottom:1px solid #000000">
<span style="float:right">


<a href='javascript:PopupCentrer("catalogue_articles_view_description_email.php?ref_article=<?php echo $article->getRef_article();?>",500,350,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes")'  >
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif"/>	</a>



<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" onClick="javascript:window.print()" style="cursor:pointer"/>
<a href="catalogue_articles_view_description_edition.php?ref_article=<?php echo $article->getRef_article();?><?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=1"; }?><?php 
				if (isset($_REQUEST["aff_qte"])) { echo "&aff_qte=".$_REQUEST["aff_qte"]; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>" target="_top">
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-editer.gif"  style="cursor:pointer"/>
</a>
</span>


<div>
<table>
<tr>
<td>
Afficher prix: 
</td>
<td>
<span id="tarif_encours_aff" class="simule_champs" style="position:relative; width:250px; cursor:pointer"  >

	<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="main_barr_tarifs">
	<tr>
	<td>
	<div id="tarif_a" style=" float:left; height:18px; margin-left:3px; line-height:18px; display:block ">
	<?php
	// tarif en cours d'affichage
	if (isset($_REQUEST["autre_prix"])) {
		echo "Autre prix: ".price_format($_REQUEST["autre_prix"])."&nbsp;".$MONNAIE[2]." ".$mode_taxation;
	} else {
		$price_affi = false;
		foreach ($tarifs_liste as $tarif_liste) {
				foreach ($liste_tarifs as $tarifs) {
					if (isset($_REQUEST["id_tarif"])) {
						if ($tarif_liste->id_tarif != $_REQUEST["id_tarif"]) { continue;}
						if ($_REQUEST["id_tarif"] == $tarifs->id_tarif) {
							echo htmlentities($tarif_liste->lib_tarif).": "; 
							echo price_format($tarifs->pu_ht*$aff_taxation )."&nbsp;".$MONNAIE[2]." ".$mode_taxation;
							$price_affi = true;
							break;
						}
					} else {
						if ($tarif_liste->id_tarif != $_SESSION['magasin']->getId_tarif()) { continue;}
						if ($tarif_liste->id_tarif == $tarifs->id_tarif) {
							echo htmlentities($tarif_liste->lib_tarif).": "; 
							echo price_format($tarifs->pu_ht*$aff_taxation )."&nbsp;".$MONNAIE[2]." ".$mode_taxation;
							$price_affi = true;
							break;
						}
					}
				}
			if ($price_affi) {break;}
		}
	}
	?>
	</div>
	</td>
	<td>
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="lib_art_categ_bt_select">
	</td>
	</tr>
	</table>

<div style="display:none; z-index:250; position:absolute;  top: 1.65em; left: -1px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:270px; height:300px; overflow:auto;" id="liste_tarifs_poss">

<?php
// liste des tarifs 
foreach ($tarifs_liste as $tarif_liste) {
	?>
	<a href="catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?>&id_tarif=<?php echo $tarif_liste->id_tarif;?><?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=1"; }?><?php 
				if (isset($_REQUEST["aff_qte"])) { echo "&aff_qte=".$_REQUEST["aff_qte"]; }?>" id="choix_grille_<?php echo $tarif_liste->id_tarif;?>" target="_top" style="cursor:pointer; width:99%">
	<?php echo htmlentities($tarif_liste->lib_tarif); ?>
	<?php
	foreach ($liste_tarifs as $tarifs) {
		if ($tarif_liste->id_tarif == $tarifs->id_tarif) {
			?>
		<?php echo price_format($tarifs->pu_ht*$aff_taxation )."&nbsp;".$MONNAIE[2]." ".$mode_taxation;?> 
		<?php
			break;
		}
	}
	?>
	</a>
	<?php
}
?>
<span id="aff_autre_prix">Autre prix: <input type="text" id="autre_prix" name="autre_prix" size="4" />
		<?php echo "&nbsp;".$MONNAIE[2]." ".$mode_taxation;?> </span>
</div> 
</span>
<script type="text/javascript">
Event.observe('main_barr_tarifs', 'click',  function(evt){Element.toggle('liste_tarifs_poss'); }, false);

Event.observe('autre_prix', 'blur',  function(evt){
	if (nummask(evt,"0", "X.X")) {
		window.open("catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?><?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=1"; }?><?php 
				if (isset($_REQUEST["aff_qte"])) { echo "&aff_qte=".$_REQUEST["aff_qte"]; }?>&autre_prix="+$("autre_prix").value,"_top");
	}
}, false);
</script>
</td>
<td>
<?php 
if (!isset($_REQUEST["aff_ht"])) { 
	?>
	<span id="aff_tarifs_ht" style="cursor:pointer"><input type="checkbox" name="chk_aff_tarifs_ht" id="chk_aff_tarifs_ht"  /> Afficher les prix HT<br />
	
	<script type="text/javascript">
	Event.observe('aff_tarifs_ht', 'click',  function(evt){
			$("chk_aff_tarifs_ht").checked="checked";
			window.open("catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?>&aff_ht=1<?php 
				if (isset($_REQUEST["aff_qte"])) { echo "&aff_qte=".$_REQUEST["aff_qte"]; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>","_top");
	}, false);
	</script>
	<?php
} else {
	?>
	<span id="aff_tarifs_TTC" style="cursor:pointer"><input type="checkbox" name="chk_aff_tarifs_TTC" id="chk_aff_tarifs_TTC"  /> Afficher les prix TTC<br />
	
	<script type="text/javascript">
	Event.observe('aff_tarifs_TTC', 'click',  function(evt){
			$("chk_aff_tarifs_TTC").checked="checked";
			window.open("catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?><?php 
				if (isset($_REQUEST["aff_qte"])) { echo "&aff_qte=".$_REQUEST["aff_qte"]; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>","_top");
	}, false);
	</script>
	<?php
}
?>
</td>
<td>
<?php 
if (!isset($_REQUEST["aff_qte"])) { 
	?>
	<span id="aff_qte_tarifs" style="cursor:pointer"><input type="checkbox" name="chk_aff_qte_tarifs" id="chk_aff_qte_tarifs"  /> Afficher les prix par quantités<br />
	<script type="text/javascript">
	Event.observe('aff_qte_tarifs', 'click',  function(evt){
			$("chk_aff_qte_tarifs").checked="checked";
			window.open("catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?>&aff_qte=1<?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=".$_REQUEST["aff_ht"]; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>","_top");
	}, false);
	</script>
	<?php
} else {
	?>
<span id="aff_qte_unique" style="cursor:pointer"><input type="checkbox" name="chk_aff_qte_unique" id="chk_aff_qte_unique"  /> Afficher le prix unitaire<br />
	<script type="text/javascript">
	Event.observe('aff_qte_unique', 'click',  function(evt){
			$("chk_aff_qte_unique").checked="checked";
			window.open("catalogue_articles_view_description.php?ref_article=<?php echo $article->getRef_article();?><?php 
				if (isset($_REQUEST["aff_ht"])) { echo "&aff_ht=".$_REQUEST["aff_ht"]; }?><?php 
				if (isset($_REQUEST["id_tarif"])) { echo "&id_tarif=".$_REQUEST["id_tarif"]; }?><?php 
				if (isset($_REQUEST["autre_prix"])) { echo "&autre_prix=".$_REQUEST["autre_prix"]; }?>","_top");
	}, false);
	</script>
	<?php
}
?>
</td>
</tr>
</table>
</div>
<br />
<br />

</div>