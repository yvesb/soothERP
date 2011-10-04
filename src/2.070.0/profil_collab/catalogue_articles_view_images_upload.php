<?php
// *************************************************************************************************************
// AJOUT D'UNE IMAGE D'UN ARTICLE EN MODE VISUALISATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
//**************************************
// Controle
$erreur = "";

	if (!isset($_REQUEST['ref_article'])) {
		echo "La référence de l'article n'est pas précisée";
		exit;
	}

	$article = new article ($_REQUEST['ref_article']);
	if (!$article->getRef_article()) {
		echo "La référence de l'article est inconnue";		exit;

	}
 // $ratio force la taille, soit en hauteur soit en largeur 
 $ratio = $ARTICLE_IMAGE_MINIATURE_RATIO;  
  
 // on teste si le formulaire permettant d'uploader un fichier a été soumis  
 if (isset($_POST['add_picture'])) { 
    // on teste si le champ permettant de soumettre un fichier est vide ou non 
    if (empty($_FILES['image']['tmp_name']) && $_REQUEST["url_img"] == "") { 
       // si oui, on affiche un petit message d'erreur 
       $erreur = 'Aucun fichier envoyé.'; 
    } 
    else { 
       // on examine le fichier uploadé 
			 if (empty($_FILES['image']['tmp_name']) && $_REQUEST["url_img"] != "" && strlen($_REQUEST["url_img"]) < 256){
			 
						 $tableau = @getimagesize($_REQUEST["url_img"]);  
				//if ( remote_file_exists ( $_REQUEST["url_img"] ) ){
//				} else {
//				 $tableau = false;
//				}
			 } else {
      	 $tableau = @getimagesize($_FILES['image']['tmp_name']); 
			 }
			 
       if ($tableau == FALSE) { 
          // si le fichier uploadé n'est pas une image, on efface le fichier uploadé et on affiche un petit message d'erreur 
          if (!empty($_FILES['image']['tmp_name'])) {unlink($_FILES['image']['tmp_name']); }
          $erreur = 'Votre fichier n\'est pas une image.'; 
       } 
       else { 
          // on teste le type de notre image : gif, jpeg ou png 
          if ($tableau[2] == 1 || $tableau[2] == 2 || $tableau[2] == 3) { 
             // si on a déjà un fichier qui porte le même nom que le fichier que l'on tente d'uploader, on modifie le nom du fichier que l'on upload 
						 if (!empty($_FILES['image']['tmp_name'])) {
       			 $extension = substr($_FILES["image"]["name"], strrpos($_FILES["image"]["name"], "."));
						 } else {
       			 $extension = substr($_REQUEST["url_img"], strrpos($_REQUEST["url_img"], "."));
						 }
						 $file_upload = md5(uniqid(rand(), true)).$extension;
             if (is_file($ARTICLES_IMAGES_DIR.$file_upload)) {$file_upload = md5(uniqid(rand(), true)).$extension; }
             
  
             // on copie le fichier que l'on vient d'uploader dans le répertoire des images de grande taille 
						 if (!empty($_FILES['image']['tmp_name'])) {
             	copy ($_FILES['image']['tmp_name'], $ARTICLES_IMAGES_DIR.$file_upload); 
						 } else {
             	copy ($_REQUEST["url_img"], $ARTICLES_IMAGES_DIR.$file_upload); 
						 }
  
             // Générer la miniature 
  
             // si notre image est de type jpeg 
             if ($tableau[2] == 2) { 
                // on crée une image à partir de notre grande image à l'aide de la librairie GD 
                $src = imagecreatefromjpeg($ARTICLES_IMAGES_DIR.$file_upload); 
                // on teste si notre image est de type paysage ou portrait 
                if ($tableau[0] > $tableau[1]) { 
									if ($tableau[0] > $ratio) {
										$x_size = $ratio;
										$y_size = round(($ratio/$tableau[0])*$tableau[1]);
									} else {
										$x_size = $tableau[0];
										$y_size = $tableau[1];
									}
                   $im = imagecreatetruecolor($x_size, $y_size); 
                   imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
                } 
                else { 
									if ($tableau[1] > $ratio) {
										$x_size = round(($ratio/$tableau[1])*$tableau[0]);
										$y_size = $ratio;
									} else {
										$x_size = $tableau[0];
										$y_size = $tableau[1];
									}
                   $im = imagecreatetruecolor($x_size, $y_size); 
                   imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
								}
                // on copie notre fichier généré dans le répertoire des miniatures 
                imagejpeg ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
             } 
             elseif ($tableau[2] == 3) { 
                $src = imagecreatefrompng($ARTICLES_IMAGES_DIR.$file_upload); 
                if ($tableau[0] > $tableau[1]) { 
									if ($tableau[0] > $ratio) {
										$x_size = $ratio;
										$y_size = round(($ratio/$tableau[0])*$tableau[1]);
									} else {
										$x_size = $tableau[0];
										$y_size = $tableau[1];
									}
                   $im = imagecreatetruecolor($x_size, $y_size); 
                   imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
										if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
											if ($val_alpha <20) {
												$background_color = imagecolorallocate ($im, 255, 255, 255);
												$transparent_color = imagecolortransparent($im,$background_color); 
											} elseif ($val_alpha >200) {
												$background_color = imagecolorallocate ($im, 0, 0, 0);
												$transparent_color = imagecolortransparent($im,$background_color); 
											}
										}
                } 
                else { 
									if ($tableau[1] > $ratio) {
										$x_size = round(($ratio/$tableau[1])*$tableau[0]);
										$y_size = $ratio;
									} else {
										$x_size = $tableau[0];
										$y_size = $tableau[1];
									}
                   $im = imagecreatetruecolor($x_size, $y_size); 
                   imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
										if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
											if ($val_alpha <20) {
												$background_color = imagecolorallocate ($im, 255, 255, 255);
												$transparent_color = imagecolortransparent($im,$background_color); 
											} elseif ($val_alpha >200) {
												$background_color = imagecolorallocate ($im, 0, 0, 0);
												$transparent_color = imagecolortransparent($im,$background_color); 
											}
										}
								}
                imagepng ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
             } 
             elseif ($tableau[2] == 1) { 
                $src = imagecreatefromgif($ARTICLES_IMAGES_DIR.$file_upload); 
								echo $tableau[0]." ". $tableau[1];
                if ($tableau[0] > $tableau[1]) { 
									if ($tableau[0] > $ratio) {
										$x_size = $ratio;
										$y_size = round(($ratio/$tableau[0])*$tableau[1]);
									} else {
										$x_size = $tableau[0];
										$y_size = $tableau[1];
									}
								echo "<br />".$x_size." ". $y_size;
                   $im = imagecreatetruecolor($x_size, $y_size); 
                   imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
										if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
											if ($val_alpha <20) {
												$background_color = imagecolorallocate ($im, 255, 255, 255);
												$transparent_color = imagecolortransparent($im,$background_color); 
											} elseif ($val_alpha >200) {
												$background_color = imagecolorallocate ($im, 0, 0, 0);
												$transparent_color = imagecolortransparent($im,$background_color); 
											}
										}
                } 
                else { 
									if ($tableau[1] > $ratio) {
										$x_size = round(($ratio/$tableau[1])*$tableau[0]);
										$y_size = $ratio;
									} else {
										$x_size = $tableau[0];
										$y_size = $tableau[1];
									}
                   $im = imagecreatetruecolor($x_size, $y_size); 
                   imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
										if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
											if ($val_alpha <20) {
												$background_color = imagecolorallocate ($im, 255, 255, 255);
												$transparent_color = imagecolortransparent($im,$background_color); 
											} elseif ($val_alpha >200) {
												$background_color = imagecolorallocate ($im, 0, 0, 0);
												$transparent_color = imagecolortransparent($im,$background_color); 
											}
										}
                } 
                imagegif ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
             } 
          } 
          else { 
             // si notre image n'est pas de type jpeg ou png, on supprime le fichier uploadé et on affiche un petit message d'erreur 
             unlink($_FILES['image']['tmp_name']); 
             $erreur = 'Votre image est d\'un format non supporté.'; 
          } 
       } 
    }  
 }  

if (isset($file_upload)) {
	$article->add_image ($file_upload);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_images_upload.inc.php");

?>