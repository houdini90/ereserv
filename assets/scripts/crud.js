$(function () {

    // INITIALISATION DE PARAMETRES UTILES
    var entity = $('#entity') ? $('#entity').val() : "";
    var attributs = $('#attributs') ? JSON.parse($('#attributs').val()) : "";
    // var foreign_key = $('#foreign_key') ? $('#foreign_key').val() : "";
    // var filter_id = $('#filter_id') ? $('#filter_id').val() : "";

    //  AFFICHAGE DU FORMULAIRE D'AJOUT
    $(document).on('click', '.addBtn', function(){
        $('#addModal').modal('show');
    });

    // GESTION DU FILTER
    
    /**
     * 
     * ON PARTIRA SUR :
     * => 01 FILTER
     * id : filter_id
     * class : filter_class
     * => 01 FILTERED
     * id : filtered_id
     * class : filtered_class
     * 
     * C'est lors de l'événement change sur le select de l'élément FILTER que le filtrage se produit
     * Le filtrage à pour objectif de modifier les items de l'élément FILTERED
     * 
     */

    $(".filter_class").change(function() {

        var $selectElement = $(this);
        
        var filtered_entity = $(this).attr("data-filtered-class");
        var foreign_key = $(this).attr("data-foreign-key");
        var filtered_name = $(this).attr("data-filtered-name");
        var filter_id = $(this).val();

        $.ajax({
            type: "GET",
            url: "/filter/"+filtered_entity+"/"+foreign_key+"/"+filter_id,
            data: {},
            success: function(data) {

                data = JSON.parse(data);
                
                var filtered_element = $("#"+filtered_name);
                // var filtered_element = $selectElement.closest('.form-group').next().find('select');
                filtered_element.empty(); // Clear the select options
                filtered_element.append($('<option value=""></option>'));

                $.each(data, function(index, option) {
                    filtered_element.append($('<option></option>')
                        .attr("value", option.id)
                        .text(option.code ? option.code : option.libelle));
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });

    });

    $(".m_filter_class").change(function() {

        var $selectElement = $(this);
        
        var filtered_entity = $(this).attr("data-filtered-class");
        var foreign_key = $(this).attr("data-foreign-key");
        var filtered_name = $(this).attr("data-filtered-name");
        var filter_id = $(this).val();

        $.ajax({
            type: "GET",
            url: "/filter/"+filtered_entity+"/"+foreign_key+"/"+filter_id,
            data: {},
            success: function(data) {
                
                data = JSON.parse(data);
                
                var filtered_element = $("#m_"+filtered_name);
                // var filtered_element = $selectElement.closest('.form-group').next().find('select');
                filtered_element.empty(); // Clear the select options
                filtered_element.append($('<option value=""></option>'));

                $.each(data, function(index, option) {
                    filtered_element.append($('<option></option>')
                        .attr("value", option.id)
                        .text(option.code ? option.code : option.libelle));
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });

    });

    // FIN GESTION DU FILTER

    // LES COLONNES
    var columns = [];
    var hidden_cols = [];
    var col_i = 0;
    attributs.forEach((attribut, index) => {
        if(!attribut.fillable || (attribut.fillable && attribut.input_type != 'password')) {
            
            if(attribut.foreign_key) {
                columns.push({"data": attribut.name})
                columns.push({"data": attribut.ref+'_'+attribut.ref_lib})
                hidden_cols.push(col_i)
                col_i++;
            }
            else {
                columns.push({"data": attribut.name})
            }
            col_i++;
        }
    });

    columns.push(
        {
            "data": null,
            render: function(data, type, row) {
                if($("#entity").val() == "Reservation")
                    return `<button data-toggle="tooltip" data-placement="bottom" title="Accepter" class="btn btn-sm accepterBtn text-success"><i class="fas fa-check"></i></button>
                        <button data-toggle="tooltip" data-placement="bottom" title="Refuser" class="btn btn-sm refuserBtn text-danger"><i class="fas fa-times"></i></button>
                        <button data-toggle="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-sm removeBtn"><i class="fas fa-trash"></i></button>`;
                else if($("#entity").val() == "Reservation")
                    return `
                            <button data-toggle="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-sm removeBtn"><i class="fas fa-trash"></i></button>`;
                else
                    return `
                        <button data-toggle="tooltip" data-placement="bottom" title="Modifier" class="btn btn-sm editBtn"><i class="fas fa-edit"></i></button>
                        <button data-toggle="tooltip" data-placement="bottom" title="Supprimer" class="btn btn-sm removeBtn"><i class="fas fa-trash"></i></button>`;
            }
        }
    )

    // DATATABLE
    var datatable = $("#datatable").DataTable({

        "serverSide": true,
        "processing": true,
        "deferRender": true,
        "stateSave": false,
        "drawCallback": function (setting, json) {

            console.log("all data are loaded into table");
            // $("input[data-bootstrap-switch]").each(function(){
            //     $(this).bootstrapSwitch({
            //         onSwitchChange: function(e) {
            //             $tr = $(this).closest('tr')
            //             var data = tableDemandes.row($tr).data()
            //             $currentID = data.identifiant
            //             $currentState = data.validation
            //             $.ajax({
            //                 url: "valider.php",
            //                 type: 'POST',
            //                 data: {
            //                     "id": $currentID,
            //                     "state": $currentState
            //                 },
            //                 success: function(data) {
            //                     // console.log(JSON.parse(data));
            //                     tableDemandes.ajax.reload(null, false);
            //                 }
            //             })

            //         }
            //     });
            // });
            
            $('[data-toggl="tooltip"]').tooltip({
                trigger: 'hover'
            });

        },
        "ajax": 'data/'+entity,
        "columns": columns,
        "columnDefs": [
            {
                "targets": hidden_cols,
                "visible": false,
                "searchable": false
            }
        ],
        "responsive": false,
        "autoWidth": false,
        "language" : {
            "sEmptyTable":     "Aucune donnée disponible dans le tableau",
            "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     "Afficher _MENU_ éléments",
            "sLoadingRecords": '<div><i class="fas fa-3x fa-spinner fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>',
            "sProcessing":     '<div><i class="fas fa-3x fa-spinner fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>',
            "sSearch":         "Rechercher :",
            "sZeroRecords":    "Aucun élément correspondant trouvé",
            "oPaginate": {
                "sFirst":    "Premier",
                "sLast":     "Dernier",
                "sNext":     "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
            },
            "select": {
                    "rows": {
                        "_": "%d lignes sélectionnées",
                        "0": "Aucune ligne sélectionnée",
                        "1": "1 ligne sélectionnée"
                    } 
            }
        }
    });

    // READAPTATION DU TOOLTIP
    $('#datatable').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
    })

    // RELOAD DU DATATABLE ET AFFICHAGE DU MESSAGE
    function reload_notify(data) {

        if(data.alert == "success") datatable.ajax.reload(null, false);

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            icon: data.alert,
            title: data.message
        });
    }

    // AJOUT
    $('#addBtn').on('click', function() {

        var data = {};

        attributs.forEach(attribut => {
            if(attribut.fillable && attribut.input_type != "file") 
                data[attribut.name] = $('#'+attribut.name).val();
            else if(attribut.fillable) {
                // console.log("photo", $('#'+attribut.name)[0].files);
                // console.log("photo", $('#'+attribut.name));
                data[attribut.name] = "salle.png";
            }
        });

        ajouter(data);
    })

    // FUNCTION DE GESTION DE L'AJOUT
    function ajouter(data) {
        
        $.ajax({
            url: "add/"+entity,
            type: "POST",
            data,
            cache: false,
            success: function(data) {

                var data = JSON.parse(data);

                // si tout s'est bien passé on fait disparaitre le modal
                if(data.alert == "success") $('#addModal').modal('hide');
                
                reload_notify(data);
                      
            }
        });
    }

    //L'IDENTIFIANT SELECTIONNE
    var currentId = "";

    // AFFICHAGE DU FORMULAIRE DE MODIFICATION
    $(document).on('click', '.editBtn', function() {

        $('#updateModal').modal('show');

        var currentRow = $(this).closest('tr');
        var data = datatable.row(currentRow).data()
        currentId = data.id;

        attributs.forEach(attribut => {
            if(attribut.fillable) {
                $('#m_'+attribut.name).val(data[attribut.name]);
            }
        });

        // $('#updateModal .textarea').summernote('code', currentDescription);        
        // IN CASE OF SELECT ELEMENT WXE NEED TO USE THIS ONE 
        // selectionner('m_delai', currentDelai);

    });

    // MODIFICATION
    $('#updateBtn').on('click', function() {

        var data = {};

        attributs.forEach(attribut => {
            if(attribut.fillable) data[attribut.name] = $('#m_'+attribut.name).val();
        });
        
        modifier(currentId, data);

    })

    // FONCTION DE GESTION DE LA MODIFICATION
    function modifier(id, data) {

        $.ajax({
            url: "edit/"+entity+"/"+id,
            type: "POST",
            data,
            cache: false,
            success: function(data){
                
                var data = JSON.parse(data);

                if(data.alert == "success") $('#updateModal').modal('hide');
                
                reload_notify(data);
                      
            }
        });
        
    }

    // AFFICHAGE DE LA CONFIRMATION DE SUPPRESSION
    $(document).on('click', '.removeBtn', function(){
        $('#deleteModal').modal('show');
        var currentRow = $(this).closest('tr');
        var data = datatable.row(currentRow).data()
        currentId = data.id
    }); 

    // SUPPRESSION
    $('#deleteBtn').on('click', function() {
        supprimer(currentId);
    })

    // FONCTION DE GESTION DE LA SUPPRESSION
    function supprimer(id) {
        
        $.ajax({
            url: "del/"+entity+"/"+id,
            type: "GET",
            cache: false,
            success: function(data) {

                var data = JSON.parse(data);

                // si tout s'est bien passé on fait disparaitre le modal
                if(data.alert == "success") $('#deleteModal').modal('hide');
                
                reload_notify(data);
                      
            }
        });
        
    }

    $(document).on('click', '.accepterBtn', function(){
        console.log("eeeeeeeeeeeeeeeeeeeeeeeeee");
        var currentRow = $(this).closest('tr');
        var data = datatable.row(currentRow).data()
        currentId = data.id
        accepter(currentId)
    }); 
    $(document).on('click', '.refuserBtn', function(){
        var currentRow = $(this).closest('tr');
        var data = datatable.row(currentRow).data()
        currentId = data.id
        refuser(currentId)
    }); 
    
    function accepter(id) {
        $.ajax({
            url: "accepter-"+id,
            type: "GET",
            cache: false,
            success: function(data) {

                var data = JSON.parse(data);

                // si tout s'est bien passé on fait disparaitre le modal
                
                reload_notify(data);
                      
            }
        });
    }
    function refuser(id) {
        $.ajax({
            url: "refuser-"+id,
            type: "GET",
            cache: false,
            success: function(data) {

                var data = JSON.parse(data);

                // si tout s'est bien passé on fait disparaitre le modal
                
                reload_notify(data);
                      
            }
        });
    }

    // FONCTION DE GESTION DE LA SUPPRESSION

    function selectionner(selectId, optionValToSelect) {
        var selectElement = document.getElementById(selectId);
        var selectOptions = selectElement.options;
        for (var opt, j = 0; opt = selectOptions[j]; j++) {
            if (opt.value == optionValToSelect) {
                selectElement.selectedIndex = j;
                break;
            }
        }
    }
    

})