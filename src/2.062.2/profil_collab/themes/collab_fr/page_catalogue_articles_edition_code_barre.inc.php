<?php 
	if (isset($_ALERTES['code_barre_exist'])) {
		?>
		<p style="text-align:center; color:#FF0000">Ce Code barre existe d&eacute;j&agrave;! <br />
		<a href="#" id="view_art_exist_code_barre" class="common_link">Voir l'article correspondant</a>
		</p>
		<script type="text/javascript">
		Event.observe("view_art_exist_code_barre", "click",  function(evt){
		Event.stop(evt); 
		page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo $_ALERTES['code_barre_exist'];?>'),'true','_blank');
		}, false);
		</script>
		<?php 
	} else { 
		?>
		<script type="text/javascript">
		$("code_barre").value="";
		</script>
		<?php 
	}	
	?>
	
	<?php 
	// ----- Affichage des codes barres ------
	$serialisation_codes_barres	=	0;
	foreach ($codes_barres as $code_barre) {
		?>
		<li id="code_barre_<?php echo $serialisation_codes_barres?>">
		<table style="width:100%;">
		<tr>
		<td style="width:65%;">
			<div style="text-align:left;width:10%;float:left;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/droite_on.gif" border="0">
			</div>
			<div style="text-align:left;text-indent:10px;">
				<?php echo htmlentities($code_barre->code_barre)?>
			</div>
		</td>
		<td style="width:10%; text-align:right;">
			<a href="#" id="code_barre_del_<?php echo $serialisation_codes_barres?>">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
			</a>
		</td>
		</tr>
		</table>
		<script type="text/javascript">
		Event.observe("code_barre_del_<?php echo $serialisation_codes_barres?>", "click", function(evt){ alerte.confirm_supprimer_tag_and_callpage("code_barre_del", "code_barre_<?php echo $serialisation_codes_barres?>",																			"catalogue_articles_edition_code_barre_supp.php?code_barre=<?php echo urlencode($code_barre->code_barre)?>&ref_article=<?php echo urlencode($article->getRef_article());?>");	Event.stop(evt);});
		</script>
		</li>
		<?php
	$serialisation_codes_barres	+=	1;
	}
	?>
