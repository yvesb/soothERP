<?php

class Helper {

	/*
	 * Filtres "id=untruc,unautretruc, ...;actif=truc1,truc2;lib=libellé1,libellé2"
	 */
    public static function createInputAnnu($id, $defaultText="", $params = array()) {
        global $DIR;
        if(!isset($params['callback']))
        //Mise a jour simple des champs
            $params['callback'] = "update_field_anu";
        //Par défaut affichage de tous les profil sauf Visiteur 
        if(!isset($params['filtres']))
            $params['filtres'] = "actif=1,2";

        $html = Helper::createSelectPopup($id, $defaultText)."\n";
        $html .= '<script type="text/javascript">
			//effet de survol sur le faux select
			Event.observe(\''.$id.'_select_c\', \'mouseover\',  function(){$("'.$id.'_select_c").src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/bt_contact_find_hover.gif";}, false);
			Event.observe(\''.$id.'_select_c\', \'mousedown\',  function(){$("'.$id.'_select_c").src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/bt_contact_find_down.gif";}, false);
			Event.observe(\''.$id.'_select_c\', \'mouseup\',  function(){$("'.$id.'_select_c").src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/bt_contact_find.gif";}, false);

			Event.observe(\''.$id.'_select_c\', \'mouseout\',  function(){$("'.$id.'_select_c").src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/bt_contact_find.gif";}, false);
			
			/*utilisation de la fonctio daffichage du mini moteur de recherche dun contact show_mini_moteur_contacts*/
			/*syntaxe des filtres : "lib=val1,val2,val3;actif=val1;id=val1,val2"*/
			Event.observe(\''.$id.'_select_c\', \'click\',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("'.$params['callback'].'", "\''.$id.'\', \''.$id.'_nom_c\'", "'.$params['filtres'].'"); page.annuaire_recherche_mini();}, false);
			Event.observe(\'liste_'.$id.'_c\', \'click\',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("'.$params['callback'].'", "\''.$id.'\', \''.$id.'_nom_c\'", "'.$params['filtres'].'"); page.annuaire_recherche_mini();}, false);
			
			Event.observe(\''.$id.'_empty_c\', \'click\',  function(evt){
                            Event.stop(evt);
                            '.$params['callback'].'("'.$id.'", "'.$id.'_nom_c", "", "'.$defaultText.'");
                        }, false);
		</script>';
        return $html;
    }

    private static function createSelectPopup($id, $defaultText="") {
        global $DIR;
        if (isset($_REQUEST["lib_contact"])) {
            $text = (urldecode($_REQUEST["lib_contact"]));
            $val = (urldecode($_REQUEST["ref_contact"]));
        } else {
            $text = $defaultText;
            $val = "";
        }

        $html = '<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
                    <tr>
                        <td style="width:80%;">
                            <input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$val.'" />
                            <span style=" width:100%;" class="simule_champs clic" id="liste_'.$id.'_c">
                                    <span id="'.$id.'_nom_c" style=" float:left; height:18px; margin-left:3px; line-height:18px;">'.$text.'</span>
                            </span>
                        </td>
                        <td style="text-align:right;padding-left:3px;">
                            <img src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/bt_contact_find.gif" class="clic" id="'.$id.'_select_c">
                        </td>
                        <td>
                            <img src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/supprime.gif" class="clic" id="'.$id.'_empty_c">
                        </td>
                    </tr>
		</table>';

        return $html;
    }

    /**
     *
     * @global <type> $DIR
     * @param <type> $id
     * @param <type> $options
     * $options["drag"] = true|false
     * $options["style_popup"] = 'style=width:50%' etc...
     * $options["forced"] = true|false
     * @param <type> $content contenu de la popup (vide par défaut, puis appel à page.traitecontent()
     * @return <type> 
     */
    public static function createPopup($id, $options=array(), $content=""){
        global $DIR;
        $style_popup = "";
        $drag = true;
        $forced = false;
        if(isset($options['style_popup']))
            $style_popup = "style=\"".$options['style_popup']."\"";
        if(isset($options['drag']))
            $drag = $options['drag'];
        if(isset($options['forced']))
            $forced = $options['forced'];

        $html='<div id="'.$id.'" class="popup" '.$style_popup.'>
            <div id="'.$id.'_bar" class="headbar">
                <span id="link_close_'.$id.'" style="float:right" class="clic">
                    <img src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/supprime.gif" border="0">
                </span>
                <script type="text/javascript">
                    Event.observe("link_close_'.$id.'", "click",  function(evt){Event.stop(evt); $("'.$id.'").hide();}, false);';
        if($drag){
            $html.='var isDown = false;
                    var decalage = 20;
                    Event.observe("'.$id.'_bar", "mousedown",  function(evt){
                        $(\''.$id.'_bar\').style.cursor = "move";
                        $(\''.$id.'\').style.opacity = "0.8";
                        isDown = true;
                        decalage = evt.clientX-$(\''.$id.'\').offsetLeft;
                    }, false);
                    Event.observe(document, "mousemove",  function(evt){
                        if(isDown){
                            $(\''.$id.'\').style.left = evt.clientX-decalage+"px";
                            $(\''.$id.'\').style.top = evt.clientY-10+"px";
                        }
                    }, false);
                    Event.observe("'.$id.'_bar", "mouseup",  function(evt){
                        $(\''.$id.'_bar\').style.cursor = "";
                        $(\''.$id.'\').style.opacity = "1";
                        isDown = false;
                    }, false);';
        }
        $html.='</script>
            </div>
            <div id="'.$id.'_content_up" class="popup_content">';
        $html .= $content;
        $html .= "</div></div>";

        return $html;
    }

}
?>