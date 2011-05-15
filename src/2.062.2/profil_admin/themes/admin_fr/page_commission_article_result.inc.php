<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

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
																			 'page.article_commission_recherche()');


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>

<div style="padding-left:10px; padding-right:10px">
<br />

	<table>
		<tr style=" ">
			<td>&nbsp;
			</td>
			<?php 
			foreach ($liste_commissions_regles as $comm_regle) {
				?>
			<td style="text-align:center; font-weight:bolder;  width:20%">
				<span><?php echo $comm_regle->lib_comm;?></span><br />
				<?php echo $comm_regle->formule_comm;?>
			</td>
				<?php
			}
			?>
			<td>&nbsp;
			</td>
		</tr>
		<tr style=" ">
			<td colspan="<?php echo count($liste_commissions_regles)+2;?>" style="border-bottom:1px solid #333333">&nbsp;
			</td>
		</tr>
<?php
foreach ($fiches as $fiche){
	?>
		<tr id="line_comm_article_<?php echo $fiche->ref_article;?>" style="">
			<td>
				<span><?php echo $fiche->lib_article;?></span>
			</td>
			<?php 
			foreach ($liste_commissions_regles as $comm_regle) {
				?>
			<td style="text-align:center">
			<input name="formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>" id="formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>" value="<?php 
			if (!isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]) || !isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm)) {?>non définie<?php } else { echo $fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm; } ?>" type="hidden"  class="classinput_hsize"/>
			<span id="aff_formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>" style="cursor:pointer; text-decoration:underline;" class="classinput_lsize"><?php 
			if (!isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]) || !isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm)) {?>non définie<?php } else { echo $fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm; } ?></span>
			
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="del_formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle; ?>" style="cursor:pointer"/>
			
			<script type="text/javascript">
			
			Event.observe('aff_formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle; ?>', "click", function(evt){
			
				Event.stop(evt);
			  $('pop_up_assistant_comm_commission').style.display='block';
				$('pop_up_assistant_comm_commission_iframe').style.display='block';
				$('assistant_comm_cellule').value='_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>';
				$('assistant_comm_id_commission_regle').value='<?php echo $comm_regle->id_commission_regle;?>';
				$('assistant_comm_article').value='<?php echo $fiche->ref_article;?>';
				$('old_formule_comm').value='<?php 
			if (isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]) && isset($fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm)) { echo $fiche->id_commission_regle[$comm_regle->id_commission_regle]->formule_comm; } ?>';
				edition_formule_commission_limited ("formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>", "<?php echo $comm_regle->formule_comm;?>"); });

			
			Event.observe('del_formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle; ?>', "click", function(evt){
				maj_commission_article ('<?php echo $comm_regle->id_commission_regle; ?>', '<?php echo $fiche->ref_article;?>', '', '');
				$('formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>').value = "";
				$('aff_formule_comm_<?php echo $fiche->ref_article;?>_<?php echo $comm_regle->id_commission_regle;?>').innerHTML = "non définie";
			});
			</script>
									
			</td>
				<?php
			}
			?>
			<td>&nbsp;
			</td>
		</tr>
	<?php
}
?>
	</table>

</div>

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
<SCRIPT type="text/javascript">

//centrage de l'assistant commission

centrage_element("pop_up_assistant_comm_commission");
centrage_element("pop_up_assistant_comm_commission_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_comm_commission_iframe");
centrage_element("pop_up_assistant_comm_commission");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>