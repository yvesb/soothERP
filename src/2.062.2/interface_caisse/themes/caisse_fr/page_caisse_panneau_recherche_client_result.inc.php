<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "clients", "form['nom']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "profils", "form['orderby']", "form['orderorder']");
check_page_variables ($page_variables);


	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
// ------------------------------------------------------------------------
// barre_navigation
// ------------------------------------------------------------------------
function barre_navigation($nbtotal,
                          $nbenr, 
                          $cfg_nbres_ppage, 
                          $debut, 
													$cfg_nb_pages,
                          $idformtochange,
													$fonctiontolauch)
													
{
	// --------------------------------------------------------------------
	global $cfg_nb_pages; // Nb de n° de pages affichées dans la barre
global $DIR;
	$barre= "";	$lien_on 	= "&nbsp;<a href='#' id='link_pagi_{cible}'>{lien}</a>&nbsp;
								<script type='text/javascript'>
								Event.observe('link_pagi_{cible}', 'click',  function(evt){Event.stop(evt); $(\"{idchange}\").value={cibleb}; {fonctionlauch};}, false);
								</script>";
	$lien_off = "&nbsp;{lien}&nbsp;";
	// --------------------------------------------------------------------
    

	// début << .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage)
	{
		$cible = 1;
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible-1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= $lien."&nbsp;<strong>&middot;</strong>";


	// précédent < .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage)
	{
		$cible = ($nbenr-1);
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_off.gif');
		$lien = str_replace('{lien}', $image, $lien_off);
	}
	$barre .= $lien."&nbsp;<B>&middot;</B>";
    

	// pages 1 . 2 . 3 . 4 . 5 . 6 . 7 . 8 . 9 . 10
	// -------------------------------------------------------------------

	if ($debut >= ($cfg_nb_pages * $cfg_nbres_ppage))
	{
		$cpt_fin = ($debut / $cfg_nbres_ppage) + 1;
		$cpt_deb = $cpt_fin - $cfg_nb_pages + 1;
	}
	else
	{
		$cpt_deb = 1;
        
		$cpt_fin = (int)($nbtotal / $cfg_nbres_ppage);
		if (($nbtotal % $cfg_nbres_ppage) != 0) $cpt_fin++;
        
		if ($cpt_fin > $cfg_nb_pages) $cpt_fin = $cfg_nb_pages;
	}

	for ($cpt = $cpt_deb; $cpt <= $cpt_fin; $cpt++)
	{
		if ($cpt == ($debut / $cfg_nbres_ppage) + 1)
		{
				$barre .= "<A CLASS='off'>&nbsp;".$cpt."&nbsp;</A> ";
		}
		else
		{				$barre .= "<a href='#' id='link_txt_".$cpt."";
				$barre .= "'>&nbsp;".$cpt."&nbsp;</a>
								<script type='text/javascript'>
								Event.observe('link_txt_".$cpt."', 'click',  function(evt){Event.stop(evt); $(\"".$idformtochange."\").value=".$cpt."; ".$fonctiontolauch.";}, false);
								</script>";
		}
	}
    

	// suivant . >
	// --------------------------------------------------------------------
	if ($debut + $cfg_nbres_ppage < $nbtotal)
	{
		$cible = ($nbenr+1);
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_off.gif');
		$lien = str_replace('{lien}', $image, $lien_off);
	}
	$barre .= "&nbsp;<B>&middot;</B>".$lien;

	// fin . >>
	// --------------------------------------------------------------------
	$fin = ($nbtotal - ($nbtotal % $cfg_nbres_ppage));
	if (($nbtotal % $cfg_nbres_ppage) == 0) $fin = $fin - $cfg_nbres_ppage;

	if ($fin != $debut)
	{
		$cible = (int)($nbtotal/$cfg_nbres_ppage)+1;
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible+1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= "<B>&middot;</B>&nbsp;".$lien;
	return($barre);
}
// ------------------------------------------------------------------------
// image_html          
// ------------------------------------------------------------------------
function image_html($img)
{
    return '<img src="'.$img.'"    border="0" >';
}

//
//
//création de la barre de nav
//
//

	$cfg_nb_pages = 10;
	$barre_nav = "";
	$debut =(($form['page_to_show']-1)*$form['fiches_par_page']);
	
	$barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
																			 'page.annuaire_recherche_simple()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>

<table width="100%"  border="0" cellpadding="0" cellspacing="3">
	<tr>
		<?php
		$nb_fiches = count($clients);
		$i = 0;
		foreach ($clients as $client) {
			$lignes_nom = explode("\n", $client->getNom());
			$ligne1 = "&nbsp:";
			$ligne2 = "&nbsp";
			$ligne3 = "&nbsp";
			
			//if($client->getLib_civ_court())
			//	{$ligne1 .= "(".$client->getLib_civ_court().") ";}
			$ligne1 = $lignes_nom[0];
			if(count($lignes_nom)==2)
				{$ligne2 = $lignes_nom[1];}
			elseif(count($lignes_nom)>2)
				{$ligne2 = $lignes_nom[1]." ...";}
			if ($client->getAdresses())
				{ $adresses = $client->getAdresses();
					//var_dump($adresses);
					$ligne3 = $adresses[0]->getCode_postal()." ".$adresses[0]->getVille();
				}
			
				$profil_client = $client->getProfil(4);?>
			<td id="client_<?php echo $client->getRef_contact();?>" class="recherche_client_cell_client" align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td class="recherche_client_ligne_1"><?php echo $ligne1; ?></td>
					</tr>
					<tr>
						<td <?php if($ligne3 == ""){echo 'class="recherche_client_ligne_3"';}else{echo 'class="recherche_client_ligne_2"';}?>><?php echo $ligne2; ?></td>
					</tr>
					<tr>
						<td class="recherche_client_ligne_3"><?php echo $ligne3; ?></td>
					</tr>
				</table>
				<script type="text/javascript">
					Event.observe("client_<?php echo $client->getRef_contact();?>", "click", function(evt){
						Event.stop(evt);
						caisse_maj_client($("ref_ticket").value, "<?php echo $client->getRef_contact();?>");
		   			change_panneau_bas("recherche_article");
					}, false);
				</script>
			</td>
			<?php if(($i % 6) !=5) {?>
			<td>&nbsp;</td>
			<?php }
			if( $i > 0 && ($i % 6) == 5  ){ ?>
			</tr>
				<td colspan="11" height="8px"></td>
			<tr>
			<?php }
			$i++;
		}
		if($nb_fiches % 6 !=0){
			for($j=0; $j<(6-($nb_fiches % 6)); $j++){?>
				<td style="width:15%;">&nbsp;</td>
				<?php if(($j % 6 !=5) && ($j<(5-($nb_fiches % 6))) ) {?>
				<td><div style="height:60px"></div></td>
				<?php } 
			}
		}
		?>
	</tr>
	<?php if($nb_fiches <= 6){?>
	<tr>
		<td colspan="11" height="8px"></td>
	</tr>
	<tr>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
	</tr>
	<?php }
	if($nb_fiches <= 12){?>
	<tr>
		<td colspan="11" height="8px"></td>
	</tr>
	<tr>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
		<td  style="width:15%;">&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
	</tr>
	<?php }?>
</table>

<?php /*

<div class="mt_size_optimise">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>

</div>

<table  cellspacing="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:30%">
			<a href="#"  id="order_nom">
			Nom
			</a>
		</td>
		<td style="width:25%; text-align:center">
		</td>
		<td style="width:20%; text-align:left">
			<a href="#"  id="order_adresse">
			Adresse
			</a>

		</td>
		<td style="width:20%">
			T&eacute;l&eacute;phone
		</td>
		<td style="width:9%">
		</td>
		<td style="width:9%">
		</td>
		<td>
		</td>
	</tr>
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr class="<?php  echo  $class_colorise?>">
			<td>
				<a  href="#" id="nom_<?php echo ($fiche->ref_contact)?>" style="display:block; width:100%;"> <?php echo nl2br(($fiche->nom))?> (<?php echo ($fiche->lib_civ_court)?>)
				</a>
				<script type="text/javascript">
				Event.observe("nom_<?php echo ($fiche->ref_contact)?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
			<td  style="width:25%; text-align:right">
				<a  href="#" id="adresse_<?php echo ($fiche->ref_contact)?>" style="display:block; width:100%;" title="<?php	if ($fiche->text_adresse) { echo (($fiche->text_adresse));}?>"> 
				<?php	if ($fiche->text_adresse) { echo substr(nl2br(($fiche->text_adresse)),0,80);}?>&nbsp;
				</a>
				<script type="text/javascript">
				Event.observe("adresse_<?php echo ($fiche->ref_contact)?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
			<td style="width:20%; text-align:left">
				<a  href="#" id="ville_<?php echo ($fiche->ref_contact)?>" style="display:block; width:100%;"> 
				<?php	if ($fiche->ville) 				{ echo ($fiche->code_postal)." - ".($fiche->ville); }?>&nbsp;
				</a>
				<script type="text/javascript">
				Event.observe("ville_<?php echo ($fiche->ref_contact)?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
			<td>
				<a  href="#" id="tel_<?php echo ($fiche->ref_contact)?>" style="display:block; width:100%;">
				<?php	if ($fiche->tel1) 				{ echo ($fiche->tel1); }?>&nbsp;
				</a>
				<script type="text/javascript">
				Event.observe("tel_<?php echo ($fiche->ref_contact)?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
			<td style="text-align:center; vertical-align:middle">
			<?php if ($fiche->email && $fiche->email != "") {?>
			<a href="mailto:<?php echo $fiche->email;?>">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/mail.gif" width="15" border="0"  vspace="5"/>
			</a>
			<?php } ?>
			</td>
			<td style="text-align:center; vertical-align:middle; padding-right:8px">
			<?php if (isset($fiche->url) && $fiche->url != "") {?>
			<a href="<?php if (!preg_match("#^((http|https|ftp)://)#", $fiche->url)) {echo "http://";} ?><?php echo $fiche->url;?>" target="_blank">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/firefox.gif"  border="0" vspace="5"/>
			</a>
			<?php } ?>
			</td>
			<td style="text-align:center; vertical-align:middle">
				<a  href="#" id="voir_<?php echo ($fiche->ref_contact)?>" style="display:block; width:100%; text-decoration:underline">Voir
				</a>
				<script type="text/javascript">
				Event.observe("voir_<?php echo ($fiche->ref_contact)?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
		</tr>
		<?php
	}
	?>
</table>

<div id="affresult">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
			<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
			<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
		</tr>
	</table>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />

</div>
<SCRIPT type="text/javascript">

Event.observe("order_nom", "click",  function(evt){Event.stop(evt);$('orderby_s').value='nom'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="nom") {echo "DESC";} else {echo "ASC";}?>'; page.caisse_recherche_client_simple();}, false);

Event.observe("order_adresse", "click",  function(evt){Event.stop(evt);$('orderby_s').value='ville'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ville") {echo "DESC";} else {echo "ASC";}?>'; page.caisse_recherche_client_simple();}, false);
</SCRIPT>
*/ ?>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>