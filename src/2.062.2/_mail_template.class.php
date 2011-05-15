<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN TEMPLATE DE MAIL
// *************************************************************************************************************


final class mail_template {
	protected $id_mail_template;
	protected $lib_mail_template;
	protected $header_img_template;
	protected $header_mail_template;
	protected $footer_img_template;
	protected $footer_mail_template;
	protected $mail_html_charset;
	protected $mail_css_template;
	

public function __construct ($id_mail_template = "") {
	global $bdd;

	if (!$id_mail_template) { return false; }

	$query = "SELECT m.lib_mail_template, m.header_img_template, m.header_mail_template, m.footer_img_template, m.footer_mail_template, m.mail_html_charset, m.mail_css_template
					 FROM mail_templates m
					 WHERE m.id_mail_template = '".$id_mail_template."' ";
	$resultat = $bdd->query ($query);
	if (!$mail_template = $resultat->fetchObject()) { return false; }

	$this->id_mail_template 		= $id_mail_template;
	$this->lib_mail_template 		= $mail_template->lib_mail_template;
	$this->header_img_template 	= $mail_template->header_img_template;
	$this->header_mail_template = $mail_template->header_mail_template;
	$this->footer_img_template 	= $mail_template->footer_img_template;
	$this->footer_mail_template = $mail_template->footer_mail_template;
	$this->mail_html_charset 		= $mail_template->mail_html_charset;
	$this->mail_css_template 		= $mail_template->mail_css_template;

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES
// *************************************************************************************************************


// Suppression d'un template de mail
public function suppression () {
	global $bdd;

	// Suppression dans la BDD
	$query = "DELETE FROM mail_templates WHERE id_mail_template = '".$this->id_mail_template."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION OU LA MISE A JOURD'UNE NEWSLETTER
// *************************************************************************************************************

public function create_mail_template ($infos) {
	global $bdd;

  // *************************************************
	// Réception des données
	$this->lib_mail_template 		= $infos['lib_mail_template'];
	$this->header_img_template 	= $infos['header_img_template'];
	$this->header_mail_template = $infos['header_mail_template'];
	$this->footer_img_template 	= $infos['footer_img_template'];
	$this->footer_mail_template = $infos['footer_mail_template'];
	$this->mail_html_charset 		= $infos['mail_html_charset'];
	$this->mail_css_template 		= $infos['mail_css_template'];
	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO mail_templates (lib_mail_template, header_img_template, header_mail_template, 
																				footer_img_template, footer_mail_template, mail_html_charset, mail_css_template)
						VALUES ('".addslashes($this->lib_mail_template)."','".$this->header_img_template."','".addslashes($this->header_mail_template)."', 
										'".$this->footer_img_template."','".addslashes($this->footer_mail_template)."','".$this->mail_html_charset."'
										,'".$this->mail_css_template."')";
	$bdd->exec ($query);
	
	$this->id_mail_template = $bdd->lastInsertId();

	return true;
}


public function maj_mail_template ($infos) {
	global $bdd;

  // *************************************************
	// Réception des données
	$this->lib_mail_template 		= $infos['lib_mail_template'];
	$this->header_img_template 	= $infos['header_img_template'];
	$this->header_mail_template = $infos['header_mail_template'];
	$this->footer_img_template 	= $infos['footer_img_template'];
	$this->footer_mail_template = $infos['footer_mail_template'];
	$this->mail_html_charset 		= $infos['mail_html_charset'];
	$this->mail_css_template 		= $infos['mail_css_template'];

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Insertion dans la bdd
	$query = "UPDATE mail_templates
						SET lib_mail_template='".addslashes($this->lib_mail_template)."', header_img_template='".$this->header_img_template."', 
								header_mail_template='".addslashes($this->header_mail_template)."', footer_img_template='".$this->footer_img_template."', 
								footer_mail_template='".addslashes($this->footer_mail_template)."', mail_html_charset='".$this->mail_html_charset."', 
								mail_css_template='".$this->mail_css_template."'
						WHERE id_mail_template = '".$this->id_mail_template."' ";
	$bdd->exec ($query);

	return true;
}


function getId_mail_template() {
	return $this->id_mail_template;
}

function getLib_mail_template() {
	return $this->lib_mail_template;
}

function getHeader_img_template() {
	return $this->header_img_template;
}

function getHeader_mail_template() {
	return $this->header_mail_template;
}

function getFooter_img_template() {
	return $this->footer_img_template;
}

function getFooter_mail_template() {
	return $this->footer_mail_template;
}

function getMail_html_charset() {
	return $this->mail_html_charset;
}

function getMail_css_template() {
	return $this->mail_css_template;
}

}
// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les templates de mail
function charger_mail_templates () {
	global $bdd;

	$mail_templates = array();
	$query = "SELECT id_mail_template, lib_mail_template, header_img_template, header_mail_template, footer_img_template, footer_mail_template, mail_html_charset, mail_css_template
						FROM mail_templates
						ORDER BY id_mail_template ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $mail_templates[] = $tmp; }
	
	return $mail_templates;
}









?>
