<div>
    <h2>Ajout d'une pi&egrave;ce jointe</h2>
    <form id="upload" enctype="multipart/form-data" method="post" action="pieces_ged_upload.php" target="formFrame">
        <input type="hidden" id="type_objet" name="type_objet" value="contact" />
        <input type="hidden" name="ref_objet" id="ref_objet" value="" />
        <input type="hidden" id="type_pie" name="type_pie" value="5" />
        Indiquez l'emplacement de la pi&egrave;ce &agrave; joindre<br/>
        <input type="file" size="35" id="pie" name="pie" />
        <br />
        OU indiquez l'url de la pi&egrave;ce &agrave; joindre<br />
        <input type="text" id="url_pie" name="url_pie" value="" size="35" /><br />
        <br />
        <br />
        Nom de la pi&egrave;ce jointe<br />
        <input type="text" id="nom_pie" name="nom_pie" value="" />
        <br />
        Description de la pi&egrave;ce jointe<br />
        <textarea cols="20" rows="5" class="classinput_xsize" id="desc_pie" name="desc_pie"></textarea>
        <br />
        <input type="button" id="add_pie" name="add_pie" value="Ajouter" />
    </form>
    <script type="text/javascript">
        Event.observe('add_pie', "click", function(evt){
            $("pop_up_piecej_add").style.display = "";

            $("upload").submit();
            update_autorisations_compte('ref_client','ref_client_nom_c',$("ref_client").value, $("ref_client_nom_c").innerHTML);
            Event.stop(evt);
        });

        $("ref_objet").value = $("ref_client").value;
        H_loading();
    </script>
</div>