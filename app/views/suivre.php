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
            
            <div class="col-md-8">

                <div id="checkResponse" class="callout callout-info">
                    <h5 class="text-info"><i class="fas fa-info"></i> Info :</h5>
                    Saisisser le numéro de référence de la demande, puis tapez sur vérifier pour savoir le statut de votre demande de réservation.
                </div>
                
                <div class="card card-primary card-outline">
                    
                    <form role="form">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1 text-lg">Numéro de référence</label>
                                <input type="text" class="form-control" id="reference" placeholder="">
                            </div>

                            <div class="form-group">
                                <button type="button" id="checkBtn" class="btn btn-primary">Vérifier</button>
                            </div>
                        
                        </div>

                    </form>
                </div>

            </div>

        </div>
        
    </div>
</section>
<!-- /.content -->

<script>

        document.getElementById("checkBtn").addEventListener("click", function() {
            // Récupérer la référence de la demande depuis l'input
            var reference = document.getElementById("reference").value;

            // Configurer l'objet de la requête
            var requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ reference: reference })
            };

            // Faire la requête fetch
            fetch('suivi', requestOptions)
            .then(response => response.json())
            .then(response => {
                // Faire quelque chose avec la réponse, par exemple l'afficher dans la console
                console.log(response);
                if(response.statut == "OK") {

                    console.log(response.data.statut);

                    if(response.data.statut == 0 || response.data.statut == null) {
                        resHTML = `
                            <h5 class="text-info"><i class="fas fa-info"></i> Demande en attente</h5>
                            Votre demande est en attente de validation
                        `
                        document.getElementById("checkResponse").innerHTML = resHTML;
                    }
                    else if(response.data.statut == 1) {
                        resHTML = `
                            <h5 class="text-success"><i class="fas fa-info"></i> Demande acceptée</h5>
                            Votre demande de réservation à été approuvée.
                            <h5 class="text-info">Salle : ${response.data.salle_nom}</h5>
                            <p>Capacité : ${response.data.salle_capacite} Places</p>
                        `
                        document.getElementById("checkResponse").innerHTML = resHTML;
                    }
                    else if(response.data.statut == 2) {
                        resHTML = `
                            <h5 class="text-danger"><i class="fas fa-info"></i> Demande refusée</h5>
                            Votre demande de réservation a été refusée.
                        `
                        document.getElementById("checkResponse").innerHTML = resHTML;
                    }

                }
                else {
                    document.getElementById("checkResponse").innerHTML = `
                        <h5 class="text-warning"><i class="fas fa-info"></i> Numéro de référence invalide :</h5>
                        La référence que vous indiquer ne correspond à aucune demande de réservation
                    `;
                }
            })
            .catch(error => console.error('Erreur lors de la requête fetch :', error));
        });
    </script>