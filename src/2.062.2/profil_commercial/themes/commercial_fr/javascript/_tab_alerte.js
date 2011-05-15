var tab_alerte	=	new Array;

// alertes navigateur autre que firefox
tab_alerte["alert_nav"]	=	new Array ('<div style="text-align:right"><img src="themes/collab_fr/images/supprime.gif" id="bouton0" style="cursor:pointer" title="fermer la fenêtre" /></div>', '<a href="http://www.mozilla-europe.org/fr/firefox/" target="_blank"><img src="themes/collab_fr/images/telecharger-firefox.jpg"/></a>', '');

tab_alerte["contact_profil2_supprime"]	=	new Array ('Suppression des informations Administrateur', 'Confirmez la suppression de ce profil', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_profil3_supprime"]	=	new Array ('Suppression des informations Collaborateur', 'Confirmez la suppression de ce profil', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_profil4_supprime"]	=	new Array ('Suppression des informations Client', 'Confirmez la suppression de ce profil', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_profil5_supprime"]	=	new Array ('Suppression des informations Fournisseur', 'Confirmez la suppression de ce profil', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_profil6_supprime"]	=	new Array ('Suppression des informations Constructeur', 'Confirmez la suppression de ce profil', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_profil7_supprime"]	=	new Array ('Suppression des informations Commercial', 'Confirmez la suppression de ce profil', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_site_supprime"]	=	new Array ('Suppression d\'un site', 'Confirmez la suppression de ce site', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_coordonnee_supprime"]	=	new Array ('Suppression d\'une coordonnée', 'Confirmez la suppression de cette coordonnée', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_adresse_supprime"]	=	new Array ('Suppression d\'une adresse', 'Confirmez la suppression de cette adresse', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');


tab_alerte["contact_user_supprime"]	=	new Array ('Suppression d\'un utilisateur', 'Confirmez la suppression de cet utilisateur', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["user_compte_maitre"]	=	new Array ('Suppression de l\'utilisateur impossible', 'Cet utilisateur est un compte maître, sa suppression est impossible', '<input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["fusionner_contact"]	=	new Array ('Fusionner deux contact', 'Confirmer la fusion des deux fiches de contact', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_suspendre_user"]	=	new Array ('Suspendre les utilisateurs', 'Confirmer la suspension des utilisateurs de ce contact', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

tab_alerte["contact_archivage"]	=	new Array ('Supprimer ce contact', 'Confirmer la suppression de ce contact', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');


//******************************************
// alerte de modification d'un formulaire
tab_alerte["form_change"]	=	new Array ('Formulaire modifié', 'Le formulaire à été modifié', '<input type="submit" name="bouton1" id="bouton1" value="Ignorer les modifications" /><input type="submit" id="bouton0" name="bouton0" value="Retour" />');

//******************************************
//suppression d'une ligne de quantité dans une grille de tarif
tab_alerte["tarif_delqte"]	=	new Array ('Supprimer la ligne ?', 'Confirmer la suppression de la ligne', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');


//suppression d'une ligne de liaison dans la création d'un article
tab_alerte["liaison_new_del"]	=	new Array ('Supprimer la liaison ?', 'Confirmer la suppression de la liaison avec cet article', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//suppression d'une ligne de composant dans la création d'un article
tab_alerte["composant_new_del"]	=	new Array ('Supprimer le composant?', 'Confirmer la suppression du composant de cet article', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//suppression d'un code barre
tab_alerte["code_barre_del"]	=	new Array ('Supprimer le code barre?', 'Confirmer la suppression du code barre de cet article', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//suppression d'une liaison d'article
tab_alerte["liaison_art_del"]	=	new Array ('Supprimer la liaison?', 'Confirmer la suppression de la liaison avec cet article', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//suppression d'un article
tab_alerte["article_confirm_supprime"]	=	new Array ('Supprimer l\'article', 'Confirmer la suppression de cet article (il sera alors archivé dans la base de données)', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')
//fin de dispo d'un article
tab_alerte["article_fin dispo"]	=	new Array ('Fin de siponibilité de l\'article', 'Confirmer la fin de vie de cet article <br />(il sera alors archivé dans la base de données s\'il n\'est plus en stock)', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

// suppression d'une formule tarifaire
tab_alerte["tarif_del_art_formule"]	=	new Array ('Suppression d\'une formule', 'Confirmez la suppression de cette formule', '<input type="submit" name="bouton1" id="bouton1" value="Confirmez la suppression" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//suppression d'un article impossible car lot
tab_alerte["article_appartenance_lot"]	=	new Array ('Suppression de  l\'article impossible!', 'Cet article fait parti d\'un lot et ne peut être supprimé', '<input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//archivage d'un article impossible car toujours en stock
tab_alerte["article_toujours_dispo"]	=	new Array ('Archivage de  l\'article impossible!', ' Cet article sera archivé dès que son stock sera épuisé ', '<input type="submit" id="bouton0" name="bouton0" value="Ok" />')

//supression d'une ligne d'un article
tab_alerte["document_ligne_supprime"]	=	new Array ('Suppression de  l\'article', 'Confirmer la suppression de cette ligne d\'article', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//supression d'un compte bancaire
tab_alerte["compta_compte_bancaire_sup"]	=	new Array ('Suppression d\'un compte bancaire', 'Confirmer la suppression de ce compte', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//supression d'une caisse
tab_alerte["compta_compte_caisse_sup"]	=	new Array ('Suppression d\'une caisse', 'Confirmer la suppression de cette caisse', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//supression d'un terminal de paiement electronique
tab_alerte["compta_compte_tpes_sup"]	=	new Array ('Suppression d\'un terminal de paiement', 'Confirmer la suppression de ce terminal', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//supression d'une carte bancaire
tab_alerte["compta_compte_cbs_sup"]	=	new Array ('Suppression d\'une carte bancaire', 'Confirmer la suppression de cette carte bancaire', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')


//supression d'un règlement
tab_alerte["documents_reglements_sup"]	=	new Array ('Suppression d\'un Règlement', 'Confirmer la suppression de ce règlement', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//supression d'une liaison
tab_alerte["liaison_sup_confirm"]	=	new Array ('Suppression d\'une liaison', 'Confirmer la suppression de cette  liaison', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />')

//suppression d'une tache
tab_alerte["planning_tache_sup"]	=	new Array ('Suppression d\'une tache', 'Confirmez la suppression de cette tache', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');


//suppression d'une art_categ d'un inventaire

tab_alerte["inventaire_art_categ_supprime"]	=	new Array ('Supprimer une catégorie à inventorier', 'Confirmez la suppression de cette catégorie de l\'inventaire<br /> Les articles déjà présent dans l\'inventaire seront conservés', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//Suppression d'un relevé de compte
tab_alerte["compta_releve_compte"]	=	new Array ('Supression d\'un relevé de compte', 'Confirmez la suppression de ce relevé de compte<br /> ATTENTION!!<br />Cette opération est irréversible.', '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');

//suppression d'un favori

tab_alerte["planning_liens_sup"]	=	new Array ('Suppression d\'un lien', 'Confirmez la suppression de ce lien', '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />');
