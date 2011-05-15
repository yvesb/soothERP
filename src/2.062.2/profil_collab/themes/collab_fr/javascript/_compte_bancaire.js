//mettre le compte bancaire à actif
function set_active_compte (id_compte_bancaire) {
    var AppelAjax = new Ajax.Request(
        "compta_compte_bancaire_active_compte.php",
        {
            parameters: {
                id_compte_bancaire: id_compte_bancaire
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}

//mettre le compte bancaire à inactif
function set_desactive_compte (id_compte_bancaire) {
    var AppelAjax = new Ajax.Request(
        "compta_compte_bancaire_desactive_compte.php",
        {
            parameters: {
                id_compte_bancaire: id_compte_bancaire
            },
            evalScripts:true,
            onLoading:S_loading,
            onException: function () {
                S_failure();
            },
            onSuccess: function (requester){
                requester.responseText.evalScripts();
                H_loading();
            }
        }
        );
}


//insertion d'une nouvelle ligne d'opération 
function insert_new_line_ope_cpt_bancaire () {
    indentation_add_ope = parseInt($("indentation_add_ope").value);
    new_indentation_add_ope = indentation_add_ope+1;
    new Insertion.Bottom($("liste_add_ope"),
        '<table border="0" cellspacing="0" cellpadding="0" style="width:100%"><tr><td style="width:20%">'+
        '<input type="text" name="date_move_'+new_indentation_add_ope+'" id="date_move_'+new_indentation_add_ope+'" value="" class="classinput_nsize" size="12"/></td>'+
        '<td>'+
        '<input type="text" name="lib_move_'+new_indentation_add_ope+'" id="lib_move_'+new_indentation_add_ope+'" value="" class="classinput_xsize"/></td>'+
        '<td style="text-align:right; width:25%">'+
        ''+
        '<input type="text" name="montant_move_'+new_indentation_add_ope+'" id="montant_move_'+new_indentation_add_ope+'" value="0.00" class="classinput_nsize" style="text-align:right" size="10"/>'+
        '<script type="text/javascript">'+
        'Event.observe($("montant_move_'+new_indentation_add_ope+'"), "blur", function(evt){'+
        'Event.stop(evt);	nummask(evt, 0, "X.XY"); '+
        '});'+
        'Event.observe("date_move_'+new_indentation_add_ope+'", "blur", datemask, false);'+
        'Event.observe("date_move_'+new_indentation_add_ope+'", "focus", function(evt){' +
        'if (parseInt($("indentation_add_ope").value) == '+new_indentation_add_ope+') {'+
        'insert_new_line_ope_cpt_bancaire ();'+
        '}'+
        '}, false);'+
        '</script></td></tr></table><div>&nbsp;</div>');
    $("indentation_add_ope").value = new_indentation_add_ope;
}

function bigModulo(nb, mod){
    //document.write(nb);
    var tcoupe = 8;
    if(nb.length <= tcoupe){
        return nb % mod;
    }
    var tab = new Array();
    //On coupe nb en nombres de taille tcoupe
    for(i=0; i<Math.ceil(nb.length/tcoupe); i++){
        tab[i] = parseInt(nb.substr(i*tcoupe, tcoupe), 10);
    }
    var total = 0;
    var pow = 0;
    var t = tcoupe;
    for(i=0; i<Math.ceil(nb.length/tcoupe); i++){
        var mul = 1;
        (nb.length-(tcoupe*(i+1)) < 0) ? pow = 0 : pow = nb.length-(tcoupe*(i+1));
        for(j=0; j<Math.ceil(pow/tcoupe); j++){
            ((j+1)*tcoupe-pow > 0) ? t = tcoupe-((j+1)*tcoupe-pow): t=tcoupe;
            mul *= Math.pow(10, t)%mod;
        }
        total += (tab[i]%mod * mul%mod) % mod;
    }
    total %= mod;
    return total;
}

function getKeyRib(banque, guichet, compte) {
    if (5 != banque.length || 5 != guichet.length || 11 != compte.length)
        return "";
    function replaceAlpha(alpha) {
        var corres = new Array('1','2','3','4','5','6','7','8','9','1','2','3','4','5','6','7','8','9','2','3','4','5','6','7','8','9');
        return corres[alpha.charCodeAt(0) - 65];
    }
    //compte= parseInt(compte.toUpperCase().replace(/[A-Z]/g, replaceAlpha), 10);
    compte = compte.toUpperCase().replace(/[A-Z]/g, replaceAlpha);
    //return 97 - (((parseInt(banque, 10)% 97 * 100000 + parseFloat(guichet)) % 97 * 100000000000 + compte) % 97) * 100 % 97;
    return 97 - bigModulo(banque+guichet+compte+"00", 97);
}

function getKeyIban(bban, country) {
    function replaceAlpha(alpha) {
        var corres = new Array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35');
        return corres[alpha.charCodeAt(0) - 65];
    }
    bban = bban+country+"00";	//bban 66 chiffres
    bban = bban.toUpperCase().replace(/[A-Z]/g, replaceAlpha);
    return 98 - bigModulo(bban, 97);
}

function checkIban(iban) {
    function replaceAlpha(alpha) {
        var corres = new Array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35');
        return corres[alpha.charCodeAt(0) - 65];
    }
    iban = iban.substr(4) + iban.substr(0, 4);
    iban = iban.toUpperCase().replace(/[A-Z]/g, replaceAlpha);
    return bigModulo(iban, 97) == 1;
}

function updateRIB(){
    if(typeof(focused) != "undefined"){
        if(focused == 'code_banque' && $("code_banque").value.length >= 5)
            $("code_guichet").focus();
        else if(focused == 'code_guichet' && $("code_guichet").value.length >= 5)
            $("numero_compte").focus();
        else if(focused == 'numero_compte' && $("numero_compte").value.length >= 11)
            $("swift").focus();
    }
    var kBban = getKeyRib($("code_banque").value, $("code_guichet").value, $("numero_compte").value);
    if(kBban < 10) kBban = "0"+kBban;
    $("cle_rib").value = kBban;
    updateIBAN();
}

function updateIBAN(){
    var codePays = "FR";
    var bban = $("code_banque").value+$("code_guichet").value+$("numero_compte").value+$("cle_rib").value;
    var kIban = getKeyIban(bban, codePays);
    $("iban").value = codePays+kIban+bban;
    $("swift").value;
    verifErreurs();
}

function verifErreurs(){
    var kBban = getKeyRib($("code_banque").value, $("code_guichet").value, $("numero_compte").value);
    if(typeof(focused) != "undefined" && focused !=  'code_banque' && focused !=  'code_guichet' && focused !=  'numero_compte'){
        if(kBban == "" | $("cle_rib").value != kBban){
            $("message_err_1").innerHTML = "Le RIB semble Invalide";
        } else $("message_err_1").innerHTML = "";
    }
    if(!checkIban($("iban").value)){
        $("message_err_2").innerHTML = "Numéro IBAN Invalide";
    } else $("message_err_2").innerHTML = "";
}
