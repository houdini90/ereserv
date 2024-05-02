<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">
                    <?= $titrePage; ?>
                    <div class="" id=""></div>
                </h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">

        <div id="checkResponse"></div>

        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
                <div class="card-body">

                  <input type="hidden" class="form-control" id="salle_id" value="<?= $salle_id ?>">
                  <div class="form-group">
                    <label for="date_debut">Date début</label>
                    <input type="date" class="form-control" id="date_debut">
                  </div> 
                  <div class="form-group">
                    <label for="date_fin">Date fin</label>
                    <input type="date" class="form-control" id="date_fin">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" id="reservBtn" class="btn btn-primary">Réserver</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

        </div>
            
        </div>
        
    </div>
</section>
<!-- /.content -->


<script>

        document.getElementById("reservBtn").addEventListener("click", function() {
            // Récupérer la référence de la demande depuis l'input
            var salle_id = document.getElementById("salle_id").value;
            var date_debut = document.getElementById("date_debut").value;
            var date_fin = document.getElementById("date_fin").value;

            // Configurer l'objet de la requête
            var requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ salle_id, date_debut, date_fin })
            };

            // Faire la requête fetch
            fetch('reserver', requestOptions)
            .then(response => response.json())
            .then(response => {
                document.getElementById("salle_id").value = "";
                document.getElementById("date_debut").value = "";
                document.getElementById("date_fin").value = "";
                // Faire quelque chose avec la réponse, par exemple l'afficher dans la console
                console.log(response);
                if(response.statut == "OK") {
                  resHTML = `<div class="callout callout-success">
                              <h5 class="text-success"><i class="fas fa-info"></i> Demande envoyée :</h5>
                              Votre demande de réservation a été envoyée avec succès. Voici le numéro de référence pour le suivi de la demande :
                              <span class="text-info">${response.data.reference}</span>
                            </div>`;
                  document.getElementById("checkResponse").innerHTML = resHTML;
                }
                else {
                    resHTML = `<div class="callout callout-warning">
                                <h5 class="text-warnin"><i class="fas fa-info"></i> Demande échouée :</h5>
                                Une erreur est survenue lors de l'envoie de la demande, veuillez réeessayer plus tard.
                              </div>`;
                    document.getElementById("checkResponse").innerHTML = resHTML;
                }
            })
            .catch(error => console.error('Erreur lors de la requête fetch :', error));
        });
    </script>