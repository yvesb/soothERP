<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

//step int : avancé de la commande
//	= 0		: Affichage du pannier
//	= 1		: Identification
//	= 2		: Choix du monde de liavraison
//	= 3		: Paiement
//	= 4		: Confirmation

//choix_livraison int
//	= -1	: On n'affiche pas la ligne de livraison
//	= 0		: On affiche la ligne et l'utilisateur devra en sélectionner
//	> 0		: On affiche la ligne a déjà choisi son mode de livraison

// Variables nécessaires à l'affichage
$page_variables = array ("Montant_ht", "Montant_ttc", "liste_contenu", "step", "page", "choix_livraison");
check_page_variables ($page_variables);

$indentation_contenu = 0;
$panier_vide = !count($liste_contenu);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<!-- LOGO -->
<div class="bg_ico_panier">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_panier.gif" />
	<div class="colorise0"></div>
</div>

<?php if($panier_vide) { ?>

<!-- PANIER VIDE -->
<div style="background-color:#FFFFFF; height: 45px;">
	<br />
	Votre panier est vide.
	<br />
	<br />
</div>
<?php } else { ?>

<!-- ETAPES -->
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="panier_text_etape">
			Votre commande
		</td>
		<td class="panier_text_etape">
			Identification
		</td>
		<td class="panier_text_etape">
			Livraison
		</td>
		<td class="panier_text_etape">
			Paiement
		</td>
		<td class="panier_text_etape">
			Confirmation
		</td>
	</tr>
	<tr >
		<td class="panier_line_etape">
			<?php if($step == 0){?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_white_dot.gif" />
			<?php }else{ ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
			<?php } ?>
		</td>
		<td class="panier_line_etape">
			<?php if($step == 1){?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_white_dot.gif" />
			<?php }else{ ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
			<?php } ?>
		</td>
		<td class="panier_line_etape">
			<?php if($step == 2){?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_white_dot.gif" />
			<?php }else{ ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
			<?php } ?>
		</td>
		<td class="panier_line_etape">
			<?php if($step == 3){?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_white_dot.gif" />
			<?php }else{ ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
			<?php } ?>
		</td>
		<td class="panier_line_etape">
			<?php if($step == 4){?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_white_dot.gif" />
			<?php }else{ ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td class="panier_text_etape" colspan="5"><br />
			
		</td>
	</tr>
</table>

<br />

<!-- LISTE DES ARTICLES -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="colorise0">
	<tr>
		<td style="width: 5%;" class="colorise0_debut" >&nbsp;</td>
		<td style="width:10%; text-align:left;" >
			Référence
		</td>
		<td style="width:25%; text-align:left; padding-left: 3px;">
			Description
		</td>
		<td style="width:10%;	text-align:center;">
			Qté
		</td>	
		<td style="width:10%; text-align:center;">
			Dispo
		</td>
		<td style="width:15%; text-align:right; font-weight:bolder;">
			Prix Unitaire <?php echo $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"];?>
		</td>	
		<td style="width:15%; text-align:right; font-weight:bolder;">
			Prix Total <?php echo $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"];?>
		</td>	
		<td style="width: 5%">&nbsp;</td>
		<td style="width: 5%" class="colorise0_fin" >&nbsp;</td>
	</tr>
</table>

<ul id="lignes" style="padding:0px; width:100%">
<?php
foreach ($liste_contenu as $contenu) { ?>
	<li id="<?php echo $indentation_contenu;?>" class="colorise_td_deco">
		<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_panier_line_".$contenu->type_of_line.".inc.php" ?>
	</li>
	<?php
	$Montant_ht +=  number_format( interface_article_pv ($contenu->article, $contenu->qte)*$contenu->qte, $TARIFS_NB_DECIMALES, ".", ""	);
	$Montant_ttc +=  number_format(( interface_article_pv ($contenu->article, $contenu->qte)*(1+$contenu->article->getTva()/100))*$contenu->qte, $TARIFS_NB_DECIMALES, ".", ""	);
	$indentation_contenu++;
} ?>
</ul>



<?php if($choix_livraison == 0 && isset($livraison_modes)) {?>

<!-- CHOIX DU MODE DE LIVRAISON -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="colorise0">
	<tr>
		<td style="width: 5%;"></td>
		<td style="width:35%">
			Sélectionnez votre mode de livraison
		</td>
		<td style="width:35%" colspan="2">
			<div style="text-align:right; padding-top:3px; padding-bottom:5px;">
				<form action="catalogue_panier_validation_step3.php" method="post" name="panier_step2" id="panier_step2">
					<?php $exist_mode_livraison = 0;
					foreach ($livraison_modes as $mode_liv) {
						if($mode_liv->nd) { continue; }
						$exist_mode_livraison = 1;
						echo $mode_liv->article->getLib_article();?> 
						<input type="radio" name="id_livraison_mode" id="id_livraison_mode_<?php echo $mode_liv->id_livraison_mode;?>" value="<?php echo $mode_liv->id_livraison_mode;?>" <?php if (isset($_REQUEST["id_livraison_mode"]) && $_REQUEST["id_livraison_mode"] == $mode_liv->id_livraison_mode ) {?>checked="checked"<?php } ?> /><br />
						<script type="text/javascript">
							Event.observe('id_livraison_mode_<?php echo $mode_liv->id_livraison_mode;?>', 'click',  function(evt){
							window.open ("<?php echo $page; ?>?id_livraison_mode=<?php echo $mode_liv->id_livraison_mode;?>","_self");
							},false);
						</script>
					<?php } ?>
				</form>
			</div>
		</td>	
		<td style="width:15%; text-align:right; padding-top:3px; padding-bottom:5px;" >
			<?php foreach ($livraison_modes as $mode_liv) {
				if ($mode_liv->nd ) { continue;}
				if ($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] == "HT") {
					$tmp_liv_mod = new livraison_modes ($mode_liv->id_livraison_mode);
					$tmp_art_liv = $tmp_liv_mod->getArticle();
					if (isset($_REQUEST["id_livraison_mode"]) && $_REQUEST["id_livraison_mode"] == $mode_liv->id_livraison_mode ) {
						$Montant_ht += price_format($mode_liv->cout_liv);
						$Montant_ttc += price_format(( $mode_liv->cout_liv*(1+$tmp_art_liv->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	);
					} ?>
					<span class="price_smaller"><?php echo price_format($mode_liv->cout_liv)."&nbsp;".$MONNAIE[1];?></span><br />
				<?php }else{
					$tmp_liv_mod = new livraison_modes ($mode_liv->id_livraison_mode);
					$tmp_art_liv = $tmp_liv_mod->getArticle();
					if (isset($_REQUEST["id_livraison_mode"]) && $_REQUEST["id_livraison_mode"] == $mode_liv->id_livraison_mode ) {
						$Montant_ht += price_format($mode_liv->cout_liv);
						$Montant_ttc += price_format(( $mode_liv->cout_liv*(1+$tmp_art_liv->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	);
					} ?>
					<span class="price_smaller"><?php echo price_format(( $mode_liv->cout_liv*(1+$tmp_art_liv->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];?></span><br />
				<?php }
			} ?>
		</td>
		<td style="width: 5%;"></td>
		<td style="width: 5%;"></td>
	</tr>
</table>
<?php }elseif($choix_livraison >0){ ?>

<!-- MODE DE LIVRAIONS DEJA CHOISI -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="colorise0">
	<tr>
		<td style="width: 5%;"></td>
		<td style="width:35%">
			Mode de livraison
		</td>
		<td style="width:35%">
			<div style="text-align:right; padding-top:3px; padding-bottom:5px;">
				<?php foreach ($livraison_modes as $mode_liv) {
					if($panier->getId_livraison_mode() != $mode_liv->id_livraison_mode )
					{			continue;}
					else{	echo $mode_liv->article->getLib_article();break;}
				} ?>
			</div>
		</td>	
		<td style="width:15%; text-align:right; padding-top:3px; padding-bottom:5px;" >
		<?php foreach ($livraison_modes as $mode_liv) {
			if ($panier->getId_livraison_mode() !=$mode_liv->id_livraison_mode )
			{		continue;}
			if ($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] == "HT") {
					$tmp_liv_mod = new livraison_modes ($mode_liv->id_livraison_mode);
					$tmp_art_liv = $tmp_liv_mod->getArticle();
					if (isset($_REQUEST["id_livraison_mode"]) && $_REQUEST["id_livraison_mode"] == $mode_liv->id_livraison_mode ) {
						$Montant_ht += price_format($mode_liv->cout_liv);
						$Montant_ttc += price_format(( $mode_liv->cout_liv*(1+$tmp_art_liv->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	);
					} ?>
					<span class="price_smaller"><?php echo price_format($mode_liv->cout_liv)."&nbsp;".$MONNAIE[1];?></span><br />
				<?php }else{
					$tmp_liv_mod = new livraison_modes ($mode_liv->id_livraison_mode);
					$tmp_art_liv = $tmp_liv_mod->getArticle();
					if (isset($_REQUEST["id_livraison_mode"]) && $_REQUEST["id_livraison_mode"] == $mode_liv->id_livraison_mode ) {
						$Montant_ht += price_format($mode_liv->cout_liv);
						$Montant_ttc += price_format(( $mode_liv->cout_liv*(1+$tmp_art_liv->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	);
					} ?>
					<span class="price_smaller"><?php echo price_format(( $mode_liv->cout_liv*(1+$tmp_art_liv->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];?></span><br />
				<?php }
		} ?>
		</td>	
		<td style="width: 5%;"></td>
		<td style="width: 5%;"></td>
	</tr>
</table>
<?php } ?>

<?php } ?>
<!-- MONTANT -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="colorise0">
	<tr>
		<td style="width: 5%;"></td>
		<td style="width:35%;"></td>
		<td style="width:35%;">
			<div style="text-align:right; padding-top:3px; padding-bottom:5px;">
				<span class="price_smaller">Prix Total HT:</span><br />
				<span class="price_smaller">Total T.V.A.:</span><br />
				<span class="price_bigger">Prix Total TTC:</span><br />
			</div>
		</td>	
		<td style="width:15%; text-align:right; padding-top:3px; padding-bottom:5px;" >
		<?php if ((!$_SESSION['user']->getLogin() && $AFF_CAT_PRIX_VISITEUR) || ($_SESSION['user']->getLogin() && $AFF_CAT_PRIX_CLIENT)) {?>
			<div style="text-align:right; ">
				<span class="price_smaller"><?php echo price_format($Montant_ht)."&nbsp;".$MONNAIE[1];?></span><br />
				<span class="price_smaller"><?php echo price_format($Montant_ttc-$Montant_ht)."&nbsp;".$MONNAIE[1];?></span><br />
				<span class="price_bigger"><?php echo price_format($Montant_ttc)."&nbsp;".$MONNAIE[1];?></span><br />
			</div>
			<?php }?>
		</td>	
		<td style="width: 5%;"></td>
		<td style="width: 5%;"></td>
	</tr>
</table>
<input type="hidden" value="<?php echo $indentation_contenu;?>" id="indentation_contenu" name="indentation_contenu"/>
