
var MethodesElements = {
	 /**
     * Génére un evenement ex: $("bt-valid").fireEvent('click');
     * @param event nom de l'évenement
     * @param bubbling true*|false propage l'evenement
     * @param cancelable true*|false permettre l'arrêt de la propagation (ex: Event.stop())
     */
    fireEvent : function(element,event,bubbling,cancelable){
        element = $(element);
        bubbling = bubbling || true;
        cancelable = cancelable || true;
        if (document.createEventObject){
            // dispatch for IE
            var evt = document.createEventObject();
            return element.fireEvent('on'+event,evt)
        }
        else{
            // dispatch for firefox + others
            var evt = document.createEvent("HTMLEvents");
            evt.initEvent(event, bubbling, cancelable ); // event type,bubbling,cancelable
            return !element.dispatchEvent(evt);
        }
    },

    /**
     * Attacher un mini calendrier à un champ input[text|hidden]
     * @param options
     *      options["date_format"] = format de la date (par défaut %d-%m-%Y)
     *      options["accept_null"] = Permetre date "Non définie"
     * @param id_button : id du bouton à écouter pour l'ouverture du calendrier
     * à définir si le bouton n'est pas le champ input lui même
     */
    attachMiniCalendar : function(element, options, id_button){
        element = $(element);
        if(element.tagName.toLowerCase() != 'input' || !['text', 'hidden'].include(element.type)){
            alert("Mini calendrier ne peut s'attacher qu'aux input[text|hidden]");
            return false;
        }
        if($("mini_calendrier") == null){
            var div_calendar = document.createElement("div");
            div_calendar.setAttribute("id", "mini_calendrier");
            div_calendar.setAttribute("class", "appercu_calendrier");
            div_calendar.setAttribute("style", "position:absolute;display:none;");
            document.body.appendChild(div_calendar);
        }

        id_button = id_button || element.id;
        var default_options = new Array();
        default_options["date_format"] = "%d-%m-%Y";
        default_options["accept_null"] = false;
        default_options["callback"] = "";
         default_options["date_format"] = "%d-%m-%Y";
        default_options["date_min"] = "";
        default_options["date_max"] = "";
        options = options || new Array();
        for(var opt in default_options){
            if(!options[opt]) options[opt] = default_options[opt];
        }

        //Event.stopObserving(id, "click");
        Event.observe(id_button, "click", function(evt){
            var pos = getPosition($(id_button));
            if($("mini_calendrier").visible()){
                close_mini_calendrier();
                return true;
            }
            $("mini_calendrier").style.top = (pos[1]+20)+"px";
            $("mini_calendrier").style.left = (pos[0])+"px";

            var current_date = Date.create(element.value, options["date_format"]);
            var current_time = (element.value!="" && current_date!=null && !isNaN(current_date.getTime()))
            ?current_date.getTime():new Date().getTime();
            var AppelAjax = new Ajax.Updater(
                "mini_calendrier",
                "appercu_calendrier.php",
                {
                    method: 'post',
                    asynchronous: true,
                    contentType:  'application/x-www-form-urlencoded',
                    encoding:     'UTF-8',
                    //parameters: {ref_date:ref_date,Udate_mini_calendrier:Udate_mini_calendrier },
                    parameters: {
                        ref_date: element.id,
                        Udate_mini_calendrier: current_time,
                        date_format: options["date_format"],
                        accept_null: options["accept_null"],
                        date_min: options["date_min"],
                        date_max: options["date_max"],
                        callback: options["callback"]
                    },
                    evalScripts:true,
                    onLoading:S_loading,
                    onComplete:function ()
                    {
                        $("mini_calendrier").show();
                        H_loading();
                    }
                }
                );
        });
        Event.observe(document.body, "click", function(evt){
            close_mini_calendrier();
        });
    }
}
Element.addMethods(MethodesElements);

function getPosition(e)
{
    var left = 0;
    var top = 0;
    /*On récupère l'élément*/
    /*Tant que l'on a un élément parent*/
    while (e.offsetParent != undefined && e.offsetParent != null)
    {
        /*On ajoute la position de l'élément parent*/
        left += e.offsetLeft + (e.clientLeft != null ? e.clientLeft : 0);
        top += e.offsetTop + (e.clientTop != null ? e.clientTop : 0);
        e = e.offsetParent;
    }
    return new Array(left,top);
}

function close_mini_calendrier() 
{
    if(document.getElementById('mini_calendrier'))
    {
        $('mini_calendrier').hide();
        $('mini_calendrier').innerHTML="";
    }
}

Date.create = function(str, format){
    var _DATE_FORMAT_REGXES = {
        'Y': new RegExp('^-?[0-9]+'),
        'd': new RegExp('^[0-9]{1,2}'),
        'm': new RegExp('^[0-9]{1,2}'),
        'H': new RegExp('^[0-9]{1,2}'),
        'M': new RegExp('^[0-9]{1,2}'),
        'S': new RegExp('^[0-9]{1,2}')
    }

    /*
     * _parseData does the actual parsing job needed by `strptime`
     */
    function _parseDate(datestring, format) {
        if(typeof datestring == 'undefined') return null;
        var parsed = {};
        for (var i1=0,i2=0;i1<format.length;i1++,i2++) {
            var c1 = format[i1];
            var c2 = datestring[i2];
            if (c1 == '%') {
                c1 = format[++i1];
                var data = _DATE_FORMAT_REGXES[c1].exec(datestring.substring(i2));
                if (data==null || !data.length) {
                    return null;
                }
                data = data[0];
                i2 += data.length-1;
                var value = parseInt(data, 10);
                if (isNaN(value)) {
                    return null;
                }
                parsed[c1] = value;
                continue;
            }
            if (c1 != c2) {
                return null;
            }
        }
        return parsed;
    }

    var parsed = _parseDate(str, format);
    if (!parsed) {
        return null;
    }
    // create initial date (!!! year=0 means 1900 !!!)
    var date = new Date(0, 0, 1, 0, 0);
    date.setFullYear(0); // reset to year 0
    if (parsed.Y) {
        date.setFullYear(parsed.Y);
    }
    if (parsed.m) {
        if (parsed.m < 1 || parsed.m > 12) {
            return null;
        }
        // !!! month indexes start at 0 in javascript !!!
        date.setMonth(parsed.m - 1);
    }
    if (parsed.d) {
        if (parsed.m < 1 || parsed.m > 31) {
            return null;
        }
        date.setDate(parsed.d);
    }
    if (parsed.H) {
        if (parsed.H < 0 || parsed.H > 23) {
            return null;
        }
        date.setHours(parsed.H);
    }
    if (parsed.M) {
        if (parsed.M < 0 || parsed.M > 59) {
            return null;
        }
        date.setMinutes(parsed.M);
    }
    if (parsed.S) {
        if (parsed.S < 0 || parsed.S > 59) {
            return null;
        }
        date.setSeconds(parsed.S);
    }
    return date;
}

//Rafraichir le calendrier et renvoi le jour selectionné
function refresh_grille_agenda(ref_date, date, date_format)//ref_date2 optionnel
{
    if(date != null){
        //Affichage de la date avec un format de deux chiffres pour jour et mois
        $(ref_date).value = date.toLocaleFormat(date_format);
    }
    else{
        $(ref_date).value = "Non définie";
    }

    $(ref_date).fireEvent("blur");
    $(ref_date).fireEvent("change");
    $(ref_date).fireEvent("keyup");
}