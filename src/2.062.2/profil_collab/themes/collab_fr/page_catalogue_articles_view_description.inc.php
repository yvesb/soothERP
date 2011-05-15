<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $article->getLib_article();?></title>
<style type="text/css"  >
<!--
body {
margin: 5px;
}
img {
border:0px;
}
body, td, th, p {
font: 0.9em Arial, Helvetica, sans-serif;
}

form {
padding:0;
margin:0;
}

table {
margin:0;
padding:0;
}
td {
vertical-align:top;
}

#grand_contener {
height: 100%;
}

dl, dt, dd, ul, li {
margin: 0;
padding: 0;
list-style-type: none;
}

img {
border:0px;
vertical-align:middle
}


/* menu principal*/

#bgmain_menu {
font: 1em Arial, Helvetica, sans-serif;
z-index:249;
position: absolute;
top: 0px;
left: 0px;
width:100%;
height:21px;
background-color:#7fa8ea;
border-bottom:1px outset #FFCC00;
}
#menu {
font: 1em Arial, Helvetica, sans-serif;
z-index:250;
position: absolute;
top: 0px;
left: 0px;
width:100%;
height:22px;
}

table.item   { 
color: #000000; 
font:1em Verdana; 
cursor:pointer;
padding:0;
height:22px;
}

table.subitem { 
background-color: #c9d8eb; 
color: #000000; 
font:1em Arial, Helvetica, sans-serif; 
cursor: pointer;
border-bottom:1px outset #FFCC00;
border-left:1px outset #FFCC00;
border-right:1px outset #FFCC00;
}			 
table.subitem td {
vertical-align:middle;
line-height:22px;
height:22px;
}  

a.item       {
padding-top:3px;
padding-left:4px;
padding-right:25px;
padding-bottom:0px;
line-height:22px;
display:block; 
font:1em Arial, Helvetica, sans-serif; 
text-decoration: none; 
color: #000000;
}

a.item_hover { 
border-left:1px outset #FFCC00;
border-right:1px outset #FFCC00;
padding-top:0px;
padding-left:3px;
padding-right:24px;
font:1em Arial, Helvetica, sans-serif; 
line-height:22px;
display:block; 
text-decoration: none; 
color: #000000;
background-color: #c9d8eb; 
}
   
a.subitem       {
padding-bottom:0px;
padding-left:4px;
padding-top:0px;
padding-right:25px;
height:22px;
display:block;
font:1em Arial, Helvetica, sans-serif; 
text-decoration: none; 
color: #000000;
}

a.subitem:hover { 
text-decoration: none; 
color: #000000;
display:block;
background-color: #7fa8ea; 
cursor:pointer;
}

#framemenu{
top:22px;
left:0px; 
width:150px; 
height:150px; 
z-index:299;  
position:absolute; 
filter:alpha(opacity=0);
display:none;
}


#framealert{
top:0px;
left:0px; 
width:0px; 
height:0px; 
z-index:999;  
position:absolute; 
filter:alpha(opacity=0);
display:none;
}

/*sous-content*/
#sub_content{
z-index:200;
padding:0;
width:100%;
border:0;
overflow:auto;
}


.emarge {
padding:0 15px;
}

/* contenu agenda */
#right_content {
background-color:#c9d8eb;
position:absolute;
right:0px;
top:22px;
z-index:230;
width:1%;
height:100%;
}

#load_show {
font: 1em Arial, Helvetica, sans-serif;
color:#FFFFFF;
position:absolute; 
z-index:900; 
visibility:hidden; 
right: 150px; 
top:0px;
margin:0;
text-decoration:none;
text-align:left;
}

#refresh_content {
font: 1em Arial, Helvetica, sans-serif;
color:#FFFFFF;
position:absolute; 
z-index:901; 
right: 3px; 
top:0px;
margin:0;
text-decoration:none;
text-align:left;
cursor:pointer;
}

#deco a {
font: 1em Arial, Helvetica, sans-serif;
height:22px;
line-height: 22px;
color:#000000;
width:100%;
margin:0 auto;
text-decoration:none;
text-align:center;
}

#deco a:hover {
background-color:#7fa8ea;
}

/* textes généraux*/

.titre {
font: 1.6em  Arial, Helvetica, sans-serif ;
font-weight:bolder;
color: #002673;
line-height: 45px;
display:block;
}
.titre_no_height {
font: 1.6em  Arial, Helvetica, sans-serif ;
font-weight:bolder;
color: #002673;
display:block;
}

.titre_second{
font: 1.2em  Arial, Helvetica, sans-serif ;
color: #002673;
}

.sous_titre1 {
font: 1.3em bolder Arial, Helvetica, sans-serif ;
color: #002673;
height:24px;
line-height: 24px;
padding-left:2em;
}

.sous_titre2 {
font: 1.3em bolder Arial, Helvetica, sans-serif ;
color: #002673;
}

.bleu_liner {
width: 88%;
color: #c9d8eb;
height:0px;
border-top:1px #c9d8eb solid;
}

.grisee {
background-color:#dbe8f0;
border:1px solid #a3dbf4;

}

.handle {
cursor:move;
}

/* alerte */
#alert_pop_up {
filter:alpha(opacity=50); 
-moz-opacity:.50; 
opacity:.50; 
background-color:#FFFFFF; 
position: absolute; 
top:0; 
left:0; 
width:100%; 
min-height: 100%; 
padding:0; 
height: auto; 
height: 100%; 
display:none; 
line-height:100%; 
z-index: 1000;
}

.alert_pop_up_tab {
border:1px solid #000000; 
position:absolute; 
display: none; 
left: 50%; 
top: 50%; 
width: 300px;  
margin-top: -100px; 
margin-left: -150px; 
z-index: 1001;
}
.alert_pop_up__exception_tab {
border:1px solid #000000; 
position:absolute; 
display: none; 
left: 50%; 
top: 50%; 
width: 400px;  
margin-top: -100px; 
margin-left: -150px; 
z-index: 1001;
}
.alert_wait_calcul {
position:absolute; 
left: 50%; 
top: 50%; 
width: 300px;  
margin-top: -100px; 
margin-left: -150px;
text-align:center
z-index: 955;
}
#bouton0 {
}
#bouton1 {
}
#titre_alert {
line-height:20px;
padding:0 10px;
font:0.9em Arial, Helvetica, sans-serif;
height:20px; 
background-color:#CCCCCC; 
border-bottom:1px solid #000000;
}
#texte_alert {
padding:10px 10px;
vertical-align:middle;
text-align:center;
font:0.9em Arial, Helvetica, sans-serif;
background-color:#ffffff;
}
#bouton_alert {
text-align:center;
padding:10px 10px;
background-color:#ffffff; 
height:20px;
}

/*
couleur pour catégories d'articles dans la création d'article
*/



.row_color {
width:100%;
background-color:#556b8f;
color:#FFFFFF;
}
.row_color td{
color:#FFFFFF;
font:1.5em bolder Arial, Helvetica, sans-serif;
text-align:center;
}


.row_color_0 {
width:100%;
background-color:#abb1ba;
color:#000000;
}
.row_color_0 td {
font: 1.1em bolder Arial, Helvetica, sans-serif;
font-weight:bolder;
}
.col_color_2{
font: 0.9em Arial, Helvetica, sans-serif;
background-color:#dbe8f0;
}
.col_color_1 {
background-color:#c2cfd7;
}

.bolder {
font-weight: bolder;
}

.align_center {
text-align:center
}

-->
</style>
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_annuaire_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_formulaire.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/mini_moteur.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_articles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_documents.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/annuaire_modif_fiche.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_small_wysiwyg.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"/></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/scriptaculous/scriptaculous.js?load=effects,dragdrop"/></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/selectupdater.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_tab_alerte.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_row_menu.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_main_menu.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_mini_moteur.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_articles.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_documents.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_bancaire.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_caisse.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_tpe.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compte_cb.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_taches.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_compta.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_stock.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_tarifs.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_small_wysiwyg.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_annuaire.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_formulaire.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/swfobject.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_general.js"></script>
<SCRIPT LANGUAGE="JavaScript">

function PopupCentrer(page,largeur,hauteur,optionsi) {
  var top=(screen.height-hauteur)/2;
  var left=(screen.width-largeur)/2;  
  window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+optionsi);
}


	//lancement proto de chargement de contenu
	//require _general.js	
	var page= new appelpage("sub_content");
	
	//lancement proto des alertes
	//require _general.js
	var alerte= new alerte_message();
	var editeur= new HTML_wysiwyg();
	
</SCRIPT>

<style media="print" type="text/css">
#menu_barre_
{
	display:none;
}
</style>
</head>

<body>
<div id="menu_barre_">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_description_button.inc.php" ?>
</div>
<div id="fiche_article">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
			<span style=" font:24px Arial, Helvetica, sans-serif"><?php echo $article->getLib_article();?></span>
			
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>Référence: &nbsp;</td>
				<td><?php echo $article->getRef_article();?>&nbsp;</td>
			</tr>
			<tr>
				<td>Constructeur: &nbsp;</td>
				<td><?php echo $article->getNom_constructeur();?>&nbsp;</td>
			</tr>
			<tr>
				<td>Référence &nbsp;constructeur:&nbsp;</td>
				<td><?php echo $article->getRef_eom();?>&nbsp;</td>
			</tr>
		</table>
		<div>&nbsp;</div>
		</td>
		<td width="30%" rowspan="2">
		<div align="center">
		
		<?php 
		
		for ($i = 0; $i<count($images); $i++) {
			?>
			<table style="">
			<tr>
			<td style="width:160px">
			<a href="http://<?php echo $_SERVER['HTTP_HOST'].str_replace("profil_collab/catalogue_articles_view_description.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $ARTICLES_IMAGES_DIR.$images["$i"]->lib_file);?>" target="_blank">
			<img src="http://<?php echo $_SERVER['HTTP_HOST'].str_replace("profil_collab/catalogue_articles_view_description.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $ARTICLES_MINI_IMAGES_DIR.$images["$i"]->lib_file);?>" id="<?php echo $images["$i"]->id_image;?>" style="border:0px"/>
			</a>
			</td>
			</tr>
			</table>
			<?php if ($i == 0) { 
				?>
				<div style="text-align:center">
				
				<?php
				//tarif affiché
				
				if (isset($_REQUEST["autre_prix"])) {
					?>
					<span style="text-align:center; font:20px Arial, Helvetica, sans-serif">
					<?php echo price_format($_REQUEST["autre_prix"])."&nbsp;".$MONNAIE[1]." ".$mode_taxation;?></span><br />

					<?php
				} else if (isset($_REQUEST["id_tarif"])) {
					$i=0;
					foreach ($liste_tarifs as $tarifs) {
						if ($_REQUEST["id_tarif"] == $tarifs->id_tarif) {
							?>
							<span style="text-align:center; font:<?php if ($i ==0 ) {echo "20";} else {echo "10";}?>px Arial, Helvetica, sans-serif">
							<?php echo price_format($tarifs->pu_ht*$aff_taxation)."&nbsp;".$MONNAIE[1]." ".$mode_taxation;?>
							<?php if ($i) {?> par <?php echo $tarifs->indice_qte;?><?php }?> 
							</span><br />
							<?php
							if (!isset($_REQUEST["aff_qte"])) {break;}
							$i++;
						}
					}
				} else {
					foreach ($tarifs_liste as $tarif_liste) {
						$i=0;
						if ($tarif_liste->id_tarif == $_SESSION['magasin']->getId_tarif()) {
							foreach ($liste_tarifs as $tarifs) {
								if ($tarif_liste->id_tarif == $tarifs->id_tarif) {
									?>
									<span style="text-align:center; font:<?php if ($i ==0 ) {echo "20";} else {echo "10";}?>px Arial, Helvetica, sans-serif">
									<?php echo price_format($tarifs->pu_ht*$aff_taxation)."&nbsp;".$MONNAIE[1]." ".$mode_taxation;?>
									<?php if ($i) {?> par <?php echo $tarifs->indice_qte;?><?php }?>
									</span><br />
									<?php
									if (!isset($_REQUEST["aff_qte"])) {break;}
									$i++;
								}
							}
						}
					}
				}
				?>
				</div>
				<?php
			}
		}
		if (count($images)) { echo "Photos non contractuelles.";}
		if (!count($images)) {
			?>
			<div style="text-align:center">
			<span style="text-align:center; font:20px Arial, Helvetica, sans-serif">
			<?php echo price_format($tarif_affiche)."&nbsp;".$MONNAIE[1]." ".$mode_taxation;?></span>
			</div>
			<?php
		}
		?>
		
		</div>
		</td>
	</tr>
	<tr>
		<td><?php echo str_replace("&curren;", "&euro;", ($article->getDesc_longue ()));?></td>
		</tr>
</table>



</div>
</body>
</noframes></html>