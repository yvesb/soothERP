<br />
<hr/>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
		<td colspan="7">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="width:2%">&nbsp;</td>
		<td style="width:25%;" class="bolder" >Fournisseur</td>
		<td style="width:15%" class="bolder">Réf fournisseur</td>
		<td style="width:23%" class="bolder">Libellé</td>
		<td style="width:10%; text-align:right" class="bolder">Prix&nbsp;d'achat&nbsp;HT</td>
		<td style="width:15%; text-align:center" class="bolder">Date </td>
		<td style="width:8%" class="bolder"></td>
		<td style="width:5%" class="bolder"></td>
		<td style="width:2%">&nbsp;</td>
	</tr>
	<tr>
		<td ></td>
		<td colspan="7" style=" border-bottom:1px solid #999999">
		</td>
		<td></td>
	</tr>
	<?php
	$i = 0;
	foreach ($ref_externes as $ref_ext) {
		?>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo $ref_ext->nom;?></td>
			<td ><?php echo $ref_ext->ref_article_externe;?>
			</td>
			<td><?php echo $ref_ext->lib_article_externe;?>
			</td>
			<td style="text-align:right"><span  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>style="display:none;"<?php } ?> ><?php echo number_format($ref_ext->pa_unitaire,$TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></span>
			</td>
			<td style="text-align:center"><?php echo date_Us_to_Fr($ref_ext->date_pa);?>
			</td>
			<td >
			
				<span class="common_link" id="link_art_mod_ref_externe_<?php echo $i;?>">Modifier</span>
				<script type="text/javascript">
				Event.observe("link_art_mod_ref_externe_<?php echo $i;?>", "click",  function(evt){Event.stop(evt); 
				ouvre_article_ref_externe ();
				page.traitecontent("catalogue_articles_view_ref_externes_mod", "catalogue_articles_view_ref_externes_mod.php?ref_article=<?php echo $article->getRef_article ();?>&ref_fournisseur=<?php echo $ref_ext->ref_fournisseur;?>&ref_article_externe=<?php echo $ref_ext->ref_article_externe;?>", "true", "aff_ref_externe_content");
				}, false);
				</script>
			</td>
			<td >
			
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="link_art_sup_ref_externe_<?php echo $i;?>"/>
				<script type="text/javascript">
				Event.observe("link_art_sup_ref_externe_<?php echo $i;?>", "click",  function(evt){Event.stop(evt); 
				window.open("catalogue_articles_view_ref_externes_sup.php?ref_article=<?php echo $article->getRef_article ();?>&ref_fournisseur=<?php echo $ref_ext->ref_fournisseur;?>&ref_article_externe=<?php echo $ref_ext->ref_article_externe;?>", "formFrame");
				}, false);
				</script>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="7" style="border-bottom:1px solid #999999">
			</td>
			<td ></td>
		</tr>
		<?php 
		$i++;
	}
	?>
	<tr>
		<td>&nbsp;</td>
		<td colspan="7" style="width:90%; text-align:right" >
		<span class="common_link" id="link_art_add_ref_externe">Ajouter un fournisseur</span>
		<script type="text/javascript">
		Event.observe("link_art_add_ref_externe", "click",  function(evt){Event.stop(evt); 
		ouvre_article_ref_externe ();
		page.traitecontent("catalogue_articles_view_ref_externes_add_new", "catalogue_articles_view_ref_externes_add_new.php?ref_article=<?php echo $article->getRef_article ();?>", "true", "aff_ref_externe_content");
		}, false);
		</script>
		</td>
		<td>&nbsp;</td>
	</tr>			
</table>
<!--Evolution des prix-->

<div id="evolution_prices" style="position:relative">
</div>
<script type="text/javascript">
<?php
//traitement historique des prix
if (isset($prix_histo["pv"])) {
	$x_array = array();
	$y_array = array();
	foreach ($prix_histo["pv"] as $pv) {
		$x_array[] =  floor((time()-strtotime($pv->date_maj))/1500);
		$y_array[] =  floor( $pv->pu_ht );
	}
}
if (isset($prix_histo["pa"])) {
	$xa_array = array();
	$ya_array = array();
	foreach ($prix_histo["pa"] as $pa) {
		$xa_array[] =  floor((time()-strtotime($pa->date_maj))/1500);
		$ya_array[] =  floor( $pa->prix_achat_ht );
	}
}
?>

</script>