<script type="text/javascript">
</script>
<div class="emarge">
    <div id="pop_up_bonus" style="display:none; width: 30%; height: 250px;" class="mini_moteur_comm">
    </div>
    <div class="titre">Gestion des bonus et malus</div>
    <div class="articletview_corps" id="compta_bonus_commerciaux_conteneur" >
        <div style="padding:8px">
            <table style="width:100%">
                <tr>
                    <td colspan="2" style="width: 15%; font-style: italic; font-weight: bold;">Recherche de bonus / malus</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="width: 5%;">&nbsp;</td>
                    <td style="font-style: italic; font-weight: bold;">Créer un bonus / malus</td>
                </tr>
                <tr>
                    <td style="width:15%">
                        <span class="labelled">Commercial:</span>
                    </td><td style="width:20%">
                        <select  name="ref_commercial_search" id="ref_commercial_search" class="classinput_xsize">
                            <option  value="">Tous</option>
                            <?php foreach($commerciaux as $commercial) { ?>
                            <option value="<?php echo $commercial->ref_contact; ?>"><?php echo $commercial->nom ?></option>
                            <?php } ?>
                        </select>

                        <input type="hidden" name="orderby" id="orderby" value="date_move" />
                        <input type="hidden" name="orderorder" id="orderorder" value="DESC" />
                        <input type="hidden" name="page_to_show" id="page_to_show" value="1"/>
                    </td>
                    <td style="width:30px">&nbsp;</td>
                    <td style="width:20%"></td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <span class="labelled">du</span>
                    </td><td>
                        <input type="text" name="date_debut" id="date_debut" value="" class="classinput_xsize"/>
                    </td>
                    <td><span>au</span>
                    </td>
                    <td>
                        <input type="text" name="date_fin" id="date_fin" value="<?php echo date("d-m-Y");?>" class="classinput_xsize"/>
                    </td>
                    <td >&nbsp;</td>
                    <td ><img id="add_bonus_commercial" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-bonus-malus.jpg"/></td>
                </tr>
                <tr>
                    <td>
                        <span class="labelled">Libellé:</span>
                    </td>
                    <td>
                        <input type="text" name="lib_search" id="lib_search" value="" class="classinput_xsize"/>
                    </td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <span class="labelled">Montant:</span>
                    </td>
                    <td>
                        <input type="text" name="montant" id="montant" value="" class="classinput_xsize"/>
                    </td>
                    <td>&agrave; +/-
                    </td>
                    <td>
                        <input type="text" name="delta_montant" id="delta_montant" value="0.00" class="classinput_nsize" size="5"/> <?php	 echo $MONNAIE[1]; ?>
                    </td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <span class="labelled">Trier par:</span>
                    </td>
                    <td>
                        <select name="order_search" id="order_search" class="classinput_xsize">
                            <option value="0">Débits et Crédits</option>
                            <option value="1">Débits uniquement</option>
                            <option value="2">Crédits uniquement</option>
                        </select>
                    </td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        <input name="submit_s" id="submit_s" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" />
                    </td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                </tr>
            </table>
        </div>

        <div class="emarge">
            <table width="100%" border="0" cellspacing="4" cellpadding="2">
                <tr>
                    <td style="width:25%; font-weight:bolder; text-align:left">Commercial</td>
                    <td style="width:20%; font-weight:bolder; text-align:center; ">Date</td>
                    <td style="width:20%; font-weight:bolder; text-align:center">Libellé</td>
                    <td style="width:20%; font-weight:bolder; text-align:center">Montant</td>
                    <td style="font-weight:bolder; text-align:center" colspan="3">Action</td>
                </tr>
            </table>
        </div>
        <div id="compta_bonus_commerciaux_result_content" style="overflow: auto;">

        </div>

        <input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>

        <SCRIPT type="text/javascript">
            Event.observe('add_bonus_commercial', "click", function(evt){
                $("pop_up_bonus").style.display = "block";
                page.traitecontent('pop_up_bonus','compta_bonus_commerciaux_add.php','true','pop_up_bonus');
                Event.stop(evt);
            });

            Event.observe('submit_s', "click", function(evt){
                compta_bonus_commerciaux_result();
            });

            //centrage de la pop up comm
            centrage_element("pop_up_bonus");

            Event.observe(window, "resize", function(evt){
                centrage_element("pop_up_bonus");
            });

            compta_bonus_commerciaux_result();
            //on masque le chargement
            H_loading();
        </SCRIPT>
    </div>
</div>