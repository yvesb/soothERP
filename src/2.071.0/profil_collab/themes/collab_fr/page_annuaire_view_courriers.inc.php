<?php
// *************************************************************************************************************
// CHARGEMENTS DES COURRIERS D'UN CONTACT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "courriers", "coordonnees", "form['id_profil']", "form['page_to_show']", "form['courriers_par_page']", "nb_courriers", "profils", "form['orderby']", "form['orderorder']");
check_page_variables ($page_variables);


	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
// ------------------------------------------------------------------------
// barre_navigation
// ------------------------------------------------------------------------

function barre_navigation($nbtotal, //nb total d'élement
                          $nbenr,  //num de la page à afficher
                          $cfg_nbres_ppage, //nb d'élément par page à afficger
                          $debut, //début de l'interval à afficher
													$cfg_nb_pages, //nb d'élément par page à afficger
                          $idformtochange, //le input stockant numéro de la page affichée 
													$fonctiontolauch) //fonction javascript à appeler lors du changement de page
													
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

	$cfg_nb_pages = 5;
	$barre_nav = "";
	$debut =(($form['page_to_show']-1)*$form['courriers_par_page']);
	//
	$barre_nav .= barre_navigation(	$nb_courriers,	//nb total d'élement
																	$form['page_to_show'],	//num de la page à afficher
																	$form['courriers_par_page'], //nb d'élément par page à afficger
																	$debut,		//début de l'interval à afficher
																	$cfg_nb_pages,	//nb d'élément par page à afficger
																	'page_to_show_s',//le input stockant numéro de la page affichée 
																 	'page.annuaire_recherche_courriers()'); //fonction javascript à appeler lors du changement de page
																			

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<!-- 	Script pour gérer la pop-up "courrier_choix_type" pour choisir lors de la création d'un courrier le type et 
			le modele d'impression d 'un courrier -->
<script type="text/javascript">
	centrage_element("courrier_choix_type");
	Event.observe(window, "resize", function(evt){centrage_element("courrier_choix_type");});
	Event.observe("nouveau_message", "click",  function(evt){
		Event.stop(evt);
		page.traitecontent('nouveau_message','courriers_choix_type.php?'+
																				'page_source=annuaire_view_courriers'+
																				'&page_cible=courriers_edition.php'+
																				'&cible=contactview_courrier'+
																				'&ref_destinataire=<?php echo $ref_contact; ?>'
																				,'true','courrier_choix_type');	
		$("courrier_choix_type").show();
	});
</script>

<!-- Script pour gérer la pop-up "courrier_options" pour gérer les option d'un courrier -->
<script type="text/javascript">
	centrage_element("courrier_options");
	Event.observe(window, "resize", function(evt){centrage_element("courrier_options");});
</script>
<br/>
<div style=" text-align:left; padding:0 20px">
	<?php 
		//@TODO COURRIER : changer l'image du bouton test en [Rédaction d'un nouveau message]
	?> 
	<a  href="#" id="nouveau_message"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-redac_nouv_msg.gif" /></a>
	<?php // integration gmail 
if(count($coordonnees)>0) {
		$href = "https://mail.google.com/mail/?shva=1#search/";
		$query = '';
		$i=0;
		$coordonneesF = array();
		foreach($coordonnees as $c) {
			if($c->getEmail()!='') {
				$coordonneesF[]=$c;
			}
		}
		foreach($coordonneesF as $c) {
			$i++;
			$query .= $c->getEmail();
			if($i!=count($coordonneesF)) {
				$query .= ' OR ';
			}
		}
		$href .= $query;
	?>
	<a  href="<?php echo $href;?>" target="_blank" id="gmail_messages" style="float:right">Voir les emails sur Gmail</a>
<?php
}
else {
?>
	<span  href="#" id="gmail_messages" style="float:right">Ajoutez une adresse email aux coordonnées pour voir les mails sur Gmail</span>
<?php
}
?>
</div>
<br/>
<div style=" text-align:left; padding:0 20px">
	<table style="width:100%" border="0">
		<tr>
			<td>
				<?php
				if (count($courriers)) {
					?>								
				<div class="art_new_info" >
					<table width="100%" border="0" cellspacing="0" cellpadding="0" height="5px">
						<tr class="smallheight">
							<td  style="width:4%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:38%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:15%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:2%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:15%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:2%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td colspan="4" style="width:24%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
						</tr>
						<tr style="color:#002673" height="25px">
							<td style="text-align:center;" >
								<!-- FUTUR DEV : bt suivi ici -->
								<span id="order_suivi" style="cursor:pointer;" >&nbsp;</span>
							</td>
							<td style="text-align:left;" >
								<span id="order_objet" style="cursor:pointer;font-weight:bold" >Objet</span>
							</td>
							<td style="text-align:left;" >
								<span id="order_expediteur" style="cursor:pointer;font-weight:bold" >Expéditeur</span>
							</td>
							<td></td>
							<td style="text-align:left;" >
								<span id="order_date" style="cursor:pointer;font-weight:bold" >Date</span>
							</td>
							<td></td>
							<td colspan="4" style="text-align:right;font-weight:bold;padding-right:5px;">
								R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($courriers)?> sur <?php echo $nb_courriers?>
							</td>
						</tr>
						<tr class="smallheight">
							<td  style="width:4%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:38%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:15%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:2%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:15%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td  style="width:2%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
							<td colspan="4" style="width:24%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1px" id="imgsizeform"/></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr height="5px">
			<td>
			</td>
		</tr>
		<tr>
			<td>
				<div class="art_new_info" >
					<?php
					foreach ($courriers as $courrier) {
					if(1==2){$courrier = new CourrierEtendu(0);}
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
						<tr class="smallheight" style="">
							<td  style="width:4%; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
							<td  style="width:38%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
							<td  style="width:15%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
							<td  style="width:2%; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
							<td  style="width:15%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
							<td  style="width:2%; "><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
							<td colspan="4" style="width:24%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" /></td>
						</tr>
						<tr id="ligne_courrier_<?php echo $courrier->getId_courrier(); ?>" >
						<?php 
							// Colore la ligne en fonction de l'état du courrier
							$color_line = "";
							switch ($courrier->getId_etat_courrier()) {
								case 1:{$color_line = "color:red;"; break;}	// état : En cours de rédaction
								case 2:{$color_line = ""; break;}						// état : Courrié rédigé	
								case 3:{$color_line = "color:gray;"; break;} // état : Courrié annulé
								default:{$color_line = ""; break;}
							}
						?>
							<td style="text-align:center;<?php echo $color_line;?>" >
								<?php 
									//@TODO COURRIER : emplacement du BOUTON suivi (petite étoile plus ou moins comme dans Gmail) 
								?>
								&nbsp;
							</td>
							<td  style="text-align:left;<?php echo $color_line;?>" >
								<?php echo $courrier->getObjet();?>
							</td>
							<td  style="text-align:left;<?php echo $color_line;?>" >
								<?php 
									$tmp_events = $courrier->getEvents();
									echo $tmp_events[0]->getUtilisateur()->getPseudo();
								?>
							</td>
							<td>&nbsp;</td>
							<td  style="text-align:left;<?php echo $color_line;?>" >
								<?php
									//echo date_Us_to_Fr($courrier->getDate_courrier());
									$d = new DateTime($courrier->getDate_courrier());
									echo $d->format("d-m-Y H:i:s");
								?>
							</td>
							<?php /*
							<td  style=" border-bottom:1px solid #FFFFFF; text-align:left; padding-left:5px" id="open_courrier_4_<?php echo $courrier->getId_courrier();?>">
								<?php echo ($courrier->getLib_etat_courrier());?>
							</td>
							*/ ?>
							<td>&nbsp;</td>
							<td style="text-align:center; "><span style="cursor:pointer;font-size:8pt;color:#707072;" id="visualiser_courrier_<?php echo $courrier->getId_courrier();?>">Visualiser</span></td>
							<td style="text-align:center; "><span style="cursor:pointer;font-size:8pt;color:#707072;" id="editer_courrier_<?php echo $courrier->getId_courrier();?>">Modifier</span></td>
							<td style="text-align:center; ">
								<span style="cursor:pointer;font-size:8pt;color:#707072;" id="envoyer_courrier_<?php echo $courrier->getId_courrier();?>">Envoyer</span>
								<div id="choix_send_courrier_<?php echo $courrier->getId_courrier();?>"  class="choix_send_courrier" style="display:none;text-align:left;background-color:#e5eef5;">
									<table>
									  <tr>
									    <td><img id="courrier_print_<?php echo $courrier->getId_courrier();?>" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" /></td>
									  </tr>
									  <tr style="display:none"> 
									  <?php 
									  	//@TODO COURRIER : Gestion du FAX : emplacement du bouton
									  ?>
									    <td><img id="courrier_fax_<?php echo $courrier->getId_courrier();?>" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fax.gif" /></td>
									  </tr>
									  <tr>
									  	<td><img id="courrier_email_<?php echo $courrier->getId_courrier();?>" style="cursor:pointer" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email.gif" /></td>
									  </tr>
									</table>
								</div>
							</td>
							<td style="text-align:center; "><span style="cursor:pointer;font-size:8pt;color:#707072;" id="options_courrier_<?php echo $courrier->getId_courrier();?>">Options</span>
								<?php /*
									<a href="courriers_editing.php?id_courrier=<?php echo $courrier->getId_courrier()?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="PDF" title="PDF"/></a>
								*/ ?>
								<script type="text/javascript">
									Event.observe("visualiser_courrier_<?php echo $courrier->getId_courrier();?>", "click", function(evt){
											Event.stop(evt);
											page.verify("visualiser_courrier","courriers_editing.php?id_courrier=<?php echo $courrier->getId_courrier(); ?>","true","_blank");});

									Event.observe("editer_courrier_<?php echo $courrier->getId_courrier();?>", "click", function(evt){
										Event.stop(evt);
										page.traitecontent('editer_courrier',"courriers_edition.php?ref_destinataire=<?php echo $ref_contact.'&id_courrier='.$courrier->getId_courrier(); ?>",'true','contactview_courrier');});

									Event.observe("envoyer_courrier_<?php echo $courrier->getId_courrier();?>", "click", function(evt){
										Event.stop(evt);
										if ($("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.display=="none") {
											$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.left = (getOffsetLeft($("envoyer_courrier_<?php echo $courrier->getId_courrier();?>"))-5)+"px";
											$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.top =  (getOffsetTop( $("envoyer_courrier_<?php echo $courrier->getId_courrier();?>"))+26)+"px";
											$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.display="block";
											$("envoyer_courrier_<?php echo $courrier->getId_courrier();?>").style.fontWeight="bold";
										} else {
											$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.display="none";
											$("envoyer_courrier_<?php echo $courrier->getId_courrier();?>").style.fontWeight="";
										}
										});
									
									Event.observe("courrier_print_<?php echo $courrier->getId_courrier();?>", "click",  function(evt){
										Event.stop(evt); //&print=1
										page.verify("visualiser_courrier","courriers_editing.php?id_courrier=<?php echo $courrier->getId_courrier(); ?>&mode_edition=1&print=1","true","_blank");
										$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.display="none";
										$("envoyer_courrier_<?php echo $courrier->getId_courrier();?>").style.fontWeight="";
										<?php
											//@TODO COURRIER : RAFRECHIR LA LISTE DES COURRIERS QUAND ON IMPRIME UN COURRIER
											//il y a un changement d'état -> changement de couleur
											/*$("ligne_courrier_<?php echo $courrier->getId_courrier(); ?>").style.color = "black";*/
										?>
									}, false);

									<?php 
										//@TODO COURRIER : Gestion du FAX : emplacement du code Javascript qui gère le bouton
									?>
									Event.observe("courrier_fax_<?php echo $courrier->getId_courrier();?>", "click",  function(evt){
										Event.stop(evt); 
										alert("fonction non gérée");
										$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.display="none";
										$("envoyer_courrier_<?php echo $courrier->getId_courrier();?>").style.fontWeight="";
										<?php
												//@TODO COURRIER : RAFRECHIR LA LISTE DES COURRIERS QUAND ON IMPRIME UN COURRIER
												//il y a un changement d'état -> changement de couleur
												/*$("ligne_courrier_<?php echo $courrier->getId_courrier(); ?>").style.color = "black";*/
											?>
									}, false);
									
									Event.observe("courrier_email_<?php echo $courrier->getId_courrier();?>", "click",  function(evt){
										Event.stop(evt);
									 	<?php
										 		//@TODO COURRIER : MODES_EDITIONS : gérer porprement le paramètre mode_edition -> Voir table editions_modes 
										?>
										PopupCentrer("courriers_editing_email.php<?php echo "?id_courrier=".$courrier->getId_courrier()."&mode_edition=2&code_pdf_modele=".$courrier->getCode_pdf_modele(); ?>",800,450,"menubar=no,statusbar=no,scrollbars=yes,resizable=yes");
										$("choix_send_courrier_<?php echo $courrier->getId_courrier();?>").style.display="none";
										$("envoyer_courrier_<?php echo $courrier->getId_courrier();?>").style.fontWeight="";
										<?php
												//@TODO COURRIER : RAFRECHIR LA LISTE DES COURRIERS QUAND ON IMPRIME UN COURRIER
												//il y a un changement d'état -> changement de couleur
												/*$("ligne_courrier_<?php echo $courrier->getId_courrier(); ?>").style.color = "black";*/
											?>
									}, false);

									Event.observe("options_courrier_<?php echo $courrier->getId_courrier();?>", "click", function(evt){
										Event.stop(evt);
										page.traitecontent('options_courrier_<?php echo $courrier->getId_courrier();?>','courriers_options.php?'+
																												'page_source=annuaire_view_courriers'+
																												'&page_cible=none'+
																												'&cible=none'+
																												'&id_courrier=<?php echo $courrier->getId_courrier(); ?>'+
																												'&ref_destinataire=<?php echo $ref_contact; ?>'
																												,'true','courrier_options');	
										$("courrier_options").show();
									});
								</script>
							</td>
						</tr>
					</table>
					<?php 
					}
					?>
				</div>
				<?php
				}else{ ?>
					Aucun courrier
				<?php } ?>
			</td>
		</tr>
	</table>
</div>

<br/>
<?php if (count($courriers)) { ?>	
<!-- Barre de navigation -->
<div id="nvbar" style="text-align:center;">
	<?php echo $barre_nav;?>
</div>

<!-- Pour débugguer mettre display:block -->
<div style="text-align:right; display:none;">
	<?php $d = new DateTime();
				echo "dernière mise à jour de la page :".$d->format("H:i:s"); ?><br/>
	nb_courriers<input value="<?php echo $nb_courriers;?>" /><br/>
	form[page_to_show]<input value="<?php echo $form['page_to_show'];?>" /><br/>
	form[courriers_par_page]<input value="<?php echo $form['courriers_par_page'];?>" /><br/>
	debut<input value="<?php echo $debut;?>" /><br/>
	cfg_nb_pages<input value="<?php echo $cfg_nb_pages;?>" /><br/>

	<!-- Inputs nécessaires pour la barre de navigation  -->
	ref_contact<input type="text" name="ref_contact" id="ref_contact" value="<?php echo $ref_contact;?>"/><br/>
	page_to_show<input type="text" name="page_to_show" id="page_to_show" value="1"/><br/>
	page_to_show_s<input type="text" name="page_to_show_s" id="page_to_show_s" value="1"/><br/>
	orderby_s<input type="text" name="orderby_s" id="orderby_s" value="<?php echo $search['orderby'];?>" /><br/>
	orderorder_s<input type="text" name="orderorder_s" id="orderorder_s" value="<?php echo $search['orderorder'];?>" /><br/>
</div>
<?php } ?>

<SCRIPT type="text/javascript">
//remplissage si on fait un retour dans l'historique

/*if (historique_request[0][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	if (historique_request[0][1] == "avancee") {
		$('page_to_show').value = historique_request[0]["page_to_show"];
	}
}*/
</SCRIPT>

<!-- Script pour trier les résultats suivant le suivi, l'objet, l'expediteu ou la date -->
<SCRIPT type="text/javascript">
Event.observe("order_suivi", "click",  function(evt){
	Event.stop(evt);
	//Pour l'instant, le suivi des courriers n'est pas géré, donc, on le traite comme quand on clic sur objet
	$('orderby_s').value='objet';
	$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="objet") {echo "DESC";} else {echo "ASC";}?>';
	page.annuaire_recherche_courriers();
	}, false);
Event.observe("order_objet", "click",  function(evt){
	Event.stop(evt);
	$('orderby_s').value='objet';
	$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="objet") {echo "DESC";} else {echo "ASC";}?>';
	page.annuaire_recherche_courriers();
	}, false);
Event.observe("order_expediteur", "click",  function(evt){
	Event.stop(evt);
	$('orderby_s').value='expediteur';
	$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="expediteur") {echo "DESC";} else {echo "ASC";}?>';
	page.annuaire_recherche_courriers();
	}, false);
Event.observe("order_date", "click",  function(evt){
	Event.stop(evt);
	$('orderby_s').value='date';
	$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date") {echo "DESC";} else {echo "ASC";}?>';
	page.annuaire_recherche_courriers();
	}, false);
</SCRIPT>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
